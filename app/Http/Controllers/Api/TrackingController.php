<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\TrackingToken;
use App\Models\VisitorLog;
use App\Events\VisitorTracked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function store(Request $request)
    {
        try {
            // ===========================
            // 1. VALIDASI INPUT
            // ===========================
            $request->validate([
                'website_id' => 'required|exists:websites,id',
                'token'      => 'required|string',
                'referrer'   => 'nullable|url',
                'current_url'=> 'nullable|url',
                'user_agent' => 'nullable|string|max:500',
            ]);

            // ===========================
            // 2. CEK WEBSITE & TOKEN
            // ===========================
            $website = Website::where('id', $request->website_id)->first();

            if (!$website) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Website tidak ditemukan.',
                ], 404);
            }

            // Token valid?
            $token = TrackingToken::where('website_id', $website->id)
                                  ->where('token', $request->token)
                                  ->where('active', true)
                                  ->first();

            if (!$token) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Token tidak valid.',
                ], 401);
            }

            $allowedHost = $this->extractHost($website->url);
            $originHost = $this->extractHost($request->header('Origin'));
            $refererHost = $this->extractHost($request->header('Referer') ?? $request->referrer);

            if ($allowedHost && (($originHost && !$this->hostsMatch($originHost, $allowedHost)) || ($refererHost && !$this->hostsMatch($refererHost, $allowedHost)))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Origin tidak diizinkan untuk website ini.',
                ], 403);
            }

            // ===========================
            // 3. SIMPAN LOG KUNJUNGAN
            // ===========================
            DB::beginTransaction();

            $visitorLog = VisitorLog::create([
                'website_id' => $website->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->user_agent ?? $request->header('User-Agent'),
                'referrer'   => $request->referrer ?? null,
                'current_url'=> $request->current_url ?? null,
                'visited_at' => now(),
            ]);

            // Update total visit
            $website->increment('total_visit');
            $website->refresh();

            // Get updated stats
            $stats = [
                'total_websites' => Website::count(),
                'total_visits' => Website::sum('total_visit'),
                'total_logs' => VisitorLog::count(),
                'today_visits' => VisitorLog::whereDate('visited_at', Carbon::today())->count(),
            ];

            DB::commit();

            // Broadcast event for real-time updates
            event(new VisitorTracked($visitorLog, $website, $stats));

            // ===========================
            // 4. RESPONSE BERHASIL
            // ===========================
            return response()->json([
                'status'  => true,
                'message' => 'Tracking recorded.',
                'website' => $website->name,
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    private function extractHost(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $host = parse_url($url, PHP_URL_HOST);

        return $host ? Str::lower($host) : null;
    }

    private function hostsMatch(string $incomingHost, string $allowedHost): bool
    {
        if ($incomingHost === $allowedHost) {
            return true;
        }

        return Str::endsWith($incomingHost, '.'.$allowedHost);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\VisitorLog;
class DashboardApiController extends Controller
{
    public function chartPerMonth()
{
    try {
        // Ambil semua website
        $websites = Website::all();

        $series = [];

        foreach ($websites as $website) {
            $monthly = VisitorLog::selectRaw('MONTH(visited_at) as month, COUNT(*) as total')
                ->where('website_id', $website->id)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Map data 1–12
            $data = array_fill(1, 12, 0);

            foreach ($monthly as $row) {
                $data[$row->month] = $row->total;
            }

            $series[] = [
                'name' => $website->name,
                'data' => array_values($data),
            ];
        }

        return response()->json([
            'success' => true,
            'months' => [
                "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
            ],
            'series' => $series
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
}

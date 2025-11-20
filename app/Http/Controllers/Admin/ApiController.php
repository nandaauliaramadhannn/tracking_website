<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function dashboardStats()
    {
        try {
            // Total Statistics
            $totalWebsites = Website::count();
            $totalVisits = Website::sum('total_visit');
            $totalLogs = VisitorLog::count();
            $todayVisits = VisitorLog::whereDate('visited_at', Carbon::today())->count();

            // Recent Visitor Logs (Last 10)
            $recentLogs = VisitorLog::with('website')
                ->orderBy('visited_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'website_id' => $log->website_id,
                        'ip_address' => $log->ip_address,
                        'visited_at' => $log->visited_at,
                        'visited_at_human' => $log->visited_at ? Carbon::parse($log->visited_at)->diffForHumans() : 'N/A',
                        'website' => [
                            'id' => $log->website->id ?? null,
                            'name' => $log->website->name ?? 'Unknown Website',
                            'url' => $log->website->url ?? null,
                        ],
                    ];
                });

            // Top 5 Websites by Visits
            $topWebsites = Website::withCount('logs')
                ->orderBy('total_visit', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($website) {
                    return [
                        'id' => $website->id,
                        'name' => $website->name,
                        'url' => $website->url,
                        'total_visit' => $website->total_visit ?? 0,
                        'logs_count' => $website->logs_count ?? 0,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'total_websites' => $totalWebsites,
                        'total_visits' => $totalVisits,
                        'total_logs' => $totalLogs,
                        'today_visits' => $todayVisits,
                    ],
                    'recent_logs' => $recentLogs,
                    'top_websites' => $topWebsites,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function analyticsStats()
    {
        try {
            // Total Statistics
            $totalWebsites = Website::count();
            $totalVisits = Website::sum('total_visit');
            $totalLogs = VisitorLog::count();
            $todayVisits = VisitorLog::whereDate('visited_at', Carbon::today())->count();
            $todayWebsites = VisitorLog::whereDate('visited_at', Carbon::today())
                ->distinct('website_id')
                ->count('website_id');

            // This Week Statistics
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd = Carbon::now()->endOfWeek();
            $weekVisits = VisitorLog::whereBetween('visited_at', [$weekStart, $weekEnd])->count();

            // This Month Statistics
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
            $monthVisits = VisitorLog::whereBetween('visited_at', [$monthStart, $monthEnd])->count();

            // Visits by Day (Last 7 Days)
            $visitsByDay = VisitorLog::select(
                    DB::raw('DATE(visited_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('visited_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->map(function ($day) {
                    return [
                        'date' => $day->date,
                        'date_formatted' => Carbon::parse($day->date)->format('M d, Y'),
                        'count' => $day->count,
                    ];
                });

            // Visits by Website (Last 7 Days)
            $visitsByWebsite = VisitorLog::select(
                    'websites.name',
                    'websites.id',
                    DB::raw('COUNT(visitor_logs.id) as visit_count')
                )
                ->join('websites', 'visitor_logs.website_id', '=', 'websites.id')
                ->where('visitor_logs.visited_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('websites.id', 'websites.name')
                ->orderBy('visit_count', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($website) {
                    return [
                        'id' => $website->id,
                        'name' => $website->name,
                        'visit_count' => $website->visit_count,
                    ];
                });

            // Top Websites by Visits
            $topWebsites = Website::withCount('logs')
                ->orderBy('total_visit', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($website) {
                    return [
                        'id' => $website->id,
                        'name' => $website->name,
                        'url' => $website->url,
                        'total_visit' => $website->total_visit ?? 0,
                        'logs_count' => $website->logs_count ?? 0,
                        'tracking_method' => $website->tracking_method,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'total_websites' => $totalWebsites,
                        'total_visits' => $totalVisits,
                        'total_logs' => $totalLogs,
                        'today_visits' => $todayVisits,
                        'today_websites' => $todayWebsites,
                        'week_visits' => $weekVisits,
                        'month_visits' => $monthVisits,
                    ],
                    'visits_by_day' => $visitsByDay,
                    'visits_by_website' => $visitsByWebsite,
                    'top_websites' => $topWebsites,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function websiteStats($id)
    {
        try {
            $website = Website::with(['tokens', 'logs'])->withCount('logs')->findOrFail($id);

            // Recent logs for this website
            $recentLogs = VisitorLog::where('website_id', $website->id)
                ->orderBy('visited_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'ip_address' => $log->ip_address,
                        'visited_at' => $log->visited_at,
                        'visited_at_human' => $log->visited_at ? Carbon::parse($log->visited_at)->diffForHumans() : 'N/A',
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'website' => [
                        'id' => $website->id,
                        'name' => $website->name,
                        'url' => $website->url,
                        'slug' => $website->slug,
                        'total_visit' => $website->total_visit ?? 0,
                        'logs_count' => $website->logs_count ?? 0,
                        'tracking_method' => $website->tracking_method,
                    ],
                    'tokens' => $website->tokens->map(function ($token) {
                        return [
                            'id' => $token->id,
                            'token' => $token->token,
                            'active' => $token->active,
                            'created_at' => $token->created_at,
                        ];
                    }),
                    'recent_logs' => $recentLogs,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}


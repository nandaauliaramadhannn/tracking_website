<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        try {
            // Total Statistics
            $totalWebsites = Website::count();
            $totalVisits = Website::sum('total_visit');
            $totalLogs = VisitorLog::count();

            // Today Statistics
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

            // Top Websites by Visits
            $topWebsites = Website::withCount('logs')
                ->orderBy('total_visit', 'desc')
                ->limit(10)
                ->get();

            // Visits by Day (Last 7 Days)
            $visitsByDay = VisitorLog::select(
                    DB::raw('DATE(visited_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('visited_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

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
                ->get();

            // All Websites with Statistics
            $websites = Website::withCount('logs')
                ->orderBy('total_visit', 'desc')
                ->get();

            return view('admin.analytics.index', compact(
                'totalWebsites',
                'totalVisits',
                'totalLogs',
                'todayVisits',
                'todayWebsites',
                'weekVisits',
                'monthVisits',
                'topWebsites',
                'visitsByDay',
                'visitsByWebsite',
                'websites'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat analytics: ' . $e->getMessage());
        }
    }
}


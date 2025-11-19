<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            // Total Statistics
            $totalWebsites = Website::count();
            $totalVisits = Website::sum('total_visit');
            $totalLogs = VisitorLog::count();

            // Today Statistics
            $todayVisits = VisitorLog::whereDate('visited_at', Carbon::today())->count();

            // Recent Visitor Logs (Last 10)
            $recentLogs = VisitorLog::with('website')
                ->orderBy('visited_at', 'desc')
                ->limit(10)
                ->get();

            // Top 5 Websites by Visits
            $topWebsites = Website::withCount('logs')
                ->orderBy('total_visit', 'desc')
                ->limit(5)
                ->get();

            return view('admin.dashboard', compact(
                'totalWebsites',
                'totalVisits',
                'totalLogs',
                'todayVisits',
                'recentLogs',
                'topWebsites'
            ));
        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'totalWebsites' => 0,
                'totalVisits' => 0,
                'totalLogs' => 0,
                'todayVisits' => 0,
                'recentLogs' => collect(),
                'topWebsites' => collect()
            ]);
        }
    }
}

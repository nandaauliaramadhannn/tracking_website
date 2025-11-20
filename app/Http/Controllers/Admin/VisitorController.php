<?php

namespace App\Http\Controllers\Admin;

use App\Models\VisitorLog;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'website_id' => 'nullable|exists:websites,id',
            'search' => 'nullable|string|max:255',
        ]);

        $visitorLog = VisitorLog::with('website')
            ->when(isset($validated['website_id']), fn ($query) => $query->where('website_id', $validated['website_id']))
            ->when(isset($validated['search']), function ($query) use ($validated) {
                $query->where(function ($subQuery) use ($validated) {
                    $subQuery->where('ip_address', 'like', "%{$validated['search']}%")
                        ->orWhere('referrer', 'like', "%{$validated['search']}%")
                        ->orWhere('current_url', 'like', "%{$validated['search']}%")
                        ->orWhere('user_agent', 'like', "%{$validated['search']}%");
                });
            })
            ->latest('visited_at')
            ->paginate(50)
            ->withQueryString();

        $websites = Website::orderBy('name')->get(['id', 'name']);

        return view('admin.visitor.index', compact('visitorLog', 'websites'));
    }
}

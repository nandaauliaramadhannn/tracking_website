<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\TrackingToken;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['websites'] = Website::withCount('logs')->orderBy('created_at', 'desc')->get();
            return view('admin.website.index', $data);
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');
            return back()->withErrors(['email' => 'An error occurred']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'url'    => 'required|url',
            'method' => 'required|in:javascript,wordpress'
        ]);
        try{
            $website = Website::create([
                'name' => $request->name,
                'url' => $request->url,
                'slug' => Str::slug($request->name),
                'total_visit' => 0,
                'tracking_method' => $request->method,
            ]);
            TrackingToken::create([
                'website_id' => $website->id,
                'token' => bin2hex(random_bytes(32)),
                'active' => true,
            ]);
            Alert::toast('Website created successfully', 'success');
            return redirect()->route('website.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $website = Website::with(['tokens', 'logs'])->withCount('logs')->findOrFail($id);
            return view('admin.website.show', compact('website'));
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');
            return back()->withErrors(['email' => 'An error occurred']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $website = Website::findOrFail($id);
            return view('admin.website.edit', compact('website'));
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');
            return back()->withErrors(['email' => 'An error occurred']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $website = Website::findOrFail($id);
            $website->update($request->all());
            Alert::toast('Website updated successfully', 'success');
            return redirect()->route('website.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');
            return back()->withErrors(['email' => 'An error occurred']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $website = Website::findOrFail($id);
            $website->delete();
            Alert::toast('Website deleted successfully', 'success');
            return redirect()->route('website.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');
            return back()->withErrors(['email' => 'An error occurred']);
        }
    }
}

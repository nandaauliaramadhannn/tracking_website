<?php

namespace App\Http\Controllers\Admin;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    public function index()
    {
        $visitorLog = VisitorLog::latest()->get();
        return view('admin.visitor.index', compact('visitorLog'));
    }
}

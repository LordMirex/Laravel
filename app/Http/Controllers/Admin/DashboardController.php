<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_members' => Member::count(),
            'total_ministries' => Ministry::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'recent_members' => Member::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

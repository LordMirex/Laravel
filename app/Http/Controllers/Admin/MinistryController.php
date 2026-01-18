<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function index()
    {
        $ministries = Ministry::withCount('members')->latest()->get();
        return view('admin.ministries.index', compact('ministries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_name' => 'nullable|string|max:255',
        ]);

        Ministry::create($validated);
        return back()->with('success', 'Ministry created successfully');
    }

    public function destroy(Ministry $ministry)
    {
        $ministry->delete();
        return back()->with('success', 'Ministry removed');
    }
}

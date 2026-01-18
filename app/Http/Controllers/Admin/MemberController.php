<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(20);
        return view('admin.members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|string',
            'joined_at' => 'nullable|date',
        ]);

        Member::create($validated);
        return back()->with('success', 'Member added successfully');
    }
}

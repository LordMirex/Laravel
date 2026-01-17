@extends('admin.layout')

@section('content')
<div class="p-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Active Blocks</h3>
            <p class="text-3xl font-bold text-slate-900">12</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Subscribers</h3>
            <p class="text-3xl font-bold text-slate-900">1,240</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">WhatsApp Clicks</h3>
            <p class="text-3xl font-bold text-slate-900">458</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-900">Recent Activity</h2>
            <button class="text-blue-600 text-sm font-semibold">View All</button>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <p class="text-slate-500 text-sm italic">No recent activity found.</p>
            </div>
        </div>
    </div>
</div>
@endsection
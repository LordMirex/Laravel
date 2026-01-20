<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Modular Influencer Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="flex min-h-screen">
    <aside class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="p-6">
            <h1 class="text-xl font-bold tracking-tight text-white">Church Manager</h1>
            <p class="text-slate-400 text-xs mt-1 uppercase tracking-widest font-bold">Admin Portal</p>
        </div>
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover-elevate transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Management</p>
            </div>
            <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Members
            </a>
            <a href="{{ route('admin.ministries.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Ministries
            </a>
            <div class="pt-4 pb-2 px-4">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Finance</p>
            </div>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Donations
            </a>
        </nav>
        <div class="p-6 border-t border-white/10">
            @if(Route::has('logout'))
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-white text-sm font-medium">Logout</button>
            </form>
            @else
            <div class="text-slate-500 text-xs">Auth not configured</div>
            @endif
        </div>
    </aside>
    <main class="flex-1 flex flex-col">
        <header class="h-16 bg-white border-b border-slate-200 px-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="text-slate-400">/</span>
                <span class="text-slate-900 font-semibold">@yield('page_title', 'Dashboard')</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="/" target="_blank" class="text-sm font-semibold text-blue-600 hover:text-blue-700">View Live Site</a>
                <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300"></div>
            </div>
        </header>
        <div class="flex-1 overflow-auto">
            @yield('content')
        </div>
    </main>
</body>
</html>
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
            <h1 class="text-xl font-bold tracking-tight">Influencer Engine</h1>
            <p class="text-slate-400 text-xs mt-1">v1.0.0 Alpha</p>
        </div>
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-white/10 text-white font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.blocks.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                Block Manager
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Product Catalog
            </a>
            <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Members
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Subscribers
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
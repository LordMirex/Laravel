<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $site_settings->site_title ?? 'Creator Engine' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; }
    </style>
</head>
<body class="antialiased selection:bg-blue-100 selection:text-blue-900">
    @if($blocks->isEmpty())
        <div class="min-h-screen flex items-center justify-center p-6 text-center">
            <div class="max-w-md">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">No content blocks yet</h1>
                <p class="text-slate-500 mb-8">Head over to the admin panel to start building your landing page.</p>
                <a href="{{ route('admin.blocks.index') }}" class="inline-block bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-slate-200">
                    Open Admin Panel
                </a>
            </div>
        </div>
    @else
        @foreach($blocks as $block)
            @if(view()->exists('blocks.' . $block->type))
                @include('blocks.' . $block->type, ['content' => $block->content])
            @endif
        @endforeach
    @endif

    <footer class="py-20 border-t border-slate-100 text-center">
        <p class="text-slate-400 text-sm font-medium">Powered by <span class="text-slate-900 font-bold">Influencer Engine</span></p>
    </footer>
</body>
</html>
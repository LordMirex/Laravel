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
<body class="antialiased">
    @foreach($blocks as $block)
        @if($block->enabled)
            @include('blocks.' . $block->type, ['content' => $block->content])
        @endif
    @endforeach

    <footer class="py-12 border-t border-slate-100 text-center">
        <p class="text-slate-400 text-sm font-medium">Powered by <span class="text-slate-900 font-bold">Influencer Engine</span></p>
    </footer>
</body>
</html>
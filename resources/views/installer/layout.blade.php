<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Installer') | Modular Influencer Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: radial-gradient(circle at top right, #f8fafc, #eff6ff); }
    </style>
    @stack('styles')
</head>
<body class="gradient-bg flex items-center justify-center min-h-screen p-6">
    <div class="max-w-2xl w-full">
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl overflow-hidden">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
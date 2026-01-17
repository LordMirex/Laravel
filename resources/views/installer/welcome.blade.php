<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Modular Influencer Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: radial-gradient(circle at top right, #f8fafc, #eff6ff); }
    </style>
</head>
<body class="gradient-bg flex items-center justify-center min-h-screen p-6">
    <div class="max-w-2xl w-full">
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            <div class="bg-blue-600 p-8 md:w-1/3 flex flex-col justify-between text-white">
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold">Setup Wizard</h2>
                    <p class="text-blue-100 text-sm mt-2">Let's get your creator site live in minutes.</p>
                </div>
                <div class="text-xs text-blue-200">Version 1.0.0</div>
            </div>
            <div class="p-8 md:w-2/3">
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Ready to launch?</h1>
                <p class="text-slate-600 mt-4 leading-relaxed">
                    Welcome to the <strong>Modular Influencer Engine</strong>. This wizard will configure your database, create your admin account, and help you select your first premium theme.
                </p>
                
                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold mt-0.5">1</div>
                        <p class="text-sm text-slate-600">Server pre-flight checks</p>
                    </div>
                    <div class="flex items-start gap-3 text-slate-400">
                        <div class="w-6 h-6 rounded-full bg-slate-50 flex items-center justify-center text-xs font-bold mt-0.5 border border-slate-100">2</div>
                        <p class="text-sm">Database connection</p>
                    </div>
                    <div class="flex items-start gap-3 text-slate-400">
                        <div class="w-6 h-6 rounded-full bg-slate-50 flex items-center justify-center text-xs font-bold mt-0.5 border border-slate-100">3</div>
                        <p class="text-sm">Migrations & Seeding</p>
                    </div>
                </div>

                <div class="mt-10 flex items-center gap-4">
                    <a href="{{ route('installer.preflight') }}" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 inline-block text-center flex-1">
                        Begin Installation
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

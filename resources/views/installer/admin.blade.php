<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account | Modular Influencer Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: radial-gradient(circle at top left, #f8fafc, #eff6ff); }
    </style>
</head>
<body class="gradient-bg flex items-center justify-center min-h-screen p-6">
    <div class="max-w-2xl w-full">
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Admin Account</h1>
                        <p class="text-slate-500 text-sm mt-1">Create your administrative credentials.</p>
                    </div>
                    <div class="flex gap-1">
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-slate-100"></div>
                    </div>
                </div>

                <form action="{{ route('installer.admin.create') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Full Name</label>
                        <input type="text" name="name" placeholder="John Doe" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Email Address</label>
                        <input type="email" name="email" placeholder="admin@example.com" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Password</label>
                            <input type="password" name="password" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <button type="submit" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 flex-1">
                            Create Account & Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

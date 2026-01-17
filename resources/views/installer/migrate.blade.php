<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Setup | Modular Influencer Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: radial-gradient(circle at top right, #f8fafc, #eff6ff); }
        .terminal-glow { box-shadow: 0 0 20px rgba(16, 185, 129, 0.1); }
    </style>
</head>
<body class="gradient-bg flex items-center justify-center min-h-screen p-6">
    <div class="max-w-2xl w-full">
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Database Setup</h1>
                        <p class="text-slate-500 text-sm mt-1">Creating your application tables.</p>
                    </div>
                    <div class="flex gap-1">
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                    </div>
                </div>

                <div id="status" class="hidden p-4 rounded-2xl text-sm font-medium mb-6"></div>
                
                <div id="console-wrapper" class="hidden mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Artisan Output</label>
                    <div class="bg-slate-900 rounded-2xl p-4 overflow-hidden terminal-glow">
                        <pre id="output" class="text-emerald-400 text-[11px] font-mono leading-relaxed max-h-48 overflow-auto"></pre>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('installer.database') }}" class="px-6 py-3.5 rounded-2xl font-semibold text-slate-600 hover:bg-slate-50 transition-all">Back</a>
                    <button id="run-btn" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 flex-1">
                        Initialize System
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('run-btn').addEventListener('click', async () => {
            const btn = document.getElementById('run-btn');
            const status = document.getElementById('status');
            const output = document.getElementById('output');
            const wrapper = document.getElementById('console-wrapper');
            
            btn.disabled = true;
            btn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Initializing...</span>';
            status.classList.add('hidden');
            wrapper.classList.add('hidden');

            try {
                const res = await fetch('{{ route('installer.migrate.run') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await res.json();
                
                if (data.success) {
                    status.innerText = 'Success! System core is ready.';
                    status.className = 'p-4 rounded-2xl text-sm bg-emerald-50 text-emerald-700 block mb-6';
                    output.innerText = data.output;
                    wrapper.classList.remove('hidden');
                    btn.innerText = 'Continue to Admin Setup';
                    btn.disabled = false;
                    btn.onclick = () => window.location.href = '{{ route('installer.admin') }}'; // Assuming next route
                } else {
                    throw new Error(data.message || 'Initialization failed');
                }
            } catch (err) {
                status.innerText = err.message;
                status.className = 'p-4 rounded-2xl text-sm bg-rose-50 text-rose-700 block mb-6';
                btn.disabled = false;
                btn.innerText = 'Retry Initialization';
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Identity | Modular Influencer Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-bg { background: radial-gradient(circle at bottom right, #f8fafc, #eff6ff); }
    </style>
</head>
<body class="gradient-bg flex items-center justify-center min-h-screen p-6">
    <div class="max-w-2xl w-full">
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Site Identity</h1>
                        <p class="text-slate-500 text-sm mt-1">Tell us about your creator brand.</p>
                    </div>
                    <div class="flex gap-1">
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                        <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
                    </div>
                </div>

                <form id="identity-form" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Site Title</label>
                            <input type="text" name="site_title" placeholder="My Awesome Site" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" placeholder="+234..." class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Category</label>
                        <select name="category" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                            <option value="skit_maker">Skit Maker / Comedian</option>
                            <option value="influencer">Influencer / Personal Brand</option>
                            <option value="seller">Seller / Brand</option>
                            <option value="educator">Educator / Coach</option>
                        </select>
                    </div>

                    <div class="mt-8">
                        <button type="submit" id="finish-btn" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 w-full">
                            Complete Setup & Launch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('identity-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('finish-btn');
            const formData = new FormData(e.target);
            
            btn.disabled = true;
            btn.innerText = 'Finalizing...';

            try {
                const res = await fetch('{{ route('installer.finish') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (res.ok) {
                    window.location.href = '/admin';
                } else {
                    throw new Error('Finalization failed');
                }
            } catch (err) {
                alert(err.message);
                btn.disabled = false;
                btn.innerText = 'Complete Setup & Launch';
            }
        });
    </script>
</body>
</html>

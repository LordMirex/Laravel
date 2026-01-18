@extends('installer.layout')

@section('title', 'Database Setup')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Database Connection</h1>
            <p class="text-slate-500 text-sm mt-1">Configure your MySQL storage.</p>
        </div>
        <div class="flex gap-1">
            <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
            <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
            <div class="w-8 h-1.5 rounded-full bg-slate-100"></div>
        </div>
    </div>

    <form id="db-form" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <div class="md:col-span-2">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Host</label>
            <input type="text" name="host" value="shuttle.proxy.rlwy.net" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Port</label>
            <input type="number" name="port" value="17743" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Database</label>
            <input type="text" name="database" value="railway" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Username</label>
            <input type="text" name="username" value="root" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Password</label>
            <input type="password" name="password" value="SdaWWXDTppnLDpiELvFpcZzURHctSPLH" class="w-full bg-white/50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
        </div>
        
        <div id="status" class="hidden md:col-span-2 p-4 rounded-2xl text-sm font-medium"></div>

        <div class="md:col-span-2 mt-4 flex items-center gap-4">
            <a href="{{ route('installer.preflight') }}" class="px-6 py-3.5 rounded-2xl font-semibold text-slate-600 hover:bg-slate-50 transition-all text-center">Back</a>
            <button type="submit" id="submit-btn" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 flex-1">
                Test & Continue
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('db-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submit-btn');
        const status = document.getElementById('status');
        const formData = new FormData(e.target);
        
        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Testing...</span>';
        status.classList.add('hidden');

        try {
            const formDataObj = Object.fromEntries(formData);
            
            const res = await fetch('{{ route('installer.database.test') }}', {
                method: 'POST',
                body: JSON.stringify(formDataObj),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            const text = await res.text();
            console.log('Response:', text);
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                throw new Error('Server returned invalid response. Check console.');
            }
            
            if (data.success) {
                status.innerText = 'Success! Connection established.';
                status.className = 'p-4 rounded-2xl text-sm bg-emerald-50 text-emerald-700 block md:col-span-2';
                setTimeout(() => {
                    window.location.href = '{{ route('installer.migrate') }}';
                }, 1000);
            } else {
                throw new Error(data.message || 'Connection failed');
            }
        } catch (err) {
            console.error('Test error:', err);
            status.innerText = err.message;
            status.className = 'p-4 rounded-2xl text-sm bg-rose-50 text-rose-700 block md:col-span-2';
            btn.disabled = false;
            btn.innerText = 'Test & Continue';
        }
    });
</script>
@endpush
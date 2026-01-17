@extends('installer.layout')

@section('title', 'Pre-flight Checks')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">System Requirements</h1>
            <p class="text-slate-500 text-sm mt-1">We're checking if your server is ready.</p>
        </div>
        <div class="flex gap-1">
            <div class="w-8 h-1.5 rounded-full bg-blue-600"></div>
            <div class="w-8 h-1.5 rounded-full bg-slate-100"></div>
            <div class="w-8 h-1.5 rounded-full bg-slate-100"></div>
        </div>
    </div>

    <div class="space-y-3">
        @foreach($checks as $check => $status)
            <div class="flex items-center justify-between p-4 rounded-2xl border {{ $status ? 'border-emerald-100 bg-emerald-50/30' : 'border-rose-100 bg-rose-50/30' }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $status ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                        @if($status)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-slate-900 capitalize">{{ str_replace('_', ' ', $check) }}</span>
                        <span class="text-[10px] uppercase tracking-wider {{ $status ? 'text-emerald-600' : 'text-rose-600' }} font-bold">
                            {{ $status ? 'Compatible' : 'Incompatible' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex items-center gap-4">
        <a href="{{ route('installer.welcome') }}" class="px-6 py-3.5 rounded-2xl font-semibold text-slate-600 hover:bg-slate-50 transition-all">Back</a>
        @if(collect($checks)->every(fn($status) => $status))
            <a href="{{ route('installer.database') }}" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 flex-1 text-center">
                Continue to Database
            </a>
        @else
            <button onclick="window.location.reload()" class="bg-rose-600 text-white px-8 py-3.5 rounded-2xl font-semibold hover:bg-rose-700 transition-all shadow-lg shadow-rose-200 flex-1">
                Fix & Retry
            </button>
        @endif
    </div>
</div>
@endsection
@extends('admin.layout')

@section('page_title', 'Member Management')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-900">Church Members</h2>
        <button onclick="document.getElementById('addMemberModal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-all">
            Add New Member
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Name</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Contact</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Joined</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($members as $member)
                <tr>
                    <td class="px-6 py-4 text-slate-900 font-medium">{{ $member->name }}</td>
                    <td class="px-6 py-4 text-slate-600 text-sm">
                        {{ $member->email }}<br>
                        <span class="text-xs">{{ $member->phone }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $member->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst($member->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600 text-sm">{{ $member->joined_at?->format('M d, Y') ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <button class="text-slate-400 hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">No members found. Add your first member to get started.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($members->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>

<div id="addMemberModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">Add New Member</h3>
            <button onclick="document.getElementById('addMemberModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>
        <form action="{{ route('admin.members.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Full Name</label>
                <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Phone Number</label>
                    <input type="text" name="phone" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Status</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    <option value="active">Active Member</option>
                    <option value="inactive">Inactive</option>
                    <option value="visitor">Visitor</option>
                </select>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-semibold hover:bg-slate-800 transition-all">Create Member Account</button>
            </div>
        </form>
    </div>
</div>
@endsection

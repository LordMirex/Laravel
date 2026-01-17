@extends('admin.layout')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Block Manager</h1>
        <button onclick="document.getElementById('add-block-modal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            Add New Block
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4" id="blocks-list">
        @forelse($blocks as $block)
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between" data-id="{{ $block->id }}">
                <div class="flex items-center gap-4">
                    <div class="cursor-move text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $block->type }}</span>
                        <h3 class="font-semibold text-slate-900 mt-1">
                            @php
                                $title = $block->content['title'] ?? 'Untitled Block';
                            @endphp
                            {{ $title }}
                        </h3>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="editBlock({{ $block->id }}, '{{ $block->type }}', {{ json_encode($block->content) }})" class="text-slate-600 hover:text-blue-600 p-2 text-sm font-medium">Edit</button>
                    <form action="{{ route('admin.blocks.destroy', $block) }}" method="POST" class="inline" onsubmit="return confirm('Delete this block?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-700 p-2 text-sm font-medium">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white border border-dashed border-slate-300 rounded-2xl">
                <p class="text-slate-500">No blocks found. Start by adding one!</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Add Modal --}}
<div id="add-block-modal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-2xl border border-slate-200">
        <h2 class="text-xl font-bold mb-4">Add Content Block</h2>
        <form action="{{ route('admin.blocks.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Block Type</label>
                    <select name="type" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="hero">Hero Section</option>
                        <option value="links">Link Grid</option>
                        <option value="featured">Featured Content</option>
                        <option value="store">Product Store</option>
                        <option value="video_grid">Video Grid</option>
                        <option value="newsletter">Newsletter</option>
                        <option value="about">About Section</option>
                    </select>
                </div>
                <input type="hidden" name="content" id="new-block-content" value='{"title": "New Block"}'>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('add-block-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-slate-600 font-semibold border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 bg-slate-900 text-white px-4 py-3 font-semibold rounded-xl hover:bg-slate-800 transition-colors">Add Block</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal (Simple JSON editor for now) --}}
<div id="edit-block-modal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl w-full max-w-2xl p-8 shadow-2xl border border-slate-200">
        <h2 class="text-xl font-bold mb-4">Edit Block Content</h2>
        <form id="edit-form" method="POST">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">JSON Content</label>
                    <textarea name="content" id="edit-content-textarea" rows="10" class="w-full border border-slate-200 rounded-xl px-4 py-3 font-mono text-sm outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('edit-block-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-slate-600 font-semibold border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-3 font-semibold rounded-xl hover:bg-blue-500 transition-colors">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function editBlock(id, type, content) {
        const modal = document.getElementById('edit-block-modal');
        const textarea = document.getElementById('edit-content-textarea');
        const form = document.getElementById('edit-form');
        
        textarea.value = JSON.stringify(content, null, 2);
        form.action = `/admin/blocks/${id}`;
        modal.classList.remove('hidden');
    }

    // Handle form submission to ensure JSON is valid
    document.getElementById('edit-form').addEventListener('submit', function(e) {
        const textarea = document.getElementById('edit-content-textarea');
        try {
            JSON.parse(textarea.value);
        } catch (err) {
            e.preventDefault();
            alert('Invalid JSON content. Please check your syntax.');
        }
    });
</script>
@endpush
@endsection
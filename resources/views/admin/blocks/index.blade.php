@extends('admin.layout')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Block Manager</h1>
        <button onclick="document.getElementById('add-block-modal').classList.toggle('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            Add New Block
        </button>
    </div>

    <div class="space-y-4" id="blocks-list">
        @foreach($blocks as $block)
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between" data-id="{{ $block->id }}">
                <div class="flex items-center gap-4">
                    <div class="cursor-move text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ $block->type }}</span>
                        <h3 class="font-semibold text-slate-900 mt-1">Block ID: #{{ $block->id }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="text-slate-600 hover:text-blue-600 p-2">Edit</button>
                    <form action="{{ route('admin.blocks.destroy', $block) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-700 p-2">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="add-block-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-2xl border border-slate-200">
        <h2 class="text-xl font-bold mb-4">Add Content Block</h2>
        <form action="{{ route('admin.blocks.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Block Type</label>
                    <select name="type" class="w-full border border-slate-200 rounded-xl px-4 py-2">
                        <option value="hero">Hero Section</option>
                        <option value="links">Link Grid</option>
                        <option value="featured">Featured Content</option>
                        <option value="store">Product Store</option>
                    </select>
                </div>
                <input type="hidden" name="content" value='{"title": "New Block"}'>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('add-block-modal').classList.add('hidden')" class="flex-1 px-4 py-2 text-slate-600 font-semibold border border-slate-200 rounded-xl">Cancel</button>
                    <button type="submit" class="flex-1 bg-slate-900 text-white px-4 py-2 font-semibold rounded-xl">Add Block</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
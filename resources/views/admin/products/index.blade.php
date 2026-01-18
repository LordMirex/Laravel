@extends('admin.layout')

@section('page_title', 'Product Management')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Products</h1>
        <button onclick="document.getElementById('add-product-modal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            Add New Product
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm flex flex-col">
                <div class="aspect-square bg-slate-100 relative">
                    <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=400' }}" class="w-full h-full object-cover" alt="{{ $product->title }}">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-slate-200">
                        {{ $product->currency }} {{ number_format($product->price, 2) }}
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-slate-900">{{ $product->title }}</h3>
                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $product->active ? 'text-emerald-600 bg-emerald-50' : 'text-slate-400 bg-slate-50' }} px-2 py-0.5 rounded">
                            {{ $product->active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-slate-500 text-sm line-clamp-2 mb-4 flex-1">{{ $product->description }}</p>
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                        <button onclick="editProduct({{ json_encode($product) }})" class="flex-1 text-slate-600 hover:text-blue-600 font-semibold text-sm transition-colors py-2">Edit</button>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-rose-600 hover:text-rose-700 font-semibold text-sm transition-colors py-2 text-center">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white border border-dashed border-slate-300 rounded-3xl">
                <p class="text-slate-400 font-medium">No products listed yet.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Add Modal --}}
<div id="add-product-modal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-3xl w-full max-w-xl p-8 shadow-2xl border border-slate-200">
        <h2 class="text-2xl font-bold mb-6 text-slate-900">Add New Product</h2>
        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Product Title</label>
                    <input type="text" name="title" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Premium Content Access" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="29.99" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Currency</label>
                    <select name="currency" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="GBP">GBP (£)</option>
                        <option value="NGN">NGN (₦)</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Image URL</label>
                    <input type="url" name="image_url" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell your customers about this product..."></textarea>
                </div>
            </div>
            <div class="flex gap-4 pt-6">
                <button type="button" onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-slate-600 font-bold border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-4 py-3 font-bold rounded-2xl hover:bg-slate-800 transition-colors shadow-lg shadow-slate-200">Save Product</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-product-modal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-3xl w-full max-w-xl p-8 shadow-2xl border border-slate-200">
        <h2 class="text-2xl font-bold mb-6 text-slate-900">Edit Product</h2>
        <form id="edit-product-form" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Product Title</label>
                    <input type="text" name="title" id="edit-title" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Price</label>
                    <input type="number" step="0.01" name="price" id="edit-price" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Currency</label>
                    <select name="currency" id="edit-currency" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="GBP">GBP (£)</option>
                        <option value="NGN">NGN (₦)</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Image URL</label>
                    <input type="url" name="image_url" id="edit-image-url" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Description</label>
                    <textarea name="description" id="edit-description" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="md:col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" id="edit-active" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="edit-active" class="text-sm font-semibold text-slate-700">Display this product on site</label>
                </div>
            </div>
            <div class="flex gap-4 pt-6">
                <button type="button" onclick="document.getElementById('edit-product-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-slate-600 font-bold border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-3 font-bold rounded-2xl hover:bg-blue-500 transition-colors shadow-lg shadow-blue-100">Update Product</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function editProduct(product) {
        const modal = document.getElementById('edit-product-modal');
        const form = document.getElementById('edit-product-form');
        
        document.getElementById('edit-title').value = product.title;
        document.getElementById('edit-price').value = product.price;
        document.getElementById('edit-currency').value = product.currency;
        document.getElementById('edit-image-url').value = product.image_url;
        document.getElementById('edit-description').value = product.description;
        document.getElementById('edit-active').checked = product.active;
        
        form.action = `/admin/products/${product.id}`;
        modal.classList.remove('hidden');
    }
</script>
@endpush
@endsection
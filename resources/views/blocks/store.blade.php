<section class="py-16 px-6 max-w-4xl mx-auto">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">{{ $content['title'] ?? 'Featured Store' }}</h2>
        <p class="text-slate-500">{{ $content['description'] ?? 'Premium items curated for you.' }}</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach(\App\Models\Product::where('active', true)->limit(4)->get() as $product)
            <div class="group bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                <div class="aspect-square relative overflow-hidden">
                    <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=800' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $product->name }}">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-sm font-bold shadow-sm">
                        ${{ number_format($product->price, 2) }}
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $product->name }}</h3>
                    <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $product->description }}</p>
                    <a href="https://wa.me/{{ str_replace(['+', ' '], '', $site_settings->whatsapp_number ?? '') }}?text=Hi, I'm interested in {{ urlencode($product->name) }}" class="w-full bg-[#25D366] text-white py-3 rounded-2xl font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.433 5.626 1.434h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Buy via WhatsApp
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
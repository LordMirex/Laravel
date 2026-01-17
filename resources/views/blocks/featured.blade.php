<section class="py-16 px-6 max-w-4xl mx-auto">
    <div class="mb-10 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 mb-2">{{ $content['title'] ?? 'Latest Content' }}</h2>
            <p class="text-slate-500">{{ $content['description'] ?? 'Highlights from my creative journey.' }}</p>
        </div>
        <a href="#" class="text-blue-600 font-bold text-sm hover:underline">See All</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach(\App\Models\Media::limit(2)->get() as $item)
            <div class="group relative aspect-video rounded-3xl overflow-hidden shadow-sm">
                <img src="{{ $item->url ?? 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=1200' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Featured Content">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <span class="text-[10px] font-bold uppercase tracking-widest bg-white/20 backdrop-blur-md px-2 py-1 rounded mb-2 inline-block">Featured</span>
                    <h3 class="font-bold text-xl">{{ $item->title ?? 'New Release' }}</h3>
                </div>
            </div>
        @endforeach
    </div>
</section>
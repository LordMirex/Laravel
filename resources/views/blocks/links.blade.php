<section class="py-16 px-6 max-w-2xl mx-auto">
    <div class="space-y-4">
        @foreach($content['links'] ?? [] as $link)
            <a href="{{ $link['url'] ?? '#' }}" class="group block bg-white border border-slate-200 p-6 rounded-2xl shadow-sm hover:shadow-md hover:scale-[1.02] transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.101-1.101"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $link['title'] ?? 'Link Title' }}</h3>
                            <p class="text-sm text-slate-500">{{ $link['description'] ?? 'Discover more content and details here.' }}</p>
                        </div>
                    </div>
                    <div class="text-slate-300 group-hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
<section class="py-16 px-6 max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="w-48 h-48 md:w-64 md:h-64 flex-shrink-0">
            <img src="{{ $content['image'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400' }}" 
                class="w-full h-full rounded-3xl object-cover shadow-xl rotate-3 group-hover:rotate-0 transition-transform duration-500" alt="About Image">
        </div>
        <div class="flex-1">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">{{ $content['title'] ?? 'About Me' }}</h2>
            <div class="prose prose-slate text-slate-600 leading-relaxed mb-8">
                {!! nl2br(e($content['bio'] ?? 'Share your journey, your passion, and what drives your creative process.')) !!}
            </div>
            <div class="flex gap-4">
                @foreach($content['socials'] ?? [] as $platform => $url)
                    <a href="{{ $url }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all">
                        <span class="sr-only">{{ $platform }}</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            {{-- Placeholder for social icons --}}
                            <circle cx="12" cy="12" r="8" />
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
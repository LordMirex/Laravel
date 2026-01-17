<section class="py-16 px-6 max-w-4xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($content['videos'] ?? [] as $video)
            <div class="group relative aspect-video rounded-3xl overflow-hidden shadow-sm">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $video['id'] ?? '' }}" 
                    title="Video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
        @endforeach
    </div>
</section>
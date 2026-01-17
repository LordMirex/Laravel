<section class="py-16 px-6 max-w-2xl mx-auto bg-slate-50 rounded-[3rem] my-12" id="newsletter">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">{{ $content['title'] ?? 'Join the Inner Circle' }}</h2>
        <p class="text-slate-500">{{ $content['description'] ?? 'Get exclusive content and updates delivered directly to your inbox.' }}</p>
    </div>
    
    <form action="/subscribe" method="POST" class="flex flex-col sm:flex-row gap-4">
        @csrf
        <input type="email" name="email" placeholder="your@email.com" 
            class="flex-1 px-6 py-4 rounded-2xl border-transparent focus:ring-2 focus:ring-blue-500 outline-none shadow-sm transition-all" required>
        <button type="submit" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
            Subscribe Now
        </button>
    </form>
</section>
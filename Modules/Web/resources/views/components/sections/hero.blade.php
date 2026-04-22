@props([
    'title' => __('Redefining Luxury Lifestyles'),
    'subtitle' => __('Established 2026'),
    'description' => __('Discover our curated collection of premium products, designed for those who appreciate the finer things in life.'),
    'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2000',
    'buttonText' => __('Explore Shop'),
    'buttonLink' => route('web.shop'),
    'showButton' => true,
    'compact' => false
])

<header class="relative {{ $compact ? 'py-24' : 'min-h-[80vh]' }} flex items-center pt-20 overflow-hidden bg-gray-900">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-bg-soft via-bg-soft/80 to-transparent z-10"></div>
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
        <div class="max-w-2xl">
            <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-[0.3em] rounded-full mb-6">
                {{ $subtitle }}
            </span>
            <h1 class="{{ $compact ? 'text-5xl' : 'text-7xl' }} font-bold text-gray-900 leading-tight mb-8">
                {!! $title !!}
            </h1>
            <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-lg">
                {{ $description }}
            </p>
            @if($showButton)
                <div class="flex items-center gap-6">
                    <a href="{{ $buttonLink }}" class="px-10 py-5 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
                        {{ $buttonText }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>

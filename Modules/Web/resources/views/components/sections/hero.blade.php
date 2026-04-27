@props([
    'title' => __('Redefining Luxury Lifestyles'),
    'subtitle' => __('Established 2026'),
    'description' => __('Discover our curated collection of premium products, designed for those who appreciate the finer things in life.'),
    'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2000',
    'buttonText' => __('Explore Shop'),
    'buttonLink' => route('web.shop'),
    'showButton' => true,
    'compact' => false,
    'slides' => null,
    'logo' => null
])

@if($slides && $slides->count() > 0)
    <div class="relative min-h-[60vh] md:min-h-[90vh] pt-20 hidden lg:block">
        <div class="swiper hero-swiper h-[50vh] md:h-[80vh]">
            <div class="swiper-wrapper">
                @foreach($slides as $slide)
                    <div class="swiper-slide relative flex items-center overflow-hidden bg-gray-900 rounded-[2rem] sm:rounded-[3rem] mx-2 sm:mx-8">
                        <div class="absolute inset-0 z-0">
                            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent z-10"></div>
                            <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                        </div>

                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
                            <div class="max-w-2xl">
                                @if($slide->subtitle)
                                    <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-[0.3em] rounded-full mb-6">
                                        {{ $slide->subtitle }}
                                    </span>
                                @endif
                                <h1 class="text-3xl md:text-7xl font-bold text-gray-900 leading-tight mb-4 md:mb-8">
                                    {!! $slide->title !!}
                                </h1>
                                @if($slide->description)
                                    <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-lg">
                                        {{ $slide->description }}
                                    </p>
                                @endif
                                @if($slide->link)
                                    <div class="flex items-center gap-6">
                                        <a href="{{ $slide->link }}" class="px-6 md:px-10 py-3 md:py-5 bg-primary text-white rounded-xl md:rounded-2xl font-bold text-sm md:text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
                                            {{ $slide->button_text ?: __('Explore Shop') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination !bottom-10"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-next !text-primary !w-12 !h-12 !bg-white/80 !backdrop-blur-md !rounded-full !after:text-lg shadow-lg"></div>
            <div class="swiper-button-prev !text-primary !w-12 !h-12 !bg-white/80 !backdrop-blur-md !rounded-full !after:text-lg shadow-lg"></div>
        </div>
    </div>
@else
    <header class="relative {{ $compact ? 'py-24' : 'min-h-[80vh]' }} flex items-center pt-20 overflow-hidden bg-gray-900 hidden lg:block">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent z-10"></div>
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
            <div class="max-w-2xl">
                @if($subtitle)
                    <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-[0.3em] rounded-full mb-6">
                        {{ $subtitle }}
                    </span>
                @endif
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
@endif

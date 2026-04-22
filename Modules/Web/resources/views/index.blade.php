<x-web::layouts.master>
    <div class="relative overflow-hidden">
        <!-- Hero Section -->
        <header class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-r from-bg-soft via-bg-soft/80 to-transparent z-10"></div>
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2000" alt="Luxury Interior" class="w-full h-full object-cover">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
                <div class="max-w-2xl">
                    <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase tracking-[0.3em] rounded-full mb-6">
                        {{ __('Established 2026') }}
                    </span>
                    <h1 class="text-7xl font-bold text-gray-900 leading-tight mb-8">
                        {{ __('Redefining') }} <br>
                        <span class="text-primary">{{ __('Luxury') }}</span> {{ __('Lifestyles') }}
                    </h1>
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-lg">
                        {{ __('Discover our curated collection of premium products, designed for those who appreciate the finer things in life.') }}
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('web.shop') }}" class="px-10 py-5 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
                            {{ __('Explore Shop') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Top Picks Section -->
        <section class="py-32 bg-white relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-6">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900">{{ __('Our Top Picks') }}</h2>
                        <p class="mt-4 text-gray-600 text-lg">{{ __('Hand-selected pieces from our latest collections.') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('web.shop') }}" class="px-6 py-3 bg-rose-50 text-primary rounded-xl font-bold hover:bg-primary hover:text-white transition-all duration-300">
                            {{ __('View All Products') }}
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($featuredProducts as $product)
                        <a href="{{ route('web.products.show', $product->id) }}" class="group relative bg-white rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-rose-50 hover:-translate-y-2">
                            <div class="aspect-square w-full overflow-hidden bg-rose-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-primary opacity-20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <span class="text-xs font-bold text-primary uppercase tracking-widest">{{ $product->category->name }}</span>
                                <h3 class="mt-2 text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-xl font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                        <span class="text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                    </div>
                                    <div class="p-2.5 rounded-full bg-rose-50 text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-20 bg-rose-50/30 rounded-3xl border-2 border-dashed border-rose-100">
                            <p class="text-primary opacity-60">{{ __('No products available yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <div id="categories">
            @foreach($categories as $category)
                @if($category->products->count() > 0)
                    <section id="category-{{ $category->id }}" class="py-20 border-t border-rose-50">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="flex justify-between items-end mb-10">
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h2>
                                    <p class="mt-2 text-gray-600">{{ __('Explore items in this category') }}</p>
                                </div>
                                <a href="{{ route('web.shop', ['category_id' => $category->id]) }}" class="text-primary font-bold hover:text-primary transition-colors">{{ __('View All') }}</a>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                                @foreach($category->products->sortBy('rank')->take(4) as $product)
                                    <a href="{{ route('web.products.show', $product->id) }}" class="group relative">
                                        <div class="aspect-square w-full rounded-2xl overflow-hidden bg-rose-50 shadow-sm transition-all duration-500 hover:-translate-y-1">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-primary opacity-20 text-4xl font-light">?</div>
                                            @endif
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-primary/5 transition-all duration-500"></div>
                                        </div>
                                        <div class="mt-4">
                                            <h3 class="text-sm font-bold text-gray-700 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                <span class="text-xs font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach
        </div>
    </div>
</x-web::layouts.master>

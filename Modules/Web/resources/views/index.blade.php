<x-web::layouts.master>
    <x-slot:title>{{ $currentVendor ? $currentVendor->name . ' - ' : '' }}Yasmina</x-slot:title>
    <div class="relative overflow-hidden">
        <!-- Hero Section -->
        <x-web::sections.hero :slides="$slides" />

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
                        <div class="group relative bg-white rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-rose-50 hover:-translate-y-2 flex flex-col h-full">
                            <div class="aspect-square w-full overflow-hidden bg-rose-50 relative">
                                <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}" class="block w-full h-full">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-primary opacity-20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                @if($product->discount_price && $product->discount_price < $product->price)
                                    <div class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg z-20">
                                        {{ __('Sale') }}
                                    </div>
                                @endif
                                @auth
                                    @php $isFavorited = auth()->user()->wishlist()->where('product_id', $product->id)->exists(); @endphp
                                    <button onclick="toggleWishlist({{ $product->id }}, this)" class="absolute top-4 right-4 w-10 h-10 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all group/wish">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/wish:text-red-500' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                @endauth
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <span class="text-xs font-bold text-primary uppercase tracking-widest">{{ $product->category->name }}</span>
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-[10px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}">
                                        <h3 class="mt-2 text-lg font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                    </a>
                                </div>
                                <div class="mt-6 flex flex-col gap-4">
                                    <div class="flex flex-col">
                                        @if($product->discount_price && $product->discount_price < $product->price)
                                            <span class="text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-2xl font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                                <span class="text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                            </div>
                                        @else
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-2xl font-black text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                <span class="text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <form action="{{ route('web.cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-gray-50 text-gray-700 rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-2 group/btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            {{ __('Add to Bag') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                                        <div class="group relative flex flex-col h-full">
                                            <div class="aspect-square w-full rounded-2xl overflow-hidden bg-rose-50 shadow-sm transition-all duration-500 hover:-translate-y-1 relative">
                                                <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}" class="block w-full h-full">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-primary opacity-20 text-4xl font-light">?</div>
                                                    @endif
                                                </a>
                                                @if($product->discount_price && $product->discount_price < $product->price)
                                                    <div class="absolute top-3 left-3 bg-red-500 text-white text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shadow-lg z-20">
                                                        {{ __('Sale') }}
                                                    </div>
                                                @endif
                                                @auth
                                                    @php $isFavorited = auth()->user()->wishlist()->where('product_id', $product->id)->exists(); @endphp
                                                    <button onclick="toggleWishlist({{ $product->id }}, this)" class="absolute top-3 right-3 w-8 h-8 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-md hover:bg-white transition-all group/wish">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/wish:text-red-500' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                @endauth
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-primary/5 pointer-events-none transition-all duration-500"></div>
                                            </div>
                                            <div class="mt-4 flex-1 flex flex-col justify-between">
                                                <div>
                                                    <div class="flex justify-between items-center mb-1">
                                                        <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}">
                                                            <h3 class="text-sm font-bold text-gray-700 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                                        </a>
                                                        <div class="flex items-center gap-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                            <span class="text-[9px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        @if($product->discount_price && $product->discount_price < $product->price)
                                                            <span class="text-[10px] text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                            <div class="flex items-baseline gap-0.5">
                                                                <span class="text-base font-bold text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                                                <span class="text-[10px] font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="flex items-baseline gap-1">
                                                                <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                                <span class="text-xs font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </section>
                @endif
            @endforeach
        </div>
    </div>

</x-web::layouts.master>

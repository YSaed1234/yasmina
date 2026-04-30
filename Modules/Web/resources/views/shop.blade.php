<x-web::layouts.master>
    <x-slot:title>{{ $currentVendor ? $currentVendor->name . ' - ' : '' }}{{ __('Shop All Products') }} - Yasmina</x-slot:title>

    <x-web::sections.hero 
        :slides="$slides"
        :title="$currentVendor ? $currentVendor->name : __('Our Collection')"
        :description="$currentVendor && $currentVendor->description ? $currentVendor->description : __('Discover our range of luxury products carefully curated for you.')"
        :logo="$currentVendor ? $currentVendor->logo : null"
        :image="$currentVendor && $currentVendor->about_image1 ? asset('storage/' . $currentVendor->about_image1) : 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2000'"
        :showButton="false"
        compact="true"
    />

    <div class="py-10 lg:py-20 bg-white" x-data="{ showFilters: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Mobile Filter Toggle -->
            <div class="lg:hidden mb-6 flex items-center justify-between bg-yasmina-50/50 p-4 rounded-2xl border border-yasmina-100">
                <span class="text-sm font-bold text-gray-900">{{ __('Filters') }}</span>
                <button @click="showFilters = !showFilters" class="flex items-center gap-2 text-primary font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span x-text="showFilters ? '{{ __('Hide') }}' : '{{ __('Show') }}'"></span>
                </button>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Filters Sidebar -->
                <aside class="w-full lg:w-64 flex-shrink-0 lg:block" :class="showFilters ? 'block' : 'hidden'">
                    <form action="{{ route('web.shop') }}" method="GET" class="space-y-6 lg:space-y-8 sticky top-32">
                        <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                        <!-- Search -->
                        <div>
                            <label class="block text-[10px] lg:text-sm font-bold text-gray-900 uppercase tracking-widest mb-3 lg:mb-4">{{ __('Search') }}</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Product name...') }}" class="w-full pl-10 pr-4 py-2.5 lg:py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-xs lg:text-sm transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5 absolute left-3 top-3 lg:top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-[10px] lg:text-sm font-bold text-gray-900 uppercase tracking-widest mb-3 lg:mb-4">{{ __('Category') }}</label>
                            <select name="category_id" class="w-full px-4 py-2.5 lg:py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-xs lg:text-sm appearance-none cursor-pointer shadow-sm">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label class="block text-[10px] lg:text-sm font-bold text-gray-900 uppercase tracking-widest mb-3 lg:mb-4">{{ __('Currency') }}</label>
                            <select name="currency_id" class="w-full px-4 py-2.5 lg:py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-xs lg:text-sm appearance-none cursor-pointer shadow-sm">
                                <option value="">{{ __('All Currencies') }}</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ request('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->name }} ({{ $currency->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-[10px] lg:text-sm font-bold text-gray-900 uppercase tracking-widest mb-3 lg:mb-4">{{ __('Price Range') }}</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('Min') }}" class="w-full px-4 py-2.5 lg:py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-xs lg:text-sm shadow-sm">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('Max') }}" class="w-full px-4 py-2.5 lg:py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-xs lg:text-sm shadow-sm">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 lg:py-4 bg-primary text-white rounded-2xl font-bold text-sm lg:text-base hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                            {{ __('Apply Filters') }}
                        </button>

                        @if(request()->anyFilled(['search', 'category_id', 'currency_id', 'min_price', 'max_price']))
                            <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="block text-center text-xs lg:text-sm font-bold text-primary hover:underline transition-all">
                                {{ __('Clear All Filters') }}
                            </a>
                        @endif
                    </form>
                </aside>

                <!-- Product Grid -->
                <div class="flex-1">
                    <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-3 gap-2 lg:gap-8">
                        @forelse($products as $product)
                            <div class="group bg-white rounded-xl lg:rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-yasmina-50 hover:-translate-y-1 lg:hover:-translate-y-2 flex flex-col relative">
                                <div class="aspect-square w-full overflow-hidden bg-yasmina-50 relative">
                                    <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => request()->has('vendor_id') ? request('vendor_id') : $product->vendor_id]) }}" class="block w-full h-full">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-primary opacity-20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 lg:h-12 lg:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    @if($badge = $product->getBadge())
                                        <div class="absolute top-1.5 lg:top-4 left-1.5 lg:left-4 {{ $badge['color'] }} text-[6px] lg:text-[10px] font-black uppercase tracking-widest px-1.5 lg:px-3 py-0.5 lg:py-1 rounded-full shadow-lg z-20 flex items-center gap-1">
                                            @if($product->hasActiveFlashSale())
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 lg:h-3 lg:w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            @endif
                                            {{ $badge['label'] }}
                                        </div>
                                    @endif

                                    @if($product->hasActiveFlashSale())
                                        <div class="absolute bottom-1.5 lg:bottom-4 left-0 right-0 px-1.5 lg:px-4 z-20">
                                            <div class="bg-white/90 backdrop-blur-md rounded-lg lg:rounded-2xl p-1 lg:p-2 shadow-xl border border-amber-100 flex items-center justify-center gap-1.5 lg:gap-3 text-amber-600" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                                <div class="text-center">
                                                    <span class="hours block text-[8px] lg:text-xs font-black">00</span>
                                                    <span class="text-[5px] lg:text-[8px] uppercase tracking-tighter">{{ __('Hrs') }}</span>
                                                </div>
                                                <div class="w-px h-2.5 lg:h-4 bg-amber-200"></div>
                                                <div class="text-center">
                                                    <span class="minutes block text-[8px] lg:text-xs font-black">00</span>
                                                    <span class="text-[5px] lg:text-[8px] uppercase tracking-tighter">{{ __('Min') }}</span>
                                                </div>
                                                <div class="w-px h-2.5 lg:h-4 bg-amber-200"></div>
                                                <div class="text-center">
                                                    <span class="seconds block text-[8px] lg:text-xs font-black">00</span>
                                                    <span class="text-[5px] lg:text-[8px] uppercase tracking-tighter">{{ __('Sec') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @auth
                                        @php $isFavorited = auth()->user()->wishlist()->where('product_id', $product->id)->exists(); @endphp
                                        <form action="{{ route('web.wishlist.toggle', $product->id) }}" method="POST" class="absolute top-1.5 lg:top-4 right-1.5 lg:right-4 z-30">
                                            @csrf
                                            <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                                            <button type="submit" class="w-7 h-7 lg:w-10 lg:h-10 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all group/wish">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-5 lg:w-5 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/wish:text-red-500' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                                <div class="p-2 lg:p-6 flex-1 flex flex-col relative z-10">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-[7px] lg:text-xs font-bold text-primary uppercase tracking-widest truncate max-w-[70%] hidden lg:block">{{ $product->category->name }}</span>
                                        <div class="flex items-center gap-0.5 lg:gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 lg:h-3 lg:w-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-[7px] lg:text-[10px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => request()->has('vendor_id') ? request('vendor_id') : $product->vendor_id]) }}">
                                        <h3 class="text-xs lg:text-lg font-bold text-gray-900 mb-2 lg:mb-4 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                    </a>
                                    <div class="mt-auto flex justify-between items-center gap-1">
                                        <div class="flex flex-col">
                                            @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                                <span class="text-[7px] lg:text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                    <span class="text-xs lg:text-xl font-black text-amber-600">{{ number_format($product->flash_sale_price, 2) }}</span>
                                                    <span class="text-[7px] lg:text-sm font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                                </div>
                                            @elseif($product->discount_price && $product->discount_price < $product->price)
                                                <span class="text-[7px] lg:text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                    <span class="text-xs lg:text-xl font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                                    <span class="text-[7px] lg:text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                </div>
                                            @else
                                                <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                    <span class="text-xs lg:text-xl font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                    <span class="text-[7px] lg:text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <form action="{{ route('web.cart.add', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" method="POST">
                                            @csrf
                                            <button type="submit" @if($product->total_stock <= 0) disabled @endif class="w-7 h-7 lg:w-11 lg:h-11 rounded-lg lg:rounded-2xl {{ $product->total_stock <= 0 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-yasmina-50 text-primary hover:bg-primary hover:text-white' }} transition-all duration-300 shadow-sm flex items-center justify-center group/btn">
                                                @if($product->total_stock <= 0)
                                                    <span class="text-[5px] lg:text-[8px] font-black uppercase tracking-widest">{{ __('Sold Out') }}</span>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 lg:py-24 bg-yasmina-50/30 rounded-3xl border-2 border-dashed border-yasmina-100">
                                <div class="w-16 h-16 lg:w-20 lg:h-20 bg-yasmina-50 rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 lg:h-10 lg:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg lg:text-xl font-bold text-gray-900 mb-2">{{ __('No matches found') }}</h3>
                                <p class="text-xs lg:text-sm text-gray-500">{{ __('Try adjusting your search or filters to find what you\'re looking for.') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 lg:mt-16">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

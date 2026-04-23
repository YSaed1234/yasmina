<x-web::layouts.master>
    <x-slot:title>{{ $currentVendor ? $currentVendor->name . ' - ' : '' }}{{ __('Shop All Products') }} - Yasmina</x-slot:title>

    <div class="pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12">
                <h1 class="text-4xl font-bold text-gray-900">{{ $currentVendor ? $currentVendor->name : __('Our Collection') }}</h1>
                <p class="mt-4 text-gray-600">{{ __('Discover our range of luxury products carefully curated for you.') }}</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Filters Sidebar -->
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <form action="{{ route('web.shop') }}" method="GET" class="space-y-8 sticky top-32">
                        <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">{{ __('Search') }}</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Product name...') }}" class="w-full pl-10 pr-4 py-3 bg-white border border-rose-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-sm transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">{{ __('Category') }}</label>
                            <select name="category_id" class="w-full px-4 py-3 bg-white border border-rose-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-sm appearance-none cursor-pointer shadow-sm">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">{{ __('Currency') }}</label>
                            <select name="currency_id" class="w-full px-4 py-3 bg-white border border-rose-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-sm appearance-none cursor-pointer shadow-sm">
                                <option value="">{{ __('All Currencies') }}</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ request('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->name }} ({{ $currency->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">{{ __('Price Range') }}</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('Min') }}" class="w-full px-4 py-3 bg-white border border-rose-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-sm shadow-sm">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('Max') }}" class="w-full px-4 py-3 bg-white border border-rose-50 rounded-2xl focus:ring-2 focus:ring-primary outline-none text-sm shadow-sm">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                            {{ __('Apply Filters') }}
                        </button>

                        @if(request()->anyFilled(['search', 'category_id', 'currency_id', 'min_price', 'max_price']))
                            <a href="{{ route('web.shop') }}" class="block text-center text-sm font-bold text-primary hover:underline transition-all">
                                {{ __('Clear All Filters') }}
                            </a>
                        @endif
                    </form>
                </aside>

                <!-- Product Grid -->
                <div class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @forelse($products as $product)
                            <div class="group bg-white rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-rose-50 hover:-translate-y-2 flex flex-col relative">
                                <div class="aspect-square w-full overflow-hidden bg-rose-50 relative">
                                    <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => request()->has('vendor_id') ? request('vendor_id') : $product->vendor_id]) }}" class="block w-full h-full">
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
                                    @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                        <div class="absolute top-4 left-4 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg z-20 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            {{ __('Flash Sale') }}
                                        </div>
                                        <div class="absolute bottom-4 left-0 right-0 px-4 z-20">
                                            <div class="bg-white/90 backdrop-blur-md rounded-2xl p-2 shadow-xl border border-amber-100 flex items-center justify-center gap-3 text-amber-600" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                                <div class="text-center">
                                                    <span class="hours block text-xs font-black">00</span>
                                                    <span class="text-[8px] uppercase tracking-tighter">{{ __('Hrs') }}</span>
                                                </div>
                                                <div class="w-px h-4 bg-amber-200"></div>
                                                <div class="text-center">
                                                    <span class="minutes block text-xs font-black">00</span>
                                                    <span class="text-[8px] uppercase tracking-tighter">{{ __('Min') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($product->discount_price && $product->discount_price < $product->price)
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
                                <div class="p-6 flex-1 flex flex-col relative z-10">
                                    <div class="flex justify-between items-start">
                                        <span class="text-xs font-bold text-primary uppercase tracking-widest">{{ $product->category->name }}</span>
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-[10px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => request()->has('vendor_id') ? request('vendor_id') : $product->vendor_id]) }}">
                                        <h3 class="mt-2 text-lg font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                    </a>
                                    <div class="mt-auto flex justify-between items-center">
                                        <div class="flex flex-col">
                                            @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                                <span class="text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-xl font-black text-amber-600">{{ number_format($product->flash_sale_price, 2) }}</span>
                                                    <span class="text-sm font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                                </div>
                                            @elseif($product->discount_price && $product->discount_price < $product->price)
                                                <span class="text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-xl font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                                    <span class="text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                </div>
                                            @else
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-xl font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                    <span class="text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <form action="{{ route('web.cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-3 rounded-2xl bg-rose-50 text-primary hover:bg-primary hover:text-white transition-all duration-300 shadow-sm flex items-center gap-2 group/btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-24 bg-rose-50/30 rounded-3xl border-2 border-dashed border-rose-100">
                                <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No matches found') }}</h3>
                                <p class="text-gray-500">{{ __('Try adjusting your search or filters to find what you\'re looking for.') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-16">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

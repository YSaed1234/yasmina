<x-web::layouts.master>
    <x-slot:title>{{ $currentVendor ? $currentVendor->name . ' - ' : '' }}Yasmina</x-slot:title>
    <div class="relative overflow-hidden">
        <!-- Hero Section -->
        <x-web::sections.hero 
            :slides="$slides" 
            :logo="$currentVendor ? $currentVendor->logo : null"
        />

        @if($coupons->count() > 0)
        <!-- Coupons Section -->
        <section class="py-6 lg:py-16 bg-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex items-center justify-between mb-6 lg:mb-10">
                    <div>
                        <span class="text-primary font-black text-[8px] lg:text-xs uppercase tracking-[0.3em] mb-1 lg:mb-2 block">{{ __('Limited Time') }}</span>
                        <h2 class="text-lg lg:text-3xl font-bold text-gray-900">{{ __('Available Coupons') }}</h2>
                    </div>
                    <div class="hidden sm:block">
                        <div class="flex items-center gap-2 text-gray-400 text-[10px] lg:text-xs font-medium bg-yasmina-50 px-4 py-2 rounded-full border border-yasmina-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Click code to copy') }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-6">
                    @foreach($coupons as $coupon)
                        <div class="group relative bg-gradient-to-br from-yasmina-50 to-white rounded-2xl lg:rounded-3xl p-3.5 lg:p-6 border border-yasmina-100/50 hover:border-primary/30 transition-all duration-300 flex items-center gap-3 lg:gap-6 overflow-hidden">
                            <!-- Ticket Notch -->
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full border border-yasmina-100/50 z-10"></div>
                            <div class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full border border-yasmina-100/50 z-10"></div>
                            
                            <div class="w-12 h-12 lg:w-20 lg:h-20 bg-primary/10 rounded-xl lg:rounded-2xl flex flex-col items-center justify-center text-primary shrink-0 border border-primary/5">
                                <span class="text-xs lg:text-xl font-black leading-none">
                                    {{ $coupon->type === 'percentage' ? number_format($coupon->value, 0) : number_format($coupon->value, 0) }}
                                </span>
                                <span class="text-[6px] lg:text-[10px] font-bold uppercase tracking-widest mt-0.5 lg:mt-1">
                                    {{ $coupon->type === 'percentage' ? '%' : ($currentVendor->currency?->symbol ?? '$') }}
                                </span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col">
                                    <h3 class="text-[10px] lg:text-base font-bold text-gray-900 uppercase tracking-tight">{{ __('Discount Coupon') }}</h3>
                                    <p class="text-[8px] lg:text-xs text-gray-500 mt-0.5 truncate">
                                        @if($coupon->min_order_amount > 0)
                                            {{ __('Min. Order') }}: {{ number_format($coupon->min_order_amount, 2) }} {{ $currentVendor->currency?->symbol ?? '$' }}
                                        @else
                                            {{ __('No Minimum Order') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="mt-2 lg:mt-4 flex items-center gap-1.5 lg:gap-3">
                                    <button 
                                        onclick="copyCouponCode('{{ $coupon->code }}', this)"
                                        class="flex-1 bg-white border-2 border-dashed border-yasmina-200 rounded-lg lg:rounded-xl py-1.5 lg:py-2.5 px-3 lg:px-4 text-center group/code relative hover:border-primary/50 transition-all"
                                    >
                                        <span class="text-[10px] lg:text-sm font-black text-gray-700 tracking-widest">{{ $coupon->code }}</span>
                                        <div class="absolute inset-0 bg-primary text-white text-[8px] lg:text-[10px] font-black uppercase tracking-widest flex items-center justify-center opacity-0 group-active/code:opacity-100 transition-opacity rounded-lg lg:rounded-xl">
                                            {{ __('Copied!') }}
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <script>
            function copyCouponCode(code, btn) {
                navigator.clipboard.writeText(code).then(() => {
                    // Feedback handled by CSS active state for immediate response
                    // Additional persistent feedback could be added here if needed
                });
            }
        </script>
        @endif

        @if($promotions->count() > 0)
        <!-- Promotions Section -->
        <section class="py-12 lg:py-24 bg-yasmina-50/50 relative overflow-hidden">
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-48 h-48 lg:w-96 lg:h-96 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-48 h-48 lg:w-96 lg:h-96 bg-primary/5 rounded-full blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-8 lg:mb-16">
                    <span class="text-primary font-black text-[8px] lg:text-xs uppercase tracking-[0.3em] mb-2 lg:mb-4 block">{{ __('Exclusive Deals') }}</span>
                    <h2 class="text-xl lg:text-4xl font-bold text-gray-900">{{ __('Special Offers for You') }}</h2>
                    <div class="w-12 lg:w-20 h-0.5 lg:h-1 bg-primary mx-auto mt-4 lg:mt-6 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-10">
                    @foreach($promotions as $promotion)
                        <div class="group relative bg-white rounded-3xl lg:rounded-[2.5rem] p-4 lg:p-8 soft-shadow border border-yasmina-100 hover:border-primary/20 transition-all duration-500 overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute -top-10 -right-10 w-20 h-20 lg:w-40 lg:h-40 bg-yasmina-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>
                            
                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4 lg:mb-8">
                                    <div class="w-10 h-10 lg:w-14 lg:h-14 bg-primary/10 rounded-xl lg:rounded-2xl flex items-center justify-center text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-7 lg:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                        </svg>
                                    </div>
                                    <div class="bg-primary text-white text-[8px] lg:text-[10px] font-black px-3 lg:px-4 py-1 lg:py-1.5 rounded-full uppercase tracking-widest shadow-lg shadow-primary/20">
                                        {{ $promotion->type === 'bogo_same' ? __('BOGO') : __('Bundle') }}
                                    </div>
                                </div>

                                <h3 class="text-lg lg:text-2xl font-bold text-gray-900 mb-1 lg:mb-2">{{ $promotion->name }}</h3>
                                <p class="text-gray-500 text-xs lg:text-sm mb-4 lg:mb-8 leading-relaxed">
                                    @if($promotion->type === 'bogo_same')
                                        {{ __('Buy :buy get :get free on :product', ['buy' => $promotion->buy_quantity, 'get' => $promotion->get_quantity, 'product' => $promotion->buyProduct->name]) }}
                                    @elseif($promotion->type === 'bogo_different')
                                        {{ __('Buy :buy from :product1 and get :get from :product2 for free!', ['buy' => $promotion->buy_quantity, 'product1' => $promotion->buyProduct->name, 'get' => $promotion->get_quantity, 'product2' => $promotion->getProduct->name]) }}
                                    @endif
                                </p>

                                <div class="flex items-center gap-3 lg:gap-6 mb-4 lg:mb-8 p-3 lg:p-4 bg-yasmina-50/50 rounded-2xl lg:rounded-3xl border border-yasmina-100/50">
                                    <div class="flex -space-x-2 lg:-space-x-4">
                                        @if($promotion->buyProduct && $promotion->buyProduct->image)
                                            <img src="{{ asset('storage/' . $promotion->buyProduct->image) }}" class="w-8 h-8 lg:w-12 lg:h-12 rounded-lg lg:rounded-2xl object-cover ring-2 lg:ring-4 ring-white" alt="">
                                        @endif
                                        @if($promotion->type === 'bogo_different' && $promotion->getProduct && $promotion->getProduct->image)
                                            <img src="{{ asset('storage/' . $promotion->getProduct->image) }}" class="w-8 h-8 lg:w-12 lg:h-12 rounded-lg lg:rounded-2xl object-cover ring-2 lg:ring-4 ring-white" alt="">
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[8px] lg:text-[10px] font-bold text-primary uppercase tracking-widest">{{ __('Deal Items') }}</span>
                                        <span class="text-[10px] lg:text-xs text-gray-600 font-medium truncate max-w-[150px]">{{ $promotion->buyProduct->name }} {{ $promotion->type === 'bogo_different' ? '+ ' . $promotion->getProduct->name : '' }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 lg:gap-3">
                                    <a href="{{ route('web.promotions.show', ['id' => $promotion->id, 'vendor_id' => request('vendor_id')]) }}" class="flex-1 py-3 lg:py-4 bg-gray-900 text-white rounded-xl lg:rounded-2xl text-[10px] lg:text-xs font-bold uppercase tracking-widest text-center hover:bg-primary transition-all duration-300 shadow-xl shadow-gray-900/10">
                                        {{ __('View Details') }}
                                    </a>
                                    <form action="{{ route('web.cart.add', ['id' => $promotion->buyProduct->id, 'vendor_id' => request('vendor_id')]) }}" method="POST" class="contents">
                                        @csrf
                                        <input type="hidden" name="quantity" value="{{ $promotion->buy_quantity }}">
                                        <button type="submit" class="w-10 h-10 lg:w-14 lg:h-14 bg-primary text-white rounded-xl lg:rounded-2xl flex items-center justify-center hover:scale-105 transition-all duration-300 shadow-xl shadow-primary/20 group/add">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Top Picks Section -->
        <section class="py-12 lg:py-32 bg-white relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 lg:mb-20 gap-4 lg:gap-6">
                    <div>
                        <h2 class="text-xl lg:text-4xl font-bold text-gray-900">{{ __('Our Top Picks') }}</h2>
                        <p class="mt-2 lg:mt-4 text-gray-600 text-sm lg:text-lg">{{ __('Hand-selected pieces from our latest collections.') }}</p>
                    </div>
                    <div class="flex">
                        <a href="{{ route('web.shop') }}" class="text-xs lg:text-base px-4 lg:px-6 py-2 lg:py-3 bg-yasmina-50 text-primary rounded-xl font-bold hover:bg-primary hover:text-white transition-all duration-300">
                            {{ __('View All Products') }}
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-2 lg:gap-8">
                    @forelse($featuredProducts as $product)
                        <div class="group relative bg-white rounded-xl lg:rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-yasmina-50 hover:-translate-y-1 lg:hover:-translate-y-2 flex flex-col h-full">
                            <div class="aspect-square w-full overflow-hidden bg-yasmina-50 relative">
                                <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}" class="block w-full h-full">
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
                                    @php $isFavorited = auth()->user()?->wishlist()?->where('product_id', $product->id)->exists(); @endphp
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
                            <div class="p-2 lg:p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-[7px] lg:text-xs font-bold text-primary uppercase tracking-widest truncate max-w-[70%] hidden lg:block">{{ $product->category->name }}</span>
                                        <div class="flex items-center gap-0.5 lg:gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 lg:h-3 lg:w-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-[7px] lg:text-[10px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}">
                                        <h3 class="text-xs lg:text-lg font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                    </a>
                                </div>
                                <div class="mt-4 flex flex-col gap-2 lg:gap-4">
                                    <div class="flex flex-col">
                                        @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                            <span class="text-[7px] lg:text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                            <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                <span class="text-xs lg:text-2xl font-black text-amber-600">{{ number_format($product->flash_sale_price, 2) }}</span>
                                                <span class="text-[7px] lg:text-sm font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                            </div>
                                        @elseif($product->discount_price && $product->discount_price < $product->price)
                                            <span class="text-[7px] lg:text-xs text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                            <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                <span class="text-xs lg:text-2xl font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                                <span class="text-[7px] lg:text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                            </div>
                                        @else
                                            <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                <span class="text-xs lg:text-2xl font-black text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                <span class="text-[7px] lg:text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <form action="{{ route('web.cart.add', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" method="POST">
                                        @csrf
                                        <button type="submit" @if($product->total_stock <= 0) disabled @endif class="w-full py-2 lg:py-3 {{ $product->total_stock <= 0 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-yasmina-50 text-primary hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/20' }} rounded-xl lg:rounded-2xl text-[8px] lg:text-xs font-bold uppercase tracking-widest transition-all flex items-center justify-center gap-1 lg:gap-2 group/btn">
                                            @if($product->total_stock <= 0)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                {{ __('Sold Out') }}
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 lg:h-4 lg:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                                {{ __('Add to Bag') }}
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-yasmina-50/30 rounded-3xl border-2 border-dashed border-yasmina-100">
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
                    <section id="category-{{ $category->id }}" class="py-12 lg:py-20 border-t border-yasmina-50">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="flex justify-between items-end mb-8 lg:mb-10">
                                <div>
                                    <h2 class="text-xl lg:text-3xl font-bold text-gray-900">{{ $category->name }}</h2>
                                    <p class="mt-1 lg:mt-2 text-xs lg:text-sm text-gray-600">{{ __('Explore items in this category') }}</p>
                                </div>
                                <a href="{{ route('web.shop', ['category_id' => $category->id]) }}" class="text-xs lg:text-base text-primary font-bold hover:text-primary transition-colors">{{ __('View All') }}</a>
                            </div>

                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-2 lg:gap-8">
                                    @foreach($category->products->where('vendor_id', $vendor?->id)->sortBy('rank')->take(4) as $product)
                                        <div class="group relative flex flex-col h-full bg-white rounded-xl lg:rounded-2xl border border-yasmina-50 soft-shadow overflow-hidden">
                                            <div class="aspect-square w-full overflow-hidden bg-yasmina-50 relative">
                                                <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}" class="block w-full h-full">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-primary opacity-20 text-4xl font-light">?</div>
                                                    @endif
                                                </a>
                                                @if($badge = $product->getBadge())
                                                    <div class="absolute top-1.5 lg:top-3 left-1.5 lg:left-3 {{ $badge['color'] }} text-[6px] lg:text-[8px] font-black uppercase tracking-widest px-1.5 lg:px-2 py-0.5 rounded-full shadow-lg z-20 flex items-center gap-1">
                                                        @if($product->hasActiveFlashSale())
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                            </svg>
                                                        @endif
                                                        {{ $badge['label'] }}
                                                    </div>
                                                @endif

                                                @if($product->hasActiveFlashSale())
                                                    <div class="absolute bottom-1.5 lg:bottom-3 left-0 right-0 px-1.5 lg:px-3 z-20">
                                                        <div class="bg-white/90 backdrop-blur-md rounded-lg lg:rounded-xl p-1 lg:p-1.5 shadow-xl border border-amber-100 flex items-center justify-center gap-1.5 lg:gap-2 text-amber-600" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                                            <div class="text-center">
                                                                <span class="hours block text-[8px] lg:text-[10px] font-black">00</span>
                                                                <span class="text-[5px] lg:text-[6px] uppercase tracking-tighter">{{ __('Hrs') }}</span>
                                                            </div>
                                                            <div class="w-px h-2.5 lg:h-3 bg-amber-200"></div>
                                                            <div class="text-center">
                                                                <span class="minutes block text-[8px] lg:text-[10px] font-black">00</span>
                                                                <span class="text-[5px] lg:text-[6px] uppercase tracking-tighter">{{ __('Min') }}</span>
                                                            </div>
                                                            <div class="w-px h-2.5 lg:h-3 bg-amber-200"></div>
                                                            <div class="text-center">
                                                                <span class="seconds block text-[8px] lg:text-[10px] font-black">00</span>
                                                                <span class="text-[5px] lg:text-[6px] uppercase tracking-tighter">{{ __('Sec') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @auth
                                                    @php $isFavorited = auth()->user()->wishlist()->where('product_id', $product->id)->exists(); @endphp
                                                    <form action="{{ route('web.wishlist.toggle', $product->id) }}" method="POST" class="absolute top-1.5 lg:top-3 right-1.5 lg:right-3 z-30">
                                                        @csrf
                                                        <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                                                        <button type="submit" class="w-7 h-7 lg:w-8 lg:h-8 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-md hover:bg-white transition-all group/wish">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-4 lg:w-4 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/wish:text-red-500' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endauth
                                            </div>
                                            <div class="p-2 lg:p-4 flex-1 flex flex-col justify-between">
                                                <div>
                                                    <div class="flex justify-between items-center mb-1">
                                                        <a href="{{ route('web.products.show', [$product->id, 'vendor_id' => $product->vendor_id]) }}">
                                                            <h3 class="text-[10px] lg:text-sm font-bold text-gray-700 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                                        </a>
                                                        <div class="flex items-center gap-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 lg:h-2.5 lg:w-2.5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                            <span class="text-[7px] lg:text-[9px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                                            <span class="text-[8px] lg:text-[10px] text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                            <div class="flex items-baseline gap-0.5">
                                                                <span class="text-xs lg:text-base font-bold text-amber-600">{{ number_format($product->flash_sale_price, 2) }}</span>
                                                                <span class="text-[8px] lg:text-[10px] font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                                            </div>
                                                        @elseif($product->discount_price && $product->discount_price < $product->price)
                                                            <span class="text-[8px] lg:text-[10px] text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                                            <div class="flex items-baseline gap-0.5">
                                                                <span class="text-xs lg:text-base font-bold text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                                                <span class="text-[8px] lg:text-[10px] font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                            </div>
                                                        @else
                                                            <div class="flex items-baseline gap-0.5">
                                                                <span class="text-xs lg:text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                                                <span class="text-[8px] lg:text-xs font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
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

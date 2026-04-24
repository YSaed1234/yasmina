<x-web::layouts.master>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-web::profile-sidebar />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-rose-50">
                        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('My Favorites') }}</h1>
                        
                        @if($wishlistItems->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                                @foreach($wishlistItems as $item)
                                    @php $product = $item->product; @endphp
                                    <div id="wishlist-item-{{ $product->id }}" class="group bg-white rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-rose-50 hover:-translate-y-2 flex flex-col relative">
                                        <div class="aspect-square w-full overflow-hidden bg-rose-50 relative">
                                            <a href="{{ route('web.products.show', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" class="block w-full h-full">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-primary opacity-20">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            @if($badge = $product->getBadge())
                                                <div class="absolute top-4 left-4 {{ $badge['color'] }} text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shadow-lg z-20 flex items-center gap-1">
                                                    @if($product->hasActiveFlashSale())
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                    @endif
                                                    {{ $badge['label'] }}
                                                </div>
                                            @endif

                                            @if($product->hasActiveFlashSale())
                                                <div class="absolute bottom-3 left-0 right-0 px-3 z-20">
                                                    <div class="bg-white/90 backdrop-blur-md rounded-xl p-1.5 shadow-xl border border-amber-100 flex items-center justify-center gap-2 text-amber-600" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                                        <div class="text-center">
                                                            <span class="hours block text-[10px] font-black">00</span>
                                                            <span class="text-[6px] uppercase tracking-tighter">{{ __('Hrs') }}</span>
                                                        </div>
                                                        <div class="w-px h-3 bg-amber-200"></div>
                                                        <div class="text-center">
                                                            <span class="minutes block text-[10px] font-black">00</span>
                                                            <span class="text-[6px] uppercase tracking-tighter">{{ __('Min') }}</span>
                                                        </div>
                                                        <div class="w-px h-3 bg-amber-200"></div>
                                                        <div class="text-center">
                                                            <span class="seconds block text-[10px] font-black">00</span>
                                                            <span class="text-[6px] uppercase tracking-tighter">{{ __('Sec') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            </a>
                                            <button onclick="removeFromWishlist({{ $product->id }}, this)" class="absolute top-4 right-4 w-10 h-10 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all group/wish">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
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
                                            <a href="{{ route('web.products.show', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}">
                                                <h3 class="mt-2 text-lg font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                            </a>
                                            <div class="mt-auto flex justify-between items-center">
                                                <div class="flex flex-col">
                                                    @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                                        <span class="text-[10px] text-gray-400 line-through leading-none mb-1">{{ number_format($product->price, 2) }}</span>
                                                        <div class="flex items-baseline gap-0.5">
                                                            <span class="text-lg font-black text-amber-600 leading-none">{{ number_format($product->flash_sale_price, 2) }}</span>
                                                            <span class="text-[10px] font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                                        </div>
                                                    @elseif($product->discount_price && $product->discount_price < $product->price)
                                                        <span class="text-[10px] text-gray-400 line-through leading-none mb-1">{{ number_format($product->price, 2) }}</span>
                                                        <div class="flex items-baseline gap-0.5">
                                                            <span class="text-lg font-black text-gray-900 leading-none">{{ number_format($product->discount_price, 2) }}</span>
                                                            <span class="text-[10px] font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-baseline gap-1">
                                                            <span class="text-xl font-bold text-gray-900 leading-none">{{ number_format($product->price, 2) }}</span>
                                                            <span class="text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <form action="{{ route('web.cart.add', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" method="POST">
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
                                @endforeach
                            </div>
                        @else
                            <div class="py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No favorites yet') }}</h3>
                                <p class="text-gray-500 mb-8">{{ __('Items you favorite will appear here for easy access.') }}</p>
                                 <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                    {{ __('Discover Products') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function removeFromWishlist(productId, btn) {
            Swal.fire({
                title: '{{ __("Are you sure?") }}',
                text: '{{ __("Do you want to remove this item from your favorites?") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--yasmina-primary)',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("Yes, remove it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleWishlist(productId, btn);
                    document.getElementById(`wishlist-item-${productId}`).remove();
                    
                    // Check if grid is empty
                    const grid = document.querySelector('.grid');
                    if (grid && grid.children.length === 0) {
                        location.reload();
                    }
                }
            });
        }
    </script>
    @endpush
</x-web::layouts.master>

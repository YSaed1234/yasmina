<x-web::layouts.master>
    <div class="py-4 lg:py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-web::profile-sidebar />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl lg:rounded-3xl p-4 lg:p-10 shadow-sm border border-yasmina-50">
                        <h1 class="text-lg lg:text-3xl font-bold text-gray-900 mb-4 lg:mb-8">{{ __('My Favorites') }}</h1>
                        
                        @if($wishlistItems->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-3 gap-2.5 lg:gap-8">
                                @foreach($wishlistItems as $item)
                                    @php $product = $item->product; @endphp
                                    <div id="wishlist-item-{{ $product->id }}" class="group bg-white rounded-xl lg:rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-yasmina-50 hover:-translate-y-1 lg:hover:-translate-y-2 flex flex-col relative">
                                        <div class="aspect-square w-full overflow-hidden bg-yasmina-50 relative">
                                            <a href="{{ route('web.products.show', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" class="block w-full h-full">
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
                                                <div class="absolute top-1.5 lg:top-4 left-1.5 lg:left-4 {{ $badge['color'] }} text-[6px] lg:text-[8px] font-black uppercase tracking-widest px-1.5 lg:px-2 py-0.5 rounded-full shadow-lg z-20 flex items-center gap-1">
                                                    {{ $badge['label'] }}
                                                </div>
                                            @endif
                                            
                                            <button onclick="removeFromWishlist({{ $product->id }}, this)" class="absolute top-1.5 lg:top-4 right-1.5 lg:right-4 w-7 h-7 lg:w-10 lg:h-10 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all group/wish">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-5 lg:w-5 text-red-500 fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="p-2 lg:p-6 flex-1 flex flex-col relative z-10">
                                            <div class="flex justify-between items-start mb-0.5 lg:mb-1">
                                                <span class="text-[7px] lg:text-xs font-bold text-primary uppercase tracking-widest">{{ $product->category->name }}</span>
                                                <div class="flex items-center gap-0.5 lg:gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 lg:h-3 lg:w-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <span class="text-[7px] lg:text-[10px] font-bold text-gray-400">{{ number_format($product->averageRating(), 1) }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('web.products.show', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}">
                                                <h3 class="text-[11px] lg:text-lg font-bold text-gray-900 lg:mb-4 group-hover:text-primary transition-colors line-clamp-1">{{ $product->name }}</h3>
                                            </a>
                                            <div class="mt-auto pt-2 lg:pt-4">
                                                <div class="flex flex-col mb-2 lg:mb-4">
                                                    @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                                                        <span class="text-[7px] lg:text-[10px] text-gray-400 line-through leading-none mb-0.5 lg:mb-1">{{ number_format($product->price, 2) }}</span>
                                                        <div class="flex items-baseline gap-0.5">
                                                            <span class="text-[11px] lg:text-lg font-black text-amber-600 leading-none">{{ number_format($product->flash_sale_price, 2) }}</span>
                                                            <span class="text-[7px] lg:text-[10px] font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                                        </div>
                                                    @elseif($product->discount_price && $product->discount_price < $product->price)
                                                        <span class="text-[7px] lg:text-[10px] text-gray-400 line-through leading-none mb-0.5 lg:mb-1">{{ number_format($product->price, 2) }}</span>
                                                        <div class="flex items-baseline gap-0.5">
                                                            <span class="text-[11px] lg:text-lg font-black text-gray-900 leading-none">{{ number_format($product->discount_price, 2) }}</span>
                                                            <span class="text-[7px] lg:text-[10px] font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-baseline gap-0.5 lg:gap-1">
                                                            <span class="text-[11px] lg:text-xl font-bold text-gray-900 leading-none">{{ number_format($product->price, 2) }}</span>
                                                            <span class="text-[9px] lg:text-sm font-bold text-primary">{{ $product->currency?->symbol ?? '$' }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <form action="{{ route('web.cart.add', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" method="POST" class="w-full">
                                                    @csrf
                                                    <button type="submit" class="w-full py-2 lg:py-3 rounded-lg lg:rounded-2xl bg-yasmina-50 text-primary hover:bg-primary hover:text-white transition-all duration-300 shadow-sm flex items-center justify-center gap-1.5 group/btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                        </svg>
                                                        <span class="text-[9px] font-bold uppercase tracking-widest">{{ __('Add to Bag') }}</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 lg:py-20 text-center bg-gray-50 rounded-2xl lg:rounded-[3rem] border-2 border-dashed border-gray-200">
                                <div class="w-16 h-16 lg:w-20 lg:h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6 text-gray-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 lg:h-10 lg:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg lg:text-xl font-bold text-gray-900 mb-2">{{ __('No favorites yet') }}</h3>
                                <p class="text-xs lg:text-sm text-gray-500 mb-6 lg:mb-8 px-4">{{ __('Items you favorite will appear here for easy access.') }}</p>
                                <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-6 py-3 lg:px-8 lg:py-4 bg-primary text-white rounded-xl lg:rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all text-sm lg:text-base">
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

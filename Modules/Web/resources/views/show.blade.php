<x-web::layouts.master>
    <x-slot:title>{{ $product->name }} - Yasmina</x-slot:title>
    
    <main class="pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                <!-- Product Image -->
                <div class="relative">
                    <div class="aspect-square rounded-[3rem] overflow-hidden bg-white soft-shadow border border-yasmina-50 p-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-[2.5rem]">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-primary opacity-20 text-6xl">?</div>
                        @endif
                    </div>
                    @if($badge = $product->getBadge())
                        <div class="absolute top-8 left-8 {{ $badge['color'] }} text-sm font-black uppercase tracking-widest px-6 py-2 rounded-full shadow-2xl z-20">
                            {{ $badge['label'] }}
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="space-y-8">
                    <div>
                        <span class="inline-block px-4 py-1.5 bg-yasmina-50 text-primary text-xs font-bold uppercase tracking-[0.2em] rounded-full mb-4">
                            {{ $product->category->name }}
                        </span>
                        <h1 class="text-5xl font-bold text-gray-900 leading-tight">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <div class="flex flex-col">
                      @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                            <div class="flex items-baseline gap-3 mb-2">
                                <span id="main-price-display" class="text-4xl font-black text-amber-600">{{ number_format($product->flash_sale_price, 2) }}</span>
                                <span class="text-xl font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                <span id="compare-price-display" class="text-lg text-gray-400 line-through ml-2">{{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="mt-4 bg-amber-50/50 border border-amber-100 rounded-3xl p-6 flex flex-col items-center gap-4 shadow-sm">
                                    <div class="flex items-center gap-2 text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm font-bold uppercase tracking-widest">{{ __('Special Offer Ends In') }}</span>
                                    </div>
                                    <div class="flex items-center gap-6 text-amber-600" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                        <div class="text-center">
                                            <span class="hours block text-3xl font-black tabular-nums">00</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ __('Hrs') }}</span>
                                        </div>
                                        <div class="w-px h-10 bg-amber-200"></div>
                                        <div class="text-center">
                                            <span class="minutes block text-3xl font-black tabular-nums">00</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ __('Min') }}</span>
                                        </div>
                                        <div class="w-px h-10 bg-amber-200"></div>
                                        <div class="text-center">
                                            <span class="seconds block text-3xl font-black tabular-nums">00</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ __('Sec') }}</span>
                                        </div>
                                    </div>
                                </div>
                        @elseif($product->discount_price && $product->discount_price < $product->price)
                            <div class="flex flex-col">
                                <span id="compare-price-display" class="text-sm text-gray-400 line-through">{{ number_format($product->price, 2) }}</span>
                                <div class="flex items-baseline gap-1">
                                    <span id="main-price-display" class="text-3xl font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                    <span class="text-sm font-bold text-yasmina-500">{{ $product->currency?->symbol ?? '$' }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-baseline gap-1">
                                <span id="main-price-display" class="text-3xl font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                                <span class="text-sm font-bold text-yasmina-500">{{ $product->currency?->symbol ?? '$' }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="prose pyasmina-rose max-w-none">
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    @if($product->variants->count() > 0)
                        <div class="space-y-6 pt-4">
                            <!-- Variant Selection -->
                            <div id="product-variants" data-variants="{{ $product->variants->toJson() }}">
                                <!-- Colors -->
                                @php $colors = $product->variants->pluck('color')->unique()->filter(); @endphp
                                @if($colors->count() > 0)
                                    <div class="mb-6">
                                        <label class="block text-xs font-black text-yasmina-400 uppercase tracking-widest mb-3">{{ __('Select Color') }}</label>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($colors as $color)
                                                <button type="button" 
                                                    onclick="selectVariantOption('color', '{{ $color }}')"
                                                    data-option-type="color"
                                                    data-option-value="{{ $color }}"
                                                    class="variant-btn px-6 py-2.5 rounded-xl border-2 border-yasmina-50 bg-white text-sm font-bold text-gray-700 hover:border-primary transition-all">
                                                    {{ $color }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Sizes -->
                                @php $sizes = $product->variants->pluck('size')->unique()->filter(); @endphp
                                @if($sizes->count() > 0)
                                    <div class="mb-6">
                                        <label class="block text-xs font-black text-yasmina-400 uppercase tracking-widest mb-3">{{ __('Select Size') }}</label>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($sizes as $size)
                                                <button type="button"
                                                    onclick="selectVariantOption('size', '{{ $size }}')"
                                                    data-option-type="size"
                                                    data-option-value="{{ $size }}"
                                                    class="variant-btn px-6 py-2.5 rounded-xl border-2 border-yasmina-50 bg-white text-sm font-bold text-gray-700 hover:border-primary transition-all">
                                                    {{ $size }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="pt-8 border-t border-yasmina-50 space-y-6">
                        <div class="flex gap-4">
                            <form action="{{ route('web.cart.add', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" method="POST" id="add-to-cart-form" class="flex-1">
                                @csrf
                                <input type="hidden" name="variant_id" id="selected-variant-id">
                                
                                <div class="mb-8">
                                    <label class="block text-xs font-black text-yasmina-400 uppercase tracking-widest mb-3">{{ __('Quantity') }}</label>
                                    <div class="flex items-center bg-yasmina-50/50 rounded-2xl p-2 w-max border border-yasmina-100/50">
                                        <button type="button" onclick="adjustQty(-1)" class="w-12 h-12 flex items-center justify-center rounded-xl bg-white soft-shadow hover:text-primary transition-all font-bold text-xl">-</button>
                                        <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="{{ $product->stock }}" class="w-20 text-center bg-transparent border-none focus:ring-0 font-bold text-lg" readonly>
                                        <button type="button" onclick="adjustQty(1)" class="w-12 h-12 flex items-center justify-center rounded-xl bg-white soft-shadow hover:text-primary transition-all font-bold text-xl">+</button>
                                    </div>
                                </div>

                                <button type="submit" @if($product->total_stock <= 0) disabled @endif id="add-to-cart-btn" class="w-full py-5 {{ $product->total_stock <= 0 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-primary text-white hover:opacity-90 shadow-primary/20' }} rounded-2xl font-bold text-lg transition-all shadow-xl flex items-center justify-center gap-3">
                                    @if($product->total_stock <= 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        {{ __('Sold Out') }}
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        {{ $product->variants->count() > 0 ? __('Select Options') : __('Add to Bag') }}
                                    @endif
                                </button>
                            </form>

                            <button type="button" 
                                    onclick="document.getElementById('wishlist-form-{{ $product->id }}').submit()"
                                    class="w-16 h-16 rounded-2xl border-2 border-yasmina-50 flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-100 hover:bg-red-50 transition-all soft-shadow bg-white">
                                @if(auth()->check() && auth()->user()->wishlist()->where('product_id', $product->id)->exists())
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                @endif
                            </button>

                            <form id="wishlist-form-{{ $product->id }}" action="{{ route('web.wishlist.toggle', $product->id) }}" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                            </form>
                        </div>

                        <script>
                            const variants = JSON.parse(document.getElementById('product-variants')?.dataset.variants || '[]');
                            let selections = { color: null, size: null };
                            const basePrice = {{ $product->getEffectivePriceAttribute() }};
                            const hasFlashSale = {{ $product->hasActiveFlashSale() ? 'true' : 'false' }};
                            const currencySymbol = '{{ $product->currency?->symbol ?? "$" }}';

                            function adjustQty(amount) {
                                const input = document.getElementById('quantity-input');
                                let val = parseInt(input.value) + amount;
                                if (val < 1) val = 1;
                                if (val > parseInt(input.max)) val = parseInt(input.max);
                                input.value = val;
                            }

                            function selectVariantOption(type, value) {
                                // Toggle selection
                                if (selections[type] === value) {
                                    selections[type] = null;
                                } else {
                                    selections[type] = value;
                                }

                                // Update UI
                                document.querySelectorAll(`.variant-btn[data-option-type="${type}"]`).forEach(btn => {
                                    if (btn.dataset.optionValue === value && selections[type] !== null) {
                                        btn.classList.add('border-primary', 'bg-yasmina-50', 'text-primary');
                                        btn.classList.remove('border-yasmina-50', 'bg-white', 'text-gray-700');
                                    } else {
                                        btn.classList.remove('border-primary', 'bg-yasmina-50', 'text-primary');
                                        btn.classList.add('border-yasmina-50', 'bg-white', 'text-gray-700');
                                    }
                                });

                                updatePriceAndStock();
                            }

                            function updatePriceAndStock() {
                                // 1. Calculate which options are available based on current selections
                                const availableColors = [...new Set(variants.filter(v => !selections.size || v.size === selections.size).map(v => v.color))];
                                const availableSizes = [...new Set(variants.filter(v => !selections.color || v.color === selections.color).map(v => v.size))];

                                // 2. Update UI for buttons (Disable/Opacity if not available)
                                document.querySelectorAll('.variant-btn[data-option-type="color"]').forEach(btn => {
                                    if (availableColors.includes(btn.dataset.optionValue)) {
                                        btn.classList.remove('opacity-20', 'cursor-not-allowed', 'pointer-events-none');
                                    } else {
                                        btn.classList.add('opacity-20', 'cursor-not-allowed', 'pointer-events-none');
                                    }
                                });
                                document.querySelectorAll('.variant-btn[data-option-type="size"]').forEach(btn => {
                                    if (availableSizes.includes(btn.dataset.optionValue)) {
                                        btn.classList.remove('opacity-20', 'cursor-not-allowed', 'pointer-events-none');
                                    } else {
                                        btn.classList.add('opacity-20', 'cursor-not-allowed', 'pointer-events-none');
                                    }
                                });

                                // 3. Find the specific selected variant
                                const colorExists = document.querySelectorAll('.variant-btn[data-option-type="color"]').length > 0;
                                const sizeExists = document.querySelectorAll('.variant-btn[data-option-type="size"]').length > 0;
                                const isFullySelected = (!colorExists || selections.color) && (!sizeExists || selections.size);

                                const variant = variants.find(v => {
                                    const matchColor = !selections.color || v.color === selections.color;
                                    const matchSize = !selections.size || v.size === selections.size;
                                    return matchColor && matchSize;
                                });

                                const mainPriceDisplay = document.getElementById('main-price-display');
                                const comparePriceDisplay = document.getElementById('compare-price-display');
                                const variantIdInput = document.getElementById('selected-variant-id');
                                const addToCartBtn = document.getElementById('add-to-cart-btn');
                                const qtyInput = document.getElementById('quantity-input');

                                if (isFullySelected && variant) {
                                    // Update Price
                                    let finalPrice = hasFlashSale ? {{ $product->flash_sale_price ?? 0 }} : (variant.price || basePrice);
                                    let originalPrice = variant.price || {{ $product->price }};
                                    
                                    if (mainPriceDisplay) mainPriceDisplay.textContent = parseFloat(finalPrice).toLocaleString(undefined, {minimumFractionDigits: 2});
                                    if (comparePriceDisplay) comparePriceDisplay.textContent = parseFloat(originalPrice).toLocaleString(undefined, {minimumFractionDigits: 2});

                                    variantIdInput.value = variant.id;
                                    
                                    // Update Quantity Max based on variant stock
                                    qtyInput.max = variant.stock;
                                    if (parseInt(qtyInput.value) > variant.stock) qtyInput.value = Math.max(1, variant.stock);
                                    
                                    if (variant.stock <= 0) {
                                        addToCartBtn.disabled = true;
                                        addToCartBtn.innerHTML = `{{ __('Sold Out') }}`;
                                        addToCartBtn.classList.add('bg-gray-100', 'text-gray-400');
                                        addToCartBtn.classList.remove('bg-primary', 'text-white');
                                    } else {
                                        addToCartBtn.disabled = false;
                                        addToCartBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg> {{ __('Add to Bag') }}`;
                                        addToCartBtn.classList.remove('bg-gray-100', 'text-gray-400');
                                        addToCartBtn.classList.add('bg-primary', 'text-white');
                                    }
                                } else {
                                    if (mainPriceDisplay) mainPriceDisplay.textContent = parseFloat(basePrice).toLocaleString(undefined, {minimumFractionDigits: 2});
                                    if (comparePriceDisplay) comparePriceDisplay.textContent = parseFloat({{ $product->price }}).toLocaleString(undefined, {minimumFractionDigits: 2});
                                    
                                    variantIdInput.value = '';
                                    qtyInput.max = {{ $product->stock }};
                                    
                                    if ((colorExists || sizeExists) && !isFullySelected) {
                                        addToCartBtn.disabled = true;
                                        addToCartBtn.innerHTML = `{{ __('Select Options') }}`;
                                        addToCartBtn.classList.add('bg-gray-100', 'text-gray-400');
                                        addToCartBtn.classList.remove('bg-primary', 'text-white');
                                    } else {
                                        @if($product->stock <= 0)
                                            addToCartBtn.disabled = true;
                                            addToCartBtn.innerHTML = `{{ __('Sold Out') }}`;
                                            addToCartBtn.classList.add('bg-gray-100', 'text-gray-400');
                                            addToCartBtn.classList.remove('bg-primary', 'text-white');
                                        @else
                                            addToCartBtn.disabled = false;
                                            addToCartBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg> {{ __('Add to Bag') }}`;
                                            addToCartBtn.classList.remove('bg-gray-100', 'text-gray-400');
                                            addToCartBtn.classList.add('bg-primary', 'text-white');
                                        @endif
                                    }
                                }
                            }
                        </script>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white rounded-2xl border border-yasmina-50 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-yasmina-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ __('Authentic Product') }}</span>
                            </div>
                            <div class="p-4 bg-white rounded-2xl border border-yasmina-50 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-yasmina-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ __('Global Shipping') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-web::layouts.master>

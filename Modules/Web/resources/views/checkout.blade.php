<x-web::layouts.master>
    <div class="py-4 lg:py-20 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-xl lg:text-4xl font-bold text-gray-900 mb-4 lg:mb-12 tracking-tight">{{ __('Checkout') }}</h1>

                @php
                    $hasStockIssues = collect($cart)->contains(fn($item) => isset($item['in_stock']) && !$item['in_stock']);
                @endphp

                @if($hasStockIssues)
                    <div class="mb-4 lg:mb-6 p-3.5 lg:p-4 bg-red-50 border border-red-100 rounded-xl lg:rounded-2xl flex items-center gap-3 lg:gap-4 text-red-700">
                        <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-[11px] lg:text-sm">{{ __('Some items need updates.') }}</p>
                            <p class="text-[9px] lg:text-xs opacity-80">{{ __('Please check your cart.') }}</p>
                        </div>
                        <a href="{{ route('web.cart') }}" class="px-3 py-1.5 bg-red-600 text-white rounded-lg text-[9px] lg:text-xs font-bold shadow-lg">
                            {{ __('Cart') }}
                        </a>
                    </div>
                @endif

                <form action="{{ route('web.checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-12">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{ $currentVendor->id ?? '' }}">
                    <div class="lg:col-span-2 space-y-4 lg:space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white p-4 lg:p-10 rounded-2xl lg:rounded-3xl shadow-sm border border-yasmina-50">
                            <div class="flex justify-between items-center mb-5 lg:mb-8">
                                <h2 class="text-sm lg:text-2xl font-bold text-gray-900 flex items-center gap-2 lg:gap-3">
                                    <span class="w-5 h-5 lg:w-8 lg:h-8 rounded-full bg-primary text-white flex items-center justify-center text-[9px] lg:text-sm font-bold">1</span>
                                    {{ __('Shipping Information') }}
                                </h2>
                                <a href="{{ route('web.profile.addresses', ['vendor_id' => request('vendor_id')]) }}" class="text-[7px] lg:text-[10px] font-bold text-primary hover:underline uppercase tracking-widest">
                                    {{ __('Addresses') }}
                                </a>
                            </div>
                            
                            @if($addresses->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-4 mb-5 lg:mb-8">
                                    @foreach($addresses as $address)
                                        @php 
                                            $vId = request('vendor_id');
                                            $currentRegion = null;
                                            if ($vId) {
                                                $currentRegion = \App\Models\Region::where('vendor_id', $vId)
                                                    ->where('governorate_id', $address->governorate_id)
                                                    ->where('name', $address->region?->name)
                                                    ->where('is_active', true)
                                                    ->first();
                                            }
                                            if (!$currentRegion) {
                                                $currentRegion = $address->region;
                                            }
                                            $isAvailable = $currentRegion && $currentRegion->is_active; 
                                        @endphp
                                        <label class="relative flex p-3.5 lg:p-6 border-2 rounded-xl lg:rounded-2xl cursor-pointer hover:bg-yasmina-50/50 transition-all border-yasmina-50 has-[:checked]:border-primary has-[:checked]:bg-yasmina-50/50 {{ !$isAvailable ? 'opacity-60 cursor-not-allowed grayscale' : '' }}"
                                               data-shipping-rate="{{ $currentRegion ? $currentRegion->rate : 0 }}"
                                               data-shipping-available="{{ $isAvailable ? 'true' : 'false' }}">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first && $isAvailable ? 'checked' : '' }} onchange="updateSummary()" class="peer hidden" {{ !$isAvailable ? 'disabled' : '' }}>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-bold text-[11px] lg:text-base text-gray-900 mb-0.5 lg:mb-1 flex justify-between gap-2">
                                                    <span class="truncate">{{ $address->name }}</span>
                                                    @if(!$isAvailable)
                                                        <span class="text-[6px] lg:text-[8px] text-red-500 font-bold uppercase tracking-widest bg-red-50 px-1 lg:px-1.5 py-0.5 rounded shadow-sm whitespace-nowrap">{{ __('N/A') }}</span>
                                                    @endif
                                                </div>
                                                <div class="text-[9px] lg:text-xs text-gray-500 leading-relaxed truncate">
                                                    {{ $address->address_line1 }}, {{ $address->region?->name ?? $address->city }}
                                                </div>
                                            </div>
                                            <div class="w-3.5 h-3.5 lg:w-5 lg:h-5 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all ml-2 shrink-0">
                                                <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-5 lg:p-8 bg-yasmina-50/50 rounded-2xl border border-dashed border-yasmina-200 text-center mb-5 lg:mb-8">
                                    <p class="text-[9px] lg:text-sm text-gray-500 mb-3">{{ __('No saved addresses found.') }}</p>
                                    <a href="{{ route('web.profile.addresses', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-4 py-2 lg:px-6 lg:py-3 bg-primary text-white rounded-xl font-bold text-[9px] lg:text-sm shadow-lg">
                                        {{ __('Add Address') }}
                                    </a>
                                </div>
                            @endif

                            <div>
                                <label class="block text-[10px] lg:text-sm font-bold text-gray-700 mb-1.5 lg:mb-3">{{ __('Order Notes (Optional)') }}</label>
                                <textarea name="notes" rows="2" placeholder="{{ __('Delivery instructions...') }}" class="w-full px-4 lg:px-6 py-2.5 lg:py-4 bg-gray-50 border border-gray-100 rounded-xl lg:rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm resize-none text-[10px] lg:text-sm"></textarea>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white p-4 lg:p-10 rounded-2xl lg:rounded-3xl shadow-sm border border-yasmina-50">
                            <h2 class="text-sm lg:text-2xl font-bold text-gray-900 mb-5 lg:mb-8 flex items-center gap-2 lg:gap-3">
                                <span class="w-5 h-5 lg:w-8 lg:h-8 rounded-full bg-primary text-white flex items-center justify-center text-[9px] lg:text-sm font-bold">2</span>
                                {{ __('Payment Method') }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-4">
                                <label class="relative flex items-center p-3.5 lg:p-6 border-2 rounded-xl lg:rounded-2xl cursor-pointer hover:bg-yasmina-50/50 transition-all border-yasmina-50 has-[:checked]:border-primary has-[:checked]:bg-yasmina-50/50">
                                    <input type="radio" name="payment_method" value="cod" checked class="peer hidden">
                                    <div class="flex-1">
                                        <div class="font-bold text-[11px] lg:text-base text-gray-900">{{ __('Cash on Delivery') }}</div>
                                        <div class="text-[8px] lg:text-[10px] text-gray-400 mt-0.5 uppercase tracking-wider">{{ __('Pay at delivery') }}</div>
                                    </div>
                                    <div class="w-3.5 h-3.5 lg:w-5 lg:h-5 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all shrink-0">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                    </div>
                                </label>

                                <label id="wallet-payment-option" class="relative flex items-center p-3.5 lg:p-6 border-2 rounded-xl lg:rounded-2xl cursor-pointer hover:bg-yasmina-50/50 transition-all border-yasmina-50 has-[:checked]:border-primary has-[:checked]:bg-yasmina-50/50">
                                    <input type="radio" name="payment_method" value="wallet" class="peer hidden">
                                    <div class="flex-1">
                                        <div class="font-bold text-[11px] lg:text-base text-gray-900">{{ __('Wallet') }}</div>
                                        <div class="text-[8px] lg:text-[10px] text-gray-400 mt-0.5 uppercase tracking-wider">{{ __('Balance') }}: {{ number_format($walletBalance, 2) }}</div>
                                    </div>
                                    <div class="w-3.5 h-3.5 lg:w-5 lg:h-5 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all shrink-0">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white p-5 lg:p-10 rounded-2xl lg:rounded-3xl shadow-xl shadow-primary/5 border border-yasmina-50 sticky top-24">
                            <h2 class="text-sm lg:text-2xl font-bold text-gray-900 mb-4 lg:mb-8 border-b border-yasmina-50 pb-3 lg:pb-6">{{ __('Order Review') }}</h2>
                            
                            <div class="space-y-3 mb-5 lg:mb-8 max-h-48 lg:max-h-60 overflow-y-auto pr-1 custom-scrollbar">
                                @foreach($cart as $id => $details)
                                    <div class="flex gap-3 lg:gap-4 items-center">
                                        <div class="w-10 h-10 lg:w-16 lg:h-16 rounded-lg lg:rounded-xl bg-gray-50 overflow-hidden flex-shrink-0 border border-yasmina-50 relative">
                                            @if(isset($details['is_gift']) && $details['is_gift'])
                                                <div class="absolute top-0.5 left-0.5 z-10">
                                                    <span class="bg-yasmina-500 text-white text-[5px] lg:text-[6px] font-black uppercase tracking-widest px-1 py-0.5 rounded shadow-sm">
                                                        {{ __('Gift') }}
                                                    </span>
                                                </div>
                                            @endif
                                            @if($details['image'])
                                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-[10px] lg:text-sm font-bold text-gray-900 truncate">{{ $details['name'] }}</h4>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <p class="text-[8px] lg:text-xs text-gray-400 font-bold">x{{ $details['quantity'] }}</p>
                                                @if(isset($details['in_stock']) && !$details['in_stock'])
                                                    <span class="text-[6px] lg:text-[8px] text-red-500 font-black uppercase tracking-wider">{{ __('Out') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end shrink-0">
                                            <div class="text-[11px] lg:text-sm font-black text-primary">
                                                {{ $details['currency'] }}{{ number_format($details['price'] * $details['quantity'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-2.5 lg:space-y-4 mb-5 lg:mb-8 border-t border-yasmina-50 pt-4 lg:pt-6">
                                <div class="flex justify-between text-gray-500 text-[10px] lg:text-base">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-bold text-gray-900">{{ reset($cart)['currency'] ?? '$' }}{{ number_format($totalOriginal, 2) }}</span>
                                </div>
                                @if($productSavings > 0)
                                    <div class="flex justify-between text-red-500 text-[10px] lg:text-base">
                                        <span>{{ __('Product Discount') }}</span>
                                        <span class="font-bold">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($productSavings, 2) }}</span>
                                    </div>
                                @endif
                                @foreach($appliedVendorDiscounts as $applied)
                                    <div class="flex justify-between text-red-600 text-[10px] lg:text-base">
                                        <span>{{ $applied['label'] }}</span>
                                        <span class="font-bold">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($applied['amount'], 2) }}</span>
                                    </div>
                                @endforeach
                                @foreach($appliedPromotions as $promo)
                                    <div class="flex justify-between text-red-600 bg-red-50/50 p-2 lg:p-3 rounded-xl border border-red-100/50">
                                        <span class="text-[8px] lg:text-xs font-black uppercase tracking-wider">{{ $promo['name'] }}</span>
                                        <span class="font-bold text-[10px] lg:text-base">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($promo['amount'], 2) }}</span>
                                    </div>
                                @endforeach
                                @if($discount > 0)
                                    <div class="flex justify-between text-red-600 font-bold text-[10px] lg:text-base">
                                        <span>{{ __('Coupon') }}</span>
                                        <span class="font-bold">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($discount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-gray-500 text-[10px] lg:text-base">
                                    <span>{{ __('Shipping') }}</span>
                                    <span id="shipping-display" class="font-bold text-gray-900"></span>
                                </div>
                                <div class="border-t border-yasmina-50 pt-3 lg:pt-6 flex justify-between items-center">
                                    <span class="text-xs lg:text-lg font-bold text-gray-900">{{ __('Total') }}</span>
                                    <span id="total-display" class="text-base lg:text-3xl font-black text-primary"></span>
                                </div>
                            </div>

                            <button type="submit" 
                                    @if($hasStockIssues) disabled @endif
                                    class="w-full py-3.5 lg:py-5 bg-primary text-white rounded-xl lg:rounded-2xl font-bold text-sm lg:text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20 {{ $hasStockIssues ? 'opacity-50 cursor-not-allowed grayscale' : '' }}">
                                {{ __('Place Order') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const baseTotal = {{ $finalTotal }};
        const walletBalance = {{ $walletBalance }};
        const isFreeShipping = {{ (isset($freeShippingVendors) && $currentVendor && in_array($currentVendor->id, $freeShippingVendors)) ? 'true' : 'false' }};
        const currency = "{{ reset($cart)['currency'] ?? '$' }}";
        const hasStockIssues = {{ $hasStockIssues ? 'true' : 'false' }};

        function updateSummary() {
            const selectedAddress = document.querySelector('input[name="address_id"]:checked');
            const submitBtn = document.querySelector('button[type="submit"]');
            const shippingDisplay = document.getElementById('shipping-display');
            const totalDisplay = document.getElementById('total-display');
            const walletOption = document.getElementById('wallet-payment-option');
            const walletInput = walletOption.querySelector('input');
            
            if (hasStockIssues) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed', 'grayscale');
            }

            if (selectedAddress) {
                const label = selectedAddress.closest('label');
                const rate = parseFloat(label.dataset.shippingRate || 0);
                const isAvailable = label.dataset.shippingAvailable === 'true';
                
                if (isAvailable) {
                    const finalRate = isFreeShipping ? 0 : rate;
                    shippingDisplay.innerText = finalRate > 0 ? currency + finalRate.toFixed(2) : "{{ __('Free') }}";
                    const total = baseTotal + finalRate;
                    totalDisplay.innerText = currency + Math.max(0, total).toFixed(2);
                    
                    // Wallet Sufficiency Check
                    if (walletBalance < total) {
                        walletOption.classList.add('opacity-50', 'grayscale', 'cursor-not-allowed');
                        walletInput.disabled = true;
                        if (walletInput.checked) {
                            document.querySelector('input[name="payment_method"][value="cod"]').checked = true;
                        }
                    } else {
                        walletOption.classList.remove('opacity-50', 'grayscale', 'cursor-not-allowed');
                        walletInput.disabled = false;
                    }

                    if (!hasStockIssues) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                } else {
                    shippingDisplay.innerText = "{{ __('Not Available') }}";
                    totalDisplay.innerText = "{{ __('N/A') }}";
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                shippingDisplay.innerText = "{{ __('Pending') }}";
                totalDisplay.innerText = currency + baseTotal.toFixed(2);
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateSummary);
    </script>
    @endpush
</x-web::layouts.master>

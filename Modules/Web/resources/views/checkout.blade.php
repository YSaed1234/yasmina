<x-web::layouts.master>
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-4xl font-bold text-gray-900 mb-12 tracking-tight">{{ __('Checkout') }}</h1>

                <form action="{{ route('web.checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{ $currentVendor->id ?? '' }}">
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white p-10 rounded-3xl shadow-sm border border-rose-50">
                            <div class="flex justify-between items-center mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">1</span>
                                    {{ __('Shipping Information') }}
                                </h2>
                                <a href="{{ route('web.profile.addresses', ['vendor_id' => request('vendor_id')]) }}" class="text-xs font-bold text-primary hover:underline uppercase tracking-widest">
                                    {{ __('Manage Addresses') }}
                                </a>
                            </div>
                            
                            @if($addresses->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
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
                                        <label class="relative flex p-6 border-2 rounded-2xl cursor-pointer hover:bg-rose-50/50 transition-all border-rose-50 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50 {{ !$isAvailable ? 'opacity-60 cursor-not-allowed grayscale' : '' }}"
                                               data-shipping-rate="{{ $currentRegion ? $currentRegion->rate : 0 }}"
                                               data-shipping-available="{{ $isAvailable ? 'true' : 'false' }}">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" {{ $loop->first && $isAvailable ? 'checked' : '' }} onchange="updateSummary()" class="peer hidden" {{ !$isAvailable ? 'disabled' : '' }}>
                                            <div class="flex-1">
                                                <div class="font-bold text-gray-900 mb-1 flex justify-between">
                                                    {{ $address->name }}
                                                    @if(!$isAvailable)
                                                        <span class="text-[10px] text-red-500 font-bold uppercase tracking-widest bg-red-50 px-2 py-0.5 rounded-lg">{{ __('Not Available') }}</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500 leading-relaxed">
                                                    {{ $address->address_line1 }}<br>
                                                    {{ $address->region?->name ?? $address->city }}@if($address->governorate), {{ $address->governorate->name }}@endif, {{ $address->country }}<br>
                                                    {{ $address->phone }}
                                                </div>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all">
                                                <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-8 bg-rose-50/50 rounded-2xl border border-dashed border-rose-200 text-center mb-8">
                                    <p class="text-sm text-gray-500 mb-4">{{ __('No saved addresses found.') }}</p>
                                    <a href="{{ route('web.profile.addresses', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20">
                                        {{ __('Add New Address') }}
                                    </a>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">{{ __('Order Notes (Optional)') }}</label>
                                <textarea name="notes" rows="3" placeholder="{{ __('Anything else we should know about your delivery?') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm resize-none"></textarea>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white p-10 rounded-3xl shadow-sm border border-rose-50">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">2</span>
                                {{ __('Payment Method') }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-6 border-2 rounded-2xl cursor-pointer hover:bg-rose-50/50 transition-all border-rose-50 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50">
                                    <input type="radio" name="payment_method" value="cod" checked class="peer hidden">
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">{{ __('Cash on Delivery') }}</div>
                                        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ __('Pay when you receive') }}</div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                </label>
                                {{-- <label class="relative flex items-center p-6 border-2 rounded-2xl cursor-pointer hover:bg-rose-50/50 transition-all border-rose-50 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50">
                                    <input type="radio" name="payment_method" value="card" class="peer hidden">
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">{{ __('Credit Card') }}</div>
                                        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ __('Pay securely online') }}</div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                </label> --}}
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white p-10 rounded-3xl shadow-xl shadow-primary/5 border border-rose-50 sticky top-24">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b border-rose-50 pb-6">{{ __('Order Review') }}</h2>
                            
                            <div class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2">
                                @foreach($cart as $id => $details)
                                    <div class="flex gap-4 items-center">
                                        <div class="w-16 h-16 rounded-xl bg-gray-50 overflow-hidden flex-shrink-0 border border-rose-50">
                                            @if($details['image'])
                                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $details['name'] }}</h4>
                                            <p class="text-xs text-gray-400 mt-1">x{{ $details['quantity'] }}</p>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            @if(isset($details['original_price']) && $details['price'] < $details['original_price'])
                                                <span class="text-[10px] text-red-400 line-through">{{ $details['currency'] }}{{ number_format($details['original_price'] * $details['quantity'], 2) }}</span>
                                            @endif
                                            <div class="text-sm font-bold text-primary">
                                                {{ $details['currency'] }}{{ number_format($details['price'] * $details['quantity'], 2) }}
                                            </div>
                                            @if(isset($details['is_flash_sale']) && $details['is_flash_sale'])
                                                <span class="text-[8px] font-black text-amber-500 uppercase tracking-widest">{{ __('Flash Price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-4 mb-8 border-t border-rose-50 pt-6">
                                <div class="flex justify-between text-gray-500">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-bold text-gray-900">{{ reset($cart)['currency'] ?? '$' }}{{ number_format($totalOriginal, 2) }}</span>
                                </div>
                                @if($productSavings > 0)
                                    <div class="flex justify-between text-red-500">
                                        <span>{{ __('Product Discount') }}</span>
                                        <span class="font-bold">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($productSavings, 2) }}</span>
                                    </div>
                                @endif
                                @foreach($appliedVendorDiscounts as $applied)
                                    <div class="flex justify-between text-yasmina-600">
                                        <span>{{ $applied['label'] }} ({{ $applied['vendor_name'] }})</span>
                                        <span class="font-bold">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($applied['amount'], 2) }}</span>
                                    </div>
                                @endforeach
                                @if($discount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>{{ __('Coupon Discount') }}</span>
                                        <span class="font-bold">-{{ reset($cart)['currency'] ?? '$' }}{{ number_format($discount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-gray-500">
                                    <span>{{ __('Shipping') }}</span>
                                    <span id="shipping-display" class="font-bold text-gray-900"></span>
                                </div>
                                <div class="border-t border-rose-50 pt-6 flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">{{ __('Total') }}</span>
                                    <span id="total-display" class="text-3xl font-bold text-primary"></span>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
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
        const subtotal = {{ $totalOriginal }};
        const productSavings = {{ $productSavings }};
        const vendorDiscount = {{ $vendorDiscount }};
        const discount = {{ $discount }};
        const isFreeShipping = {{ (isset($currentVendor) && in_array($currentVendor->id, $freeShippingVendors)) ? 'true' : 'false' }};
        const currency = "{{ reset($cart)['currency'] ?? '$' }}";

        function updateSummary() {
            const selectedAddress = document.querySelector('input[name="address_id"]:checked');
            const submitBtn = document.querySelector('button[type="submit"]');
            
            if (selectedAddress) {
                const label = selectedAddress.closest('label');
                const rate = parseFloat(label.dataset.shippingRate || 0);
                const isAvailable = label.dataset.shippingAvailable === 'true';
                
                if (isAvailable) {
                    const finalRate = isFreeShipping ? 0 : rate;
                    document.getElementById('shipping-display').innerText = finalRate > 0 ? currency + finalRate.toFixed(2) : "{{ __('Free') }}";
                    document.getElementById('total-display').innerText = currency + (subtotal - productSavings - vendorDiscount - discount + finalRate).toFixed(2);
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    document.getElementById('shipping-display').innerText = "{{ __('Not Available') }}";
                    document.getElementById('total-display').innerText = "{{ __('N/A') }}";
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateSummary);
    </script>
    @endpush
</x-web::layouts.master>

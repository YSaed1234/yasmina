<x-web::layouts.master>
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center gap-4 mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight">{{ __('Your Shopping Bag') }}</h1>
                    <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-full text-xs font-bold uppercase tracking-widest">
                        {{ count($cart) }} {{ __('Items') }}
                    </span>
                </div>

                @if(count($cart) > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <div class="lg:col-span-2 space-y-6">
                            @foreach($cart as $id => $details)
                                <div class="bg-white p-8 rounded-3xl shadow-sm border border-rose-50 flex gap-8 items-center group">
                                    <div class="w-32 h-32 rounded-2xl overflow-hidden bg-gray-50 flex-shrink-0">
                                        @if($details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between mb-2">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900">{{ $details['name'] }}</h3>
                                                @if(isset($details['is_gift']) && $details['is_gift'])
                                                    <span class="text-[10px] font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Free Gift') }}</span>
                                                @elseif(isset($details['is_flash_sale']) && $details['is_flash_sale'])
                                                    <span class="text-[10px] font-bold text-amber-500 uppercase tracking-widest flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                        {{ __('Flash Sale Price') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <button onclick="removeFromCart({{ $id }})" class="text-gray-400 hover:text-red-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="flex items-center justify-between mt-6">
                                            @if(!(isset($details['is_gift']) && $details['is_gift']))
                                                <div class="flex items-center bg-gray-50 rounded-xl p-1 border border-gray-100">
                                                    <button onclick="updateQuantity({{ $id }}, {{ $details['quantity'] - 1 }})" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">-</button>
                                                    <span class="w-10 text-center font-bold text-sm">{{ $details['quantity'] }}</span>
                                                    <button onclick="updateQuantity({{ $id }}, {{ $details['quantity'] + 1 }})" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-primary transition-colors">+</button>
                                                </div>
                                            @else
                                                <div class="text-xs font-bold text-gray-400 italic">
                                                    {{ __('Quantity: 1') }}
                                                </div>
                                            @endif
                                            <div class="flex flex-col items-end">
                                                @if(isset($details['original_price']) && $details['price'] < $details['original_price'] && !(isset($details['is_gift']) && $details['is_gift']))
                                                    <span class="text-xs text-red-400 line-through">{{ $details['currency'] }}{{ number_format($details['original_price'] * $details['quantity'], 2) }}</span>
                                                @endif
                                                <div class="text-lg font-bold text-primary">
                                                    @if(isset($details['is_gift']) && $details['is_gift'])
                                                        {{ __('Free') }}
                                                    @else
                                                        {{ $details['currency'] }}{{ number_format($details['price'] * $details['quantity'], 2) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if(isset($availableGifts) && count($availableGifts) > 0)
                                <div class="mt-12 bg-yasmina-50/30 rounded-[2.5rem] p-10 border-2 border-dashed border-yasmina-100">
                                    <div class="flex items-center gap-4 mb-8">
                                        <div class="w-12 h-12 bg-yasmina-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-yasmina-500/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-bold text-gray-900">{{ __('Choose Your Free Gift') }}</h2>
                                            <p class="text-gray-500 text-sm">{{ __('You\'ve reached a threshold to unlock these rewards!') }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        @foreach($availableGifts as $gift)
                                            <div class="bg-white p-6 rounded-3xl border border-yasmina-100 flex items-center gap-6 group hover:shadow-xl hover:shadow-yasmina-500/5 transition-all">
                                                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-50 shrink-0">
                                                    <img src="{{ asset('storage/' . $gift->image) }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-bold text-gray-900 mb-1">{{ $gift->name }}</h4>
                                                    <span class="text-[10px] font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Free Reward') }}</span>
                                                    <form action="{{ route('web.cart.add', $gift->id) }}" method="POST" class="mt-3">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="w-full py-2 bg-yasmina-50 text-yasmina-600 rounded-xl text-xs font-bold hover:bg-yasmina-500 hover:text-white transition-all">
                                                            {{ __('Select Gift') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-white p-10 rounded-3xl shadow-xl shadow-primary/5 border border-rose-50 sticky top-24">
                                <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b border-rose-50 pb-6">{{ __('Order Summary') }}</h2>
                                
                                <!-- Coupon Input -->
                                <div class="mb-8">
                                    <form action="{{ route('web.cart.coupon.apply', ['vendor_id' => request('vendor_id')]) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="text" name="code" placeholder="{{ __('Coupon code...') }}" class="flex-1 px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary outline-none text-sm shadow-sm" {{ session()->has('coupon') ? 'disabled' : '' }} value="{{ session()->get('coupon.code') }}">
                                        @if(session()->has('coupon'))
                                            <button type="button" onclick="document.getElementById('remove-coupon-form').submit()" class="px-4 py-3 bg-red-50 text-red-500 rounded-xl font-bold text-sm hover:bg-red-100 transition-all">
                                                ✕
                                            </button>
                                        @else
                                            <button type="submit" class="px-6 py-3 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-gray-800 transition-all shadow-lg">
                                                {{ __('Apply') }}
                                            </button>
                                        @endif
                                    </form>
                                    <form id="remove-coupon-form" action="{{ route('web.cart.coupon.remove', ['vendor_id' => request('vendor_id')]) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @if(session()->has('coupon'))
                                        <p class="text-[10px] text-green-600 font-bold mt-2 uppercase tracking-widest flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            {{ __('Coupon applied successfully!') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="space-y-4 mb-8">
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
                                </div>
                                <div class="border-t border-rose-50 pt-6 mb-10">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">{{ __('Total') }}</span>
                                        <span class="text-3xl font-bold text-primary">{{ reset($cart)['currency'] ?? '$' }}{{ number_format($finalTotal, 2) }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('web.checkout', ['vendor_id' => request('vendor_id')]) }}" class="block w-full py-5 bg-primary text-white text-center rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                                    {{ __('Proceed to Checkout') }}
                                </a>
                                <p class="text-center text-gray-400 text-xs mt-6">
                                    {{ __('Taxes and shipping calculated at checkout') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-rose-50">
                        <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-8 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Your bag is empty') }}</h2>
                        <p class="text-gray-500 mb-10 max-w-md mx-auto">{{ __('Looks like you haven\'t added any luxury pieces to your bag yet. Start exploring our latest collections.') }}</p>
                        <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-10 py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                            {{ __('Explore Shop') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateQuantity(id, quantity) {
            if(quantity < 1) return;
            fetch("{{ route('web.cart.update', ['vendor_id' => request('vendor_id')]) }}", {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({id: id, quantity: quantity})
            }).then(() => location.reload());
        }

        function removeFromCart(id) {
            if(!confirm('{{ __("Are you sure?") }}')) return;
            fetch("{{ route('web.cart.remove', ['vendor_id' => request('vendor_id')]) }}", {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({id: id})
            }).then(() => location.reload());
        }
    </script>
    @endpush
</x-web::layouts.master>

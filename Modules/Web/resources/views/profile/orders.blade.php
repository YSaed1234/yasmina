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
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                            <h1 class="text-3xl font-bold text-gray-900">{{ __('Order History') }}</h1>
                            
                            @if($totalPromotionalSavings > 0)
                                <div class="bg-gradient-to-br from-yasmina-500 to-yasmina-600 p-0.5 rounded-2xl shadow-lg shadow-yasmina-500/20">
                                    <div class="bg-white rounded-[calc(1rem-2px)] px-6 py-3 flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-yasmina-50 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-yasmina-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5">{{ __('Total Promotional Savings') }}</span>
                                            <p class="text-xl font-bold text-yasmina-600">{{ number_format($totalPromotionalSavings, 2) }} {{ $orders->first()?->items?->first()?->product?->currency?->symbol ?? '$' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        @if($orders->count() > 0)
                            <div class="space-y-6">
                                @foreach($orders as $order)
                                    <div class="border border-gray-100 rounded-[2.5rem] overflow-hidden bg-white hover:border-primary transition-all duration-300">
                                        <div class="bg-rose-50/30 p-6 flex flex-wrap justify-between items-center gap-4 border-b border-gray-100">
                                            <div class="flex gap-8">
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Order Placed') }}</span>
                                                    <p class="text-sm font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Total Amount') }}</span>
                                                    <p class="text-sm font-bold text-primary">{{ number_format($order->total, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Order ID') }}</span>
                                                    <p class="text-sm font-bold text-gray-900">#{{ $order->id }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <button onclick="showOrderDetails({{ json_encode($order->load('items.product')) }})" class="px-6 py-2 bg-white text-gray-700 rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all border border-primary/10 shadow-sm">
                                                    {{ __('View Details') }}
                                                </button>
                                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }} shadow-sm">
                                                    {{ $order->status->label() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-8">
                                            <div class="space-y-6">
                                                @foreach($order->items as $item)
                                                    <div class="flex items-center gap-6">
                                                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 relative">
                                                            @if($item->is_gift)
                                                                <div class="absolute top-1 left-1 z-10">
                                                                    <span class="bg-yasmina-500 text-white text-[6px] font-black uppercase tracking-widest px-1 py-0.5 rounded shadow-lg shadow-yasmina-500/20">
                                                                        {{ __('Gift') }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            @if($item->product && $item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-xl font-bold">?</div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <h4 class="font-bold text-gray-900">{{ $item->product->name ?? __('Product Not Found') }}</h4>
                                                            <p class="text-sm text-gray-500 mt-1">{{ __('Qty') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }}</p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            @if($item->product)
                                                                @php 
                                                                    $existingReview = auth()->user()->reviews()->where('product_id', $item->product->id)->first();
                                                                @endphp
                                                                <button onclick="toggleRatingForm({{ $item->id }})" class="px-6 py-2 {{ $existingReview ? 'bg-green-50 text-green-600' : 'bg-primary/5 text-primary' }} rounded-xl text-xs font-bold hover:opacity-80 transition-all flex items-center gap-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="{{ $existingReview ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                                    </svg>
                                                                    {{ $existingReview ? __('Rated') : __('Rate') }}
                                                                </button>
                                                                <a href="{{ route('web.products.show', ['id' => $item->product->id, 'vendor_id' => request('vendor_id')]) }}" class="px-6 py-2 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all">
                                                                    {{ __('Buy Again') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if($item->product)
                                                        <div id="rating-form-{{ $item->id }}" class="hidden mt-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                                            <form action="{{ route('web.reviews.store', ['vendor_id' => request('vendor_id')]) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                                <div class="flex flex-wrap gap-6">
                                                                    <div class="flex-1 min-w-[200px]">
                                                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Your Rating') }}</label>
                                                                        <div class="flex gap-2 rating-stars">
                                                                            @for($i = 1; $i <= 5; $i++)
                                                                                <label class="cursor-pointer">
                                                                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ ($existingReview?->rating == $i) ? 'checked' : '' }} required>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200 peer-checked:text-yellow-400 hover:text-yellow-300 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                                    </svg>
                                                                                </label>
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-[2] min-w-[300px]">
                                                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Review Comment') }} ({{ __('Optional') }})</label>
                                                                        <textarea name="comment" rows="2" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="{{ __('What did you think of this product?') }}">{{ $existingReview?->comment }}</textarea>
                                                                    </div>
                                                                    <div class="flex items-end">
                                                                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                                                            {{ __('Submit Review') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-10">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="p-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No orders yet') }}</h3>
                                <p class="text-gray-500 mb-8">{{ __('Your order history will appear here once you make your first purchase.') }}</p>
                                <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                    {{ __('Start Shopping') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeOrderDetails()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-rose-50">
                <div class="bg-white px-8 pt-10 pb-8 sm:p-10 sm:pb-8">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900" id="modal-order-id"></h3>
                        <button onclick="closeOrderDetails()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Items -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Items Ordered') }}</h4>
                            <div id="modal-items-list" class="space-y-4">
                                <!-- JS will fill this -->
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="bg-rose-50/30 rounded-3xl p-6 border border-rose-100">
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">{{ __('Subtotal') }}</span>
                                    <span id="modal-subtotal" class="font-bold text-gray-900"></span>
                                </div>
                                <div id="modal-coupon-row" class="flex justify-between text-sm hidden">
                                    <span class="text-gray-500">{{ __('Coupon Discount') }}</span>
                                    <span id="modal-discount" class="font-bold text-green-600"></span>
                                </div>
                                
                                <!-- Special Discounts Block -->
                                <div id="modal-special-discounts" class="hidden -mx-6 bg-amber-50/50 border-y border-amber-100/50 divide-y divide-amber-100/30">
                                    <div id="modal-vendor-discount-row" class="flex justify-between items-center text-sm px-6 py-2 hidden">
                                        <span class="text-amber-600 font-bold uppercase tracking-widest text-[10px]" id="modal-vendor-discount-label"></span>
                                        <span id="modal-vendor-discount" class="font-bold text-amber-600"></span>
                                    </div>
                                    <div id="modal-promo-discount-row" class="flex justify-between items-center text-sm px-6 py-2 hidden">
                                        <span class="text-amber-600 font-bold uppercase tracking-widest text-[10px]">{{ __('Promotional Offers (BOGO/Bundle)') }}</span>
                                        <span id="modal-promo-discount" class="font-bold text-amber-600"></span>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">{{ __('Shipping') }}</span>
                                    <span id="modal-shipping" class="font-bold text-gray-900"></span>
                                </div>
                                <div class="border-t border-rose-100 pt-3 flex justify-between">
                                    <span class="font-bold text-gray-900">{{ __('Total') }}</span>
                                    <span id="modal-total" class="font-bold text-primary text-lg"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Payment Method') }}</h4>
                                <div class="px-4 py-3 bg-gray-50 rounded-2xl border border-gray-100 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span id="modal-payment-method" class="text-xs font-bold text-gray-700 uppercase"></span>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Payment Status') }}</h4>
                                <div id="modal-payment-status-wrapper" class="px-4 py-3 rounded-2xl border flex items-center gap-2">
                                    <span id="modal-payment-status" class="text-[10px] font-black uppercase tracking-widest"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping info -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ __('Shipping Address') }}</h4>
                            <div class="p-6 bg-gray-50 rounded-3xl border border-gray-100">
                                <p id="modal-shipping-name" class="font-bold text-gray-900 mb-1"></p>
                                <p id="modal-shipping-address" class="text-sm text-gray-500 leading-relaxed"></p>
                                <p id="modal-shipping-phone" class="text-sm text-gray-500 mt-2"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-6 sm:px-10 flex justify-end">
                    <button type="button" onclick="closeOrderDetails()" class="px-8 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleRatingForm(id) {
            const form = document.getElementById(`rating-form-${id}`);
            form.classList.toggle('hidden');
        }

        function showOrderDetails(order) {
            document.getElementById('modal-order-id').innerText = `{{ __('Order') }} #${order.id}`;
            
            const list = document.getElementById('modal-items-list');
            list.innerHTML = '';
            
            order.items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'flex items-center gap-4 py-2 border-b border-gray-50 last:border-0';
                div.innerHTML = `
                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shrink-0 relative">
                        ${item.is_gift ? `
                            <div class="absolute top-0.5 left-0.5 z-10">
                                <span class="bg-yasmina-500 text-white text-[5px] font-black uppercase tracking-tighter px-1 py-0.5 rounded shadow-sm">
                                    {{ __('Gift') }}
                                </span>
                            </div>
                        ` : ''}
                        <img src="/storage/${item.product.image}" class="w-full h-full object-cover" onerror="this.src='/placeholder.png'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">${item.product.name}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">${item.quantity} × ${parseFloat(item.price).toFixed(2)}</p>
                    </div>
                    <div class="text-sm font-bold text-gray-900">
                        ${(item.quantity * item.price).toFixed(2)}
                    </div>
                `;
                list.appendChild(div);
            });

            const shippingAmount = parseFloat(order.shipping_amount || 0);
            const discountAmount = parseFloat(order.discount_amount || 0);
            const vendorDiscountAmount = parseFloat(order.vendor_discount_amount || 0);
            const promotionalDiscountAmount = parseFloat(order.promotional_discount_amount || 0);
            const totalPromotionalDiscount = vendorDiscountAmount + promotionalDiscountAmount;
            
            const totalAmount = parseFloat(order.total);
            const subtotalAmount = totalAmount - shippingAmount + discountAmount + totalPromotionalDiscount;

            document.getElementById('modal-subtotal').innerText = subtotalAmount.toFixed(2);
            document.getElementById('modal-shipping').innerText = shippingAmount.toFixed(2);
            
            // Coupon Discount
            const couponRow = document.getElementById('modal-coupon-row');
            if (discountAmount > 0) {
                couponRow.classList.remove('hidden');
                document.getElementById('modal-discount').innerText = `-${discountAmount.toFixed(2)}`;
            } else {
                couponRow.classList.add('hidden');
            }
            
            // Vendor Specific Discount (Threshold/Multi-item)
            const vendorRow = document.getElementById('modal-vendor-discount-row');
            if (vendorDiscountAmount > 0) {
                vendorRow.classList.remove('hidden');
                const label = order.vendor_discount_type === 'threshold' ? '{{ __("Order Threshold Discount") }}' : '{{ __("Multi-item Discount") }}';
                document.getElementById('modal-vendor-discount-label').innerText = label;
                document.getElementById('modal-vendor-discount').innerText = `-${vendorDiscountAmount.toFixed(2)}`;
            } else {
                vendorRow.classList.add('hidden');
            }

            // Promotional Discount (BOGO/Bundle)
            const promoRow = document.getElementById('modal-promo-discount-row');
            if (promotionalDiscountAmount > 0) {
                promoRow.classList.remove('hidden');
                document.getElementById('modal-promo-discount').innerText = `-${promotionalDiscountAmount.toFixed(2)}`;
            } else {
                promoRow.classList.add('hidden');
            }

            // Show/Hide Special Discounts Block
            const specialBlock = document.getElementById('modal-special-discounts');
            if (vendorDiscountAmount > 0 || promotionalDiscountAmount > 0) {
                specialBlock.classList.remove('hidden');
            } else {
                specialBlock.classList.add('hidden');
            }

            document.getElementById('modal-total').innerText = totalAmount.toFixed(2);
            
            // Payment info
            document.getElementById('modal-payment-method').innerText = order.payment_method === 'cod' ? '{{ __("Cash on Delivery") }}' : '{{ __("Credit Card") }}';
            
            const pStatus = document.getElementById('modal-payment-status');
            const pWrapper = document.getElementById('modal-payment-status-wrapper');
            pStatus.innerText = order.payment_status === 'paid' ? '{{ __("paid") }}' : '{{ __("pending") }}';
            
            if (order.payment_status === 'paid') {
                pWrapper.className = 'px-4 py-3 rounded-2xl border border-green-100 bg-green-50 flex items-center gap-2 text-green-600';
            } else {
                pWrapper.className = 'px-4 py-3 rounded-2xl border border-amber-100 bg-amber-50 flex items-center gap-2 text-amber-600';
            }

            const shipping = order.shipping_details;
            document.getElementById('modal-shipping-name').innerText = shipping.name;
            document.getElementById('modal-shipping-address').innerText = `${shipping.address}, ${shipping.city}, ${shipping.country}`;
            document.getElementById('modal-shipping-phone').innerText = shipping.phone;

            document.getElementById('orderDetailsModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
    @endpush
</x-web::layouts.master>

<x-web::layouts.master>
    <div class="py-4 lg:py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-web::profile-sidebar />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl lg:rounded-3xl p-3.5 lg:p-10 shadow-sm border border-yasmina-50">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 lg:gap-4 mb-6 lg:mb-10">
                            <h1 class="text-base lg:text-3xl font-bold text-gray-900 leading-tight">{{ __('Order History') }}</h1>
                            
                            @if($totalPromotionalSavings > 0)
                                <div class="bg-gradient-to-br from-yasmina-500 to-yasmina-600 p-0.5 rounded-xl lg:rounded-2xl shadow-lg shadow-yasmina-500/20">
                                    <div class="bg-white rounded-[calc(0.75rem-2px)] lg:rounded-[calc(1rem-2px)] px-2.5 py-1.5 lg:px-6 lg:py-3 flex items-center gap-2 lg:gap-4">
                                        <div class="w-6 h-6 lg:w-10 lg:h-10 rounded-lg lg:rounded-xl bg-yasmina-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 lg:w-6 lg:h-6 text-yasmina-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-[7px] lg:text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5">{{ __('Total Promotional Savings') }}</span>
                                            <p class="text-xs lg:text-xl font-bold text-yasmina-600 leading-none">{{ number_format($totalPromotionalSavings, 2) }} {{ $orders->first()?->items?->first()?->product?->currency?->symbol ?? '$' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        @if($orders->count() > 0)
                            <div class="space-y-4 lg:space-y-6">
                                @foreach($orders as $order)
                                    <div class="border border-gray-100 rounded-2xl lg:rounded-[2.5rem] overflow-hidden bg-white hover:border-primary transition-all duration-300">
                                        <div class="bg-yasmina-50/30 p-3 lg:p-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 lg:gap-4 border-b border-gray-100">
                                            <div class="flex gap-3.5 lg:gap-8 overflow-x-auto pb-1 sm:pb-0 scrollbar-hide">
                                                <div class="shrink-0">
                                                    <span class="text-[7px] lg:text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5 lg:mb-1">{{ __('Order Placed') }}</span>
                                                    <p class="text-[9px] lg:text-sm font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <div class="shrink-0">
                                                    <span class="text-[7px] lg:text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5 lg:mb-1">{{ __('Total Amount') }}</span>
                                                    <p class="text-[9px] lg:text-sm font-bold text-primary">{{ number_format($order->total, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</p>
                                                </div>
                                                <div class="shrink-0">
                                                    <span class="text-[7px] lg:text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5 lg:mb-1">{{ __('Order ID') }}</span>
                                                    <p class="text-[9px] lg:text-sm font-bold text-gray-900">#{{ $order->id }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between sm:justify-end gap-2 lg:gap-4">
                                                @php
                                                    $refundedCount = $order->returnRequests
                                                        ->where('status', 'completed')
                                                        ->flatMap->items
                                                        ->sum('quantity');
                                                @endphp
                                                @if($refundedCount > 0)
                                                    <span class="px-2 py-1 lg:px-4 lg:py-1.5 bg-rose-50 text-rose-600 rounded-full text-[7px] lg:text-[10px] font-black uppercase tracking-widest border border-rose-100 shadow-sm flex items-center gap-1 lg:gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 lg:h-3 lg:w-3" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011-1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $refundedCount }} {{ __('Refunded') }}
                                                    </span>
                                                @endif
                                                <button onclick="showOrderDetails({{ json_encode($order->load('items.product')) }})" class="px-2.5 py-1 lg:px-6 lg:py-2 bg-white text-gray-700 rounded-lg lg:rounded-xl text-[9px] lg:text-xs font-bold hover:bg-primary hover:text-white transition-all border border-primary/10 shadow-sm">
                                                    {{ __('View') }}
                                                </button>
                                                <span class="px-2 py-1 lg:px-4 lg:py-1.5 rounded-full text-[7px] lg:text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }} shadow-sm">
                                                    {{ $order->status->label() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-3.5 lg:p-8">
                                            <div class="space-y-4 lg:space-y-6">
                                                @foreach($order->items as $item)
                                                    <div class="flex items-center gap-3 lg:gap-6">
                                                        <div class="w-12 h-12 lg:w-20 lg:h-20 rounded-xl lg:rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 relative shrink-0">
                                                            @if($item->is_gift)
                                                                <div class="absolute top-0.5 left-0.5 z-10">
                                                                    <span class="bg-yasmina-500 text-white text-[4px] lg:text-[6px] font-black uppercase tracking-widest px-1 py-0.5 rounded shadow-lg shadow-yasmina-500/20">
                                                                        {{ __('Gift') }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            @if($item->product && $item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-[10px] lg:text-xl font-bold">?</div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="font-bold text-gray-900 text-[10px] lg:text-base truncate">{{ $item->product->name ?? __('Product Not Found') }}</h4>
                                                            <p class="text-[9px] lg:text-sm text-gray-500 mt-0.5">{{ __('Qty') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }}</p>
                                                        </div>
                                                        <div class="flex flex-col lg:flex-row gap-1.5 lg:gap-2">
                                                            @if($item->product)
                                                                @php 
                                                                    $existingReview = auth()->user()->reviews()->where('product_id', $item->product->id)->first();
                                                                @endphp
                                                                <button onclick="toggleRatingForm({{ $item->id }})" class="px-2 py-1.5 lg:px-6 lg:py-2 {{ $existingReview ? 'bg-green-50 text-green-600' : 'bg-primary/5 text-primary' }} rounded-lg lg:rounded-xl text-[9px] lg:text-xs font-bold hover:opacity-80 transition-all flex items-center justify-center gap-1 lg:gap-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 lg:h-4 lg:w-4" fill="{{ $existingReview ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                                    </svg>
                                                                    {{ $existingReview ? __('Rated') : __('Rate') }}
                                                                </button>
                                                                <a href="{{ route('web.products.show', ['id' => $item->product->id, 'vendor_id' => request('vendor_id')]) }}" class="px-2 py-1.5 lg:px-6 lg:py-2 bg-gray-50 text-gray-600 rounded-lg lg:rounded-xl text-[9px] lg:text-xs font-bold hover:bg-primary hover:text-white transition-all text-center">
                                                                    {{ __('Buy Again') }}
                                                                </a>
                                                            @endif
                                                            
                                                            @if($order->status->value === 'delivered')
                                                                @php $returnRequest = $order->returnRequests->first(); @endphp
                                                                @if(!$returnRequest)
                                                                    <a href="{{ route('web.orders.return', $order) }}" class="px-2 py-1.5 lg:px-6 lg:py-2 bg-rose-50 text-rose-600 rounded-lg lg:rounded-xl text-[9px] lg:text-xs font-bold hover:bg-rose-500 hover:text-white transition-all text-center">
                                                                        {{ __('Return') }}
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('web.returns.show', $returnRequest) }}" class="px-2 py-1.5 lg:px-6 lg:py-2 bg-blue-50 text-blue-600 rounded-lg lg:rounded-xl text-[9px] lg:text-xs font-bold hover:bg-blue-500 hover:text-white transition-all text-center">
                                                                        {{ __('Return Status') }}
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if($item->product)
                                                        <div id="rating-form-{{ $item->id }}" class="hidden mt-3 p-3.5 lg:p-6 bg-gray-50 rounded-xl lg:rounded-2xl border border-gray-100">
                                                            <form action="{{ route('web.reviews.store', ['vendor_id' => request('vendor_id')]) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                                <div class="flex flex-col gap-3 lg:gap-6">
                                                                    <div>
                                                                        <label class="block text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 lg:mb-3">{{ __('Your Rating') }}</label>
                                                                        <div class="flex gap-1 lg:gap-2 rating-stars">
                                                                            @for($i = 1; $i <= 5; $i++)
                                                                                <label class="cursor-pointer">
                                                                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ ($existingReview?->rating == $i) ? 'checked' : '' }} required>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-8 lg:w-8 text-gray-200 peer-checked:text-yellow-400 hover:text-yellow-300 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                                    </svg>
                                                                                </label>
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full">
                                                                        <label class="block text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 lg:mb-3">{{ __('Review Comment') }} ({{ __('Optional') }})</label>
                                                                        <textarea name="comment" rows="2" class="w-full px-3 py-2 bg-white border border-gray-100 rounded-xl text-[10px] lg:text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="{{ __('What did you think of this product?') }}">{{ $existingReview?->comment }}</textarea>
                                                                    </div>
                                                                    <div>
                                                                        <button type="submit" class="w-full lg:w-auto px-6 py-2 bg-primary text-white rounded-xl text-[10px] lg:text-sm font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
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
                            <div class="mt-8 lg:mt-10">
                                {{ $orders->links('web::pagination.custom') }}
                            </div>
                        @else
                            <div class="py-10 lg:py-20 text-center bg-gray-50 rounded-2xl lg:rounded-[3rem] border-2 border-dashed border-gray-200">
                                <div class="w-12 h-12 lg:w-20 lg:h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6 text-gray-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 lg:h-10 lg:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm lg:text-xl font-bold text-gray-900 mb-2 leading-tight">{{ __('No orders yet') }}</h3>
                                <p class="text-[9px] lg:text-sm text-gray-500 mb-6 lg:mb-8 px-4 leading-relaxed">{{ __('Your order history will appear here once you make your first purchase.') }}</p>
                                <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="inline-block px-6 py-2.5 lg:px-8 lg:py-4 bg-primary text-white rounded-xl lg:rounded-2xl text-[10px] lg:text-sm font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                    {{ __('Start Shopping') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end lg:items-center justify-center min-h-screen pt-4 px-4 pb-0 lg:pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeOrderDetails()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-t-2xl lg:rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-yasmina-50 w-full">
                <div class="bg-white px-3.5 pt-5 lg:px-10 lg:pt-10 pb-4 lg:pb-8 max-h-[85vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4 lg:mb-8">
                        <h3 class="text-base lg:text-2xl font-bold text-gray-900 leading-tight" id="modal-order-id"></h3>
                        <button onclick="closeOrderDetails()" class="text-gray-400 hover:text-gray-500 p-2">
                            <svg class="h-4 w-4 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4 lg:space-y-8">
                        <!-- Items -->
                        <div>
                            <h4 class="text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 lg:mb-4">{{ __('Items Ordered') }}</h4>
                            <div id="modal-items-list" class="space-y-2 lg:space-y-4 max-h-[30vh] lg:max-h-[40vh] overflow-y-auto pr-1">
                                <!-- JS will fill this -->
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="bg-yasmina-50/30 rounded-xl lg:rounded-3xl p-3 lg:p-6 border border-yasmina-100">
                            <div class="space-y-1.5 lg:space-y-3">
                                <div class="flex justify-between text-[10px] lg:text-sm">
                                    <span class="text-gray-500">{{ __('Subtotal') }}</span>
                                    <span id="modal-subtotal" class="font-bold text-gray-900"></span>
                                </div>
                                <div id="modal-coupon-row" class="flex justify-between text-[10px] lg:text-sm hidden">
                                    <span class="text-gray-500">{{ __('Coupon Discount') }}</span>
                                    <span id="modal-discount" class="font-bold text-green-600"></span>
                                </div>
                                
                                <!-- Special Discounts Block -->
                                <div id="modal-special-discounts" class="hidden -mx-3 lg:-mx-6 bg-amber-50/50 border-y border-amber-100/50 divide-y divide-amber-100/30 my-1 lg:my-2">
                                    <div id="modal-vendor-discount-row" class="flex justify-between items-center text-[8px] lg:text-sm px-3 lg:px-6 py-1.5 lg:py-2 hidden">
                                        <span class="text-amber-600 font-bold uppercase tracking-widest text-[6px] lg:text-[10px]" id="modal-vendor-discount-label"></span>
                                        <span id="modal-vendor-discount" class="font-bold text-amber-600"></span>
                                    </div>
                                    <div id="modal-promo-discount-row" class="flex justify-between items-center text-[8px] lg:text-sm px-3 lg:px-6 py-1.5 lg:py-2 hidden">
                                        <span class="text-amber-600 font-bold uppercase tracking-widest text-[6px] lg:text-[10px]">{{ __('Promotional Offers') }}</span>
                                        <span id="modal-promo-discount" class="font-bold text-amber-600"></span>
                                    </div>
                                </div>
                                <div class="flex justify-between text-[10px] lg:text-sm">
                                    <span class="text-gray-500">{{ __('Shipping') }}</span>
                                    <span id="modal-shipping" class="font-bold text-gray-900"></span>
                                </div>
                                <div class="border-t border-yasmina-100 pt-2 lg:pt-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-900 text-[11px] lg:text-base">{{ __('Total') }}</span>
                                    <span id="modal-total" class="font-bold text-primary text-xs lg:text-lg"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 lg:gap-6">
                            <div>
                                <h4 class="text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 lg:mb-3">{{ __('Payment Method') }}</h4>
                                <div class="px-2.5 py-1.5 lg:px-4 lg:py-3 bg-gray-50 rounded-lg lg:rounded-2xl border border-gray-100 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 lg:h-4 lg:w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span id="modal-payment-method" class="text-[8px] lg:text-xs font-bold text-gray-700 uppercase"></span>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 lg:mb-3">{{ __('Payment Status') }}</h4>
                                <div id="modal-payment-status-wrapper" class="px-2.5 py-1.5 lg:px-4 lg:py-3 rounded-lg lg:rounded-2xl border flex items-center gap-2">
                                    <span id="modal-payment-status" class="text-[7px] lg:text-[10px] font-black uppercase tracking-widest"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-8">
                            <div>
                                <h4 class="text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 lg:mb-4">{{ __('Shipping Address') }}</h4>
                                <div class="p-3 lg:p-6 bg-gray-50 rounded-xl lg:rounded-3xl border border-gray-100">
                                    <p id="modal-shipping-name" class="font-bold text-gray-900 mb-0.5 text-[10px] lg:text-sm"></p>
                                    <p id="modal-shipping-address" class="text-[10px] lg:text-sm text-gray-500 leading-relaxed"></p>
                                    <p id="modal-shipping-phone" class="text-[9px] lg:text-sm text-gray-500 mt-1 lg:mt-2 font-medium"></p>
                                </div>
                            </div>
                            <!-- Driver info -->
                            <div id="modal-driver-info" class="hidden">
                                <h4 class="text-[7px] lg:text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 lg:mb-4">{{ __('Delivery Personnel') }}</h4>
                                <div class="p-3 lg:p-6 bg-blue-50 rounded-xl lg:rounded-3xl border border-blue-100 flex items-center gap-2.5 lg:gap-4">
                                    <div class="w-8 h-8 lg:w-12 lg:h-12 rounded-lg lg:rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p id="modal-driver-name" class="font-bold text-blue-900 text-[10px] lg:text-sm truncate"></p>
                                        <p id="modal-driver-phone" class="text-[9px] lg:text-sm text-blue-600 font-medium"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-3.5 py-3.5 lg:px-10 lg:py-6 flex justify-end">
                    <button type="button" onclick="closeOrderDetails()" class="w-full sm:w-auto px-6 py-2 lg:px-8 lg:py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-[10px] lg:text-sm font-bold hover:bg-gray-50 transition-all shadow-sm">
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
            
            let subtotalAmount = 0;
            order.items.forEach(item => {
                const itemSubtotal = parseFloat(item.quantity) * parseFloat(item.price);
                subtotalAmount += itemSubtotal;
                
                const div = document.createElement('div');
                div.className = "flex items-center gap-3 lg:gap-4 p-2 hover:bg-gray-50 rounded-xl lg:rounded-2xl transition-all";
                div.innerHTML = `
                    <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shrink-0 relative">
                        ${item.is_gift ? `
                            <div class="absolute top-0.5 left-0.5 z-10">
                                <span class="bg-yasmina-500 text-white text-[5px] font-black uppercase tracking-tighter px-1 py-0.5 rounded shadow-sm">
                                    {{ __('Gift') }}
                                </span>
                            </div>
                        ` : ''}
                        <img src="/storage/${item.product ? item.product.image : ''}" class="w-full h-full object-cover" onerror="this.src='/placeholder.png'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs lg:text-sm font-bold text-gray-900 truncate">${item.product ? item.product.name : '{{ __("Product Not Found") }}'}</p>
                        <p class="text-[8px] lg:text-[10px] text-gray-400 font-bold uppercase tracking-tighter">${item.quantity} × ${parseFloat(item.price).toFixed(2)}</p>
                    </div>
                    <div class="text-xs lg:text-sm font-bold text-gray-900 shrink-0">
                        ${itemSubtotal.toFixed(2)}
                    </div>
                `;
                list.appendChild(div);
            });

            const currency = order.items.length > 0 && order.items[0].product && order.items[0].product.currency 
                ? order.items[0].product.currency.symbol 
                : '{{ __("LE") }}';

            const shippingAmount = parseFloat(order.shipping_amount || 0);
            const discountAmount = parseFloat(order.discount_amount || 0);
            const vendorDiscountAmount = parseFloat(order.vendor_discount_amount || 0);
            const promotionalDiscountAmount = parseFloat(order.promotional_discount_amount || 0);
            const totalAmount = parseFloat(order.total);

            document.getElementById('modal-subtotal').innerText = currency + subtotalAmount.toFixed(2);
            document.getElementById('modal-shipping').innerText = shippingAmount > 0 ? currency + shippingAmount.toFixed(2) : '{{ __("Free") }}';
            
            // Coupon Discount
            const couponRow = document.getElementById('modal-coupon-row');
            if (discountAmount > 0) {
                couponRow.classList.remove('hidden');
                document.getElementById('modal-discount').innerText = `-${currency}${discountAmount.toFixed(2)}`;
            } else {
                couponRow.classList.add('hidden');
            }
            
            // Vendor Specific Discount (Threshold/Multi-item)
            const vendorRow = document.getElementById('modal-vendor-discount-row');
            if (vendorDiscountAmount > 0) {
                vendorRow.classList.remove('hidden');
                const label = order.vendor_discount_type === 'threshold' ? '{{ __("Order Threshold Discount") }}' : '{{ __("Multi-item Discount") }}';
                document.getElementById('modal-vendor-discount-label').innerText = label;
                document.getElementById('modal-vendor-discount').innerText = `-${currency}${vendorDiscountAmount.toFixed(2)}`;
            } else {
                vendorRow.classList.add('hidden');
            }

            // Promotional Discount (BOGO/Bundle)
            const promoRow = document.getElementById('modal-promo-discount-row');
            if (promotionalDiscountAmount > 0) {
                promoRow.classList.remove('hidden');
                document.getElementById('modal-promo-discount').innerText = `-${currency}${promotionalDiscountAmount.toFixed(2)}`;
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

            document.getElementById('modal-total').innerText = currency + totalAmount.toFixed(2);
            
            // Payment info
            document.getElementById('modal-payment-method').innerText = order.payment_method === 'cod' ? '{{ __("Cash on Delivery") }}' : (order.payment_method === 'wallet' ? '{{ __("Wallet") }}' : order.payment_method);
            
            const pStatus = document.getElementById('modal-payment-status');
            const pWrapper = document.getElementById('modal-payment-status-wrapper');
            pStatus.innerText = order.payment_status === 'paid' ? '{{ __("paid") }}' : '{{ __("pending") }}';
            
            if (order.payment_status === 'paid') {
                pWrapper.className = 'px-4 py-2.5 lg:px-4 lg:py-3 rounded-xl lg:rounded-2xl border border-green-100 bg-green-50 flex items-center gap-2 text-green-600';
            } else {
                pWrapper.className = 'px-4 py-2.5 lg:px-4 lg:py-3 rounded-xl lg:rounded-2xl border border-amber-100 bg-amber-50 flex items-center gap-2 text-amber-600';
            }

            const shipping = order.shipping_details;
            document.getElementById('modal-shipping-name').innerText = shipping.name;
            document.getElementById('modal-shipping-address').innerText = `${shipping.address}, ${shipping.city}, ${shipping.country}`;
            document.getElementById('modal-shipping-phone').innerText = shipping.phone;

            // Driver Info
            const driverBlock = document.getElementById('modal-driver-info');
            if (order.driver) {
                driverBlock.classList.remove('hidden');
                document.getElementById('modal-driver-name').innerText = order.driver.name;
                document.getElementById('modal-driver-phone').innerText = order.driver.phone;
            } else {
                driverBlock.classList.add('hidden');
            }

            document.getElementById('orderDetailsModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeOrderDetails() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Auto-open modal if targetOrder is passed from server
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($targetOrder))
                showOrderDetails(@json($targetOrder));
            @endif
        });
    </script>
    @endpush
</x-web::layouts.master>

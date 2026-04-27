<x-vendor::layouts.master>
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Order Details') }} #{{ $order->id }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Detailed view of items from your institution in this order.') }}</p>
        </div>
        <a href="{{ route('vendor.orders.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Orders') }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Items Table -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] border border-gray-100 shadow-xl overflow-hidden">
                <div class="p-8 border-b border-gray-50">
                    <h3 class="text-xl font-bold text-gray-800">{{ __('Your Products') }}</h3>
                </div>
                <table class="w-full text-left rtl:text-right">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Product') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Price') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Qty') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        @if($item->is_gift)
                                            <div class="absolute -top-2 -left-2 z-10">
                                                <span class="bg-yasmina-500 text-white text-[6px] font-black uppercase tracking-widest px-1 py-0.5 rounded shadow-lg shadow-yasmina-500/20">
                                                    {{ __('Gift') }}
                                                </span>
                                            </div>
                                        @endif
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $item->product->name }}</p>
                                        @if($item->variant)
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mt-0.5">
                                                {{ $item->variant->color }} {{ $item->variant->size ? '/ ' . $item->variant->size : '' }}
                                            </span>
                                        @endif
                                        <p class="text-xs text-gray-400">{{ $item->product->category->name ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 font-bold text-gray-600">
                                @if($item->is_gift)
                                    <span class="text-yasmina-600 uppercase text-[10px]">{{ __('Free') }}</span>
                                @else
                                    {{ number_format($item->price, 2) }}
                                @endif
                            </td>
                            <td class="px-8 py-6 font-bold text-gray-600">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-8 py-6 text-right font-black text-primary">
                                @if($item->is_gift)
                                    <span class="text-yasmina-600 uppercase text-[10px]">{{ __('Free') }}</span>
                                @else
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php $currency = $order->items->first()?->product?->currency?->symbol ?? __('LE'); @endphp
                        <tr class="bg-gray-50/50">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Subtotal') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }} {{ $currency }}</td>
                        </tr>
                        @if($order->vendor_discount_amount > 0)
                        <tr class="bg-yasmina-50/30">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-yasmina-600 uppercase tracking-widest text-[10px]">
                                <span class="flex items-center justify-end gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01" />
                                    </svg>
                                    {{ $order->vendor_discount_type === 'threshold' ? __('Order Threshold Discount') : __('Multi-item Discount') }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right font-bold text-yasmina-600">
                                -{{ number_format($order->vendor_discount_amount, 2) }} {{ $currency }}
                            </td>
                        </tr>
                        @endif
                        @if($order->promotional_discount_amount > 0)
                        <tr class="bg-amber-50/30">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-amber-600 uppercase tracking-widest text-[10px]">
                                {{ __('Promotional Discount') }}
                            </td>
                            <td class="px-8 py-4 text-right font-bold text-amber-600">
                                -{{ number_format($order->promotional_discount_amount, 2) }} {{ $currency }}
                            </td>
                        </tr>
                        @endif
                        <tr class="bg-gray-50/50">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Shipping') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->shipping_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        <tr class="border-y border-gray-100 bg-gray-50/80">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-gray-900 uppercase tracking-widest text-[10px]">{{ __('Total Amount') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->total, 2) }} {{ $currency }}</td>
                        </tr>
                        <tr class="bg-yasmina-50/30">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-yasmina-600 uppercase tracking-widest text-[10px]">
                                {{ __('Yasmina Commission') }}
                            </td>
                            <td class="px-8 py-4 text-right font-bold text-yasmina-600">
                                -{{ number_format($order->commission_amount, 2) }} {{ $currency }}
                            </td>
                        </tr>
                        <tr class="bg-primary/5">
                            <td colspan="3" class="px-8 py-6 text-right font-bold text-primary uppercase tracking-widest text-xs">{{ __('Vendor Net') }}</td>
                            <td class="px-8 py-6 text-right font-black text-primary text-2xl">
                                {{ number_format($order->vendor_net_amount, 2) }} {{ $currency }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Customer & Order Info -->
        <div class="space-y-8">
            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2.5rem] border border-gray-100 shadow-xl">
                <h3 class="text-xl font-bold text-gray-800 mb-6">{{ __('Customer Info') }}</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Name') }}</p>
                            <span class="font-bold text-gray-900">{{ $order->user->name . "( ".$order->shipping_details['name']. " ) " }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Phone') }}</p>
                        <p class="font-bold text-gray-800">{{ $order->shipping_details['phone'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Address') }}</p>
                        <p class="font-bold text-gray-800 text-sm leading-relaxed">
                            {{ $order->shipping_details['address'] ?? '' }}, 
                            {{ $order->shipping_details['city'] ?? '' }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Payment Method') }}</p>
                        <p class="font-bold text-primary">{{ in_array($order->payment_method, ['cod', 'wallet']) ? __($order->payment_method) : strtoupper($order->payment_method) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-primary p-8 rounded-[2.5rem] shadow-xl shadow-primary/20 text-white">
                <h3 class="text-xl font-bold mb-6">{{ __('Manage Status') }}</h3>
                <div class="space-y-6">
                    <form action="{{ route('vendor.orders.update-status', $order) }}" method="POST" id="statusForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="rejection_reason" id="rejection_reason">
                        <label class="block text-xs font-bold text-white/50 uppercase tracking-widest mb-2">{{ __('Order Status') }}</label>
                        <select name="status" onchange="handleStatusChange(this)" class="w-full px-5 py-4 bg-white/10 border border-white/20 rounded-2xl focus:ring-4 focus:ring-white/10 outline-none font-bold text-white transition-all appearance-none cursor-pointer">
                            @foreach(\App\Enums\OrderStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ $order->status == $status ? 'selected' : '' }} class="text-gray-800">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </form>

                    <form action="{{ route('vendor.orders.update-payment-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-bold text-white/50 uppercase tracking-widest mb-2">{{ __('Payment Status') }}</label>
                        <select name="payment_status" onchange="this.form.submit()" class="w-full px-5 py-4 bg-white/10 border border-white/20 rounded-2xl focus:ring-4 focus:ring-white/10 outline-none font-bold text-white transition-all appearance-none cursor-pointer">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }} class="text-gray-800">{{ __('pending') }}</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }} class="text-gray-800">{{ __('paid') }}</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }} class="text-gray-800">{{ __('failed') }}</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleStatusChange(select) {
            if (select.value === 'cancelled') {
                const reason = prompt("{{ __('Please enter the reason for cancellation:') }}");
                if (reason) {
                    document.getElementById('rejection_reason').value = reason;
                    document.getElementById('statusForm').submit();
                } else {
                    select.value = "{{ $order->status->value }}";
                    return false;
                }
            } else {
                select.form.submit();
            }
        }
    </script>
</x-vendor::layouts.master>

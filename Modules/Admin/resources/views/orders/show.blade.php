<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <div class="flex items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Order Details') }} #{{ $order->id }}</h1>
                <span class="px-4 py-1.5 {{ $order->status->color() }} rounded-full text-[10px] font-bold uppercase tracking-widest">{{ $order->status->label() }}</span>
                @if($order->is_manual)
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase tracking-tighter border border-amber-200">
                        {{ __('Manual') }}: {{ strtoupper($order->source) }}
                    </span>
                @endif
            </div>
            <p class="text-gray-500 mt-2">{{ __('Placed on') }} {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl font-bold hover:bg-gray-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Orders') }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Order Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Items Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-900">{{ __('Order Items') }}</h2>
                    @if(auth()->user()->vendor_id)
                        <p class="text-xs text-gray-400 mt-1">{{ __('Detailed view of items from your institution in this order.') }}</p>
                    @endif
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Product') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Quantity') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Price') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Commission') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 relative">
                                            @if($item->is_gift)
                                                <div class="absolute -top-1 -left-1 z-10">
                                                    <span class="bg-yasmina-500 text-white text-[5px] font-black uppercase tracking-widest px-1 py-0.5 rounded shadow-sm">
                                                        {{ __('Gift') }}
                                                    </span>
                                                </div>
                                            @endif
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                         <div>
                                             <span class="block font-bold text-gray-900">{{ $item->product->name ?? __('Product Not Found') }}</span>
                                             @if($item->variant)
                                                 <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mt-0.5">
                                                     {{ $item->variant->color }} {{ $item->variant->size ? '/ ' . $item->variant->size : '' }}
                                                 </span>
                                             @endif
                                             @if($item->product && $item->product->vendor)
                                                 <span class="text-[10px] font-black uppercase text-blue-500 tracking-widest bg-blue-50 px-2 py-0.5 rounded-lg border border-blue-100 mt-1 inline-block">{{ $item->product->vendor->name }}</span>
                                             @endif
                                         </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center font-bold text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-8 py-6 text-right font-medium text-gray-500">
                                    @if($item->is_gift)
                                        <span class="text-yasmina-600 uppercase text-[10px]">{{ __('Free') }}</span>
                                    @else
                                        {{ number_format($item->price, 2) }} {{ $item->product->currency->symbol ?? __('LE') }}
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right font-medium text-yasmina-600">
                                    {{ number_format($item->commission_amount, 2) }} {{ $item->product->currency->symbol ?? __('LE') }}
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-gray-900">
                                    @if($item->is_gift)
                                        <span class="text-yasmina-600 uppercase text-[10px]">{{ __('Free') }}</span>
                                    @else
                                        {{ number_format($item->price * $item->quantity, 2) }} {{ $item->product->currency->symbol ?? __('LE') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php $currency = $order->items->first()?->product?->currency?->symbol ?? __('LE'); @endphp
                        <tr class="bg-gray-50/50">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Subtotal') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }} {{ $currency }}</td>
                        </tr>
                        @if($order->vendor_discount_amount > 0)
                        <tr class="bg-gray-50/50">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">
                                {{ $order->vendor_discount_type === 'threshold' ? __('Order Threshold Discount') : __('Multi-item Discount') }}
                            </td>
                            <td class="px-8 py-4 text-right font-bold text-yasmina-600">-{{ number_format($order->vendor_discount_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        @endif
                        @if($order->promotional_discount_amount > 0)
                        <tr class="bg-gray-50/50">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Promotional Discount') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-amber-600">-{{ number_format($order->promotional_discount_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        @endif
                        @if($order->discount_amount > 0)
                        <tr class="bg-gray-50/50">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Coupon Discount') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-green-600">-{{ number_format($order->discount_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        @endif
                        <tr class="bg-gray-50/50">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Shipping') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->shipping_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        <tr class="bg-yasmina-50/30">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-yasmina-600 uppercase tracking-widest text-[10px]">{{ __('Yasmina Commission') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-yasmina-600">-{{ number_format($order->commission_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        <tr class="bg-emerald-50/30">
                            <td colspan="4" class="px-8 py-4 text-right font-bold text-emerald-600 uppercase tracking-widest text-[10px]">{{ __('Vendor Net') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-emerald-600">{{ number_format($order->vendor_net_amount, 2) }} {{ $currency }}</td>
                        </tr>
                        <tr class="bg-gray-50/50 border-t border-gray-100">
                            <td colspan="4" class="px-8 py-6 text-right font-bold text-gray-500 uppercase tracking-widest text-xs">{{ __('Grand Total') }}</td>
                            <td class="px-8 py-6 text-right font-black text-2xl text-primary">{{ number_format($order->total, 2) }} {{ $currency }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Shipping & Notes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Shipping Address') }}
                    </h3>
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Full Name') }}</span>
                            <span class="font-bold text-gray-900">
                                @if($order->user)
                                    {{ $order->user->name . "( ".$order->shipping_details['name']. " ) " }}
                                @else
                                    {{ $order->customer_name }}
                                @endif
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Contact') }}</span>
                            @if($order->user)
                                <span class="font-bold text-gray-900">{{ $order->shipping_details['email'] ?? $order->user->email }}</span>
                            @endif
                            <span class="text-sm text-gray-500">{{ $order->shipping_details['phone'] ?? $order->customer_phone }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Address') }}</span>
                            <span class="font-bold text-gray-900">{{ $order->shipping_details['address'] ?? '' }}, {{ $order->shipping_details['city'] ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('Order Notes') }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed italic">
                        {{ $order->notes ?: __('No additional notes from the customer.') }}
                    </p>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">{{ __('Payment History') }}</h2>
                        <p class="text-xs text-gray-400 mt-1">{{ __('Paid') }}: {{ number_format($order->paid_amount, 2) }} {{ $currency }} | {{ __('Remaining') }}: {{ number_format($order->remaining_amount, 2) }} {{ $currency }}</p>
                    </div>
                    @if($order->remaining_amount > 0)
                        <button onclick="togglePaymentModal()" class="px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                            {{ __('Record Payment') }}
                        </button>
                    @endif
                </div>
                @if($order->payments->count() > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Amount') }}</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Note') }}</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Receipt') }}</th>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($order->payments as $payment)
                                <tr>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($payment->amount, 2) }} {{ $currency }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-500">{{ $payment->note }}</td>
                                    <td class="px-8 py-4 text-center">
                                        @if($payment->receipt_image)
                                            <a href="{{ asset('storage/' . $payment->receipt_image) }}" target="_blank" class="text-primary hover:underline text-xs font-bold">
                                                {{ __('View Receipt') }}
                                            </a>
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        @if($order->status->value !== 'delivered')
                                            <form action="{{ route('admin.orders.delete-payment', [$order, $payment->id]) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this payment record?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-all p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-8 text-center text-gray-400 text-sm italic">
                        {{ __('No payments recorded yet.') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Management Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-xl shadow-primary/5 border border-gray-100 sticky top-10">
                <h3 class="text-lg font-bold text-gray-900 mb-8 border-b border-gray-50 pb-6">{{ __('Manage Order') }}</h3>
                
                <div class="space-y-6">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" id="statusForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="rejection_reason" id="rejection_reason">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Order Status') }}</label>
                        <select name="status" onchange="handleStatusChange(this)" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all appearance-none">
                            @foreach(\App\Enums\OrderStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </form>

                    <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Payment Status') }}</label>
                        <select name="payment_status" onchange="this.form.submit()" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all appearance-none">
                            @foreach(['pending', 'paid', 'partially_paid', 'failed'] as $p_status)
                                <option value="{{ $p_status }}" {{ $order->payment_status === $p_status ? 'selected' : '' }}>{{ __($p_status) }}</option>
                            @endforeach
                        </select>
                    </form>

                    @if(in_array($order->status->value, ['new', 'pending']))
                    <form action="{{ route('admin.orders.assign-driver', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Assign Driver') }}</label>
                        <div class="flex gap-2">
                            <select name="driver_id" class="flex-1 px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all appearance-none text-sm">
                                <option value="">{{ __('Select Driver') }}</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ $order->driver_id == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} {{ $driver->vendor ? '('.$driver->vendor->name.')' : '('.__('Global').')' }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-5 bg-primary text-white rounded-2xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    @elseif($order->driver)
                    <div class="p-5 bg-blue-50 border border-blue-100 rounded-2xl">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-3">{{ __('Assigned Driver') }}</label>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-blue-900">{{ $order->driver->name }}</p>
                                <p class="text-[10px] text-blue-500 font-bold tracking-widest">{{ $order->driver->phone }}</p>
                            </div>
                        </div>
                    </div>
                    @endif


                        </div>
                    </div>

                    @if($order->commission_value > 0 || $order->product_commission_value > 0)
                        <div class="p-5 bg-gray-50/50 border border-gray-100 rounded-2xl">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Applied Commission Rule') }}</label>
                            <div class="space-y-2">
                                @if($order->product_commission_value > 0)
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-gray-500 uppercase">{{ __('Per-Item') }}</span>
                                        <span class="text-xs font-black text-emerald-600">
                                            @if($order->product_commission_type == 'percentage')
                                                {{ $order->product_commission_value }}%
                                            @else
                                                {{ number_format($order->product_commission_value, 2) }} {{ __('LE') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                
                                @if($order->commission_value > 0)
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-gray-500 uppercase">{{ __('Global') }}</span>
                                        <span class="text-xs font-black text-indigo-600">
                                            @if($order->commission_type == 'percentage')
                                                {{ $order->commission_value }}%
                                            @else
                                                {{ number_format($order->commission_value, 2) }} {{ __('LE') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end lg:items-center justify-center min-h-screen pt-4 px-4 pb-0 lg:pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="togglePaymentModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-t-2xl lg:rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-yasmina-50 w-full">
                <form action="{{ route('admin.orders.record-payment', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-8 pt-8 pb-4">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 leading-tight">{{ __('Record Partial Payment') }}</h3>
                            <button type="button" onclick="togglePaymentModal()" class="text-gray-400 hover:text-gray-500 p-2">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Amount to Pay') }} ({{ $currency }})</label>
                                <input type="number" name="amount" step="0.01" max="{{ $order->remaining_amount }}" min="0.01" value="{{ $order->remaining_amount }}" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Receipt Image') }}</label>
                                <input type="file" name="receipt_image" accept="image/*" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Note / Reference') }}</label>
                                <textarea name="note" rows="3" placeholder="{{ __('Payment method, reference number, etc.') }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-8 py-6 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-primary text-white rounded-2xl font-bold text-sm shadow-xl shadow-primary/20 hover:opacity-90 transition-all">
                            {{ __('Save Payment') }}
                        </button>
                        <button type="button" onclick="togglePaymentModal()" class="w-full sm:w-auto px-10 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePaymentModal() {
            const modal = document.getElementById('paymentModal');
            modal.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

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
</x-admin::layouts.master>

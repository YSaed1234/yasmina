<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <div class="flex items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Order Details') }} #{{ $order->id }}</h1>
                <span class="px-4 py-1.5 {{ $order->status->color() }} rounded-full text-[10px] font-bold uppercase tracking-widest">{{ $order->status->label() }}</span>
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
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Product') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Quantity') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Price') }}</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <span class="font-bold text-gray-900">{{ $item->product->name ?? __('Product Not Found') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center font-bold text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-8 py-6 text-right font-medium text-gray-500">{{ number_format($item->price, 2) }}</td>
                                <td class="px-8 py-6 text-right font-bold text-gray-900">{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50/50">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Subtotal') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->total - $order->shipping_amount + $order->discount_amount, 2) }}</td>
                        </tr>
                        @if($order->discount_amount > 0)
                        <tr class="bg-gray-50/50">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Discount') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-green-600">-{{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="bg-gray-50/50">
                            <td colspan="3" class="px-8 py-4 text-right font-bold text-gray-500 uppercase tracking-widest text-[10px]">{{ __('Shipping') }}</td>
                            <td class="px-8 py-4 text-right font-bold text-gray-900">{{ number_format($order->shipping_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-50/50 border-t border-gray-100">
                            <td colspan="3" class="px-8 py-6 text-right font-bold text-gray-500 uppercase tracking-widest text-xs">{{ __('Grand Total') }}</td>
                            <td class="px-8 py-6 text-right font-black text-2xl text-primary">{{ number_format($order->total, 2) }}</td>
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
                            <span class="font-bold text-gray-900">{{ $order->shipping_details['name'] ?? '' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">{{ __('Contact') }}</span>
                            <span class="font-bold text-gray-900">{{ $order->shipping_details['email'] ?? '' }}</span>
                            <span class="text-sm text-gray-500">{{ $order->shipping_details['phone'] ?? '' }}</span>
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
        </div>

        <!-- Order Management Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-xl shadow-primary/5 border border-gray-100 sticky top-10">
                <h3 class="text-lg font-bold text-gray-900 mb-8 border-b border-gray-50 pb-6">{{ __('Manage Order') }}</h3>
                
                <div class="space-y-6">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Order Status') }}</label>
                        <select name="status" onchange="this.form.submit()" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all appearance-none">
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
                            @foreach(['pending', 'paid', 'failed'] as $p_status)
                                <option value="{{ $p_status }}" {{ $order->payment_status === $p_status ? 'selected' : '' }}>{{ __($p_status) }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-50">
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this order? This action cannot be undone.') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-50 text-red-600 rounded-2xl font-bold text-sm hover:bg-red-100 transition-all">
                            {{ __('Delete Order Record') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts.master>

<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Orders') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Track and manage orders containing your products.') }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        <table class="w-full text-left rtl:text-right">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Order ID') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Your Items') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Your Revenue') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Payment') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($orders->firstItem() - 1) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-bold text-gray-800">#{{ $order->id }}</p>
                        <p class="text-[10px] text-gray-400 font-medium uppercase">{{ $order->created_at->format('M d, Y') }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-bold text-gray-800">{{ $order->shipping_details['name'] ?? __('Guest') }}</p>
                        <p class="text-xs text-gray-400">{{ $order->shipping_details['phone'] ?? '' }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full bg-primary/5 text-primary text-[10px] font-black uppercase border border-primary/10">
                            {{ $order->items->count() }} {{ __('Items') }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        @php $currency = $order->items->first()?->product?->currency?->symbol ?? __('LE'); @endphp
                        <p class="font-bold text-gray-900">{{ number_format($order->total, 2) }} {{ $currency }}</p>
                        <p class="text-[10px] text-rose-500 font-medium">-{{ number_format($order->commission_amount, 2) }} {{ $currency }} {{ __('Yasmina Commission') }}</p>
                        <p class="text-[10px] text-emerald-600 font-bold">{{ number_format($order->vendor_net_amount, 2) }} {{ $currency }} {{ __('Vendor Net') }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <form action="{{ route('vendor.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="rejection_reason" class="rejection-reason-input">
                            <select name="status" onchange="handleStatusChange(this)" 
                                data-original-status="{{ $order->status->value }}"
                                class="px-4 py-2 rounded-2xl text-[10px] font-bold uppercase tracking-widest border-none outline-none cursor-pointer transition-all {{ $order->status->color() }}">
                                @foreach(\App\Enums\OrderStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ $order->status == $status ? 'selected' : '' }} class="bg-white text-gray-700">
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-8 py-5">
                        <form action="{{ route('vendor.orders.update-payment-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="payment_status" onchange="this.form.submit()" 
                                class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest border-none outline-none cursor-pointer transition-all {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-600' : ($order->payment_status === 'failed' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>{{ __('paid') }}</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>{{ __('failed') }}</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('vendor.orders.show', $order->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-8 py-10 text-center text-gray-400 font-medium">
                        {{ __('No orders found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @endif
    <script>
        function handleStatusChange(select) {
            if (select.value === 'cancelled') {
                const reason = prompt("{{ __('Please enter the reason for cancellation:') }}");
                if (reason) {
                    const form = select.closest('form');
                    form.querySelector('.rejection-reason-input').value = reason;
                    form.submit();
                } else {
                    select.value = select.getAttribute('data-original-status');
                    return false;
                }
            } else {
                select.form.submit();
            }
        }
    </script>
</x-vendor::layouts.master>

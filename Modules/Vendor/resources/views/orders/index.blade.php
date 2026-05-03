<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Orders') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Track and manage orders containing your products.') }}</p>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-gray-200/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] w-16 text-center">#</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">{{ __('Order Details') }}</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">{{ __('Customer') }}</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">{{ __('Financials') }}</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">{{ __('Status') }}</th>
                        <th class="px-8 py-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/80 transition-all group">
                            <td class="px-8 py-8 text-center">
                                <span class="text-xs font-bold text-gray-300">#{{ $loop->iteration + ($orders->firstItem() - 1) }}</span>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-base font-black text-gray-900 group-hover:text-primary transition-colors">#{{ $order->id }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    <div class="mt-2 flex justify-center">
                                        <span class="px-3 py-1 rounded-full bg-primary/5 text-primary text-[9px] font-black uppercase border border-primary/10">
                                            {{ $order->items->count() }} {{ __('Items') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <p class="font-black text-gray-800 text-sm">{{ $order->user->name }}</p>
                                    <div class="flex items-center justify-center gap-2 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-xs font-bold">{{ $order->shipping_details['phone'] ?? $order->user->phone }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                @php $currency = $order->items->first()?->product?->currency?->symbol ?? __('LE'); @endphp
                                <div class="flex flex-col items-center gap-1">
                                    <p class="text-lg font-black text-primary">{{ number_format($order->total, 2) }} <span class="text-[10px]">{{ $currency }}</span></p>
                                    <div class="flex flex-col items-center">
                                        <span class="text-[9px] text-yasmina-500 font-bold uppercase tracking-widest">{{ __('Yasmina') }}: -{{ number_format($order->commission_amount, 2) }}</span>
                                        <span class="text-[9px] text-emerald-600 font-bold uppercase tracking-widest">{{ __('Net') }}: {{ number_format($order->vendor_net_amount, 2) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <div class="flex flex-col items-center gap-3 min-w-[140px]">
                                    <form action="{{ route('vendor.orders.update-status', $order) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="rejection_reason" class="rejection-reason-input">
                                        <div class="relative">
                                            <select name="status" onchange="handleStatusChange(this)" 
                                                data-original-status="{{ $order->status->value }}"
                                                class="w-full pl-4 pr-8 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border-2 outline-none cursor-pointer transition-all appearance-none {{ $order->status->color() }}">
                                                @foreach(\App\Enums\OrderStatus::cases() as $status)
                                                    <option value="{{ $status->value }}" {{ $order->status == $status ? 'selected' : '' }} class="bg-white text-gray-700">
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none opacity-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </form>

                                    <form action="{{ route('vendor.orders.update-payment-status', $order) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <div class="relative">
                                            <select name="payment_status" onchange="this.form.submit()" 
                                                class="w-full pl-4 pr-8 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border-2 outline-none cursor-pointer transition-all appearance-none {{ $order->payment_status === 'paid' ? 'bg-green-50 border-green-100 text-green-600' : ($order->payment_status === 'partially_paid' ? 'bg-blue-50 border-blue-100 text-blue-600' : ($order->payment_status === 'failed' ? 'bg-red-50 border-red-100 text-red-600' : 'bg-amber-50 border-amber-100 text-amber-600')) }}">
                                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
                                                <option value="partially_paid" {{ $order->payment_status === 'partially_paid' ? 'selected' : '' }}>{{ __('partially_paid') }}</option>
                                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>{{ __('paid') }}</option>
                                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>{{ __('failed') }}</option>
                                            </select>
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none opacity-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <a href="{{ route('vendor.orders.show', $order->id) }}" class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl hover:bg-primary hover:text-white transition-all shadow-sm group-hover:shadow-lg group-hover:shadow-primary/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">
                                {{ __('No orders found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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

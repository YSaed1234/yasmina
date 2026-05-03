<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Orders') }} <span class="ml-2 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">{{ $orders->total() }}</span></h1>
            <p class="text-gray-500 mt-2">
                @if(auth()->user()->vendor_id)
                    {{ __('Track and manage orders containing your products.') }}
                @else
                    {{ __('Manage customer orders and track payment statuses.') }}
                @endif
            </p>
        </div>
    </div>

    <div class="mb-10 flex flex-wrap gap-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex-1 flex gap-4 min-w-[300px]">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by Order ID or Customer Name') }}..." 
                       class="w-full pl-12 pr-4 py-3 bg-white border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <select name="status" onchange="this.form.submit()" class="px-6 py-3 bg-white border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none transition-all min-w-[200px]">
                <option value="">{{ __('All Statuses') }}</option>
                @foreach(\App\Enums\OrderStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
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
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/80 transition-all group">
                            <td class="px-8 py-8 text-center">
                                <span class="text-xs font-bold text-gray-300">#{{ $loop->iteration + ($orders->firstItem() - 1) }}</span>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-base font-black text-gray-900 group-hover:text-primary transition-colors">#{{ $order->id }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    <div class="flex flex-wrap justify-center gap-1 mt-2">
                                        @php
                                            $vendors = $order->items->map(fn($i) => $i->product->vendor)->filter()->unique('id');
                                        @endphp
                                        @foreach($vendors as $vendor)
                                            <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-500 text-[9px] font-black uppercase tracking-tighter border border-blue-100/50 whitespace-nowrap">
                                                {{ $vendor->name }}
                                            </span>
                                        @endforeach
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
                                    <p class="text-[10px] text-gray-400 font-medium truncate max-w-[150px] mx-auto">{{ $order->shipping_details['address'] ?? '' }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                @php $currency = $order->items->first()?->product?->currency?->symbol ?? __('LE'); @endphp
                                <div class="flex flex-col items-center gap-1">
                                    <p class="text-lg font-black text-primary">{{ number_format($order->total, 2) }} <span class="text-[10px]">{{ $currency }}</span></p>
                                    <div class="flex flex-col items-center">
                                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ __('Commission') }}: <span class="text-yasmina-500">{{ number_format($order->commission_amount, 2) }}</span></span>
                                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ __('Net') }}: <span class="text-emerald-500">{{ number_format($order->vendor_net_amount, 2) }}</span></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="status-update-form w-full max-w-[140px]">
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

                                    <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="w-full max-w-[140px]">
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
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 text-gray-400 rounded-2xl hover:bg-primary hover:text-white transition-all shadow-sm group-hover:shadow-lg group-hover:shadow-primary/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-black uppercase tracking-[0.2em] text-xs">{{ __('No orders found') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>    <div class="px-8 py-6 border-t border-gray-50">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
    <script>
        function handleStatusChange(select) {
            if (select.value === 'cancelled') {
                const reason = prompt("{{ __('Please enter the reason for cancellation:') }}");
                if (reason) {
                    const form = select.closest('form');
                    form.querySelector('.rejection-reason-input').value = reason;
                    form.submit();
                } else {
                    // Reset to original value if cancelled
                    select.value = select.getAttribute('data-original-status');
                    return false;
                }
            } else {
                select.form.submit();
            }
        }
    </script>
</x-admin::layouts.master>

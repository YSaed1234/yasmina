<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Orders') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage customer orders and track payment statuses.') }}</p>
        </div>
    </div>

    <div class="mb-10 flex flex-wrap gap-4">
        <form method="GET" action="{{ route('orders.index') }}" class="flex-1 flex gap-4 min-w-[300px]">
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

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order ID') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Total') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Shipping') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Payment') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="font-bold text-gray-900">#{{ $order->id }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900">{{ $order->shipping_details['name'] ?? 'Guest' }}</span>
                                <span class="text-xs text-gray-400">{{ $order->shipping_details['email'] ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 font-bold text-primary">
                            {{ number_format($order->total, 2) }}
                        </td>
                        <td class="px-8 py-6 text-sm text-gray-500 font-bold">
                            {{ number_format($order->shipping_amount, 2) }}
                        </td>
                        <td class="px-8 py-6">
                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="status-update-form">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" 
                                    class="px-4 py-2 rounded-2xl text-[10px] font-bold uppercase tracking-widest border-none outline-none cursor-pointer transition-all {{ $order->status->color() }}">
                                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                                        <option value="{{ $status->value }}" {{ $order->status == $status ? 'selected' : '' }} class="bg-white text-gray-700">
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-8 py-6">
                            <form action="{{ route('orders.update-payment-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="payment_status" onchange="this.form.submit()" 
                                    class="px-4 py-2 rounded-2xl text-[10px] font-bold uppercase tracking-widest border-none outline-none cursor-pointer transition-all {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-600' : ($order->payment_status === 'failed' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>{{ __('paid') }}</option>
                                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>{{ __('failed') }}</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-8 py-6 text-sm text-gray-500 font-medium">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ __('View Details') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">{{ __('No orders found') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-6 border-t border-gray-50">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</x-admin::layouts.master>

<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Orders') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage customer orders and track payment statuses.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order ID') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Total') }}</th>
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
                        <td class="px-8 py-6">
                            @php
                                $statusColors = [
                                    'new' => 'bg-blue-50 text-blue-600',
                                    'processing' => 'bg-amber-50 text-amber-600',
                                    'shipped' => 'bg-indigo-50 text-indigo-600',
                                    'delivered' => 'bg-green-50 text-green-600',
                                    'cancelled' => 'bg-red-50 text-red-600',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $statusColors[$order->status] ?? 'bg-gray-50 text-gray-600' }}">
                                {{ __($order->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ __($order->payment_status) }}
                            </span>
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
            {{ $orders->links() }}
        </div>
    </div>
</x-admin::layouts.master>

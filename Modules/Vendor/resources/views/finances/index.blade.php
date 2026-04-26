<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Finances') }}</h1>
        <p class="text-gray-500">{{ __('Track your sales, commissions, and net earnings.') }}</p>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Sales -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Sales') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_sales'], 2) }} <span class="text-sm font-bold text-gray-400">LE</span></p>
        </div>

        <!-- Total Commission -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-yasmina-100 transition-all group">
            <h3 class="text-yasmina-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Yasmina Commission') }}</h3>
            <p class="text-3xl font-black text-yasmina-500">-{{ number_format($stats['total_commission'], 2) }} <span class="text-sm font-bold text-yasmina-300">LE</span></p>
        </div>

        <!-- Promotional Discounts -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-amber-100 transition-all group">
            <h3 class="text-amber-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Promotional Discounts') }}</h3>
            <p class="text-3xl font-black text-amber-500">{{ number_format($stats['total_promotional_discounts'], 2) }} <span class="text-sm font-bold text-amber-400">LE</span></p>
        </div>

        <!-- Vendor Net -->
        <div class="bg-emerald-50 p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-emerald-100 transition-all group">
            <h3 class="text-emerald-500 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Vendor Net') }}</h3>
            <p class="text-3xl font-black text-emerald-600">{{ number_format($stats['net_earnings'], 2) }} <span class="text-sm font-bold text-emerald-400">LE</span></p>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-gray-800">{{ __('Order Breakdown') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order ID') }}</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Amount') }}</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Commission') }}</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Vendor Payout') }}</th>
                        <th class="px-8 py-6 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6 font-bold text-gray-900">#{{ $order->id }}</td>
                            <td class="px-8 py-6 text-gray-500">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-8 py-6 font-bold text-gray-900">{{ number_format($order->total, 2) }} LE</td>
                            <td class="px-8 py-6 text-yasmina-500 font-medium">-{{ number_format($order->commission_amount, 2) }} LE</td>
                            <td class="px-8 py-6 text-emerald-600 font-bold">{{ number_format($order->vendor_net_amount, 2) }} LE</td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest {{ $order->status->color() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-12 text-center text-gray-400 italic">
                                {{ __('No orders found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-gray-50">
            {{ $orders->links() }}
        </div>
    </div>
</x-vendor::layouts.master>

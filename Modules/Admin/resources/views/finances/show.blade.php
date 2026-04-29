<x-admin::layouts.master>
    <div class="mb-10">
        <a href="{{ route('admin.finances.index') }}" class="text-primary font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Reports') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Financial Details') }}: {{ $vendor->name }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Granular breakdown of orders and commissions for this institution.') }}</p>
    </div>

    <!-- Vendor Totals -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 transition-all group">
            <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Sales') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($stats->total_sales, 2) }} <span class="text-xs font-bold text-gray-400">LE</span></p>
        </div>

        <div class="bg-amber-50 p-8 rounded-[2.5rem] shadow-sm border border-amber-100 transition-all group">
            <h3 class="text-amber-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Promotional Discounts') }}</h3>
            <p class="text-3xl font-black text-amber-600">{{ number_format($stats->total_promotions, 2) }} <span class="text-xs font-bold text-amber-400">LE</span></p>
        </div>

        <div class="bg-indigo-50 p-8 rounded-[2.5rem] shadow-sm border border-indigo-100 transition-all group">
            <h3 class="text-indigo-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Yasmina Share') }}</h3>
            <p class="text-3xl font-black text-indigo-600">{{ number_format($stats->total_commission, 2) }} <span class="text-xs font-bold text-indigo-400">LE</span></p>
        </div>

        <div class="bg-emerald-50 p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 transition-all group">
            <h3 class="text-emerald-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Vendor Net') }}</h3>
            <p class="text-3xl font-black text-emerald-600">{{ number_format($stats->total_net, 2) }} <span class="text-xs font-bold text-emerald-400">LE</span></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-xl font-bold text-gray-800">{{ __('Order Breakdown') }}</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Order ID') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Date') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Amount') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Commission Rule') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Commission') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Vendor Payout') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-6 font-bold text-gray-900">
                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary">#{{ $order->id }}</a>
                    </td>
                    <td class="px-8 py-6 text-center text-sm text-gray-500">
                        {{ $order->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-8 py-6 text-center font-bold text-gray-900">
                        {{ number_format($order->total, 2) }} {{ __('LE') }}
                    </td>
                    <td class="px-8 py-6 text-center">
                        @if($order->product_commission_value > 0)
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-lg uppercase">
                                {{ __('Per Item') }}
                            </span>
                        @else
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-lg uppercase">
                                {{ __('Per Order') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-center text-indigo-600 font-bold">
                        -{{ number_format($order->commission_amount, 2) }} {{ __('LE') }}
                    </td>
                    <td class="px-8 py-6 text-center text-emerald-600 font-bold">
                        {{ number_format($order->vendor_net_amount, 2) }} {{ __('LE') }}
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }}">
                            {{ $order->status->label() }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-10 text-center text-gray-400 italic">
                        {{ __('No orders found for this institution.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-6 bg-gray-50/50">
            {{ $orders->links() }}
        </div>
    </div>
</x-admin::layouts.master>

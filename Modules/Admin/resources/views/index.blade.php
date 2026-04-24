<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Welcome back,') }} {{ auth()->user()->name }}</h1>
        <p class="text-gray-500">
            @if(auth()->user()->vendor_id)
                {{ __('Here is what is happening with your institution today.') }}
            @else
                {{ __('Here is what is happening with your platform today.') }}
            @endif
        </p>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Revenue -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Sales') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_revenue'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Yasmina Share -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Yasmina Share') }}</h3>
            <p class="text-3xl font-black text-rose-600">{{ number_format($stats['total_commission'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Vendor Net -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Vendor Payouts') }}</h3>
            <p class="text-3xl font-black text-emerald-600">{{ number_format($stats['total_vendor_net'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Orders -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Orders') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['orders_count'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Platform Revenue Trend -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-gray-800">{{ __('Platform Revenue Trend') }}</h3>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Last 6 Months') }}</span>
            </div>
            <div id="revenueChart" class="w-full h-80"></div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-2xl font-bold text-gray-800 mb-8">{{ __('Order Breakdown') }}</h3>
            <div class="space-y-6">
                @foreach(\App\Enums\OrderStatus::cases() as $status)
                    @php
                        $count = $statusBreakdown[$status->value] ?? 0;
                        $total = array_sum($statusBreakdown);
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        $color = $status->chartColor();
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $status->label() }}</span>
                            <span class="text-sm font-black text-gray-900">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-yasmina-50 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-{{ $color }}-500 h-full transition-all duration-1000 shadow-sm" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(!auth()->user()->vendor_id && count($topVendors) > 0)
    <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50 mb-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-8">{{ __('Top Performing Vendors') }}</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left rtl:text-right">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-yasmina-50">
                        <th class="pb-6 font-black">{{ __('Vendor') }}</th>
                        <th class="pb-6 font-black text-center">{{ __('Orders') }}</th>
                        <th class="pb-6 font-black text-center">{{ __('Revenue') }}</th>
                        <th class="pb-6 font-black text-center">{{ __('Commission') }}</th>
                        <th class="pb-6 font-black text-right">{{ __('Net Profit') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yasmina-50">
                    @foreach($topVendors as $vendor)
                        <tr class="group hover:bg-yasmina-50/30 transition-colors">
                            <td class="py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-yasmina-50 flex items-center justify-center overflow-hidden border border-yasmina-100 shrink-0">
                                        @if($vendor['logo'])
                                            <img src="{{ asset('storage/' . $vendor['logo']) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-yasmina-300 font-bold text-xl">{{ substr($vendor['name'], 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $vendor['name'] }}</span>
                                </div>
                            </td>
                            <td class="py-6 text-center font-bold text-gray-600">{{ $vendor['orders_count'] }}</td>
                            <td class="py-6 text-center font-black text-gray-900">{{ number_format($vendor['revenue'], 2) }}</td>
                            <td class="py-6 text-center font-black text-rose-500">{{ number_format($vendor['commission'], 2) }}</td>
                            <td class="py-6 text-right">
                                <span class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl font-black text-sm">
                                    {{ number_format($vendor['revenue'] - $vendor['commission'], 2) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-gray-800">{{ __('Recent Orders') }}</h3>
                <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-yasmina-50 text-yasmina-600 rounded-xl font-bold text-sm hover:bg-yasmina-100 transition-all">
                    {{ __('View All') }}
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left rtl:text-right">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-yasmina-50">
                            <th class="pb-6 font-black">{{ __('Order ID') }}</th>
                            <th class="pb-6 font-black">{{ __('Customer') }}</th>
                            <th class="pb-6 font-black">{{ __('Total') }}</th>
                            <th class="pb-6 font-black">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-yasmina-50">
                        @forelse($recentOrders as $order)
                            <tr class="group hover:bg-yasmina-50/30 transition-colors">
                                <td class="py-6">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="font-black text-yasmina-600 hover:text-yasmina-700">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td class="py-6">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800">{{ $order->user->name ?? $order->shipping_details['name'] ?? __('Guest') }}</span>
                                    </div>
                                </td>
                                <td class="py-6 font-black text-gray-900">
                                    {{ number_format($order->total, 2) }} <span class="text-[10px] text-gray-400">LE</span>
                                </td>
                                <td class="py-6">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-400 italic">
                                    {{ __('No orders found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-2xl font-bold text-gray-800 mb-8">{{ __('Top Selling Products') }}</h3>
            <div class="space-y-6">
                @forelse($topProducts as $item)
                    <div class="flex items-center gap-4 group">
                        <div class="w-16 h-16 rounded-2xl bg-yasmina-50 overflow-hidden shrink-0 border border-yasmina-100">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-yasmina-300 italic text-[10px]">No Image</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $item->product->name }}</h4>
                            <p class="text-xs text-gray-400 font-medium">{{ $item->total_qty }} {{ __('Items Sold') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-gray-900">{{ number_format($item->total_revenue, 2) }}</p>
                            <span class="text-[10px] font-bold text-gray-400 uppercase">LE</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm italic py-8">{{ __('No products sold yet') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions / Recent Activity Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl hover:bg-yasmina-50 transition-all group border border-yasmina-50">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-yasmina-500 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">{{ __('Add Product') }}</span>
                </a>
                <a href="{{ route('admin.coupons.create') }}" class="flex flex-col items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl hover:bg-yasmina-50 transition-all group border border-yasmina-50">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-yasmina-500 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">{{ __('Create Coupon') }}</span>
                </a>
            </div>
        </div>

        <div class="bg-yasmina-500 p-10 rounded-[3rem] shadow-xl shadow-yasmina-100 text-white flex flex-col justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-4">
                    @if(auth()->user()->vendor_id)
                        {{ __('Institution Status') }}
                    @else
                        {{ __('Store Status') }}
                    @endif
                </h3>
                <p class="text-yasmina-100 leading-relaxed">
                    @if(auth()->user()->vendor_id)
                        {{ __('Your institution is currently active. You can manage your products and track sales directly from this panel.') }}
                    @else
                        {{ __('Your store is currently live and performing well. We have detected a growth in user engagement this week.') }}
                    @endif
                </p>
            </div>
            <div class="mt-8">
                <a href="/" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-yasmina-600 rounded-2xl font-bold hover:bg-yasmina-50 transition-all">
                    {{ __('View Storefront') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthlyData = @json($monthlySales);
            const categories = monthlyData.map(d => {
                const monthName = new Date(d.year, d.month - 1).toLocaleString('{{ app()->getLocale() }}', { month: 'short' });
                return monthName + ' ' + d.year;
            });
            const revenue = monthlyData.map(d => d.revenue);
            const commission = monthlyData.map(d => d.commission);

            const options = {
                series: [{
                    name: '{{ __("Platform Revenue") }}',
                    data: revenue
                }, {
                    name: '{{ __("Yasmina Share") }}',
                    data: commission
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    toolbar: { show: false },
                    fontFamily: 'Outfit, Tajawal, sans-serif'
                },
                colors: ['#3b82f6', '#f43f5e'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: categories,
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) { return val.toLocaleString() + ' LE'; }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) { return val.toLocaleString() + ' LE'; }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [20, 100]
                    }
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4
                }
            };

            const chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();
        });
    </script>
    @endpush
</x-admin::layouts.master>

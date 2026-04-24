<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Welcome back,') }} {{ auth('vendor')->user()->name }}</h1>
        <p class="text-gray-500">{{ __('Here is what is happening with your institution today.') }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Sales -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Sales') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_sales'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Net Earnings -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Net Earnings') }}</h3>
            <p class="text-3xl font-black text-gray-900 text-emerald-600">{{ number_format($stats['net_earnings'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Yasmina Commission -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Yasmina Commission') }}</h3>
            <p class="text-3xl font-black text-gray-900 text-rose-500">{{ number_format($stats['total_commission'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Promotional Discounts -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Promotional Discounts') }}</h3>
            <p class="text-3xl font-black text-gray-900 text-amber-500">{{ number_format($stats['total_promotional_discounts'], 2) }} <span class="text-sm font-bold text-gray-400">{{ __('LE') }}</span></p>
        </div>

        <!-- Active Products -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Active Products') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['products_count'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Sales Trend Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-gray-800">{{ __('Sales Trend') }}</h3>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Last 6 Months') }}</span>
            </div>
            <div id="salesChart" class="w-full h-80"></div>
        </div>

        <!-- Order Status Breakdown -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-8">{{ __('Order Status') }}</h3>
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
                            <span class="text-sm font-bold text-gray-600 uppercase tracking-tight">{{ $status->label() }}</span>
                            <span class="text-sm font-black text-gray-900">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-{{ $color }}-500 h-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Recent Orders -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-gray-800">{{ __('Recent Orders') }}</h3>
                <a href="{{ route('vendor.orders.index') }}" class="text-sm font-bold text-primary hover:underline">{{ __('View All') }}</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left rtl:text-right">
                    <thead>
                        <tr class="text-gray-400 text-[10px] uppercase tracking-widest border-b border-gray-50">
                            <th class="pb-4 font-black">{{ __('Order ID') }}</th>
                            <th class="pb-4 font-black">{{ __('Customer') }}</th>
                            <th class="pb-4 font-black">{{ __('Total') }}</th>
                            <th class="pb-4 font-black">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="py-4">
                                    <a href="{{ route('vendor.orders.show', $order->id) }}" class="text-sm font-bold text-gray-900 hover:text-primary transition-colors">#{{ $order->id }}</a>
                                </td>
                                <td class="py-4">
                                    <span class="text-sm font-medium text-gray-600">{{ $order->user->name ?? __('Guest') }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="text-sm font-black text-gray-900">{{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 text-sm italic">{{ __('No orders yet') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-8">{{ __('Top Selling Products') }}</h3>
            <div class="space-y-6">
                @forelse($topProducts as $item)
                    <div class="flex items-center gap-4 group">
                        <div class="w-16 h-16 rounded-2xl bg-gray-50 overflow-hidden shrink-0 border border-gray-100">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 italic text-[10px]">No Image</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $item->product->name }}</h4>
                            <p class="text-xs text-gray-400 font-medium">{{ $item->total_qty }} {{ __('Items Sold') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-gray-900">{{ number_format($item->total_revenue, 2) }}</p>
                            <span class="text-[10px] font-bold text-gray-400 uppercase">{{ __('LE') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm italic py-8">{{ __('No products sold yet') }}</p>
                @endforelse
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
            const net = monthlyData.map(d => d.net);

            const options = {
                series: [{
                    name: '{{ __("Total Sales") }}',
                    data: revenue
                }, {
                    name: '{{ __("Net Earnings") }}',
                    data: net
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    toolbar: { show: false },
                    fontFamily: 'Outfit, Tajawal, sans-serif'
                },
                colors: ['#865d58', '#10b981'],
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

            const chart = new ApexCharts(document.querySelector("#salesChart"), options);
            chart.render();
        });
    </script>
    @endpush
</x-vendor::layouts.master>

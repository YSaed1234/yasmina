<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Financial Reports') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Overview of sales and commissions across all institutions.') }}</p>
    </div>

    <!-- Grand Totals -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Platform Sales') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($grand_stats->total_sales, 2) }} <span class="text-xs font-bold text-gray-400">LE</span></p>
        </div>

        <div class="bg-amber-50 p-8 rounded-[2.5rem] shadow-sm border border-amber-100 hover:shadow-xl hover:shadow-amber-100 transition-all group">
            <h3 class="text-amber-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Promotional Discounts') }}</h3>
            <p class="text-3xl font-black text-amber-600">{{ number_format($grand_stats->total_promotions, 2) }} <span class="text-xs font-bold text-amber-400">LE</span></p>
        </div>

        <div class="bg-indigo-50 p-8 rounded-[2.5rem] shadow-sm border border-indigo-100 hover:shadow-xl hover:shadow-indigo-100 transition-all group">
            <h3 class="text-indigo-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Yasmina Commission') }}</h3>
            <p class="text-3xl font-black text-indigo-600">{{ number_format($grand_stats->total_commission, 2) }} <span class="text-xs font-bold text-indigo-400">LE</span></p>
        </div>

        <div class="bg-emerald-50 p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 hover:shadow-xl hover:shadow-emerald-100 transition-all group">
            <h3 class="text-emerald-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Vendor Payouts') }}</h3>
            <p class="text-3xl font-black text-emerald-600">{{ number_format($grand_stats->total_net, 2) }} <span class="text-xs font-bold text-emerald-400">LE</span></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-xl font-bold text-gray-800">{{ __('Institution Commission Summary') }}</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Institution') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Orders') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Commission Structure') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Total Sales') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-indigo-600">{{ __('Yasmina Share') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($vendors as $vendor)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            @if($vendor->logo)
                                <img src="{{ asset('storage/' . $vendor->logo) }}" class="w-10 h-10 rounded-xl object-cover shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <span class="font-bold text-gray-900 block">{{ $vendor->name }}</span>
                                <span class="text-[10px] text-gray-400 uppercase font-black tracking-widest">{{ $vendor->status }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-sm font-bold text-gray-600">{{ $vendor->orders_count }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black rounded-lg uppercase">
                            @if($vendor->commission_type == 'percentage')
                                {{ $vendor->commission_value }}%
                            @else
                                {{ number_format($vendor->commission_value, 2) }} LE (Fixed)
                            @endif
                        </span>
                    </td>
                    <td class="px-8 py-6 font-bold text-gray-900">
                        {{ number_format($vendor->total_sales, 2) }} LE
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600">
                        {{ number_format($vendor->total_commission, 2) }} LE
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('admin.finances.show', $vendor) }}" class="px-4 py-2 bg-primary/10 text-primary rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all">
                            {{ __('View Details') }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-8 py-6 bg-gray-50/50">
            {{ $vendors->links() }}
        </div>
    </div>
</x-admin::layouts.master>

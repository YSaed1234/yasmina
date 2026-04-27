<x-admin::layouts.master>
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Vendor Transactions') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Overview of total sales and orders across all institutions.') }}</p>
        </div>
        
        <form action="{{ route('admin.reports.vendor_transactions') }}" method="GET" class="flex items-center gap-3 bg-white p-2 px-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="vendor_search" value="{{ $vendorSearch }}" placeholder="{{ __('Search Institution...') }}" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-700 w-64">
            @if($vendorSearch)
                <a href="{{ route('admin.reports.vendor_transactions') }}" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
            <button type="submit" class="hidden"></button>
        </form>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gray-50/30">
            <h2 class="text-xl font-bold text-gray-900">{{ __('Institutions Financial Overview') }}</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Institution') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Successful Orders') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Returned Orders') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Total Revenue') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Performance') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($vendorStats as $vendor)
                    <tr class="hover:bg-gray-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                @if($vendor->logo)
                                    <img src="{{ asset('storage/'.$vendor->logo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-100">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-yasmina-100 flex items-center justify-center text-yasmina-600 font-bold">
                                        {{ substr($vendor->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <span class="block font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $vendor->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $vendor->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">{{ $vendor->orders_count }}</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 {{ $vendor->returned_orders_count > 0 ? 'bg-rose-100 text-rose-600' : 'bg-gray-100 text-gray-700' }} rounded-full text-xs font-bold">{{ $vendor->returned_orders_count }}</span>
                        </td>
                        <td class="px-8 py-6 text-center font-black text-emerald-600">
                            {{ number_format($vendor->orders_sum_total ?? 0, 2) }} {{ __('LE') }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary" style="width: {{ min(100, ($vendor->orders_count / max(1, $vendorStats->max('orders_count'))) * 100) }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-400">{{ round(($vendor->orders_count / max(1, $vendorStats->max('orders_count'))) * 100) }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">
                            {{ __('No institution transactions found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($vendorStats->hasPages())
            <div class="p-8 border-t border-gray-50 bg-gray-50/30">
                {{ $vendorStats->links() }}
            </div>
        @endif
    </div>
</x-admin::layouts.master>

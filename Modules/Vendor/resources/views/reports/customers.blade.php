<x-vendor::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Customer Behavior') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Analyze your top customers and their purchasing patterns for your products.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">{{ __('Your Top 20 Customers') }}</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Orders with You') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Total Spent on You') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Joined') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-yasmina-100 flex items-center justify-center text-yasmina-600 font-bold">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="block font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $customer->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $customer->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">{{ $customer->orders_count }}</span>
                        </td>
                        <td class="px-8 py-6 text-right font-black text-emerald-600">
                            {{ number_format($customer->orders_sum_total ?? 0, 2) }} {{ __('LE') }}
                        </td>
                        <td class="px-8 py-6 text-right text-xs text-gray-500 font-medium">
                            {{ $customer->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">
                            {{ __('No customer data found for your products.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-vendor::layouts.master>

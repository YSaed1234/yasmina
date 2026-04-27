<x-admin::layouts.master>
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Customer Behavior') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Analyze your top customers and their purchasing patterns.') }}</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center gap-4">
            

            @if(!auth()->user()->vendor_id)
            <form action="{{ route('admin.reports.customers') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="search" value="{{ $search }}">
                {{-- <input type="text" name="vendor_search" value="{{ $vendorSearch }}" placeholder="{{ __('Search Institution...') }}" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none"> --}}
                <select name="vendor_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none">
                    <option value="">{{ __('All Institutions') }}</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $vendorId == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </form>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">{{ $search ? __('Search Results') : __('Top 20 Customers') }}</h2>
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Total Customers') }}</p>
                    <p class="text-lg font-black text-primary">{{ \App\Models\User::where('role', '!=', 'admin')->orWhereNull('role')->count() }}</p>
                </div>
            </div>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Orders') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Total Spent') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Wallet Balance') }}</th>
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
                                    <br/>
                                    <span class="text-xs text-gray-400">{{ $customer->phone }}</span>

                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">{{ $customer->orders_count }}</span>
                        </td>
                        <td class="px-8 py-6 text-right font-black text-emerald-600">
                            {{ number_format($customer->orders_sum_total ?? 0, 2) }} {{ __('LE') }}
                        </td>
                        <td class="px-8 py-6 text-right font-bold text-blue-600">
                            {{ number_format($customer->balance, 2) }} {{ __('LE') }}
                        </td>
                        <td class="px-8 py-6 text-right text-xs text-gray-500 font-medium">
                            {{ $customer->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic">
                            {{ __('No customer data found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin::layouts.master>

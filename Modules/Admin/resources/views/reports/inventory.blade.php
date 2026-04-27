<x-admin::layouts.master>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Inventory Report') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Monitor your stock levels across all products and variants.') }}</p>
        </div>

        @if(!auth()->user()->vendor_id)
            <div class="flex flex-col md:flex-row items-center gap-4">
                <form action="{{ route('admin.inventory.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-yasmina-100">
                    <input type="text" name="vendor_search" value="{{ $vendorSearch }}" placeholder="{{ __('Search Institution...') }}" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-700 w-48">
                    <button type="submit" class="p-2 bg-yasmina-50 text-yasmina-600 rounded-xl hover:bg-primary hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if($vendorSearch)
                        <a href="{{ route('admin.inventory.index') }}" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>

                <form action="{{ route('admin.inventory.index') }}" method="GET" class="flex items-center gap-4 bg-white p-3 rounded-2xl shadow-sm border border-yasmina-100">
                    <select name="vendor_id" onchange="this.form.submit()" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-700 min-w-[200px]">
                        <option value="">{{ __('Filter by Institution') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $vendorId == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                    @if($vendorId)
                        <a href="{{ route('admin.inventory.index') }}" class="text-xs text-red-500 font-bold hover:underline px-2">{{ __('Reset') }}</a>
                    @endif
                </form>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-yasmina-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-yasmina-50/50">
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest">{{ __('Product') }}</th>
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest">{{ __('Vendor') }}</th>
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest text-center">{{ __('Base Stock') }}</th>
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest text-center">{{ __('Variant Stock') }}</th>
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest text-center">{{ __('Total Available') }}</th>
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-xs font-black text-yasmina-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yasmina-50">
                    @foreach($products as $product)
                        <tr class="hover:bg-yasmina-50/30 transition-all">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-800">{{ $product['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $product['vendor'] }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-gray-600">
                                {{ $product['base_stock'] }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-gray-600">
                                {{ $product['variant_stock'] }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1 rounded-full text-sm font-bold {{ $product['low_stock'] ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                    {{ $product['total_stock'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($product['low_stock'])
                                    <span class="flex items-center gap-2 text-xs font-bold text-red-500 uppercase tracking-wider">
                                        <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                                        {{ __('Low Stock') }}
                                    </span>
                                @else
                                    <span class="flex items-center gap-2 text-xs font-bold text-green-500 uppercase tracking-wider">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                        {{ __('In Stock') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $product['id']) }}" class="p-2 bg-yasmina-50 text-yasmina-600 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm" title="{{ __('Edit Product') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.orders.index', ['product_id' => $product['id']]) }}" class="p-2 bg-yasmina-50 text-yasmina-600 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm" title="{{ __('View Orders') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin::layouts.master>

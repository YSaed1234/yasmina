<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Sales Analysis') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Identify your winning and losing products based on sales performance.') }}</p>
        </div>
        
        @if(!auth()->user()->vendor_id)
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="vendor_search" value="{{ $vendorSearch }}" placeholder="{{ __('Search Institution...') }}" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none">
                <select name="vendor_id" onchange="this.form.submit()" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none">
                    <option value="">{{ __('All Institutions') }}</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $vendorId == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="p-2 bg-primary text-white rounded-xl hover:opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Winning Products -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    {{ __('Winning Products') }}
                </h2>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">{{ __('Top 10 Sold') }}</span>
            </div>

            <div class="space-y-4">
                @forelse($winningProducts as $stat)
                    <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-emerald-200 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-white overflow-hidden flex-shrink-0 border border-gray-100">
                            @if($stat->product->image)
                                <img src="{{ asset('storage/' . $stat->product->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="ms-4 flex-1">
                            <p class="font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ $stat->product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $stat->product->vendor->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-emerald-600">{{ $stat->total_sold }} {{ __('Sold') }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ number_format($stat->revenue, 2) }} {{ __('LE') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-10 text-gray-400 italic">{{ __('No sales data found for winning products.') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Losing Products -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="p-2 bg-rose-100 text-rose-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                    </div>
                    {{ __('Losing Products') }}
                </h2>
                <span class="text-xs font-bold text-rose-500 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-widest">{{ __('Bottom 10 Sold') }}</span>
            </div>

            <div class="space-y-4">
                @forelse($losingProducts as $product)
                    <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-rose-200 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-white overflow-hidden flex-shrink-0 border border-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="ms-4 flex-1">
                            <p class="font-bold text-gray-900 group-hover:text-rose-600 transition-colors">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $product->vendor->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-rose-600">{{ (int)$product->total_sold }} {{ __('Sold') }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('In Stock') }}: {{ $product->total_stock }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-10 text-gray-400 italic">{{ __('No sales data found for losing products.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</x-admin::layouts.master>

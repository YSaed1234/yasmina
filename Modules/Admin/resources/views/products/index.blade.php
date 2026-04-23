<x-admin::layouts.master>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Products') }} <span class="ml-2 px-3 py-1 bg-yasmina-50 text-yasmina-500 text-sm rounded-full font-bold shadow-sm">{{ $products->total() }}</span></h1>
            <p class="text-gray-500 mt-2">
                @if(auth()->user()->vendor_id)
                    {{ __('Manage your institution product catalog.') }}
                @else
                    {{ __('Manage your product catalog and inventory.') }}
                @endif
            </p>
        </div>
        @canany(['create products'])
        <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-lg shadow-yasmina-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Product') }}
        </a>
        @endcanany
    </div>

    <div class="mb-10 flex flex-wrap gap-4">
        <form id="filterForm" method="GET" action="{{ route('admin.products.index') }}" class="flex-1 flex gap-4 min-w-[300px]">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       oninput="debounceSubmit()"
                       placeholder="{{ __('Search products') }}..." 
                       class="w-full pl-12 pr-4 py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-yasmina-200 outline-none transition-all">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-yasmina-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <select name="category_id" onchange="this.form.submit()" class="px-6 py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-yasmina-200 outline-none transition-all min-w-[200px]">
                <option value="">{{ __('All Categories') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <script>
        let timer;
        function debounceSubmit() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        }
    </script>

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50 overflow-hidden">
        <table class="min-w-full divide-y divide-yasmina-50">
            <thead>
                <tr class="bg-yasmina-50/50">
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Rank') }}</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Image') }}</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Name') }}</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Category') }}</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Price') }}</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Rating') }}</th>
                    @canany(['edit products', 'delete products'])
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Actions') }}</th>
                    @endcanany
                </tr>
            </thead>
            <tbody class="divide-y divide-yasmina-50">
                @foreach($products as $product)
                <tr class="hover:bg-yasmina-50/30 transition-colors">
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-400 text-center">
                        {{ $loop->iteration + ($products->firstItem() - 1) }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-700">
                        <div class="flex justify-center">
                            <span class="w-8 h-8 rounded-lg bg-yasmina-50 flex items-center justify-center text-yasmina-600">{{ $product->rank }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-2xl object-cover border border-yasmina-100 shadow-sm">
                            @else
                                <div class="h-12 w-12 rounded-2xl bg-yasmina-50 flex items-center justify-center text-yasmina-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-800 text-center">
                        {{ $product->name }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-center">
                        <span class="px-3 py-1 bg-yasmina-50 text-yasmina-600 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-center">
                        @if($product->discount_price && $product->discount_price < $product->price)
                            <div class="flex flex-col items-center">
                                <span class="text-xs text-red-400 line-through">{{ number_format($product->price, 2) }}</span>
                                <span class="text-lg font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                <span class="text-[10px] font-bold text-yasmina-500">{{ $product->currency?->symbol ?? '$' }}</span>
                            </div>
                        @else
                            <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                            <span class="text-sm font-bold text-yasmina-500 ml-1">{{ $product->currency?->symbol ?? '$' }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="font-bold text-gray-700">{{ number_format($product->averageRating(), 1) }}</span>
                            <span class="text-xs text-gray-400 font-normal">({{ $product->reviews->count() }})</span>
                        </div>
                    </td>
                    @canany(['edit products', 'delete products'])
                    <td class="px-8 py-5 whitespace-nowrap text-center text-sm font-bold">
                        <div class="flex justify-center gap-3">
                            @canany(['edit products'])
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-yasmina-500 hover:bg-yasmina-50 rounded-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            @endcanany

                            @canany(['delete products'])
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:bg-red-50 rounded-xl transition-all" onclick="return confirm('{{ __('Are you sure?') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @endcanany
                        </div>
                    </td>
                    @endcanany
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $products->appends(request()->query())->links() }}
    </div>
</x-admin::layouts.master>

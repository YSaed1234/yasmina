<x-vendor::layouts.master>
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Our Products') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage your institution product catalog.') }}</p>
        </div>
        <a href="{{ route('vendor.products.create') }}" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add Product') }}
        </a>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        <table class="w-full text-left rtl:text-right">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Image') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Name') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Category') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Inventory') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Price') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($products->firstItem() - 1) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-xl object-cover border border-gray-100">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-bold text-gray-800">{{ $product->name }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-4 py-1.5 rounded-full bg-primary/5 text-primary text-xs font-bold border border-primary/10">
                            {{ $product->category->name ?? __('N/A') }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-2">
                            <input type="number" 
                                   value="{{ $product->stock }}" 
                                   onchange="updateStock({{ $product->id }}, this.value)"
                                   class="w-20 px-3 py-1 bg-gray-50 border border-gray-100 rounded-lg focus:ring-2 focus:ring-primary/20 outline-none font-bold text-gray-700 text-center transition-all"
                                   min="0">
                            
                            <div id="stock-status-{{ $product->id }}">
                                @if($product->stock <= 0)
                                    <span class="p-1 rounded-full bg-red-50 text-red-600 border border-red-100 block" title="{{ __('Out of Stock') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </span>
                                @elseif($product->stock <= 5)
                                    <span class="p-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100 block" title="{{ __('Low Stock') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </span>
                                @else
                                    <span class="p-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 block" title="{{ __('In Stock') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        @php $currencyCode = $product->currency->code ?? 'LE'; @endphp
                        @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                            <div class="flex flex-col">
                                <span class="text-[9px] bg-amber-500 text-white px-2 py-0.5 rounded-full font-black uppercase self-start mb-1">{{ __('Flash Sale') }}</span>
                                <span class="text-[10px] text-amber-500 line-through">{{ number_format($product->price, 2) }} {{ $currencyCode }}</span>
                                <span class="font-bold text-amber-600">{{ number_format($product->flash_sale_price, 2) }} {{ $currencyCode }}</span>
                                <span class="text-[10px] font-bold text-amber-500" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                    <span class="hours">00</span>:<span class="minutes">00</span>
                                </span>
                            </div>
                        @elseif($product->discount_price && $product->discount_price < $product->price)
                            <div class="flex flex-col">
                                <span class="text-[10px] text-red-400 line-through">{{ number_format($product->price, 2) }} {{ $currencyCode }}</span>
                                <span class="font-bold text-gray-800">{{ number_format($product->discount_price, 2) }} {{ $currencyCode }}</span>
                            </div>
                        @else
                            <span class="font-bold text-gray-800">{{ number_format($product->price, 2) }} {{ $currencyCode }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('vendor.products.edit', $product->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-gray-400 font-medium">
                        {{ __('No products found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="mt-8">
        {{ $products->links() }}
    </div>
    @endif

    <script>
        function updateStock(id, value) {
            const input = event.target;
            input.classList.add('opacity-50', 'pointer-events-none');
            
            fetch(`{{ url('vendor-panel/products') }}/${id}/update-stock`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ stock: value })
            })
            .then(response => response.json())
            .then(data => {
                input.classList.remove('opacity-50', 'pointer-events-none');
                if (data.success) {
                    const statusContainer = document.getElementById(`stock-status-${id}`);
                    let iconHtml = '';
                    
                    if (data.stock <= 0) {
                        iconHtml = `
                            <span class="p-1 rounded-full bg-red-50 text-red-600 border border-red-100 block" title="{{ __('Out of Stock') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                        `;
                    } else if (data.stock <= 5) {
                        iconHtml = `
                            <span class="p-1 rounded-full bg-amber-50 text-amber-600 border border-amber-100 block" title="{{ __('Low Stock') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </span>
                        `;
                    } else {
                        iconHtml = `
                            <span class="p-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 block" title="{{ __('In Stock') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        `;
                    }
                    statusContainer.innerHTML = iconHtml;
                    
                    // Show a small toast or notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-10 left-10 bg-gray-900 text-white px-6 py-3 rounded-2xl font-bold shadow-2xl z-[100] animate-bounce';
                    toast.innerText = data.message;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 2000);
                } else {
                    alert(data.message || 'Error updating stock');
                }
            })
            .catch(error => {
                input.classList.remove('opacity-50', 'pointer-events-none');
                console.error('Error:', error);
                alert('An error occurred while updating stock');
            });
        }
    </script>
</x-vendor::layouts.master>

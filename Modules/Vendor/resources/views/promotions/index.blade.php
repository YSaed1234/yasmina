<x-vendor::layouts.master>
    <div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Promotions & BOGO Deals') }}</h1>
            <p class="text-gray-500 mt-1">{{ __('Manage your "Buy One Get One" and other quantity-based offers.') }}</p>
        </div>
        <a href="{{ route('vendor.promotions.create') }}" class="px-6 py-3 bg-yasmina-600 text-white rounded-2xl font-bold hover:bg-yasmina-700 transition-all shadow-lg shadow-yasmina-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            {{ __('Add New Deal') }}
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-yasmina-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left rtl:text-right">
                <thead>
                    <tr class="bg-yasmina-50/50 text-gray-400 text-xs uppercase tracking-widest">
                        <th class="px-8 py-6 font-black">{{ __('Deal Name') }}</th>
                        <th class="px-8 py-6 font-black">{{ __('Type') }}</th>
                        <th class="px-8 py-6 font-black">{{ __('Offer Details') }}</th>
                        <th class="px-8 py-6 font-black">{{ __('Validity') }}</th>
                        <th class="px-8 py-6 font-black">{{ __('Status') }}</th>
                        <th class="px-8 py-6 font-black text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yasmina-50">
                    @forelse($promotions as $promotion)
                    <tr class="group hover:bg-yasmina-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <span class="font-bold text-gray-900">{{ $promotion->name ?: __('Untitled Deal') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-yasmina-50 text-yasmina-600 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                {{ __($promotion->type) }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-bold text-gray-800">
                                    {{ __('Buy') }} <span class="text-yasmina-600">{{ $promotion->buy_quantity }}</span> × {{ $promotion->buyProduct->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ __('Get') }} <span class="text-emerald-600">{{ $promotion->get_quantity }}</span> × {{ $promotion->getProduct->name }} 
                                    @if($promotion->discount_type == 'free')
                                        <span class="font-bold text-emerald-600">({{ __('FREE') }})</span>
                                    @else
                                        @if($promotion->discount_type == 'percentage')
                                            <span class="font-bold text-emerald-600">(@ {{ $promotion->discount_value }}% {{ __('OFF') }})</span>
                                        @else
                                            <span class="font-bold text-emerald-600">(@ {{ $promotion->discount_value }} {{ __('OFF') }})</span>
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm text-gray-500">
                            @if($promotion->starts_at || $promotion->expires_at)
                                <div class="flex flex-col gap-1">
                                    <span class="text-[10px] uppercase font-bold">{{ __('From') }}: {{ $promotion->starts_at?->format('Y-m-d') ?: '∞' }}</span>
                                    <span class="text-[10px] uppercase font-bold">{{ __('To') }}: {{ $promotion->expires_at?->format('Y-m-d') ?: '∞' }}</span>
                                </div>
                            @else
                                <span class="italic text-gray-400 text-xs">{{ __('Always Active') }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            @if($promotion->isValid())
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ __('Active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    {{ __('Inactive') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('vendor.promotions.edit', $promotion->id) }}" class="p-2 text-gray-400 hover:text-yasmina-600 hover:bg-yasmina-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </a>
                                <form action="{{ route('vendor.promotions.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this deal?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-yasmina-50 rounded-full flex items-center justify-center text-yasmina-300 mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ __('No deals yet') }}</h3>
                                <p class="text-gray-500 max-w-xs mt-2">{{ __('Start creating "Buy One Get One" deals to boost your sales and clear stock.') }}</p>
                                <a href="{{ route('vendor.promotions.create') }}" class="mt-6 px-6 py-2 bg-yasmina-600 text-white rounded-xl font-bold hover:bg-yasmina-700 transition-all">
                                    {{ __('Create Your First Deal') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($promotions->hasPages())
            <div class="px-8 py-6 bg-yasmina-50/30 border-t border-yasmina-50">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>
</div>
    </div>
</x-vendor::layouts.master>

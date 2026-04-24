<x-admin::layouts.master>
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Promotional Deals') }}</h1>
            <p class="text-gray-500">{{ __('Manage BOGO and bundle promotions across the platform.') }}</p>
        </div>
        <a href="{{ route('admin.promotions.create') }}" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-xl shadow-primary/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Create Promotion') }}
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-yasmina-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left rtl:text-right">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-yasmina-50">
                        <th class="px-8 py-6 font-black">{{ __('Promotion') }}</th>
                        <th class="px-8 py-6 font-black text-center">{{ __('Vendor') }}</th>
                        <th class="px-8 py-6 font-black text-center">{{ __('Type') }}</th>
                        <th class="px-8 py-6 font-black text-center">{{ __('Rules') }}</th>
                        <th class="px-8 py-6 font-black text-center">{{ __('Status') }}</th>
                        <th class="px-8 py-6 font-black text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yasmina-50">
                    @forelse($promotions as $promotion)
                        <tr class="group hover:bg-yasmina-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900">{{ $promotion->name_ar ?: $promotion->name_en ?: __('No Name') }}</span>
                                    @if($promotion->starts_at || $promotion->expires_at)
                                        <span class="text-[10px] text-gray-400 font-medium">
                                            {{ $promotion->starts_at ? $promotion->starts_at->format('Y-m-d') : '∞' }} 
                                            → 
                                            {{ $promotion->expires_at ? $promotion->expires_at->format('Y-m-d') : '∞' }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($promotion->vendor)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold">{{ $promotion->vendor->name }}</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-bold">{{ __('Global') }}</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 {{ $promotion->type === 'bogo_same' ? 'bg-purple-50 text-purple-600' : 'bg-amber-50 text-amber-600' }} rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ $promotion->type === 'bogo_same' ? __('BOGO') : __('Bundle') }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="text-xs">
                                    <span class="font-bold text-gray-700">{{ __('Buy') }} {{ $promotion->buy_quantity }}</span>
                                    <span class="text-gray-400">→</span>
                                    <span class="font-bold text-yasmina-600">
                                        @if($promotion->discount_type === 'free')
                                            {{ __('Get') }} {{ $promotion->get_quantity }} {{ __('Free') }}
                                        @else
                                            {{ $promotion->discount_type === 'percentage' ? $promotion->discount_value.'%' : number_format($promotion->discount_value, 2) }} {{ __('Off') }}
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 {{ $promotion->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} rounded-full text-[10px] font-black uppercase tracking-widest">
                                    {{ $promotion->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="p-2 text-gray-400 hover:text-yasmina-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-yasmina-50 rounded-full flex items-center justify-center text-yasmina-200 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ __('No Promotions Found') }}</h3>
                                    <p class="text-gray-500 mb-6">{{ __('Create your first promotional deal to boost sales.') }}</p>
                                    <a href="{{ route('admin.promotions.create') }}" class="px-6 py-3 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                        {{ __('Create Now') }}
                                    </a>
                                </div>
                            </td>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($promotions->hasPages())
            <div class="px-8 py-6 border-t border-yasmina-50">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>
</x-admin::layouts.master>

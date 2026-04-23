<x-admin::layouts.master>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Coupons') }} <span class="ml-2 px-3 py-1 bg-yasmina-50 text-yasmina-500 text-sm rounded-full font-bold shadow-sm">{{ $coupons->total() }}</span></h1>
            <p class="text-gray-500 mt-1">{{ __('Manage your discount coupons and usage limits.') }}</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="flex items-center gap-2 px-6 py-3 bg-yasmina-500 text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-lg shadow-yasmina-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Coupon') }}
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-yasmina-50 mb-8">
        <form id="filterForm" action="{{ route('admin.coupons.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Search') }}</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    oninput="debounceSubmit()"
                    placeholder="{{ __('Coupon code...') }}" 
                    class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
            </div>
            <div class="w-48">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Status') }}</label>
                <select name="is_active" onchange="this.form.submit()" class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                </select>
            </div>
            <a href="{{ route('admin.coupons.index') }}" class="px-8 py-3 bg-yasmina-50 text-gray-500 rounded-2xl font-bold hover:bg-yasmina-100 transition-all">
                {{ __('Reset') }}
            </a>
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

    <div class="bg-white rounded-3xl shadow-sm border border-yasmina-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-yasmina-50/50">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">#</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Code') }}</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Type') }}</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Value') }}</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Usage') }}</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Limits') }}</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yasmina-50">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-yasmina-50/30 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-400">
                                {{ $loop->iteration + ($coupons->firstItem() - 1) }}
                            </td>
                            <td class="px-8 py-5 font-bold text-yasmina-600">{{ $coupon->code }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $coupon->type == 'fixed' ? 'bg-blue-50 text-blue-500' : 'bg-purple-50 text-purple-500' }}">
                                    {{ __($coupon->type) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 font-bold">
                                {{ $coupon->type == 'percentage' ? $coupon->value . '%' : $coupon->value }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-700">{{ $coupon->used_count }} {{ __('Uses') }}</span>
                                    @if($coupon->usage_limit)
                                        <span class="text-[10px] text-gray-400 uppercase">{{ __('Limit') }}: {{ $coupon->usage_limit }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs text-gray-500">{{ __('Per user') }}: {{ $coupon->usage_limit_per_user }}</span>
                            </td>
                            <td class="px-8 py-5">
                                @if($coupon->is_active && $coupon->isValid())
                                    <span class="flex items-center gap-2 text-green-500 font-bold text-sm">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        {{ __('Active') }}
                                    </span>
                                @else
                                    <span class="flex items-center gap-2 text-red-400 font-bold text-sm">
                                        <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                        {{ __('Inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-2 text-gray-400 hover:text-yasmina-500 hover:bg-yasmina-50 rounded-xl transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
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
                            <td colspan="8" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-yasmina-50 rounded-full flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yasmina-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ __('No coupons found') }}</h3>
                                    <p class="text-gray-500">{{ __('Try adjusting your filters or add a new coupon.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
            <div class="px-8 py-5 bg-yasmina-50/30 border-t border-yasmina-50">
                {{ $coupons->links() }}
            </div>
        @endif
    </div>
</x-admin::layouts.master>

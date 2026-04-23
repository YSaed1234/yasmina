<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Shipping Zones') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage regional shipping rates and availability.') }}</p>
        </div>
        <a href="{{ route('admin.shipping_zones.create') }}" class="px-6 py-3 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all flex items-center gap-2 shadow-xl shadow-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Zone') }}
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Zone Name') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Rate') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($zones as $zone)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($zones->firstItem() - 1) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-bold text-gray-900">{{ $zone->name }}</span>
                        </td>
                        <td class="px-8 py-6 font-bold text-primary">
                            {{ number_format($zone->rate, 2) }}
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $zone->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $zone->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                <a href="{{ route('admin.shipping_zones.edit', $zone) }}" class="p-2 bg-gray-100 text-gray-600 rounded-xl hover:bg-primary hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.shipping_zones.destroy', $zone) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-gray-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">{{ __('No shipping zones found') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-6 border-t border-gray-50">
            {{ $zones->links() }}
        </div>
    </div>
</x-admin::layouts.master>

<x-vendor::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Shipping Rates') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage specific areas and their corresponding shipping rates for your institution.') }}</p>
        </div>
        <a href="{{ route('vendor.shipping.create') }}" class="px-8 py-4 bg-primary text-white rounded-2xl font-black shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Region') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-600 rounded-2xl font-bold flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left rtl:text-right">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Region Name') }}</th>
                    <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Governorate') }}</th>
                    <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Rate') }}</th>
                    <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($regions as $region)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="font-bold text-gray-900">{{ $region->name }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold">
                                {{ $region->governorate->name }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-primary font-black">{{ number_format($region->rate, 2) }} {{ __('LE') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            @if($region->is_active)
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ __('Active') }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ __('Inactive') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('vendor.shipping.edit', $region->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('vendor.shipping.destroy', $region->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ __('No regions found') }}</h3>
                                <p class="text-gray-500 mt-1 max-w-xs mx-auto">{{ __('Get started by defining your first shipping area and rate.') }}</p>
                                <a href="{{ route('vendor.shipping.create') }}" class="mt-6 px-6 py-3 bg-primary/10 text-primary rounded-xl font-bold hover:bg-primary hover:text-white transition-all">
                                    {{ __('Add First Region') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($regions->hasPages())
            <div class="px-8 py-6 border-t border-gray-50">
                {{ $regions->links() }}
            </div>
        @endif
    </div>
</x-vendor::layouts.master>

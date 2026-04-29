<x-admin::layouts.master>
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Drivers Management') }} <span class="ml-2 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">{{ $drivers->total() }}</span></h1>
            <p class="text-gray-500 mt-2">{{ __('Manage delivery drivers and their assignments.') }}</p>
        </div>
        <a href="{{ route('admin.drivers.create') }}" class="px-6 py-3 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Driver') }}
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Name') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Contact') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Vehicle') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Institution') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($drivers as $driver)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($drivers->firstItem() - 1) }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="font-bold text-gray-900 block">{{ $driver->name }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-gray-600 block">{{ $driver->phone }}</span>
                        <span class="text-[10px] text-gray-400">{{ $driver->email }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-gray-600 block">{{ $driver->vehicle_type ?: '---' }}</span>
                        <span class="text-[10px] text-gray-400 tracking-wider uppercase">{{ $driver->vehicle_number }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $driver->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                            {{ $driver->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        @if($driver->vendor)
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-lg uppercase">
                                {{ $driver->vendor->name }}
                            </span>
                        @else
                            <span class="text-gray-300 italic text-[10px] font-bold uppercase tracking-widest">{{ __('Global') }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                            <a href="{{ route('admin.drivers.edit', $driver) }}" title="{{ __('Edit') }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
                    <td colspan="7" class="px-8 py-10 text-center text-gray-400 italic">
                        {{ __('No drivers found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-6 bg-gray-50/50">
            {{ $drivers->links() }}
        </div>
    </div>
</x-admin::layouts.master>

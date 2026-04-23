<x-vendor::layouts.master>
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Categories') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('View global categories and manage your own.') }}</p>
        </div>
        <a href="{{ route('vendor.categories.create') }}" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add Category') }}
        </a>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        <table class="w-full text-left rtl:text-right">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Name') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Owner') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($categories->firstItem() - 1) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-bold text-gray-800">{{ $category->name }}</p>
                    </td>
                    <td class="px-8 py-5">
                        @if($category->vendor_id)
                            <span class="px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                                {{ __('My Category') }}
                            </span>
                        @else
                            <span class="px-4 py-1.5 rounded-full bg-gray-50 text-gray-500 text-[10px] font-bold uppercase tracking-wider border border-gray-100">
                                {{ __('Global') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-3">
                            @if($category->vendor_id)
                                <a href="{{ route('vendor.categories.edit', $category->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('vendor.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">{{ __('Read-only') }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-10 text-center text-gray-400 font-medium">
                        {{ __('No categories found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="mt-8">
        {{ $categories->links() }}
    </div>
    @endif
</x-vendor::layouts.master>

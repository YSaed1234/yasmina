<x-admin::layouts.master>
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Categories') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage your product categories and their display order.') }}</p>
        </div>
        <a href="{{ route('categories.create') }}" class="px-6 py-3 bg-barbie-500 text-white rounded-2xl font-bold hover:bg-barbie-600 transition-all shadow-lg shadow-barbie-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add Category') }}
        </a>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-barbie-50 shadow-xl shadow-barbie-100/50 overflow-hidden">
        <table class="min-w-full divide-y divide-barbie-50">
            <thead>
                <tr class="bg-barbie-50/50">
                    <th class="px-8 py-5 text-left text-xs font-bold text-barbie-500 uppercase tracking-widest">{{ __('Rank') }}</th>
                    <th class="px-8 py-5 text-left text-xs font-bold text-barbie-500 uppercase tracking-widest">{{ __('Name') }}</th>
                    <th class="px-8 py-5 text-right text-xs font-bold text-barbie-500 uppercase tracking-widest">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-barbie-50">
                @foreach($categories as $category)
                <tr class="hover:bg-barbie-50/30 transition-colors">
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-700">
                        <span class="w-8 h-8 rounded-lg bg-barbie-50 flex items-center justify-center text-barbie-600">{{ $category->rank }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-800">
                        {{ $category->translate(app()->getLocale())->name ?? $category->name }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-bold">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('categories.edit', $category) }}" class="p-2 text-barbie-500 hover:bg-barbie-50 rounded-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:bg-red-50 rounded-xl transition-all" onclick="return confirm('{{ __('Are you sure?') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin::layouts.master>

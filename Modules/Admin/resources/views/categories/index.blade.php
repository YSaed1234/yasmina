<x-admin::layouts.master>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Categories') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage your product categories and their display order.') }}</p>
        </div>
        @canany(['create categories'])
        <a href="{{ route('admin.categories.create') }}" class="px-6 py-3 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-lg shadow-yasmina-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add Category') }}
        </a>
        @endcanany
    </div>

    <div class="mb-10 flex flex-wrap gap-4">
        <form id="filterForm" method="GET" action="{{ route('admin.categories.index') }}" class="flex-1 min-w-[300px]">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       oninput="debounceSubmit()"
                       placeholder="{{ __('Search') }}..." 
                       class="w-full pl-12 pr-4 py-3 bg-white border border-yasmina-50 rounded-2xl focus:ring-2 focus:ring-yasmina-200 outline-none transition-all">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-yasmina-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
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
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Rank') }}</th>
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Name') }}</th>
                    @canany(['edit categories', 'delete categories'])
                    <th class="px-8 py-5 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Actions') }}</th>
                    @endcanany
                </tr>
            </thead>
            <tbody class="divide-y divide-yasmina-50">
                @foreach($categories as $category)
                <tr class="hover:bg-yasmina-50/30 transition-colors">
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-700">
                        <div class="flex justify-center">
                            <span class="w-8 h-8 rounded-lg bg-yasmina-50 flex items-center justify-center text-yasmina-600">{{ $category->rank }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-800 text-center">
                        {{ $category->name }}
                    </td>
                    @canany(['edit categories', 'delete categories'])
                    <td class="px-8 py-5 whitespace-nowrap text-center text-sm font-bold">
                        <div class="flex justify-center gap-3">
                            @canany(['edit categories'])
                            <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 text-yasmina-500 hover:bg-yasmina-50 rounded-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            @endcanany
                            
                            @canany(['delete categories'])
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
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
        {{ $categories->appends(request()->query())->links() }}
    </div>
</x-admin::layouts.master>

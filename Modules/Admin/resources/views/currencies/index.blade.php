<x-admin::layouts.master>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Currencies</h1>
        <a href="{{ route('currencies.create') }}" class="px-6 py-3 bg-rose-500 text-white rounded-full font-bold hover:bg-rose-600 transition-all shadow-lg shadow-rose-100">Add New Currency</a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-rose-50 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-6 py-4 font-bold text-gray-900">Name</th>
                    <th class="px-6 py-4 font-bold text-gray-900">Code</th>
                    <th class="px-6 py-4 font-bold text-gray-900">Symbol</th>
                    <th class="px-6 py-4 font-bold text-gray-900 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-50">
                @foreach($currencies as $currency)
                    <tr class="hover:bg-rose-50/30 transition-colors">
                        <td class="px-6 py-4 text-gray-700">{{ $currency->name }}</td>
                        <td class="px-6 py-4 font-mono text-rose-500">{{ $currency->code }}</td>
                        <td class="px-6 py-4 text-gray-700 text-xl">{{ $currency->symbol }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('currencies.edit', $currency->id) }}" class="inline-block p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Are you sure?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin::layouts.master>

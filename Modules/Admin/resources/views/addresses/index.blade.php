<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Customer Addresses') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage and filter all stored customer shipping and billing locations.') }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8">
        <form id="filterForm" action="{{ route('admin.addresses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Search') }}</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    oninput="debounceSubmit()"
                    placeholder="{{ __('Name, City, or User...') }}" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary outline-none text-sm transition-all shadow-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Filter by User') }}</label>
                <select name="user_id" id="user-select" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-primary outline-none text-sm appearance-none cursor-pointer shadow-sm">
                    <option value="">{{ __('All Users') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                @if(request()->anyFilled(['search', 'user_id']))
                    <a href="{{ route('admin.addresses.index') }}" class="w-full py-3 px-6 bg-gray-100 text-gray-500 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all text-center">
                        {{ __('Reset') }}
                    </a>
                @endif
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

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Address Name') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Address Details') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Phone') }}</th>
                    <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($addresses as $address)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($addresses->firstItem() - 1) }}</span>
                        </td>
                        <td class="px-8 py-6 font-bold text-gray-900">{{ $address->name }}</td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900">{{ $address->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $address->user->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $address->address_line1 }}<br>
                                {{ $address->city }}@if($address->shippingZone), {{ $address->shippingZone->name }}@endif, {{ $address->country }}
                            </p>
                        </td>
                        <td class="px-8 py-6 text-sm font-medium text-gray-900">{{ $address->phone }}</td>
                        <td class="px-8 py-6 text-right">
                            <form action="{{ route('admin.addresses.destroy', $address) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">{{ __('No addresses found') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($addresses->hasPages())
            <div class="px-8 py-6 border-t border-gray-50">
                {{ $addresses->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#user-select', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            onChange: function(value) {
                document.getElementById('filterForm').submit();
            }
        });
    </script>
    @endpush
</x-admin::layouts.master>

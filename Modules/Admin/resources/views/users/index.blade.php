<x-admin::layouts.master>
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Users') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Manage your platform users and their roles.') }}</p>
            </div>
            <a href="{{ route('users.create') }}" class="px-6 py-3 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add New User') }}
            </a>
        </div>

        <div class="mb-10 flex flex-wrap gap-4">
            <form method="GET" action="{{ route('users.index') }}" class="flex-1 min-w-[300px]">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search users by name or email') }}..." 
                           class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 text-sm font-bold flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-center text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">
                        <th class="pb-4 px-6">{{ __('Image') }}</th>
                        <th class="pb-4 px-6">{{ __('Name') }}</th>
                        <th class="pb-4 px-6">{{ __('Email') }}</th>
                        <th class="pb-4 px-6">{{ __('Phone') }}</th>
                        <th class="pb-4 px-6">{{ __('Roles') }}</th>
                        <th class="pb-4 px-6">{{ __('Joined At') }}</th>
                        <th class="pb-4 px-6">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="bg-gray-50/50 hover:bg-rose-50/30 transition-colors rounded-2xl">
                            <td class="py-6 px-6 text-center first:rounded-l-2xl">
                                <div class="w-12 h-12 rounded-2xl overflow-hidden mx-auto border-2 border-white shadow-sm">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-rose-50 flex items-center justify-center text-primary font-bold text-xs uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-6 px-6 text-center text-sm font-bold text-gray-900">{{ $user->name }}</td>
                            <td class="py-6 px-6 text-center text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="py-6 px-6 text-center text-sm text-gray-600 font-medium">{{ $user->phone ?? '-' }}</td>
                            <td class="py-6 px-6 text-center">
                                <div class="flex flex-wrap justify-center gap-2">
                                    <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider rounded-full border border-primary/20">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-6 px-6 text-center text-sm text-gray-500 font-medium">
                                {{ $user->created_at->format('Y-m-d') }}
                            </td>
                            <td class="py-6 px-6 text-center last:rounded-r-2xl">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 text-gray-400 hover:text-primary transition-all" title="{{ __('Edit Roles') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button onclick="confirmDelete({{ $user->id }})" class="p-2 text-gray-400 hover:text-red-500 transition-all" title="{{ __('Delete User') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6">
                        <svg class="h-10 w-10 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" id="modal-title">
                        {{ __('Confirm Delete') }}
                    </h3>
                    <p class="text-gray-500 mb-10">
                        {{ __('Are you sure you want to delete this user? This action cannot be undone.') }}
                    </p>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                        {{ __('Cancel') }}
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold hover:bg-red-600 transition-all shadow-lg shadow-red-100">
                            {{ __('Delete User') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/admin-dashboard-2026/users/${id}`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-admin::layouts.master>

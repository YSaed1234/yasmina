<x-admin::layouts.master>
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Roles & Permissions') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage access levels for your team.') }}</p>
        </div>
        <a href="{{ route('roles.create') }}" class="px-8 py-4 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-lg shadow-yasmina-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Role') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-600 rounded-2xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50 overflow-hidden">
        <table class="min-w-full divide-y divide-yasmina-50">
            <thead class="bg-yasmina-50/50">
                <tr>
                    <th class="px-6 py-4 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Role Name') }}</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Permissions') }}</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-yasmina-50">
                @foreach($roles as $role)
                <tr class="hover:bg-yasmina-50/30 transition-colors">
                    <td class="px-6 py-4 text-center">
                        <span class="font-bold text-gray-800">{{ $role->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1 justify-center">
                            @foreach($role->permissions as $permission)
                                <span class="px-2 py-1 bg-yasmina-50 text-yasmina-600 text-[10px] font-bold rounded-lg">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center space-x-2 rtl:space-x-reverse">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('roles.edit', $role) }}" class="inline-flex p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-all">
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

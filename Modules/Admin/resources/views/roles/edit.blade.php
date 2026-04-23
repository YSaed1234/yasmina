<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Edit Role') }}: {{ $role->name }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Modify permissions for this access level.') }}</p>
    </div>

    <div class="max-w-4xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Role Name') }}</label>
                <input type="text" name="name" id="name" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" value="{{ $role->name }}" required>
                @error('name') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-6">
                    <label class="block text-sm font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Assign Permissions') }}</label>
                    <button type="button" onclick="toggleAllPermissions(this)" class="text-xs font-bold text-primary hover:underline uppercase tracking-widest">{{ __('Select All') }}</button>
                </div>
                <div class="space-y-8">
                    @foreach($permissions as $group => $groupPermissions)
                    <div class="bg-yasmina-50/30 p-6 rounded-3xl border border-yasmina-50 permission-group">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-yasmina-300"></span>
                                {{ __($group) }}
                            </h3>
                            <button type="button" onclick="toggleGroupPermissions(this)" class="text-[10px] font-bold text-gray-400 hover:text-primary uppercase tracking-widest">{{ __('Toggle Group') }}</button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($groupPermissions as $permission)
                            <label class="flex items-center gap-3 p-4 bg-white border border-yasmina-50 rounded-2xl hover:bg-yasmina-50 transition-all cursor-pointer group shadow-sm">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }} class="w-5 h-5 text-yasmina-500 border-yasmina-200 rounded focus:ring-yasmina-500 transition-all">
                                <span class="text-sm font-bold text-gray-600 group-hover:text-yasmina-600">{{ $permission->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('permissions') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 px-8 py-4 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-lg shadow-yasmina-100">
                    {{ __('Update Role') }}
                </button>
                <a href="{{ route('admin.roles.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

<script>
    window.toggleAllPermissions = function(btn) {
        console.log('Toggling all permissions...');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="permissions[]"]');
        console.log('Found ' + checkboxes.length + ' checkboxes');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
            cb.dispatchEvent(new Event('change'));
        });
        btn.innerText = !allChecked ? "{{ __('Deselect All') }}" : "{{ __('Select All') }}";
    }

    window.toggleGroupPermissions = function(btn) {
        console.log('Toggling group permissions...');
        const group = btn.closest('.permission-group');
        const checkboxes = group.querySelectorAll('input[type="checkbox"][name="permissions[]"]');
        console.log('Found ' + checkboxes.length + ' group checkboxes');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
            cb.dispatchEvent(new Event('change'));
        });
    }
</script>

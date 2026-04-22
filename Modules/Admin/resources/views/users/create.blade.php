<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Add New User') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Create a new account and assign roles.') }}</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Email') }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Password') }}</label>
                        <input type="password" name="password" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('password') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-6">{{ __('Select Role') }}</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($roles as $role)
                            <label class="group relative flex items-center p-6 border rounded-3xl cursor-pointer transition-all hover:bg-rose-50/30 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50 border-gray-100">
                                <input type="radio" name="roles" value="{{ $role->name }}" class="peer hidden" {{ is_array(old('roles')) && in_array($role->name, old('roles')) ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <div class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $role->name }}</div>
                                    <div class="text-xs text-gray-400 mt-1 uppercase tracking-wider font-medium">{{ count($role->permissions) }} {{ __('Permissions') }}</div>
                                </div>
                                <div class="w-8 h-8 rounded-full border-2 border-primary flex items-center justify-center transition-all bg-white peer-checked:bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('role') <p class="text-red-500 text-xs mt-4 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-gray-50 flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                        {{ __('Create User') }}
                    </button>
                    <a href="{{ route('users.index') }}" class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-2xl font-bold text-lg text-center hover:bg-gray-200 transition-all">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        input[type="checkbox"]:checked + div + .border-primary .check-indicator {
            opacity: 1;
        }
        input[type="checkbox"]:checked ~ .w-6 {
            background-color: var(--yasmina-primary);
        }
    </style>
</x-admin::layouts.master>

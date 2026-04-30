<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Add New User') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Create a new account and assign roles.') }}</p>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="flex items-center gap-8 p-8 bg-yasmina-50/30 rounded-3xl border border-yasmina-50/50 mb-10">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-3xl bg-white shadow-md border-2 border-white overflow-hidden">
                            <img id="imagePreview" src="https://ui-avatars.com/api/?name=User&background=fff&color=865d58&bold=true" class="w-full h-full object-cover">
                        </div>
                        <label class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary text-white rounded-2xl flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform active:scale-95">
                            <input type="file" name="profile_image" class="hidden" onchange="previewImage(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Profile Photo') }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ __('Upload a high-quality avatar for the user.') }}</p>
                        @error('profile_image') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

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
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('phone') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                <div class="col-span-full mt-4">
                    <label class="block text-sm font-bold text-gray-700 mb-6">{{ __('Assign Security Role') }}</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($roles as $role)
                            <label class="relative cursor-pointer group h-full">
                                <input type="radio" name="role" value="{{ $role->name }}" class="peer hidden" {{ old('role') == $role->name ? 'checked' : '' }} required>
                                <div class="p-6 bg-white border-2 border-gray-100 rounded-3xl transition-all duration-300 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/30 h-full flex flex-col">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 peer-checked:bg-primary peer-checked:text-white transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all check-indicator opacity-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h4 class="font-bold text-gray-900 mb-1 capitalize">{{ $role->name }}</h4>
                                    <p class="text-xs text-gray-500 mb-4">{{ __('Full access to specific module permissions.') }}</p>
                                    
                                    <div class="mt-auto pt-4 border-t border-gray-50 flex flex-wrap gap-1.5">
                                        @foreach($role->permissions->take(4) as $permission)
                                            <span class="px-2 py-1 bg-gray-100 rounded-lg text-[10px] font-bold text-gray-500 uppercase tracking-tight">
                                                {{ str_replace('manage ', '', $permission->name) }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() > 4)
                                            <span class="px-2 py-1 bg-gray-100 rounded-lg text-[10px] font-bold text-gray-400">
                                                +{{ $role->permissions->count() - 4 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('role') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
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

                <div class="pt-6 border-t border-gray-50 flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                        {{ __('Create User') }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-2xl font-bold text-lg text-center hover:bg-gray-200 transition-all">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        input[type="checkbox"]:checked + div + .border-primary .check-indicator {
            opacity: 1;
        }
        input[type="checkbox"]:checked ~ .w-6 {
            background-color: var(--yasmina-primary);
        }
    </style>
</x-admin::layouts.master>

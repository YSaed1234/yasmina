<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Add New User') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Create a new account and assign roles.') }}</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="flex items-center gap-8 p-8 bg-rose-50/30 rounded-3xl border border-rose-50/50 mb-10">
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
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Select Role') }} ({{ __('Role field is required') }})</label>
                        <select name="role" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm font-bold text-gray-700">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
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
                    <a href="{{ route('users.index') }}" class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-2xl font-bold text-lg text-center hover:bg-gray-200 transition-all">
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

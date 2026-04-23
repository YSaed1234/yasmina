<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Edit User') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Update account details and modify roles for :name', ['name' => $user->name]) }}</p>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-8 p-8 bg-rose-50/30 rounded-3xl border border-rose-50/50 mb-10">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-3xl bg-white shadow-md border-2 border-white overflow-hidden">
                            <img id="imagePreview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=fff&color=865d58&bold=true' }}" class="w-full h-full object-cover">
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
                        <p class="text-sm text-gray-500 mt-1">{{ __('Update the user\'s profile picture.') }}</p>
                        @error('profile_image') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Email') }}</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                        @error('phone') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Select Role') }}</label>
                        @if($user->role != 'admin')
                            <select name="role" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm font-bold text-gray-700">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="role" value="admin">
                            <div class="px-6 py-4 bg-primary/5 border border-primary/20 rounded-2xl text-primary font-bold text-sm">
                                {{ __('Administrator (System Protected)') }}
                            </div>
                        @endif
                        @error('role') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('New Password') }}</label>
                        <input type="password" name="password" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm" placeholder="{{ __('Leave blank to keep current') }}">
                        @error('password') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-50 flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                        {{ __('Update User') }}
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
    <div class="max-w-4xl mx-auto mt-12">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ __('Saved Addresses') }}</h2>
                <p class="text-gray-500 mt-2">{{ __('Customer stored shipping and billing locations.') }}</p>
            </div>

            @if($user->addresses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($user->addresses as $address)
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span class="font-bold text-gray-900">{{ $address->name }}</span>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                {{ $address->address_line1 }}<br>
                                {{ $address->city }}, {{ $address->country }}<br>
                                <span class="font-bold text-gray-700 mt-2 block">{{ $address->phone }}</span>
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-100 text-center">
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">{{ __('No addresses saved by this user') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-admin::layouts.master>

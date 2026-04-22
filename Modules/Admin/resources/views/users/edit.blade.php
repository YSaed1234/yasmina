<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Edit User') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Update account details and modify roles for :name', ['name' => $user->name]) }}</p>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

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

                @if($user->role != 'admin')
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-6">{{ __('Select Role') }}</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($roles as $role)
                            <label class="group relative flex items-center p-6 border rounded-3xl cursor-pointer transition-all hover:bg-rose-50/30 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50 border-gray-100">
                                <input type="radio" name="role" value="{{ $role->name }}" class="peer hidden" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
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
                @else
                    <input type="hidden" name="role" value="Admin">
                    <div class="p-6 bg-rose-50/50 border border-primary/20 rounded-3xl flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-primary">{{ __('Role') }}</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ __('Administrator') }}</p>
                        </div>
                        <span class="px-4 py-2 bg-primary text-white text-[10px] font-bold uppercase tracking-widest rounded-full">
                            {{ __('System Protected') }}
                        </span>
                    </div>
                @endif

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

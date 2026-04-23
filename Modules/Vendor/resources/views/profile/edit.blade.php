<x-vendor::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Edit Profile') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Update your institution details and account security.') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-600 rounded-2xl font-bold flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Left Side: Basic Info -->
                <div class="space-y-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Institution Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $vendor->name) }}" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" required>
                        @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Email Address') }}</label>
                        <input type="email" name="email" value="{{ old('email', $vendor->email) }}" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" required>
                        @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone Number 1') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        @error('phone') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone Number 2') }}</label>
                        <input type="text" name="phone_secondary" value="{{ old('phone_secondary', $vendor->phone_secondary) }}" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        @error('phone_secondary') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Address') }}</label>
                        <textarea name="address" rows="3" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">{{ old('address', $vendor->address) }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Right Side: Logo & Password -->
                <div class="space-y-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Institution Logo') }}</label>
                        <div class="flex items-center gap-6">
                            @if($vendor->logo)
                                <img src="{{ asset('storage/' . $vendor->logo) }}" alt="Current Logo" class="w-24 h-24 rounded-3xl object-cover border-4 border-gray-50 shadow-sm">
                            @else
                                <div class="w-24 h-24 rounded-3xl bg-gray-50 flex items-center justify-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all">
                                <p class="text-[10px] text-gray-400 mt-2">{{ __('Recommended: Square image, max 2MB') }}</p>
                            </div>
                        </div>
                        @error('logo') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Institution Description') }}</label>
                        <textarea name="description" rows="4" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">{{ old('description', $vendor->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6 border-t border-gray-50 space-y-6">
                        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">{{ __('Change Password') }}</h3>
                        
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('New Password') }}</label>
                            <input type="password" name="password" placeholder="{{ __('Leave blank to keep current') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                            @error('password') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Section: About Us & Social Links -->
            <div class="mt-10 pt-10 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-8">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">{{ __('About Us Content') }}</h3>
                    
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('About Us (Arabic)') }}</label>
                        <textarea name="about_ar" rows="6" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">{{ old('about_ar', $vendor->about_ar) }}</textarea>
                        @error('about_ar') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('About Us (English)') }}</label>
                        <textarea name="about_en" rows="6" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">{{ old('about_en', $vendor->about_en) }}</textarea>
                        @error('about_en') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-8">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">{{ __('Social Media Links') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Facebook URL') }}</label>
                            <input type="url" name="facebook" value="{{ old('facebook', $vendor->facebook) }}" 
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Instagram URL') }}</label>
                            <input type="url" name="instagram" value="{{ old('instagram', $vendor->instagram) }}" 
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Twitter URL') }}</label>
                            <input type="url" name="twitter" value="{{ old('twitter', $vendor->twitter) }}" 
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('WhatsApp Number') }}</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $vendor->whatsapp) }}" 
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" placeholder="e.g. 201234567890">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-50">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('About Image 1') }}</label>
                            @if($vendor->about_image1)
                                <img src="{{ asset('storage/' . $vendor->about_image1) }}" alt="About Image 1" class="w-20 h-20 rounded-2xl object-cover mb-3">
                            @endif
                            <input type="file" name="about_image1" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('About Image 2') }}</label>
                            @if($vendor->about_image2)
                                <img src="{{ asset('storage/' . $vendor->about_image2) }}" alt="About Image 2" class="w-20 h-20 rounded-2xl object-cover mb-3">
                            @endif
                            <input type="file" name="about_image2" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-end">
                <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-black shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Update Profile') }}
                </button>
            </div>
        </form>
    </div>
</x-vendor::layouts.master>

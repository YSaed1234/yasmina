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
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Institution Slug') }}</label>
                        <input type="text" name="slug" value="{{ old('slug', $vendor->slug) }}" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900">
                        @error('slug') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
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

            <!-- New Section: Promotional Settings -->
            <div class="mt-10 pt-10 border-t border-gray-100">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-8">{{ __('Promotional & Discount Settings') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Order Threshold Discount -->
                    <div class="p-8 bg-rose-50/30 rounded-3xl border border-rose-50 space-y-6">
                        <h4 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Order Threshold Discount') }}
                        </h4>
                        <p class="text-xs text-gray-500">{{ __('Apply a discount if the total order amount exceeds a certain threshold.') }}</p>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Minimum Order Amount') }}</label>
                                <input type="number" step="0.01" name="order_threshold" value="{{ old('order_threshold', $vendor->order_threshold) }}" 
                                    class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" placeholder="0.00">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Discount Value') }}</label>
                                    <input type="number" step="0.01" name="order_threshold_discount" value="{{ old('order_threshold_discount', $vendor->order_threshold_discount) }}" 
                                        class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Discount Type') }}</label>
                                    <select name="order_threshold_discount_type" class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900 appearance-none">
                                        <option value="fixed" {{ old('order_threshold_discount_type', $vendor->order_threshold_discount_type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }}</option>
                                        <option value="percentage" {{ old('order_threshold_discount_type', $vendor->order_threshold_discount_type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage (%)') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multi-item Discount -->
                    <div class="p-8 bg-yasmina-50/30 rounded-3xl border border-yasmina-50 space-y-6">
                        <h4 class="font-bold text-gray-900 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yasmina-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            {{ __('Multi-item Discount (Bundle)') }}
                        </h4>
                        <p class="text-xs text-gray-500">{{ __('Apply a discount if the customer buys more than a specific number of items.') }}</p>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Minimum Number of Items') }}</label>
                                <input type="number" name="min_items_for_discount" value="{{ old('min_items_for_discount', $vendor->min_items_for_discount) }}" 
                                    class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" placeholder="0">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Discount Value') }}</label>
                                    <input type="number" step="0.01" name="items_discount_amount" value="{{ old('items_discount_amount', $vendor->items_discount_amount) }}" 
                                        class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Discount Type') }}</label>
                                    <select name="items_discount_type" class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900 appearance-none">
                                        <option value="fixed" {{ old('items_discount_type', $vendor->items_discount_type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }}</option>
                                        <option value="percentage" {{ old('items_discount_type', $vendor->items_discount_type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage (%)') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Free Shipping Setting -->
                <div class="mt-10 p-8 bg-sky-50/30 rounded-3xl border border-sky-50 space-y-6">
                    <h4 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                        {{ __('Free Shipping Threshold') }}
                    </h4>
                    <p class="text-xs text-gray-500">{{ __('Offer free delivery if the order amount from your institution exceeds this value.') }}</p>
                    
                    <div class="max-w-md">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Minimum Order for Free Shipping') }}</label>
                        <input type="number" step="0.01" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $vendor->free_shipping_threshold) }}" 
                            class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" placeholder="0.00">
                    </div>
                </div>
            </div>

            <!-- Existing Section: About Us & Social Links -->
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

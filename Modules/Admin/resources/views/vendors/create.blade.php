<x-admin::layouts.master>
    <div class="mb-10">
        <a href="{{ route('admin.vendors.index') }}" class="text-primary font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Vendors') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Add New Vendor') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Register a new institution or service provider.') }}</p>
    </div>

    <div class="max-w-4xl bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
        <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Logo') }}</label>
                        <input type="file" name="logo" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('About Image 1') }}</label>
                        <input type="file" name="about_image1" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('About Image 2') }}</label>
                        <input type="file" name="about_image2" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Slug') }}</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="e.g. boutique-name">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Status') }}</label>
                    <select name="status" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        <option value="active">{{ __('Active') }}</option>
                        <option value="inactive">{{ __('Inactive') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone 1') }}</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone 2') }}</label>
                    <input type="text" name="phone_secondary" value="{{ old('phone_secondary') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Password') }}</label>
                    <input type="password" name="password" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Facebook URL') }}</label>
                        <input type="url" name="facebook" value="{{ old('facebook') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Instagram URL') }}</label>
                        <input type="url" name="instagram" value="{{ old('instagram') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Twitter URL') }}</label>
                        <input type="url" name="twitter" value="{{ old('twitter') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('WhatsApp Number') }}</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="e.g. 201234567890">
                    </div>
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <h3 class="md:col-span-2 text-sm font-bold text-gray-900 uppercase tracking-widest">{{ __('Promotional Settings') }}</h3>
                    
                    <div class="p-6 bg-rose-50/30 rounded-2xl border border-rose-50 space-y-4">
                        <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Order Threshold Discount') }}</label>
                        <div class="grid grid-cols-1 gap-4">
                            <input type="number" step="0.01" name="order_threshold" value="{{ old('order_threshold') }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Min Order Amount') }}">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="number" step="0.01" name="order_threshold_discount" value="{{ old('order_threshold_discount') }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Discount Value') }}">
                                <select name="order_threshold_discount_type" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                                    <option value="fixed">{{ __('Fixed') }}</option>
                                    <option value="percentage">{{ __('Percentage') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 space-y-4">
                        <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Multi-item Discount') }}</label>
                        <div class="grid grid-cols-1 gap-4">
                            <input type="number" name="min_items_for_discount" value="{{ old('min_items_for_discount') }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Min Items Count') }}">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="number" step="0.01" name="items_discount_amount" value="{{ old('items_discount_amount') }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Discount Value') }}">
                                <select name="items_discount_type" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                                    <option value="fixed">{{ __('Fixed') }}</option>
                                    <option value="percentage">{{ __('Percentage') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 p-6 bg-sky-50/30 rounded-2xl border border-sky-50 space-y-4">
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Free Shipping Threshold') }}</label>
                    <input type="number" step="0.01" name="free_shipping_threshold" value="{{ old('free_shipping_threshold') }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Min Order for Free Shipping') }}">
                </div>

                <div class="md:col-span-2 p-6 bg-indigo-50/30 rounded-2xl border border-indigo-50 space-y-4">
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Commission Settings (Yasmina Share)') }}</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <select name="commission_type" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                            <option value="percentage" {{ old('commission_type') == 'percentage' ? 'selected' : '' }}>{{ __('Percentage') }} (%)</option>
                            <option value="fixed" {{ old('commission_type') == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }}</option>
                        </select>
                        <input type="number" step="0.01" name="commission_value" value="{{ old('commission_value') }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Commission Value') }}">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Address') }}</label>
                    <textarea name="address" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">{{ old('address') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Description') }}</label>
                    <textarea name="description" rows="5" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                    {{ __('Create Vendor') }}
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

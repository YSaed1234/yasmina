<x-admin::layouts.master>
    @push('styles')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            .ql-editor {
                min-height: 180px;
                font-family: inherit;
                font-size: 1rem;
                text-align: initial;
            }
            .ql-toolbar.ql-snow {
                border: 1px solid #f3f4f6;
                background: #f9fafb;
                border-radius: 1.25rem 1.25rem 0 0;
                padding: 12px;
            }
            .ql-container.ql-snow {
                border: 1px solid #f3f4f6;
                background: #f9fafb;
                border-radius: 0 0 1.25rem 1.25rem;
                font-size: 1rem;
            }
            [dir="rtl"] .ql-editor {
                text-align: right;
            }
            [dir="rtl"] .ql-snow .ql-picker:not(.ql-color-picker):not(.ql-icon-picker) svg {
                right: auto;
                left: 0;
            }
            [dir="rtl"] .ql-snow .ql-picker-label {
                padding-left: 18px;
                padding-right: 8px;
            }
        </style>
    @endpush
    <div class="mb-10">
        <a href="{{ route('admin.vendors.index') }}" class="text-primary font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Vendors') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Edit Vendor') }}: {{ $vendor->name }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Update institution or service provider details.') }}</p>
    </div>

    <div class="max-w-4xl bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
        <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Logo') }}</label>
                        <div class="flex items-center gap-6">
                            @if($vendor->logo)
                                <img src="{{ asset('storage/' . $vendor->logo) }}" class="w-12 h-12 rounded-xl object-cover shadow-md">
                            @endif
                            <input type="file" name="logo" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl outline-none text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('About Image 1') }}</label>
                        <div class="flex items-center gap-6">
                            @if($vendor->about_image1)
                                <img src="{{ asset('storage/' . $vendor->about_image1) }}" class="w-12 h-12 rounded-xl object-cover shadow-md">
                            @endif
                            <input type="file" name="about_image1" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl outline-none text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('About Image 2') }}</label>
                        <div class="flex items-center gap-6">
                            @if($vendor->about_image2)
                                <img src="{{ asset('storage/' . $vendor->about_image2) }}" class="w-12 h-12 rounded-xl object-cover shadow-md">
                            @endif
                            <input type="file" name="about_image2" class="w-full px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl outline-none text-xs">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $vendor->name) }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Slug') }}</label>
                    <input type="text" name="slug" value="{{ old('slug', $vendor->slug) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Status') }}</label>
                    <select name="status" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        <option value="active" {{ $vendor->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ $vendor->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $vendor->email) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone 1') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone 2') }}</label>
                    <input type="text" name="phone_secondary" value="{{ old('phone_secondary', $vendor->phone_secondary) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Password') }}</label>
                    <input type="password" name="password" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Leave blank to keep current') }}">
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Facebook URL') }}</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $vendor->facebook) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Instagram URL') }}</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $vendor->instagram) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Twitter URL') }}</label>
                        <input type="url" name="twitter" value="{{ old('twitter', $vendor->twitter) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('WhatsApp Number') }}</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $vendor->whatsapp) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="e.g. 201234567890">
                    </div>
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-50 pt-8">
                    <h3 class="md:col-span-2 text-sm font-bold text-gray-900 uppercase tracking-widest">{{ __('Promotional Settings') }}</h3>
                    
                    <div class="p-6 bg-rose-50/30 rounded-2xl border border-rose-50 space-y-4">
                        <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Order Threshold Discount') }}</label>
                        <div class="grid grid-cols-1 gap-4">
                            <input type="number" step="0.01" name="order_threshold" value="{{ old('order_threshold', $vendor->order_threshold) }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Min Order Amount') }}">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="number" step="0.01" name="order_threshold_discount" value="{{ old('order_threshold_discount', $vendor->order_threshold_discount) }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Discount Value') }}">
                                <select name="order_threshold_discount_type" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                                    <option value="fixed" {{ old('order_threshold_discount_type', $vendor->order_threshold_discount_type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                    <option value="percentage" {{ old('order_threshold_discount_type', $vendor->order_threshold_discount_type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 space-y-4">
                        <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Multi-item Discount') }}</label>
                        <div class="grid grid-cols-1 gap-4">
                            <input type="number" name="min_items_for_discount" value="{{ old('min_items_for_discount', $vendor->min_items_for_discount) }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Min Items Count') }}">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="number" step="0.01" name="items_discount_amount" value="{{ old('items_discount_amount', $vendor->items_discount_amount) }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Discount Value') }}">
                                <select name="items_discount_type" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                                    <option value="fixed" {{ old('items_discount_type', $vendor->items_discount_type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                    <option value="percentage" {{ old('items_discount_type', $vendor->items_discount_type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 p-6 bg-sky-50/30 rounded-2xl border border-sky-50 space-y-4">
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Free Shipping Threshold') }}</label>
                    <input type="number" step="0.01" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $vendor->free_shipping_threshold) }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Min Order for Free Shipping') }}">
                </div>

                <div class="md:col-span-2 p-6 bg-indigo-50/30 rounded-2xl border border-indigo-50 space-y-4">
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-widest">{{ __('Commission Settings (Yasmina Share)') }}</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <select name="commission_type" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                            <option value="percentage" {{ old('commission_type', $vendor->commission_type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage') }} (%)</option>
                            <option value="fixed" {{ old('commission_type', $vendor->commission_type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }}</option>
                        </select>
                        <input type="number" step="0.01" name="commission_value" value="{{ old('commission_value', $vendor->commission_value) }}" class="w-full px-6 py-4 bg-white border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Commission Value') }}">
                    </div>
                </div>

                <div class="md:col-span-2 p-6 bg-emerald-50/30 rounded-2xl border border-emerald-50 space-y-4">
                    <label class="block text-xs font-bold text-emerald-900 uppercase tracking-widest">{{ __('Product Commission Settings (Per Item)') }}</label>
                    <p class="text-[10px] text-emerald-600 font-medium uppercase tracking-widest mb-2">{{ __('If set, this will be applied per product unit. If zero, the general commission above will be used.') }}</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <select name="product_commission_type" class="w-full px-6 py-4 bg-white border border-emerald-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 outline-none transition-all font-medium">
                            <option value="">{{ __('None') }}</option>
                            <option value="percentage" {{ old('product_commission_type', $vendor->product_commission_type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage') }} (%)</option>
                            <option value="fixed" {{ old('product_commission_type', $vendor->product_commission_type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }}</option>
                        </select>
                        <input type="number" step="0.01" name="product_commission_value" value="{{ old('product_commission_value', $vendor->product_commission_value) }}" class="w-full px-6 py-4 bg-white border border-emerald-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 outline-none transition-all font-medium" placeholder="{{ __('Product Commission Value') }}">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Address') }}</label>
                    <textarea name="address" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">{{ old('address', $vendor->address) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Description') }}</label>
                    <div id="editor_description" class="bg-gray-50 rounded-2xl"></div>
                    <input type="hidden" name="description" id="description" value="{{ old('description', $vendor->description) }}">
                </div>
            </div>

             <div class="mt-10 pt-10 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-8">
                    <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">{{ __('About Us Content') }}</h3>
                    
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('About Us (Arabic)') }}</label>
                        <div id="editor_about_ar" class="bg-gray-50 rounded-2xl"></div>
                        <input type="hidden" name="about_ar" id="about_ar" value="{{ old('about_ar', $vendor->about_ar) }}">
                        @error('about_ar') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('About Us (English)') }}</label>
                        <div id="editor_about_en" class="bg-gray-50 rounded-2xl"></div>
                        <input type="hidden" name="about_en" id="about_en" value="{{ old('about_en', $vendor->about_en) }}">
                        @error('about_en') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6 border-t border-gray-50">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Return Policy (Arabic)') }}</label>
                        <div id="editor_return_policy_ar" class="bg-gray-50 rounded-2xl"></div>
                        <input type="hidden" name="return_policy_ar" id="return_policy_ar" value="{{ old('return_policy_ar', $vendor->return_policy_ar) }}">
                        @error('return_policy_ar') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Return Policy (English)') }}</label>
                        <div id="editor_return_policy_en" class="bg-gray-50 rounded-2xl"></div>
                        <input type="hidden" name="return_policy_en" id="return_policy_en" value="{{ old('return_policy_en', $vendor->return_policy_en) }}">
                        @error('return_policy_en') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
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

            <div class="flex justify-end pt-6">
                <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                    {{ __('Update Vendor') }}
                </button>
            </div>
        </form>
    </div>
     @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            function initQuill(editorId, inputId) {
                var quill = new Quill('#' + editorId, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'color': [] }, { 'background': [] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });

                var input = document.getElementById(inputId);
                quill.root.innerHTML = input.value || '';

                quill.on('text-change', function() {
                    input.value = quill.root.innerHTML;
                });
            }

            function decodeHtml(html) {
                if(!html) return '';
                var txt = document.createElement("textarea");
                txt.innerHTML = html;
                return txt.value;
            }

            document.addEventListener('DOMContentLoaded', function() {
                var fields = ['description', 'about_ar', 'about_en', 'return_policy_ar', 'return_policy_en'];
                
                fields.forEach(id => {
                    var input = document.getElementById(id);
                    if(input) {
                        input.value = decodeHtml(input.value);
                    }
                });

                initQuill('editor_description', 'description');
                initQuill('editor_about_ar', 'about_ar');
                initQuill('editor_about_en', 'about_en');
                initQuill('editor_return_policy_ar', 'return_policy_ar');
                initQuill('editor_return_policy_en', 'return_policy_en');
            });
        </script>
    @endpush
</x-admin::layouts.master>

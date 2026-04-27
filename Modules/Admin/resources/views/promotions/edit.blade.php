<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto" x-data="{ 
        type: '{{ $promotion->type }}', 
        discountType: '{{ $promotion->discount_type }}',
        selectedVendor: '{{ $promotion->vendor_id }}'
    }">
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Edit Promotion') }}</h1>
                <p class="text-gray-500">{{ __('Modify your promotional deal settings.') }}</p>
            </div>
            <a href="{{ route('admin.promotions.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-yasmina-50">
                <h2 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-yasmina-50 text-yasmina-500 rounded-lg flex items-center justify-center text-sm">1</span>
                    {{ __('General Information') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Promotion Name (Arabic)') }}</label>
                        <input type="text" name="name_ar" value="{{ $promotion->name_ar }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="مثلاً: عرض اشتري واحد واحصل على واحد مجاناً">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Promotion Name (English)') }}</label>
                        <input type="text" name="name_en" value="{{ $promotion->name_en }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="e.g., Buy 1 Get 1 Free Deal">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Institution (Optional)') }}</label>
                    <select name="vendor_id" x-model="selectedVendor" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="">{{ __('Global / No Institution') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Promotion Type') }}</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="bogo_same" x-model="type" class="peer sr-only">
                                <div class="p-4 border border-gray-100 rounded-2xl bg-gray-50 text-center peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                    <span class="text-sm font-bold">{{ __('Same Product') }}</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="type" value="bogo_different" x-model="type" class="peer sr-only">
                                <div class="p-4 border border-gray-100 rounded-2xl bg-gray-50 text-center peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                    <span class="text-sm font-bold">{{ __('Different Product') }}</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Discount Type') }}</label>
                        <select name="discount_type" x-model="discountType" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all">
                            <option value="free">{{ __('Free Item') }}</option>
                            <option value="percentage">{{ __('Percentage Discount') }}</option>
                            <option value="fixed">{{ __('Fixed Amount Discount') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Product Selection -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-yasmina-50">
                <h2 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-yasmina-50 text-yasmina-500 rounded-lg flex items-center justify-center text-sm">2</span>
                    {{ __('Deal Rules') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Buy Part -->
                    <div class="space-y-6">
                        <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100">
                            <h3 class="text-blue-600 font-black text-xs uppercase tracking-widest mb-6">{{ __('When customer buys...') }}</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Select Product') }}</label>
                                    <select name="buy_product_id" class="w-full px-4 py-3 bg-white border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm select2">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $promotion->buy_product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->vendor->name ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Quantity required') }}</label>
                                    <input type="number" name="buy_quantity" value="{{ $promotion->buy_quantity }}" min="1" class="w-full px-4 py-3 bg-white border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Get Part -->
                    <div class="space-y-6">
                        <div class="p-6 bg-yasmina-50/50 rounded-3xl border border-yasmina-100">
                            <h3 class="text-yasmina-600 font-black text-xs uppercase tracking-widest mb-6">{{ __('They get...') }}</h3>
                            
                            <div class="space-y-4">
                                <div x-show="type === 'bogo_different'">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Select Product') }}</label>
                                    <select name="get_product_id" class="w-full px-4 py-3 bg-white border border-yasmina-100 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm select2">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $promotion->get_product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->vendor->name ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Quantity to discount') }}</label>
                                    <input type="number" name="get_quantity" value="{{ $promotion->get_quantity }}" min="1" class="w-full px-4 py-3 bg-white border border-yasmina-100 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm">
                                </div>
                                <div x-show="discountType !== 'free'">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Discount Value') }}</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="discount_value" value="{{ $promotion->discount_value }}" class="w-full px-4 py-3 bg-white border border-yasmina-100 rounded-xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400" x-text="discountType === 'percentage' ? '%' : 'LE'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-yasmina-50">
                <h2 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-yasmina-50 text-yasmina-500 rounded-lg flex items-center justify-center text-sm">3</span>
                    {{ __('Validity & Status') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-end">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Starts At') }}</label>
                        <input type="datetime-local" name="starts_at" value="{{ $promotion->starts_at ? $promotion->starts_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Expires At') }}</label>
                        <input type="datetime-local" name="expires_at" value="{{ $promotion->expires_at ? $promotion->expires_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all">
                    </div>
                    <div class="flex items-center gap-4 py-4 bg-gray-50 px-6 rounded-2xl border border-gray-100">
                        <label class="text-sm font-bold text-gray-700 flex-1">{{ __('Active Status') }}</label>
                        <label class="relative inline-block w-12 h-6 transition duration-200 ease-in-out rounded-full cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ $promotion->is_active ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-full h-full bg-gray-200 rounded-full peer-checked:bg-emerald-500 transition-all"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:left-7"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.promotions.index') }}" class="px-10 py-4 bg-white border border-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-50 transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:opacity-90 transition-all">
                    {{ __('Update Promotion') }}
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

<x-vendor::layouts.master>
<div class="p-8 max-w-5xl" x-data="{ type: '{{ $promotion->type }}', discountType: '{{ $promotion->discount_type }}' }">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('vendor.promotions.index') }}" class="w-10 h-10 rounded-xl bg-white border border-yasmina-100 flex items-center justify-center text-gray-400 hover:text-yasmina-600 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Edit Deal') }}</h1>
            <p class="text-gray-500 mt-1">{{ __('Modify your promotional rules and BOGO offers.') }}</p>
        </div>
    </div>

    <form action="{{ route('vendor.promotions.update', $promotion->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- General Info -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-xl font-bold text-gray-800 mb-8 pb-4 border-b border-yasmina-50">{{ __('General Information') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Deal Name (Arabic)') }}</label>
                    <input type="text" name="name_ar" value="{{ $promotion->name_ar }}" class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900" placeholder="{{ __('e.g. عرض اشترِ 2 واحصل على 1 مجاناً') }}">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Deal Name (English)') }}</label>
                    <input type="text" name="name_en" value="{{ $promotion->name_en }}" class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900" placeholder="{{ __('e.g. Buy 2 Get 1 Free') }}">
                </div>
            </div>
        </div>

        <!-- Deal Logic -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-xl font-bold text-gray-800 mb-8 pb-4 border-b border-yasmina-50">{{ __('Deal Configuration') }}</h3>
            
            <div class="space-y-8">
                <!-- Type Toggle -->
                <div class="space-y-4">
                    <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Deal Type') }}</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex items-center p-6 bg-yasmina-50/50 rounded-3xl cursor-pointer transition-all border-2 border-transparent hover:border-yasmina-200" :class="{ 'border-yasmina-600 bg-white shadow-xl shadow-yasmina-100': type === 'bogo_same' }">
                            <input type="radio" name="type" value="bogo_same" x-model="type" class="hidden">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900">{{ __('Quantity Based (BOGO Same Product)') }}</span>
                                <span class="text-xs text-gray-400 mt-1">{{ __('Buy X units of a product, get Y units of the same product.') }}</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-6 bg-yasmina-50/50 rounded-3xl cursor-pointer transition-all border-2 border-transparent hover:border-yasmina-200" :class="{ 'border-yasmina-600 bg-white shadow-xl shadow-yasmina-100': type === 'bogo_different' }">
                            <input type="radio" name="type" value="bogo_different" x-model="type" class="hidden">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900">{{ __('Cross Sell (BOGO Different Product)') }}</span>
                                <span class="text-xs text-gray-400 mt-1">{{ __('Buy Product A, get Product B for free or at a discount.') }}</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Products Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Buy Product') }}</label>
                            <span class="text-xs font-bold text-yasmina-600 bg-yasmina-50 px-3 py-1 rounded-full uppercase">{{ __('Required') }}</span>
                        </div>
                        <select name="buy_product_id" required class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900 select2">
                            <option value="">{{ __('Select Product') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $promotion->buy_product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <div class="flex items-center gap-4 mt-4">
                            <div class="flex-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Quantity to Buy') }}</label>
                                <input type="number" name="buy_quantity" value="{{ $promotion->buy_quantity }}" min="1" class="w-full px-6 py-3 bg-yasmina-50/50 border-0 rounded-xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4" x-show="type === 'bogo_different'">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Get Product') }}</label>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase">{{ __('Reward') }}</span>
                        </div>
                        <select name="get_product_id" :required="type === 'bogo_different'" class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900 select2">
                            <option value="">{{ __('Select Reward Product') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $promotion->get_product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <div class="flex items-center gap-4 mt-4">
                            <div class="flex-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Quantity to Get') }}</label>
                                <input type="number" name="get_quantity" value="{{ $promotion->get_quantity }}" min="1" class="w-full px-6 py-3 bg-yasmina-50/50 border-0 rounded-xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900">
                            </div>
                        </div>
                    </div>

                    <!-- Same Product Quantity to Get -->
                    <div class="space-y-4" x-show="type === 'bogo_same'">
                         <div class="flex items-center justify-between opacity-50">
                            <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Get Product') }}</label>
                        </div>
                        <div class="w-full px-6 py-4 bg-gray-100 border-0 rounded-2xl font-bold text-gray-400">
                            {{ __('Same as Buy Product') }}
                        </div>
                        <div class="flex items-center gap-4 mt-4">
                            <div class="flex-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Quantity to Get') }}</label>
                                <input type="number" name="get_quantity" value="{{ $promotion->get_quantity }}" min="1" class="w-full px-6 py-3 bg-yasmina-50/50 border-0 rounded-xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reward Type -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-xl font-bold text-gray-800 mb-8 pb-4 border-b border-yasmina-50">{{ __('Discount / Reward Type') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <label class="relative flex items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl cursor-pointer transition-all border-2 border-transparent hover:border-yasmina-200" :class="{ 'border-yasmina-600 bg-white shadow-xl shadow-yasmina-100': discountType === 'free' }">
                    <input type="radio" name="discount_type" value="free" x-model="discountType" class="hidden">
                    <span class="font-black uppercase tracking-widest">{{ __('FREE') }}</span>
                </label>
                <label class="relative flex items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl cursor-pointer transition-all border-2 border-transparent hover:border-yasmina-200" :class="{ 'border-yasmina-600 bg-white shadow-xl shadow-yasmina-100': discountType === 'percentage' }">
                    <input type="radio" name="discount_type" value="percentage" x-model="discountType" class="hidden">
                    <span class="font-black uppercase tracking-widest">{{ __('Percentage %') }}</span>
                </label>
                <label class="relative flex items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl cursor-pointer transition-all border-2 border-transparent hover:border-yasmina-200" :class="{ 'border-yasmina-600 bg-white shadow-xl shadow-yasmina-100': discountType === 'fixed' }">
                    <input type="radio" name="discount_type" value="fixed" x-model="discountType" class="hidden">
                    <span class="font-black uppercase tracking-widest">{{ __('Fixed Amount') }}</span>
                </label>
            </div>

            <div class="space-y-4" x-show="discountType !== 'free'">
                <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Discount Value') }}</label>
                <div class="relative">
                    <input type="number" name="discount_value" value="{{ $promotion->discount_value }}" step="0.01" class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900">
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 font-black">
                        <span x-show="discountType === 'percentage'">%</span>
                        <span x-show="discountType === 'fixed'">{{ __('LE') }}</span>
                    </div>
                </div>
            </div>
            
            <div x-show="discountType === 'free'">
                <input type="hidden" name="discount_value" value="100">
                <p class="text-center py-4 text-emerald-600 font-bold bg-emerald-50 rounded-2xl border border-emerald-100">
                    {{ __('The "Get Product" will be completely free (100% discount).') }}
                </p>
            </div>
        </div>

        <!-- Validity -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-xl font-bold text-gray-800 mb-8 pb-4 border-b border-yasmina-50">{{ __('Availability & Validity') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Starts At') }}</label>
                    <input type="date" name="starts_at" value="{{ $promotion->starts_at?->format('Y-m-d') }}" class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black text-gray-700 uppercase tracking-widest">{{ __('Expires At') }}</label>
                    <input type="date" name="expires_at" value="{{ $promotion->expires_at?->format('Y-m-d') }}" class="w-full px-6 py-4 bg-yasmina-50/50 border-0 rounded-2xl focus:ring-2 focus:ring-yasmina-500 font-bold text-gray-900">
                </div>
            </div>
            <label class="flex items-center gap-4 p-6 bg-yasmina-50/50 rounded-3xl cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $promotion->is_active ? 'checked' : '' }} class="w-6 h-6 rounded-lg text-yasmina-600 focus:ring-yasmina-500 border-0">
                <div>
                    <span class="font-bold text-gray-900">{{ __('Activate this deal immediately') }}</span>
                    <p class="text-xs text-gray-400">{{ __('If checked, customers can use this deal once it starts.') }}</p>
                </div>
            </label>
        </div>

        <div class="flex items-center justify-end gap-4 pb-12">
            <a href="{{ route('vendor.promotions.index') }}" class="px-8 py-4 text-gray-500 font-bold hover:text-gray-900 transition-all">{{ __('Cancel') }}</a>
            <button type="submit" class="px-12 py-4 bg-yasmina-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-yasmina-700 transition-all shadow-xl shadow-yasmina-100">
                {{ __('Update Deal') }}
            </button>
        </div>
    </form>
</div>
</div>
</x-vendor::layouts.master>

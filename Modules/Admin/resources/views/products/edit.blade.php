<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Edit Product') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Modify product details and pricing.') }}</p>
    </div>

    <div class="max-w-4xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="p-6 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                    <div class="flex items-center gap-3 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-sm font-bold text-red-800">{{ __('Please correct the following errors:') }}</h3>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Product Name (Arabic)') }}</label>
                    <input type="text" name="ar[name]" value="{{ $product->translate('ar')->name ?? '' }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Product Name (English)') }}</label>
                    <input type="text" name="en[name]" value="{{ $product->translate('en')->name ?? '' }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Category') }}</label>
                    <select name="category_id" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Currency') }}</label>
                    <select name="currency_id" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $product->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->name }} ({{ $currency->symbol }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Price') }}</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-5 py-4 bg-yasmina-50/50 border {{ $errors->has('price') ? 'border-red-500' : 'border-yasmina-100' }} rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
                    @error('price')
                        <p class="mt-1 text-xs font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Discount Price') }}</label>
                    <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="w-full px-5 py-4 bg-yasmina-50/50 border {{ $errors->has('discount_price') ? 'border-red-500' : 'border-yasmina-100' }} rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="0.00">
                    @error('discount_price')
                        <p class="mt-1 text-xs font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-6 bg-amber-50/50 rounded-3xl border border-amber-100 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-bold text-amber-600 uppercase tracking-widest mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Flash Sale Settings') }}
                        </h3>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-amber-500 mb-2 uppercase tracking-widest">{{ __('Flash Sale Price') }}</label>
                        <input type="number" step="0.01" name="flash_sale_price" value="{{ old('flash_sale_price', $product->flash_sale_price) }}" class="w-full px-5 py-4 bg-white border {{ $errors->has('flash_sale_price') ? 'border-red-500' : 'border-amber-100' }} rounded-2xl focus:ring-4 focus:ring-amber-100 outline-none font-bold text-gray-700" placeholder="0.00">
                        @error('flash_sale_price')
                            <p class="mt-1 text-xs font-bold text-red-500 uppercase tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-amber-500 mb-2 uppercase tracking-widest">{{ __('Expiry Date') }}</label>
                        <input type="datetime-local" name="flash_sale_expires_at" value="{{ $product->flash_sale_expires_at ? $product->flash_sale_expires_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-5 py-4 bg-white border border-amber-100 rounded-2xl focus:ring-4 focus:ring-amber-100 outline-none font-bold text-gray-700">
                    </div>
                </div>

                <div class="p-6 bg-yasmina-50/50 rounded-3xl border border-yasmina-100 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-bold text-yasmina-600 uppercase tracking-widest mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            {{ __('Gift Settings') }}
                        </h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_gift" id="is_gift" value="1" {{ $product->is_gift ? 'checked' : '' }} class="w-5 h-5 text-yasmina-500 border-yasmina-100 rounded focus:ring-yasmina-500">
                        <label for="is_gift" class="text-sm font-bold text-yasmina-500 uppercase tracking-widest">{{ __('Designate as Gift') }}</label>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Minimum Order Threshold') }}</label>
                        <input type="number" step="0.01" name="gift_threshold" value="{{ $product->gift_threshold }}" class="w-full px-5 py-4 bg-white border border-yasmina-100 rounded-2xl focus:ring-4 focus:ring-yasmina-100 outline-none font-bold text-gray-700" placeholder="0.00">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Rank') }}</label>
                    <input type="number" name="rank" value="{{ $product->rank }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Institution (Optional)') }}</label>
                    <select name="vendor_id" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700 appearance-none">
                        <option value="">{{ __('No Institution (Global)') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Description (Arabic)') }}</label>
                    <textarea name="ar[description]" rows="4" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700">{{ $product->translate('ar')->description ?? '' }}</textarea>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Description (English)') }}</label>
                    <textarea name="en[description]" rows="4" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700">{{ $product->translate('en')->description ?? '' }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Product Image') }}</label>
                    @if($product->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $product->image) }}" class="h-32 w-32 object-cover rounded-2xl border border-yasmina-100">
                        </div>
                    @endif
                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-yasmina-100 border-dashed rounded-3xl bg-yasmina-50/30 hover:bg-yasmina-50 transition-all cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-yasmina-300 group-hover:text-yasmina-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer rounded-md font-bold text-yasmina-500 hover:text-yasmina-600 focus-within:outline-none">
                                    <span>{{ __('Upload a file') }}</span>
                                    <input id="image" name="image" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-lg shadow-yasmina-100">
                    {{ __('Update Product') }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

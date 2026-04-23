<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Add New Product') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('List a new product in your store.') }}</p>
    </div>

    <div class="max-w-4xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Product Name (Arabic)') }}</label>
                    <input type="text" name="ar[name]" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('e.g. فستان حرير') }}" required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Product Name (English)') }}</label>
                    <input type="text" name="en[name]" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('e.g. Silk Dress') }}" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Category') }}</label>
                    <select name="category_id" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Currency') }}</label>
                    <select name="currency_id" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        <option value="">{{ __('Select Currency') }}</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->symbol }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Price') }}</label>
                    <input type="number" step="0.01" name="price" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="0.00" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Discount Price') }}</label>
                    <input type="number" step="0.01" name="discount_price" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="0.00">
                </div>

                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Rank') }}</label>
                    <input type="number" name="rank" value="0" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Institution (Optional)') }}</label>
                    <select name="vendor_id" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700 appearance-none">
                        <option value="">{{ __('No Institution (Global)') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Description (Arabic)') }}</label>
                    <textarea name="ar[description]" rows="4" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('وصف المنتج...') }}"></textarea>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Description (English)') }}</label>
                    <textarea name="en[description]" rows="4" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('Product description...') }}"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Product Image') }}</label>
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
                    {{ __('Save Product') }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

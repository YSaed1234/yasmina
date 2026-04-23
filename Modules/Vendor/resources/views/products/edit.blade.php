<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Edit Product') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Update details for') }} {{ $product->name }}.</p>
    </div>

    <div class="max-w-4xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-gray-100 shadow-xl">
        <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Product Name (Arabic)') }}</label>
                    <input type="text" name="ar[name]" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700" 
                        value="{{ $product->translate('ar')->name ?? '' }}" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Product Name (English)') }}</label>
                    <input type="text" name="en[name]" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700" 
                        value="{{ $product->translate('en')->name ?? '' }}" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Category') }}</label>
                    <select name="category_id" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700 appearance-none" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Price') }}</label>
                    <input type="number" step="0.01" name="price" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700" 
                        value="{{ $product->price }}" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Discount Price') }}</label>
                    <input type="number" step="0.01" name="discount_price" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700" 
                        value="{{ $product->discount_price }}" placeholder="0.00">
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Description (Arabic)') }}</label>
                    <textarea name="ar[description]" rows="4" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700">{{ $product->translate('ar')->description ?? '' }}</textarea>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Description (English)') }}</label>
                    <textarea name="en[description]" rows="4" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary/30 transition-all outline-none font-bold text-gray-700">{{ $product->translate('en')->description ?? '' }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-widest">{{ __('Product Image') }}</label>
                    
                    @if($product->image)
                    <div class="mb-4 relative w-32 h-32 rounded-2xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white text-[10px] font-bold uppercase">{{ __('Current') }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-100 border-dashed rounded-3xl bg-gray-50/30 hover:bg-gray-50 transition-all cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-300 group-hover:text-primary transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer rounded-md font-bold text-primary hover:text-primary/80 focus-within:outline-none">
                                    <span>{{ __('Upload a new file') }}</span>
                                    <input id="image" name="image" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                    {{ __('Update Product') }}
                </button>
                <a href="{{ route('vendor.products.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-vendor::layouts.master>

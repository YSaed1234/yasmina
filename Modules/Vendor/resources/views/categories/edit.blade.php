<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Edit Category') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Modify your category details.') }}</p>
    </div>

    <div class="max-w-2xl bg-white/70 backdrop-blur-md p-10 rounded-[3rem] border border-gray-100 shadow-xl shadow-gray-100/50">
        <form action="{{ route('vendor.categories.update', $category->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="name_ar" class="block text-sm font-bold text-gray-400 mb-3 uppercase tracking-widest">{{ __('Name (Arabic)') }}</label>
                    <input type="text" name="ar[name]" id="name_ar" 
                        class="w-full px-6 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all outline-none font-bold text-gray-700" 
                        value="{{ $category->translate('ar')->name ?? '' }}" required>
                    @error('ar.name') <p class="mt-2 text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="name_en" class="block text-sm font-bold text-gray-400 mb-3 uppercase tracking-widest">{{ __('Name (English)') }}</label>
                    <input type="text" name="en[name]" id="name_en" 
                        class="w-full px-6 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all outline-none font-bold text-gray-700" 
                        value="{{ $category->translate('en')->name ?? '' }}" required>
                    @error('en.name') <p class="mt-2 text-red-500 text-xs font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 flex gap-4">
                <button type="submit" class="flex-1 px-8 py-5 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                    {{ __('Update Category') }}
                </button>
                <a href="{{ route('vendor.categories.index') }}" class="px-8 py-5 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-vendor::layouts.master>

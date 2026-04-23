<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Add Slider') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Create a new slider for your homepage.') }}</p>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        <form action="{{ route('vendor.sliders.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Image') }}</label>
                        <input type="file" name="image" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Title (Arabic)') }}</label>
                            <input type="text" name="title_ar" value="{{ old('title_ar') }}" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Title (English)') }}</label>
                            <input type="text" name="title_en" value="{{ old('title_en') }}" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Subtitle (Arabic)') }}</label>
                            <input type="text" name="subtitle_ar" value="{{ old('subtitle_ar') }}" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Subtitle (English)') }}</label>
                            <input type="text" name="subtitle_en" value="{{ old('subtitle_en') }}" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Link URL') }}</label>
                        <input type="text" name="link" value="{{ old('link') }}" placeholder="https://..." class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Order') }}</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="active" value="1" checked class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                        <label class="text-sm font-bold text-gray-700">{{ __('Active') }}</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('vendor.sliders.index') }}" class="px-8 py-4 text-gray-500 font-bold hover:underline">{{ __('Cancel') }}</a>
                <button type="submit" class="px-12 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                    {{ __('Create Slider') }}
                </button>
            </div>
        </form>
    </div>
</x-vendor::layouts.master>

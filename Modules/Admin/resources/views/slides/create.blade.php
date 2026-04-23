<x-admin::layouts.master>
    <div class="mb-10">
        <a href="{{ route('admin.slides.index') }}" class="flex items-center gap-2 text-primary font-bold text-sm mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Slides') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Add New Slide') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Define the content and style for your new hero slide.') }}</p>
    </div>

    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-8">
        @csrf
        
        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-8">{{ __('Slide Content') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Slide Image') }}</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-100 border-dashed rounded-3xl hover:border-primary/30 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label class="relative cursor-pointer bg-white rounded-md font-bold text-primary hover:text-primary/80 focus-within:outline-none">
                                    <span>{{ __('Upload a file') }}</span>
                                    <input type="file" name="image" required class="sr-only">
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-400">{{ __('PNG, JPG, GIF up to 2MB') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Title (Arabic)') }}</label>
                    <input type="text" name="title_ar" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Title (English)') }}</label>
                    <input type="text" name="title_en" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Subtitle (Arabic)') }}</label>
                    <input type="text" name="subtitle_ar" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Subtitle (English)') }}</label>
                    <input type="text" name="subtitle_en" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Description (Arabic)') }}</label>
                    <textarea name="description_ar" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Description (English)') }}</label>
                    <textarea name="description_en" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium"></textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-8">{{ __('Button & Links') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Button Text (Arabic)') }}</label>
                    <input type="text" name="button_text_ar" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Button Text (English)') }}</label>
                    <input type="text" name="button_text_en" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Button Link (URL)') }}</label>
                    <input type="text" name="link" placeholder="https://..." class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium text-left">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-8">{{ __('Settings') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Display Order') }}</label>
                    <input type="number" name="order" value="0" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Initial Status') }}</label>
                    <select name="active" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium appearance-none">
                        <option value="1">{{ __('Active') }}</option>
                        <option value="0">{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                {{ __('Create Slide') }}
            </button>
        </div>
    </form>
</x-admin::layouts.master>

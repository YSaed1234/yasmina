<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Add New Shipping Zone') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Define a new regional shipping rate.') }}</p>
        </div>
        <a href="{{ route('admin.shipping_zones.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl font-bold hover:bg-gray-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Zones') }}
        </a>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.shipping_zones.store') }}" method="POST" class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 space-y-8">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Zone Name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all"
                       placeholder="{{ __('e.g. Cairo, Giza, etc.') }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Shipping Rate') }}</label>
                <div class="relative">
                    <input type="number" step="0.01" name="rate" value="{{ old('rate') }}" required
                           class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all"
                           placeholder="0.00">
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold">
                        $
                    </div>
                </div>
                @error('rate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                        <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-checked:bg-primary transition-all"></div>
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-6"></div>
                    </div>
                    <span class="text-sm font-bold text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Active and available for customers') }}</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                    {{ __('Create Shipping Zone') }}
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

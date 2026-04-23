<x-vendor::layouts.master>
    <div class="mb-10 flex items-center gap-6">
        <a href="{{ route('vendor.shipping.index') }}" class="w-12 h-12 bg-white rounded-2xl border border-gray-100 flex items-center justify-center text-gray-400 hover:text-primary hover:border-primary/20 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">
                {{ isset($region) ? __('Edit Shipping Rate') : __('Add New Shipping Rate') }}
            </h1>
            <p class="text-gray-500 mt-2">{{ __('Define specific areas and their shipping costs for your customers.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ isset($region) ? route('vendor.shipping.update', $region->id) : route('vendor.shipping.store') }}" method="POST" class="p-10">
            @csrf
            @if(isset($region))
                @method('PUT')
            @endif

            <div class="space-y-8">
                <!-- Governorate -->
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Select Governorate') }}</label>
                    <select name="governorate_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" required>
                        <option value="">{{ __('Select Governorate') }}</option>
                        @foreach($governorates as $gov)
                            <option value="{{ $gov->id }}" {{ (old('governorate_id', isset($region) ? $region->governorate_id : '')) == $gov->id ? 'selected' : '' }}>
                                {{ $gov->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('governorate_id') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Region Name -->
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Region Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', isset($region) ? $region->name : '') }}" 
                        placeholder="{{ __('e.g. Heliopolis, Dokki, etc.') }}"
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" required>
                    @error('name') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Shipping Rate -->
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Shipping Rate') }}</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="rate" value="{{ old('rate', isset($region) ? $region->rate : '') }}" 
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-900" required>
                        <div class="absolute inset-y-0 end-6 flex items-center pointer-events-none">
                            <span class="text-gray-400 font-bold">{{ __('LE') }}</span>
                        </div>
                    </div>
                    @error('rate') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Active Status -->
                <div class="pt-6 border-t border-gray-50">
                    <label class="flex items-center gap-4 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" class="sr-only peer" {{ old('is_active', isset($region) ? $region->is_active : true) ? 'checked' : '' }}>
                            <div class="w-14 h-8 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                        </div>
                        <div>
                            <span class="block text-sm font-black text-gray-900">{{ __('Active and available for shipping') }}</span>
                            <span class="text-xs text-gray-400">{{ __('Toggle to enable or disable this shipping rate for customers.') }}</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-12 flex justify-end">
                <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-black shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ isset($region) ? __('Update Shipping Rate') : __('Create Shipping Rate') }}
                </button>
            </div>
        </form>
    </div>
</x-vendor::layouts.master>

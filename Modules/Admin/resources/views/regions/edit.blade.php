<x-admin::layouts.master>
    <div class="mb-10 flex items-center gap-4">
        <a href="{{ route('admin.regions.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 hover:text-primary transition-all border border-gray-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ isset($region) ? __('Edit Region') : __('Add New Region') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Define specific areas and their shipping costs within governorates.') }}</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
            <form action="{{ isset($region) ? route('admin.regions.update', $region) : route('admin.regions.store') }}" method="POST">
                @csrf
                @if(isset($region))
                    @method('PUT')
                @endif

                <div class="space-y-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Governorate') }}</label>
                        <select name="governorate_id" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium appearance-none">
                            <option value="">{{ __('Select Governorate') }}</option>
                            @foreach($governorates as $gov)
                                <option value="{{ $gov->id }}" {{ (old('governorate_id', $region->governorate_id ?? '') == $gov->id) ? 'selected' : '' }}>
                                    {{ $gov->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Region Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $region->name ?? '') }}" required
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Shipping Rate') }}</label>
                        <input type="number" step="0.01" name="rate" value="{{ old('rate', $region->rate ?? '0.00') }}" required
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>

                    <div class="flex items-center gap-4 p-6 bg-yasmina-50/30 rounded-3xl border border-yasmina-100">
                        <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out rounded-full shadow-inner bg-gray-200 has-[:checked]:bg-primary">
                            <input type="checkbox" name="is_active" id="is_active" class="absolute w-6 h-6 bg-white border-4 border-gray-200 rounded-full appearance-none cursor-pointer checked:right-0 right-6 transition-all duration-200" {{ old('is_active', $region->is_active ?? true) ? 'checked' : '' }}>
                        </div>
                        <label for="is_active" class="text-sm font-bold text-gray-700 cursor-pointer">{{ __('Active and available for shipping') }}</label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($region) ? __('Update Region') : __('Create Region') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin::layouts.master>

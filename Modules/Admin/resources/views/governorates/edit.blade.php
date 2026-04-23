<x-admin::layouts.master>
    <div class="mb-10 flex items-center gap-4">
        <a href="{{ route('governorates.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 hover:text-primary transition-all border border-gray-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ isset($governorate) ? __('Edit Governorate') : __('Add New Governorate') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Fill in the details to manage your administrative regions.') }}</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
            <form action="{{ isset($governorate) ? route('governorates.update', $governorate) : route('governorates.store') }}" method="POST">
                @csrf
                @if(isset($governorate))
                    @method('PUT')
                @endif

                <div class="space-y-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Governorate Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $governorate->name ?? '') }}" required
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        @error('name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($governorate) ? __('Update Governorate') : __('Create Governorate') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin::layouts.master>

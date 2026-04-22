<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Add Category') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Create a new category for your products.') }}</p>
    </div>

    <div class="max-w-2xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-rose-50 shadow-xl shadow-rose-100/50">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-bold text-rose-500 mb-2 uppercase tracking-widest">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="w-full px-5 py-4 bg-rose-50/50 border border-rose-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('e.g. Dresses') }}" required>
                @error('name') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="rank" class="block text-sm font-bold text-rose-500 mb-2 uppercase tracking-widest">{{ __('Rank') }}</label>
                <input type="number" name="rank" id="rank" class="w-full px-5 py-4 bg-rose-50/50 border border-rose-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-rose-100 focus:border-rose-300 transition-all outline-none font-bold text-gray-700" value="0">
                @error('rank') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>
            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 px-8 py-4 bg-rose-500 text-white rounded-2xl font-bold hover:bg-rose-600 transition-all shadow-lg shadow-rose-100">
                    {{ __('Save Category') }}
                </button>
                <a href="{{ route('categories.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Add New Currency') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Define a new currency for product pricing.') }}</p>
    </div>

    <div class="max-w-2xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-barbie-50 shadow-xl shadow-barbie-100/50">
        <form action="{{ route('currencies.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-barbie-500 mb-2 uppercase tracking-widest">{{ __('Currency Name (Arabic)') }}</label>
                <input type="text" name="ar[name]" class="w-full px-5 py-4 bg-barbie-50/50 border border-barbie-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-barbie-100 focus:border-barbie-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('e.g. دولار أمريكي') }}" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-barbie-500 mb-2 uppercase tracking-widest">{{ __('Currency Name (English)') }}</label>
                <input type="text" name="en[name]" class="w-full px-5 py-4 bg-barbie-50/50 border border-barbie-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-barbie-100 focus:border-barbie-300 transition-all outline-none font-bold text-gray-700" placeholder="{{ __('e.g. US Dollar') }}" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-barbie-500 mb-2 uppercase tracking-widest">{{ __('Code') }}</label>
                    <input type="text" name="code" class="w-full px-5 py-4 bg-barbie-50/50 border border-barbie-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-barbie-100 focus:border-barbie-300 transition-all outline-none font-bold text-gray-700" placeholder="USD" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-barbie-500 mb-2 uppercase tracking-widest">{{ __('Symbol') }}</label>
                    <input type="text" name="symbol" class="w-full px-5 py-4 bg-barbie-50/50 border border-barbie-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-barbie-100 focus:border-barbie-300 transition-all outline-none font-bold text-gray-700" placeholder="$" required>
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-barbie-500 text-white rounded-2xl font-bold hover:bg-barbie-600 transition-all shadow-lg shadow-barbie-100">
                    {{ __('Create Currency') }}
                </button>
                <a href="{{ route('currencies.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

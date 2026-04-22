<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Edit Currency') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Modify currency details.') }}</p>
    </div>

    <div class="max-w-2xl bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50">
        <form action="{{ route('currencies.update', $currency->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Currency Name (Arabic)') }}</label>
                <input type="text" name="ar[name]" value="{{ $currency->translate('ar')->name ?? '' }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Currency Name (English)') }}</label>
                <input type="text" name="en[name]" value="{{ $currency->translate('en')->name ?? '' }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Code') }}</label>
                    <input type="text" name="code" value="{{ $currency->code }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-yasmina-500 mb-2 uppercase tracking-widest">{{ __('Symbol') }}</label>
                    <input type="text" name="symbol" value="{{ $currency->symbol }}" class="w-full px-5 py-4 bg-yasmina-50/50 border border-yasmina-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-yasmina-100 focus:border-yasmina-300 transition-all outline-none font-bold text-gray-700" required>
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 py-4 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-lg shadow-yasmina-100">
                    {{ __('Update Currency') }}
                </button>
                <a href="{{ route('currencies.index') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

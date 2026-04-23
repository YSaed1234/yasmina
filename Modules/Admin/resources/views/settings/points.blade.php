<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Loyalty Points Settings') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Configure how customers earn and redeem points.') }}</p>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.settings.points.update') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    {{ __('Earning Rules') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Points per 1.00 Currency spent') }}</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="points_per_currency" value="{{ $settings['points_per_currency'] ?? '1' }}" required
                                   class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs uppercase">{{ __('Points') }}</div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 italic">{{ __('Example: If 1, then 100 spent = 100 points.') }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Earn Points When Order Status Is') }}</label>
                        <select name="points_earning_status" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium appearance-none">
                            <option value="processing" {{ ($settings['points_earning_status'] ?? '') == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                            <option value="shipped" {{ ($settings['points_earning_status'] ?? '') == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                            <option value="delivered" {{ ($settings['points_earning_status'] ?? '') == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                            <option value="completed" {{ ($settings['points_earning_status'] ?? '') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    {{ __('Redemption Rules') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Money Value per 1 Point') }}</label>
                        <div class="relative">
                            <input type="number" step="0.001" name="currency_per_point" value="{{ $settings['currency_per_point'] ?? '0.1' }}" required
                                   class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs uppercase">{{ __('Currency') }}</div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 italic">{{ __('Example: If 0.1, then 100 points = 10 units of money.') }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Minimum Points to Convert') }}</label>
                        <input type="number" name="min_points_to_convert" value="{{ $settings['min_points_to_convert'] ?? '100' }}" required
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Save Points Settings') }}
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

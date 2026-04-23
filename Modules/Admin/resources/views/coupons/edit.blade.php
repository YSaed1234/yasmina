<x-admin::layouts.master>
    <div class="mb-8">
        <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-2 text-yasmina-500 font-bold hover:gap-3 transition-all mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Coupons') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Edit Coupon') }}: {{ $coupon->code }}</h1>
        <p class="text-gray-500 mt-1">{{ __('Update discount rules and usage limits.') }}</p>
    </div>

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="max-w-4xl">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Basic Info -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-yasmina-50 space-y-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-yasmina-50 pb-4">{{ __('Coupon Information') }}</h3>
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Coupon Code') }}</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all uppercase">
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Discount Type') }}</label>
                        <select name="type" required class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }}</option>
                            <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>{{ __('Percentage') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Value') }}</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" required class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                        @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Minimum Order Amount') }}</label>
                    <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" required class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Status') }}</label>
                    <select name="is_active" required class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                        <option value="1" {{ old('is_active', $coupon->is_active) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ old('is_active', $coupon->is_active) == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>

            <!-- Usage Limits -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-yasmina-50 space-y-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-yasmina-50 pb-4">{{ __('Usage & Validity') }}</h3>
                
                <div class="p-4 bg-yasmina-50/30 rounded-2xl border border-yasmina-50 mb-4">
                    <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">{{ __('Current Usage') }}</p>
                    <p class="text-xl font-bold text-yasmina-600">{{ $coupon->used_count }} {{ __('times') }}</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Total Usage Limit') }}</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="{{ __('No limit') }}" class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Usage Limit Per User') }}</label>
                    <input type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}" required class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Starts At') }}</label>
                        <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d\TH:i')) }}" class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">{{ __('Expires At') }}</label>
                        <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}" class="w-full px-5 py-3 bg-yasmina-50/50 border-none rounded-2xl focus:ring-2 focus:ring-yasmina-200 transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-12 py-4 bg-yasmina-500 text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-xl shadow-yasmina-100 text-lg">
                {{ __('Update Coupon') }}
            </button>
        </div>
    </form>
</x-admin::layouts.master>

<x-web::layouts.master>
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-4xl font-bold text-gray-900 mb-12 tracking-tight">{{ __('Checkout') }}</h1>

                <form action="{{ route('web.checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    @csrf
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white p-10 rounded-3xl shadow-sm border border-rose-50">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">1</span>
                                {{ __('Shipping Information') }}
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Full Name') }}</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name ?? old('name') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Email Address') }}</label>
                                    <input type="email" name="email" value="{{ auth()->user()->email ?? old('email') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Street Address') }}</label>
                                    <input type="text" name="address" value="{{ old('address') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('City') }}</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Order Notes (Optional)') }}</label>
                                    <input type="text" name="notes" value="{{ old('notes') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white p-10 rounded-3xl shadow-sm border border-rose-50">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">2</span>
                                {{ __('Payment Method') }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-6 border-2 rounded-2xl cursor-pointer hover:bg-rose-50/50 transition-all border-rose-50 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50">
                                    <input type="radio" name="payment_method" value="cod" checked class="peer hidden">
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">{{ __('Cash on Delivery') }}</div>
                                        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ __('Pay when you receive') }}</div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-6 border-2 rounded-2xl cursor-pointer hover:bg-rose-50/50 transition-all border-rose-50 has-[:checked]:border-primary has-[:checked]:bg-rose-50/50">
                                    <input type="radio" name="payment_method" value="card" class="peer hidden">
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">{{ __('Credit Card') }}</div>
                                        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ __('Pay securely online') }}</div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center bg-white peer-checked:bg-primary transition-all">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white p-10 rounded-3xl shadow-xl shadow-primary/5 border border-rose-50 sticky top-24">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b border-rose-50 pb-6">{{ __('Order Review') }}</h2>
                            
                            <div class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2">
                                @foreach($cart as $id => $details)
                                    <div class="flex gap-4 items-center">
                                        <div class="w-16 h-16 rounded-xl bg-gray-50 overflow-hidden flex-shrink-0 border border-rose-50">
                                            @if($details['image'])
                                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $details['name'] }}</h4>
                                            <p class="text-xs text-gray-400 mt-1">x{{ $details['quantity'] }}</p>
                                        </div>
                                        <div class="text-sm font-bold text-primary">
                                            {{ $details['currency'] }}{{ number_format($details['price'] * $details['quantity'], 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-4 mb-8 border-t border-rose-50 pt-6">
                                <div class="flex justify-between text-gray-500">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-bold text-gray-900">{{ reset($cart)['currency'] ?? '$' }}{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-500">
                                    <span>{{ __('Shipping') }}</span>
                                    <span class="font-bold text-green-600 uppercase text-xs tracking-widest">{{ __('Free') }}</span>
                                </div>
                                <div class="border-t border-rose-50 pt-6 flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">{{ __('Total') }}</span>
                                    <span class="text-3xl font-bold text-primary">{{ reset($cart)['currency'] ?? '$' }}{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                                {{ __('Place Order') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-web::layouts.master>

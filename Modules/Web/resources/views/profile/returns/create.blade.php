<x-web::layouts.master>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-web::profile-sidebar />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-yasmina-50">
                        <div class="flex items-center justify-between mb-10">
                            <h1 class="text-3xl font-bold text-gray-900">{{ __('Request Return') }} - #{{ $order->id }}</h1>
                        </div>

                        <form action="{{ route('web.orders.return.store', $order) }}" method="POST">
                            @csrf
                            
                            <div class="mb-10">
                                <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Select items to return') }}</h3>
                                <div class="space-y-4">
                                    @foreach($order->items as $index => $item)
                                        <div class="flex items-center p-6 bg-yasmina-50/30 rounded-[2rem] border border-yasmina-50 hover:border-primary transition-all group">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" name="items[{{ $index }}][order_item_id]" value="{{ $item->id }}" class="rounded-lg border-yasmina-200 text-primary focus:ring-primary h-6 w-6 cursor-pointer">
                                            </div>
                                            <div class="ms-6 flex-1 flex items-center gap-6">
                                                <div class="w-16 h-16 rounded-2xl overflow-hidden border border-yasmina-100 bg-white">
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $item->product->name }}</p>
                                                    <p class="text-sm text-gray-500 font-medium">{{ $item->quantity }} × {{ number_format($item->price, 2) }} {{ $order->vendor->currency_code ?? 'LE' }}</p>
                                                </div>
                                            </div>
                                            <div class="ms-6">
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 text-center">{{ __('Qty') }}</label>
                                                <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" max="{{ $item->quantity }}" class="w-20 py-2 rounded-xl border-yasmina-100 focus:border-primary focus:ring-primary text-center font-bold text-gray-700">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('items')
                                    <p class="mt-4 text-sm text-red-600 font-bold flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="mb-10">
                                <label for="reason" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Reason for Return') }}</label>
                                <textarea name="reason" id="reason" rows="5" class="w-full rounded-[2rem] border-yasmina-100 focus:border-primary focus:ring-primary p-6 text-gray-700 leading-relaxed placeholder:text-gray-300 transition-all" placeholder="{{ __('Please explain why you want to return these items...') }}" required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <p class="mt-4 text-sm text-red-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                                <a href="{{ route('web.profile.orders') }}" class="px-8 py-4 bg-gray-50 text-gray-500 rounded-2xl font-bold hover:bg-gray-100 transition-all">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-xl shadow-primary/20 flex items-center gap-3">
                                    <span>{{ __('Submit Return Request') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

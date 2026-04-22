<x-web::layouts.master>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-rose-50 sticky top-24">
                        <div class="text-center mb-8">
                            <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-lg">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <nav class="space-y-2">
                            <a href="{{ route('web.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Personal Details') }}</span>
                            </a>
                            <a href="{{ route('web.profile.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile.orders') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('My Orders') }}</span>
                            </a>
                            <a href="{{ route('web.profile.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile.addresses') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('My Addresses') }}</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-rose-50">
                        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Order History') }}</h1>
                        
                        @if($orders->count() > 0)
                            <div class="space-y-6">
                                @foreach($orders as $order)
                                    <div class="border border-gray-100 rounded-[2.5rem] overflow-hidden bg-white hover:border-primary transition-all duration-300">
                                        <div class="bg-rose-50/30 p-6 flex flex-wrap justify-between items-center gap-4 border-b border-gray-100">
                                            <div class="flex gap-8">
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Order Placed') }}</span>
                                                    <p class="text-sm font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Total Amount') }}</span>
                                                    <p class="text-sm font-bold text-primary">{{ number_format($order->total_amount, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Order ID') }}</span>
                                                    <p class="text-sm font-bold text-gray-900">#{{ $order->id }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-white text-primary border border-primary/10 shadow-sm">
                                                    {{ __($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-8">
                                            <div class="space-y-6">
                                                @foreach($order->items as $item)
                                                    <div class="flex items-center gap-6">
                                                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100">
                                                            @if($item->product && $item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-xl font-bold">?</div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <h4 class="font-bold text-gray-900">{{ $item->product->name ?? __('Product Not Found') }}</h4>
                                                            <p class="text-sm text-gray-500 mt-1">{{ __('Qty') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }}</p>
                                                        </div>
                                                        @if($item->product)
                                                            <a href="{{ route('web.products.show', $item->product->id) }}" class="px-6 py-2 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all">
                                                                {{ __('Buy Again') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-10">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="p-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No orders yet') }}</h3>
                                <p class="text-gray-500 mb-8">{{ __('Your order history will appear here once you make your first purchase.') }}</p>
                                <a href="{{ route('web.shop') }}" class="inline-block px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                    {{ __('Start Shopping') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

<x-web::layouts.master>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-rose-50 sticky top-24">
                        <div class="text-center mb-8">
                            <div class="w-24 h-24 rounded-full overflow-hidden mx-auto mb-4 border-4 border-white shadow-lg">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-primary/10 flex items-center justify-center text-primary font-bold text-3xl">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
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
                        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Account Overview') }}</h1>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-6 bg-rose-50/50 rounded-3xl border border-rose-100">
                                <span class="text-xs font-bold text-primary uppercase tracking-widest block mb-2">{{ __('Full Name') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div class="p-6 bg-rose-50/50 rounded-3xl border border-rose-100">
                                <span class="text-xs font-bold text-primary uppercase tracking-widest block mb-2">{{ __('Email Address') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div class="p-6 bg-rose-50/50 rounded-3xl border border-rose-100">
                                <span class="text-xs font-bold text-primary uppercase tracking-widest block mb-2">{{ __('Phone Number') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ $user->phone ?? __('Not Provided') }}</p>
                            </div>
                        </div>

                        <div class="mt-12">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('Recent Orders') }}</h3>
                            @php $recentOrders = $user->orders()->latest()->take(3)->get(); @endphp
                            @if($recentOrders->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentOrders as $order)
                                        <div class="p-6 bg-white border border-gray-100 rounded-3xl flex items-center justify-between hover:border-primary transition-colors group">
                                            <div class="flex items-center gap-6">
                                                <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-primary font-bold">
                                                    #{{ $order->id }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                                    <p class="text-sm text-gray-500">{{ $order->items->count() }} {{ __('Items') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-8">
                                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-50 text-primary">
                                                    {{ __($order->status) }}
                                                </span>
                                                <span class="font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</span>
                                                <a href="{{ route('web.profile.orders') }}" class="text-gray-300 group-hover:text-primary transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-10 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                                    <p class="text-gray-400">{{ __('No recent orders found.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

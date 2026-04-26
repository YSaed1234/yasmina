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
                        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Account Overview') }}</h1>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                            <!-- Points Card -->
                            <div class="p-8 bg-primary rounded-[2.5rem] text-white shadow-xl shadow-primary/20 relative overflow-hidden group">
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full">{{ __('Loyalty Points') }}</span>
                                    </div>
                                    <div class="text-4xl font-black mb-2">{{ number_format($user->points) }}</div>
                                    <p class="text-white/70 text-sm font-medium mb-6">{{ __('Earn more points with every order!') }}</p>
                                    
                                    @php $minPoints = (int) \App\Models\PointSetting::getValue('min_points_to_convert', 100); @endphp
                                    @if($user->points >= $minPoints)
                                        <form action="{{ route('web.profile.convert-points', ['vendor_id' => request('vendor_id')]) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="number" name="points" max="{{ $user->points }}" min="{{ $minPoints }}" value="{{ $user->points }}" 
                                                class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-xl outline-none text-sm placeholder:text-white/40" placeholder="{{ __('Points to convert') }}">
                                            <button type="submit" class="px-6 py-2 bg-white text-primary rounded-xl font-bold text-xs whitespace-nowrap hover:bg-yasmina-50 transition-colors">
                                                {{ __('Convert Now') }}
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-[10px] text-white/50 italic">{{ __('Need at least :min points to convert to money.', ['min' => $minPoints]) }}</p>
                                    @endif
                                </div>
                                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-500"></div>
                            </div>

                            <!-- Wallet Card -->
                            <div class="p-8 bg-gray-900 rounded-[2.5rem] text-white shadow-xl shadow-gray-900/10 relative overflow-hidden group">
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-green-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full text-green-400">{{ __('Wallet Balance') }}</span>
                                    </div>
                                    <div class="text-4xl font-black mb-2">{{ number_format($user->balance, 2) }} <span class="text-sm font-bold text-gray-500">{{ __('LE') }}</span></div>
                                    <p class="text-white/50 text-sm font-medium">{{ __('Use your balance for future orders.') }}</p>
                                </div>
                                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-green-500/10 rounded-full blur-3xl group-hover:bg-green-500/20 transition-all duration-500"></div>
                            </div>
                        </div>

                        <!-- Referral Card -->
                        <div class="mb-12 p-8 bg-yasmina-50 rounded-[2.5rem] border border-yasmina-100 relative overflow-hidden group">
                            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Invite & Earn') }}</h3>
                                    <p class="text-gray-600 max-w-md">
                                        {{ __('Share your referral code with friends! When they join Yasmina using your code, you will earn :points points.', ['points' => (int) \App\Models\PointSetting::getValue('referral_points', 50)]) }}
                                    </p>
                                </div>
                                <div class="bg-white p-4 rounded-3xl shadow-sm border border-yasmina-100 flex items-center gap-6 min-w-[250px]">
                                    <div class="flex-1">
                                        <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em] block mb-1">{{ __('Your Invite Code') }}</span>
                                        <div class="text-2xl font-black text-gray-900 tracking-widest">{{ $user->referral_code }}</div>
                                    </div>
                                    <button onclick="copyToClipboard('{{ $user->referral_code }}', this)" class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all group/btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="absolute -right-12 -top-12 w-48 h-48 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-all duration-500"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-6 bg-yasmina-50/50 rounded-3xl border border-yasmina-100">
                                <span class="text-xs font-bold text-primary uppercase tracking-widest block mb-2">{{ __('Full Name') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div class="p-6 bg-yasmina-50/50 rounded-3xl border border-yasmina-100">
                                <span class="text-xs font-bold text-primary uppercase tracking-widest block mb-2">{{ __('Email Address') }}</span>
                                <p class="text-lg font-bold text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div class="p-6 bg-yasmina-50/50 rounded-3xl border border-yasmina-100">
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
                                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }}">
                                                    {{ $order->status->label() }}
                                                </span>
                                                <span class="font-bold text-gray-900">{{ number_format($order->total, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</span>
                                                <a href="{{ route('web.profile.orders', ['vendor_id' => request('vendor_id')]) }}" class="text-gray-300 group-hover:text-primary transition-colors">
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

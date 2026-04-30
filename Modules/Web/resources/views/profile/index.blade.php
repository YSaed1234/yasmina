<x-web::layouts.master>
    <div class="py-6 lg:py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-web::profile-sidebar />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl p-4 lg:p-10 shadow-sm border border-yasmina-50">
                        <h1 class="text-xl lg:text-3xl font-bold text-gray-900 mb-6 lg:mb-8">{{ __('Account Overview') }}</h1>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-8 mb-8 lg:mb-12">
                            <!-- Points Card -->
                            <div class="p-5 lg:p-8 bg-primary rounded-[2rem] lg:rounded-[2.5rem] text-white shadow-xl shadow-primary/20 relative overflow-hidden group">
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4 lg:mb-6">
                                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl lg:rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-[8px] lg:text-[10px] font-black uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full">{{ __('Loyalty Points') }}</span>
                                    </div>
                                    <div class="text-2xl lg:text-4xl font-black mb-1 lg:mb-2">{{ number_format($user->points) }}</div>
                                    <p class="text-white/70 text-[10px] lg:text-sm font-medium mb-4 lg:mb-6">{{ __('Earn more points with every order!') }}</p>
                                    
                                    @php $minPoints = (int) \App\Models\PointSetting::getValue('min_points_to_convert', 100); @endphp
                                    @if($user->points >= $minPoints)
                                        <form action="{{ route('web.profile.convert-points', ['vendor_id' => request('vendor_id')]) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="number" name="points" max="{{ $user->points }}" min="{{ $minPoints }}" value="{{ $user->points }}" 
                                                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-xl outline-none text-xs lg:text-sm placeholder:text-white/40" placeholder="{{ __('Points to convert') }}">
                                            <button type="submit" class="px-4 py-2 bg-white text-primary rounded-xl font-bold text-[10px] lg:text-xs whitespace-nowrap hover:bg-yasmina-50 transition-colors">
                                                {{ __('Convert Now') }}
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-[8px] lg:text-[10px] text-white/50 italic">{{ __('Need at least :min points to convert to money.', ['min' => $minPoints]) }}</p>
                                    @endif
                                </div>
                                <div class="absolute -right-8 -bottom-8 w-32 h-32 lg:w-40 lg:h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-500"></div>
                            </div>

                            <!-- Wallet Card -->
                            <div class="p-5 lg:p-8 bg-gray-900 rounded-[2rem] lg:rounded-[2.5rem] text-white shadow-xl shadow-gray-900/10 relative overflow-hidden group">
                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4 lg:mb-6">
                                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl lg:rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-green-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <span class="text-[8px] lg:text-[10px] font-black uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full text-green-400">{{ __('Wallet Balance') }}</span>
                                    </div>
                                    <div class="text-2xl lg:text-4xl font-black mb-1 lg:mb-2">{{ number_format($user->balance, 2) }} <span class="text-[10px] lg:text-sm font-bold text-gray-500">{{ __('LE') }}</span></div>
                                    <p class="text-white/50 text-[10px] lg:text-sm font-medium">{{ __('Use your balance for future orders.') }}</p>
                                </div>
                                <div class="absolute -right-8 -bottom-8 w-32 h-32 lg:w-40 lg:h-40 bg-green-500/10 rounded-full blur-3xl group-hover:bg-green-500/20 transition-all duration-500"></div>
                            </div>
                        </div>

                        <!-- Referral Card -->
                        <div class="mb-8 lg:mb-12 p-5 lg:p-8 bg-yasmina-50 rounded-[2rem] lg:rounded-[2.5rem] border border-yasmina-100 relative overflow-hidden group">
                            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 lg:gap-8">
                                <div class="text-center md:text-left">
                                    <h3 class="text-lg lg:text-2xl font-bold text-gray-900 mb-1 lg:mb-2">{{ __('Invite & Earn') }}</h3>
                                    <p class="text-xs lg:text-sm text-gray-600 max-w-md">
                                        {{ __('Share your referral code with friends! When they join Yasmina using your code, you will earn :points points.', ['points' => (int) \App\Models\PointSetting::getValue('referral_points', 50)]) }}
                                    </p>
                                </div>
                                <div class="bg-white p-3 lg:p-4 rounded-2xl lg:rounded-3xl shadow-sm border border-yasmina-100 flex items-center gap-4 lg:gap-6 w-full md:w-auto md:min-w-[250px]">
                                    <div class="flex-1">
                                        <span class="text-[8px] lg:text-[10px] font-black text-primary uppercase tracking-[0.2em] block mb-0.5 lg:mb-1">{{ __('Your Invite Code') }}</span>
                                        <div class="text-xl lg:text-2xl font-black text-gray-900 tracking-widest">{{ $user->referral_code }}</div>
                                    </div>
                                    <button onclick="copyToClipboard('{{ $user->referral_code }}', this)" class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl lg:rounded-2xl bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all group/btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="absolute -right-12 -top-12 w-48 h-48 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-all duration-500"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-8">
                            <div class="p-4 lg:p-6 bg-yasmina-50/50 rounded-2xl lg:rounded-3xl border border-yasmina-100">
                                <span class="text-[10px] lg:text-xs font-bold text-primary uppercase tracking-widest block mb-1 lg:mb-2">{{ __('Full Name') }}</span>
                                <p class="text-sm lg:text-lg font-bold text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div class="p-4 lg:p-6 bg-yasmina-50/50 rounded-2xl lg:rounded-3xl border border-yasmina-100">
                                <span class="text-[10px] lg:text-xs font-bold text-primary uppercase tracking-widest block mb-1 lg:mb-2">{{ __('Email Address') }}</span>
                                <p class="text-sm lg:text-lg font-bold text-gray-900 truncate">{{ $user->email }}</p>
                            </div>
                            <div class="p-4 lg:p-6 bg-yasmina-50/50 rounded-2xl lg:rounded-3xl border border-yasmina-100 md:col-span-2 lg:col-span-1">
                                <span class="text-[10px] lg:text-xs font-bold text-primary uppercase tracking-widest block mb-1 lg:mb-2">{{ __('Phone Number') }}</span>
                                <p class="text-sm lg:text-lg font-bold text-gray-900">{{ $user->phone ?? __('Not Provided') }}</p>
                            </div>
                        </div>

                        <div class="mt-8 lg:mt-12">
                            <h3 class="text-lg lg:text-xl font-bold text-gray-900 mb-4 lg:mb-6">{{ __('Recent Orders') }}</h3>
                            @php $recentOrders = $user->orders()->latest()->take(3)->get(); @endphp
                            @if($recentOrders->count() > 0)
                                <div class="space-y-3 lg:space-y-4">
                                    @foreach($recentOrders as $order)
                                        <div class="p-4 lg:p-6 bg-white border border-gray-100 rounded-2xl lg:rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-primary transition-colors group">
                                            <div class="flex items-center gap-4 lg:gap-6">
                                                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl lg:rounded-2xl bg-gray-50 flex items-center justify-center text-primary font-bold text-xs lg:text-base">
                                                    #{{ $order->id }}
                                                </div>
                                                <div>
                                                    <p class="text-sm lg:text-base font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                                    <p class="text-xs lg:text-sm text-gray-500">{{ $order->items->count() }} {{ __('Items') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between sm:justify-end gap-4 lg:gap-8 border-t sm:border-t-0 pt-3 sm:pt-0">
                                                <span class="px-3 lg:px-4 py-1 rounded-full text-[8px] lg:text-[10px] font-black uppercase tracking-widest {{ $order->status->color() }}">
                                                    {{ $order->status->label() }}
                                                </span>
                                                <span class="text-sm lg:text-base font-bold text-gray-900">{{ number_format($order->total, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</span>
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
                                <div class="p-8 lg:p-10 bg-gray-50 rounded-2xl lg:rounded-3xl border-2 border-dashed border-gray-200 text-center">
                                    <p class="text-xs lg:text-sm text-gray-400">{{ __('No recent orders found.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

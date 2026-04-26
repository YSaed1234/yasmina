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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <!-- Points Card -->
                        <div class="bg-gradient-to-br from-yasmina-500 to-yasmina-700 rounded-[2.5rem] p-10 shadow-2xl shadow-yasmina-500/20 text-white relative overflow-hidden group">
                            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-500"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold">{{ __('My Points') }}</h3>
                                </div>
                                <p class="text-5xl font-black mb-2">{{ number_format($user->points) }}</p>
                                <p class="text-yasmina-100 text-sm font-medium">{{ __('Earned through purchases and referrals') }}</p>
                            </div>
                        </div>

                        <!-- Wallet Card -->
                        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-yasmina-50 relative overflow-hidden group">
                            <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-all duration-500"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-primary/5 flex items-center justify-center text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ __('Wallet Balance') }}</h3>
                                </div>
                                <p class="text-5xl font-black text-primary mb-2">{{ number_format($user->balance, 2) }} <span class="text-lg">LE</span></p>
                                <p class="text-gray-400 text-sm font-medium">{{ __('Use this balance at checkout') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Convert Points -->
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-yasmina-50 mb-12">
                        <div class="max-w-2xl">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Convert Points to Balance') }}</h3>
                            <p class="text-gray-500 mb-8">{{ __('Convert your hard-earned points into real money in your wallet. 1 point = :rate LE.', ['rate' => $rate]) }}</p>

                            <form action="{{ route('web.profile.convert-points') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                                @csrf
                                <div class="flex-1 relative">
                                    <input type="number" name="points" min="{{ $minPoints }}" max="{{ $user->points }}" class="w-full h-16 rounded-2xl border-gray-100 focus:border-primary focus:ring-primary ps-6 font-bold text-lg" placeholder="{{ __('Points to convert') }}" required>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        {{ __('Min') }}: {{ $minPoints }}
                                    </div>
                                </div>
                                <button type="submit" class="h-16 px-10 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-3">
                                    <span>{{ __('Convert Now') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- History Grid -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-12">
                        <!-- Wallet History -->
                        <div class="bg-white rounded-3xl p-10 shadow-sm border border-yasmina-50">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8">{{ __('Wallet History') }}</h3>
                            
                            <div class="space-y-4">
                                @forelse($walletTransactions as $transaction)
                                    <div class="flex items-center justify-between p-6 bg-gray-50/50 rounded-2xl border border-gray-50 hover:border-yasmina-100 transition-all">
                                        <div class="flex items-center gap-6">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $transaction->type === 'credit' ? 'bg-green-100 text-green-600' : 'bg-rose-100 text-rose-600' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transaction->type === 'credit' ? 'M12 4v16m8-8H4' : 'M20 12H4' }}" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm">{{ $transaction->description }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-widest">{{ $transaction->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-black {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-rose-600' }}">
                                                {{ $transaction->type === 'credit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                            </p>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-300">LE</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 text-center">
                                        <p class="text-gray-400 font-medium italic">{{ __('No wallet transactions yet.') }}</p>
                                    </div>
                                @endforelse
                            </div>

                            @if($walletTransactions->hasPages())
                                <div class="mt-10">
                                    {{ $walletTransactions->appends(['points_page' => $pointTransactions->currentPage()])->links() }}
                                </div>
                            @endif
                        </div>

                        <!-- Points History -->
                        <div class="bg-white rounded-3xl p-10 shadow-sm border border-yasmina-50">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8">{{ __('Points History') }}</h3>
                            
                            <div class="space-y-4">
                                @forelse($pointTransactions as $transaction)
                                    <div class="flex items-center justify-between p-6 bg-gray-50/50 rounded-2xl border border-gray-50 hover:border-yasmina-100 transition-all">
                                        <div class="flex items-center gap-6">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $transaction->points > 0 ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-600' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transaction->points > 0 ? 'M12 4v16m8-8H4' : 'M20 12H4' }}" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm">{{ $transaction->description ?: ($transaction->points > 0 ? __('Points Earned') : __('Points Spent')) }}</p>
                                                <p class="text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-widest">{{ $transaction->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-black {{ $transaction->points > 0 ? 'text-amber-600' : 'text-gray-600' }}">
                                                {{ $transaction->points > 0 ? '+' : '' }}{{ number_format($transaction->points) }}
                                            </p>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-gray-300">{{ __('Points') }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 text-center">
                                        <p class="text-gray-400 font-medium italic">{{ __('No point transactions yet.') }}</p>
                                    </div>
                                @endforelse
                            </div>

                            @if($pointTransactions->hasPages())
                                <div class="mt-10">
                                    {{ $pointTransactions->appends(['wallet_page' => $walletTransactions->currentPage()])->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

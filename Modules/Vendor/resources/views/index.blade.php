<x-vendor::layouts.master>
    <div class="mb-12">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">{{ __('Welcome back,') }} {{ auth('vendor')->user()->name }}</h1>
        <p class="text-gray-500 mt-2 text-lg">{{ __('Here is what is happening with your institution today.') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Sales Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-green-600 bg-green-50 px-3 py-1 rounded-full">{{ __('Total Revenue') }}</span>
            </div>
            <div class="text-4xl font-black text-gray-900 mb-2">{{ number_format($stats['total_sales'], 2) }} <span class="text-sm font-bold text-gray-400">LE</span></div>
            <p class="text-gray-400 text-sm font-medium">{{ __('Lifetime earnings from your products') }}</p>
        </div>

        <!-- Orders Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ __('Product Orders') }}</span>
            </div>
            <div class="text-4xl font-black text-gray-900 mb-2">{{ $stats['orders_count'] }}</div>
            <p class="text-gray-400 text-sm font-medium">{{ __('Total times your products were ordered') }}</p>
        </div>

        <!-- Products Card -->
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-orange-600 bg-orange-50 px-3 py-1 rounded-full">{{ __('Active Inventory') }}</span>
            </div>
            <div class="text-4xl font-black text-gray-900 mb-2">{{ $stats['products_count'] }}</div>
            <p class="text-gray-400 text-sm font-medium">{{ __('Products currently listed under your name') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm">
            <h3 class="text-xl font-bold text-gray-900 mb-8">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-2 gap-6">
                <button class="p-6 bg-primary/5 rounded-3xl border border-primary/10 hover:bg-primary/10 transition-all text-left group cursor-not-allowed">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-primary mb-4 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900 block">{{ __('Add Product') }}</span>
                    <span class="text-xs text-gray-400">{{ __('Create a new listing') }}</span>
                </button>
                <button class="p-6 bg-secondary/5 rounded-3xl border border-secondary/10 hover:bg-secondary/10 transition-all text-left group cursor-not-allowed">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-secondary mb-4 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900 block">{{ __('View Orders') }}</span>
                    <span class="text-xs text-gray-400">{{ __('Check customer requests') }}</span>
                </button>
            </div>
        </div>

        <div class="bg-gray-900 rounded-[3rem] p-10 text-white relative overflow-hidden group">
            <div class="relative z-10">
                <h3 class="text-xl font-bold mb-8">{{ __('Institution Info') }}</h3>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/50 uppercase tracking-widest">{{ __('Address') }}</p>
                            <p class="font-bold">{{ auth('vendor')->user()->address ?? __('Not specified') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/50 uppercase tracking-widest">{{ __('Phone') }}</p>
                            <p class="font-bold">{{ auth('vendor')->user()->phone ?? __('Not specified') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-primary/10 rounded-full blur-3xl group-hover:bg-primary/20 transition-all duration-500"></div>
        </div>
    </div>
</x-vendor::layouts.master>

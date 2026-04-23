<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Welcome back,') }} {{ auth('vendor')->user()->name }}</h1>
        <p class="text-gray-500">{{ __('Here is what is happening with your institution today.') }}</p>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Revenue -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Revenue') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_sales'], 2) }} <span class="text-sm font-bold text-gray-400">LE</span></p>
        </div>

        <!-- Orders -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Orders') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['orders_count'] }}</p>
        </div>

        <!-- Products -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-primary/10 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Active Products') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['products_count'] }}</p>
        </div>
    </div>

    <!-- Quick Actions / Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('vendor.products.create') }}" class="flex flex-col items-center justify-center p-6 bg-primary/5 rounded-3xl hover:bg-primary/10 transition-all group border border-primary/10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-primary mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">{{ __('Add Product') }}</span>
                </a>
                <a href="{{ route('vendor.orders.index') }}" class="flex flex-col items-center justify-center p-6 bg-primary/5 rounded-3xl hover:bg-primary/10 transition-all group border border-primary/10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-primary mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">{{ __('View Orders') }}</span>
                </a>
            </div>
        </div>

        <div class="bg-primary p-10 rounded-[3rem] shadow-xl shadow-primary/20 text-white flex flex-col justify-between relative overflow-hidden group">
            <div class="relative z-10">
                <h3 class="text-2xl font-bold mb-4">{{ __('Institution Status') }}</h3>
                <p class="text-white/80 leading-relaxed mb-6">{{ __('Your institution is currently active. You can manage your products and track sales directly from this panel.') }}</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ auth('vendor')->user()->address ?? __('No address set') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm font-medium">{{ auth('vendor')->user()->phone ?? __('No phone set') }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-500"></div>
        </div>
    </div>
</x-vendor::layouts.master>

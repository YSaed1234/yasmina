<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('Dashboard Overview') }}</h1>
        <p class="text-gray-500">{{ __('Welcome back! Here is what is happening with your store today.') }}</p>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
        <!-- Products -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-3 py-1 rounded-full">+12%</span>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Products') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['products_count'] }}</p>
        </div>

        <!-- Categories -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Categories') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['categories_count'] }}</p>
        </div>

        <!-- Orders -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-blue-500 bg-blue-50 px-3 py-1 rounded-full">{{ __('New') }}</span>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Orders') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['orders_count'] }}</p>
        </div>

        <!-- Users -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Total Users') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['users_count'] }}</p>
        </div>

        <!-- Coupons -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Active Coupons') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['coupons_count'] }}</p>
        </div>

        <!-- Contact Requests -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-50 hover:shadow-xl hover:shadow-yasmina-100/50 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:bg-yasmina-500 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">{{ __('Contact Requests') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ $stats['contact_requests_count'] }}</p>
        </div>
    </div>

    <!-- Quick Actions / Recent Activity Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-yasmina-50">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl hover:bg-yasmina-50 transition-all group border border-yasmina-50">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-yasmina-500 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">{{ __('Add Product') }}</span>
                </a>
                <a href="{{ route('admin.coupons.create') }}" class="flex flex-col items-center justify-center p-6 bg-yasmina-50/50 rounded-3xl hover:bg-yasmina-50 transition-all group border border-yasmina-50">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-yasmina-500 mb-3 shadow-sm group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700">{{ __('Create Coupon') }}</span>
                </a>
            </div>
        </div>

        <div class="bg-yasmina-500 p-10 rounded-[3rem] shadow-xl shadow-yasmina-100 text-white flex flex-col justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-4">{{ __('Store Status') }}</h3>
                <p class="text-yasmina-100 leading-relaxed">{{ __('Your store is currently live and performing well. We have detected a growth in user engagement this week.') }}</p>
            </div>
            <div class="mt-8">
                <a href="/" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-yasmina-600 rounded-2xl font-bold hover:bg-yasmina-50 transition-all">
                    {{ __('View Storefront') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-admin::layouts.master>

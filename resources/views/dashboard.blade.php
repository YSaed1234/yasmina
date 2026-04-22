<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Dashboard') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Welcome back! Here is an overview of your store.') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Stats Card: Categories -->
        <div class="bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50 hover:border-yasmina-200 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-yasmina-400 uppercase tracking-widest">{{ __('Categories') }}</span>
            </div>
            <h3 class="text-4xl font-black text-gray-800 mb-2">{{ \App\Models\Category::count() }}</h3>
            <a href="{{ route('categories.index') }}" class="text-sm font-bold text-yasmina-500 hover:text-yasmina-600 flex items-center gap-1">
                {{ __('Manage Categories') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Stats Card: Products -->
        <div class="bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50 hover:border-yasmina-200 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-yasmina-400 uppercase tracking-widest">{{ __('Products') }}</span>
            </div>
            <h3 class="text-4xl font-black text-gray-800 mb-2">{{ \App\Models\Product::count() }}</h3>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-yasmina-500 hover:text-yasmina-600 flex items-center gap-1">
                {{ __('Manage Products') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Stats Card: Currencies -->
        <div class="bg-white/70 backdrop-blur-md p-8 rounded-3xl border border-yasmina-50 shadow-xl shadow-yasmina-100/50 hover:border-yasmina-200 transition-all group">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-yasmina-50 rounded-2xl flex items-center justify-center text-yasmina-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-yasmina-400 uppercase tracking-widest">{{ __('Currencies') }}</span>
            </div>
            <h3 class="text-4xl font-black text-gray-800 mb-2">{{ \App\Models\Currency::count() }}</h3>
            <a href="{{ route('currencies.index') }}" class="text-sm font-bold text-yasmina-500 hover:text-yasmina-600 flex items-center gap-1">
                {{ __('Manage Currencies') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-yasmina-50/50 p-10 rounded-[3rem] border-2 border-dashed border-yasmina-100 text-center relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-yasmina-100/50 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -top-10 w-40 h-40 bg-yasmina-100/50 rounded-full blur-3xl"></div>
        
        <h4 class="text-2xl font-black text-yasmina-800 relative z-10">{{ __('Welcome to Yasmina Storefront!') }}</h4>
        <p class="text-yasmina-600 mt-3 text-lg relative z-10">{{ __('Everything you need to manage your luxury brand is right here at your fingertips.') }}</p>
        
        <div class="mt-8 relative z-10">
            <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-yasmina-500 text-white rounded-2xl font-bold hover:bg-yasmina-600 transition-all shadow-xl shadow-yasmina-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ __('Preview Live Store') }}
            </a>
        </div>
    </div>
</x-admin::layouts.master>

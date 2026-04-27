<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Traffic Analytics') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Real-time insights into how visitors are interacting with your institution.') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 group hover:border-primary transition-all">
            <div class="p-4 bg-primary/10 text-primary rounded-2xl group-hover:bg-primary group-hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Total Views') }}</p>
                <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_views']) }}</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 group hover:border-blue-500 transition-all">
            <div class="p-4 bg-blue-50 text-blue-500 rounded-2xl group-hover:bg-blue-500 group-hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Unique Visitors') }}</p>
                <p class="text-3xl font-black text-gray-900">{{ number_format($stats['unique_visitors']) }}</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center gap-6 group hover:border-emerald-500 transition-all">
            <div class="p-4 bg-emerald-50 text-emerald-500 rounded-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Conversion Rate') }}</p>
                <p class="text-3xl font-black text-gray-900">{{ $stats['conversion_rate'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-primary/5 p-12 rounded-[3rem] border border-primary/10 text-center">
        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('Traffic Insights') }}</h3>
        <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
            {{ __('These stats represent live interactions with your products on the Yasmina storefront. High views with low conversion might suggest adjusting prices or improving product descriptions.') }}
        </p>
    </div>
</x-vendor::layouts.master>

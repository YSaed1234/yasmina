<x-admin::layouts.master>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Traffic Report') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Track visitor engagement and store performance metrics.') }}</p>
        </div>

        @if(!auth()->user()->vendor_id)
            <div class="flex flex-col md:flex-row items-center gap-4">
                <form action="{{ route('admin.traffic.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-yasmina-100">
                    <input type="text" name="vendor_search" value="{{ $vendorSearch }}" placeholder="{{ __('Search Institution...') }}" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-700 w-48">
                    <button type="submit" class="p-2 bg-yasmina-50 text-yasmina-600 rounded-xl hover:bg-primary hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if($vendorSearch)
                        <a href="{{ route('admin.traffic.index') }}" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>

                <form action="{{ route('admin.traffic.index') }}" method="GET" class="flex items-center gap-4 bg-white p-3 rounded-2xl shadow-sm border border-yasmina-100">
                    <select name="vendor_id" onchange="this.form.submit()" class="bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-700 min-w-[200px]">
                        <option value="">{{ __('Filter by Institution') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $vendorId == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                    @if($vendorId)
                        <a href="{{ route('admin.traffic.index') }}" class="text-xs text-red-500 font-bold hover:underline px-2">{{ __('Reset') }}</a>
                    @endif
                </form>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 transition-all group-hover:scale-110"></div>
            <p class="text-xs font-black text-yasmina-400 uppercase tracking-[0.2em] mb-4">{{ __('Total Views') }}</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-4xl font-black text-gray-900">{{ number_format($stats['total_views']) }}</h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 transition-all group-hover:scale-110"></div>
            <p class="text-xs font-black text-yasmina-400 uppercase tracking-[0.2em] mb-4">{{ __('Unique Visitors') }}</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-4xl font-black text-gray-900">{{ number_format($stats['unique_visitors']) }}</h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-yasmina-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 transition-all group-hover:scale-110"></div>
            <p class="text-xs font-black text-yasmina-400 uppercase tracking-[0.2em] mb-4">{{ __('Conversion Rate') }}</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-4xl font-black text-gray-900">{{ $stats['conversion_rate'] }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-yasmina-50/50 border-2 border-dashed border-yasmina-200 rounded-[3rem] p-20 flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center text-primary mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Detailed Traffic Analytics') }}</h2>
        <p class="text-gray-500 max-w-md mx-auto">{{ __('We are currently integrating with advanced tracking services to provide you with heatmaps and deep visitor behavior insights.') }}</p>
    </div>
</x-admin::layouts.master>

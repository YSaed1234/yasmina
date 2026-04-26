@php
    $currentVendor = request()->attributes->get('current_vendor');
@endphp
<x-web::layouts.master>
    <div class="bg-bg-soft min-h-screen pb-20">
        <!-- Hero Section -->
        <div class="relative bg-primary py-24 overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 uppercase tracking-widest">{{ __('Exclusive Promotions') }}</h1>
                <p class="text-white/80 text-lg max-w-2xl mx-auto font-medium">
                    {{ __('Discover our best deals and buy-one-get-one offers curated just for you.') }}
                </p>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
            <div class="bg-white rounded-3xl shadow-2xl shadow-primary/10 p-8 border border-yasmina-50">
                <form action="{{ route('web.promotions.index', ['vendor_id' => request('vendor_id')]) }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    @if(request('vendor_id'))
                        <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                    @endif
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider px-1">{{ __('Search Deals') }}</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="{{ __('Search by name...') }}" 
                                   class="w-full bg-yasmina-50/50 border-2 border-transparent focus:border-primary/20 rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-700">
                            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-primary hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider px-1">{{ __('Offer Type') }}</label>
                        <select name="type" onchange="this.form.submit()" 
                                class="w-full bg-yasmina-50/50 border-2 border-transparent focus:border-primary/20 rounded-2xl px-6 py-4 outline-none transition-all font-medium text-gray-700 appearance-none cursor-pointer">
                            <option value="">{{ __('All Offers') }}</option>
                            <option value="bogo" {{ request('type') == 'bogo' ? 'selected' : '' }}>{{ __('BOGO (Buy 1 Get 1)') }}</option>
                            <option value="bundle" {{ request('type') == 'bundle' ? 'selected' : '' }}>{{ __('Bundle Deals') }}</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-primary text-white rounded-2xl px-8 py-4 font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            {{ __('Apply Filters') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Promotions Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
            @if($promotions->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-yasmina-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('No Promotions Found') }}</h3>
                    <p class="text-gray-500">{{ __('Try adjusting your search or filters to find what you\'re looking for.') }}</p>
                    <a href="{{ route('web.promotions.index', ['vendor_id' => request('vendor_id')]) }}" class="inline-block mt-8 text-primary font-bold hover:underline">
                        {{ __('Clear all filters') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($promotions as $promotion)
                        <a href="{{ route('web.promotions.show', ['id' => $promotion->id, 'vendor_id' => request('vendor_id')]) }}" 
                           class="group bg-white rounded-[2.5rem] overflow-hidden border border-yasmina-50 hover:shadow-2xl hover:shadow-primary/10 transition-all duration-500 hover:-translate-y-2">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                @if($promotion->buyProduct && $promotion->buyProduct->image)
                                    <img src="{{ asset('storage/' . $promotion->buyProduct->image) }}" alt="{{ $promotion->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-yasmina-50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 012-2V6a2 2 0 01-2-2H6a2 2 0 01-2 2v12a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Badge -->
                                <div class="absolute top-6 left-6">
                                    <span class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full shadow-lg">
                                        {{ $promotion->type == 'bogo' ? __('BOGO') : __('Bundle') }}
                                    </span>
                                </div>

                                @if($promotion->expires_at)
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <div class="bg-white/90 backdrop-blur-md rounded-2xl p-3 flex items-center justify-center gap-4 text-primary font-bold shadow-xl" 
                                             data-countdown="{{ $promotion->expires_at }}">
                                            <div class="text-center">
                                                <span class="days block text-lg leading-none">00</span>
                                                <span class="text-[8px] uppercase opacity-60">{{ __('Days') }}</span>
                                            </div>
                                            <div class="w-px h-6 bg-primary/20"></div>
                                            <div class="text-center">
                                                <span class="hours block text-lg leading-none">00</span>
                                                <span class="text-[8px] uppercase opacity-60">{{ __('Hrs') }}</span>
                                            </div>
                                            <div class="w-px h-6 bg-primary/20"></div>
                                            <div class="text-center">
                                                <span class="minutes block text-lg leading-none">00</span>
                                                <span class="text-[8px] uppercase opacity-60">{{ __('Min') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors line-clamp-1 uppercase tracking-tight">
                                    {{ $promotion->name }}
                                </h3>
                                <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed">
                                    {{ $promotion->description }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Deal Type') }}</span>
                                        <span class="text-primary font-bold">
                                            @if($promotion->type == 'bogo')
                                                {{ __('Buy 1 Get 1 Free') }}
                                            @else
                                                {{ __('Special Bundle') }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16">
                    {{ $promotions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-web::layouts.master>

<div class="bg-white rounded-3xl p-8 shadow-sm border border-yasmina-50 sticky top-24">
    <div class="text-center mb-8">
        <div class="w-24 h-24 rounded-full overflow-hidden mx-auto mb-4 border-4 border-white shadow-lg">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-primary/10 flex items-center justify-center text-primary font-bold text-3xl">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
            @endif
        </div>
        <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
        
        <div class="mt-4 flex flex-wrap justify-center gap-2">
            <div class="px-3 py-1 bg-primary/10 rounded-full flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-[10px] font-bold text-primary">{{ number_format(auth()->user()->points) }}</span>
            </div>
            <div class="px-3 py-1 bg-gray-100 rounded-full flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span class="text-[10px] font-bold text-gray-700">{{ number_format(auth()->user()->balance, 2) }} LE</span>
            </div>
        </div>
    </div>

    <nav class="space-y-2">
        <a href="{{ route('web.profile', ['vendor_id' => request('vendor_id')]) }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-yasmina-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="font-bold text-sm">{{ __('Personal Details') }}</span>
        </a>
        <a href="{{ route('web.profile.orders', ['vendor_id' => request('vendor_id')]) }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile.orders') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-yasmina-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="font-bold text-sm">{{ __('My Orders') }}</span>
        </a>
        <a href="{{ route('web.wishlist', ['vendor_id' => request('vendor_id')]) }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.wishlist') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-yasmina-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span class="font-bold text-sm">{{ __('My Favorites') }}</span>
        </a>
        <a href="{{ route('web.profile.addresses', ['vendor_id' => request('vendor_id')]) }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile.addresses') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-yasmina-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-bold text-sm">{{ __('My Addresses') }}</span>
        </a>
        
        <div class="pt-4 mt-4 border-t border-yasmina-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all text-gray-400 hover:bg-red-50 hover:text-red-500 w-full text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="font-bold text-sm">{{ __('Logout') }}</span>
                </button>
            </form>
        </div>
    </nav>
</div>

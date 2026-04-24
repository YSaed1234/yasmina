<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? __('Vendor Panel') }} - Yasmina</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
        
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            yasmina: {
                                50: 'var(--yasmina-50)',
                                100: 'var(--yasmina-100)',
                                200: 'var(--yasmina-200)',
                                300: 'var(--yasmina-300)',
                                400: 'var(--yasmina-400)',
                                500: 'var(--yasmina-500)',
                                600: 'var(--yasmina-600)',
                                700: 'var(--yasmina-700)',
                                800: 'var(--yasmina-800)',
                                900: 'var(--yasmina-900)',
                            },
                            primary: 'var(--yasmina-500)',
                            'primary-hover': 'var(--yasmina-600)',
                            secondary: 'var(--yasmina-400)',
                            'bg-soft': 'var(--yasmina-50)',
                        },
                        fontFamily: {
                            sans: ['Outfit', 'Tajawal', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <style>
            :root {
                /* Yasmina Rose (Default) */
                --yasmina-50: #fdf8f7;
                --yasmina-100: #f9eded;
                --yasmina-200: #f2d8d5;
                --yasmina-300: #e5bcba;
                --yasmina-400: #d6a6a1;
                --yasmina-500: #865d58;
                --yasmina-600: #75514c;
                --yasmina-700: #634541;
                --yasmina-800: #523a37;
                --yasmina-900: #422f2c;
            }

            [data-theme="barbie"] {
                --yasmina-50: #fff0f7;
                --yasmina-100: #ffe4f2;
                --yasmina-200: #ffc9e7;
                --yasmina-300: #ff9ed1;
                --yasmina-400: #ff64b1;
                --yasmina-500: #e0218a;
                --yasmina-600: #c2146e;
                --yasmina-700: #a20e58;
                --yasmina-800: #86104a;
                --yasmina-900: #701140;
            }
            body {
                background-color: var(--yasmina-50);
                font-family: 'Outfit', 'Tajawal', sans-serif;
            }
        </style>
        @stack('styles')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="antialiased">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-72 bg-white border-e border-gray-100 flex flex-col fixed inset-y-0 start-0 h-full z-40">
                <div class="p-8 border-b border-gray-50 flex items-center gap-4">
                    @if(auth('vendor')->user()->logo)
                        <img src="{{ asset('storage/' . auth('vendor')->user()->logo) }}" alt="Logo" class="w-12 h-12 rounded-2xl object-cover shadow-sm">
                    @else
                        <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="font-bold text-gray-900 truncate max-w-[150px]">{{ auth('vendor')->user()->name }}</h2>
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary">{{ __('Vendor Panel') }}</span>
                    </div>
                </div>

                <div class="px-6 pb-2">
                    <a href="{{ route('web.shop', ['vendor_id' => auth('vendor')->user()->slug ?? auth('vendor')->id()]) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl transition-all bg-primary/5 text-primary hover:bg-primary hover:text-white font-bold text-xs border border-primary/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ __('View Store') }}
                    </a>
                </div>

                <nav class="flex-1 p-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.dashboard') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>

                    <a href="{{ route('vendor.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.categories.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        {{ __('Categories') }}
                    </a>

                    <a href="{{ route('vendor.sliders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.sliders.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ __('Homepage Sliders') }}
                    </a>

                    <div class="pt-4 pb-2 px-4">
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ __('Management') }}</span>
                    </div>

                    <a href="{{ route('vendor.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.products.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        {{ __('Our Products') }}
                    </a>

                    <a href="{{ route('vendor.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.orders.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        {{ __('Orders') }}
                    </a>

                    <a href="{{ route('vendor.shipping.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.shipping.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Shipping Rates') }}
                    </a>

                    <a href="{{ route('vendor.contacts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.contacts.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('Contact Requests') }}
                    </a>

                    <a href="{{ route('vendor.finances.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.finances.*') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Finances') }}
                    </a>
                </nav>

                <div class="p-6 border-t border-gray-50">
                    <form method="POST" action="{{ route('vendor.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-500 hover:bg-red-50 transition-all font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ms-72 relative">
                <!-- Header -->
                <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-30 backdrop-blur-md bg-white/80">
                    <div class="flex items-center gap-4">
                        <h2 class="text-xl font-black text-gray-900 tracking-tight">{{ auth('vendor')->user()->name }}</h2>
                    </div>

                    <div class="flex items-center gap-6">
                        <!-- Theme Switcher -->
                        <div class="flex items-center bg-gray-50 rounded-2xl p-1 shadow-sm border border-gray-100">
                            <button onclick="changeTheme('yasmina')" class="p-1.5 rounded-xl transition-all hover:bg-white group" title="Yasmina Rose">
                                <div class="w-4 h-4 rounded-lg" style="background: linear-gradient(to right, #865d58, #d6a6a1);"></div>
                            </button>
                            <button onclick="changeTheme('barbie')" class="p-1.5 rounded-xl transition-all hover:bg-white group" title="Barbie Pink">
                                <div class="w-4 h-4 rounded-lg" style="background: linear-gradient(to right, #e0218a, #ff64b1);"></div>
                            </button>
                        </div>

                        <!-- Language Switcher -->
                        <div class="flex items-center bg-gray-50 rounded-2xl p-1 shadow-sm border border-gray-100">
                            <a href="{{ route('lang.switch', 'en') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary' }}">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'ar' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary' }}">AR</a>
                        </div>

                        <div class="relative border-s border-gray-100 ps-6" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-2xl transition-all">
                                <div class="flex flex-col items-end rtl:items-start">
                                    <span class="text-sm font-bold text-gray-900">{{ auth('vendor')->user()->name }}</span>
                                    <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">{{ __('Institution Admin') }}</span>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-black shadow-lg shadow-primary/20">
                                    {{ substr(auth('vendor')->user()->name, 0, 1) }}
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 class="absolute end-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                                 <a href="{{ route('vendor.profile.edit') }}" class="w-full text-left rtl:text-right px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors block">
                                    {{ __('Edit Profile') }}
                                </a>
                                <form method="POST" action="{{ route('vendor.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left rtl:text-right px-4 py-2 text-sm font-bold text-red-500 hover:bg-red-50 transition-colors">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Content Area -->
                <div class="p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function changeTheme(themeName) {
                document.documentElement.setAttribute('data-theme', themeName);
                localStorage.setItem('yasmina-theme', themeName);
            }

            // Load saved theme
            const savedTheme = localStorage.getItem('yasmina-theme') || 'yasmina';
            document.documentElement.setAttribute('data-theme', savedTheme);

            function initCountdown() {
                const timers = document.querySelectorAll('[data-countdown]');
                timers.forEach(timer => {
                    const target = new Date(timer.dataset.countdown).getTime();
                    
                    const update = () => {
                        const now = new Date().getTime();
                        const diff = target - now;
                        
                        if (diff <= 0) {
                            timer.innerHTML = '{{ __("Offer Ended") }}';
                            return;
                        }
                        
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        
                        if(timer.querySelector('.days')) timer.querySelector('.days').innerText = String(days).padStart(2, '0');
                        if(timer.querySelector('.hours')) timer.querySelector('.hours').innerText = String(hours).padStart(2, '0');
                        if(timer.querySelector('.minutes')) timer.querySelector('.minutes').innerText = String(minutes).padStart(2, '0');
                        if(timer.querySelector('.seconds')) timer.querySelector('.seconds').innerText = String(seconds).padStart(2, '0');
                    };
                    
                    update();
                    setInterval(update, 1000);
                });
            }
            
            document.addEventListener('DOMContentLoaded', initCountdown);
        </script>
        @stack('scripts')
    </body>
</html>

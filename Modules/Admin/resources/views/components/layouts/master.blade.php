<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                            'primary-soft': 'var(--yasmina-50)',
                        }
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
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>

    <body class="bg-yasmina-50/30">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-x border-yasmina-100 shadow-sm flex flex-col h-screen sticky top-0">
                <div class="p-6 border-b border-yasmina-50 flex items-center justify-center">
                    <img src="{{ asset('assets/logo.png') }}" alt="{{ __('Yasmina Admin') }}" class="h-12 w-auto">
                </div>
                <nav class="mt-6 px-4 space-y-2 flex-1">
                    <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.index') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                    
                    @canany([ 'manage categories'])
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('categories.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{ __('Categories') }}
                    </a>
                    @endcanany

                    @canany([ 'manage products'])
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('products.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        {{ __('Products') }}
                    </a>
                    @endcanany

                    @canany([ 'manage currencies'])
                    <a href="{{ route('currencies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('currencies.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Currencies') }}
                    </a>
                    @endcanany

                    @can('manage users')
                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('users.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        {{ __('Users') }}
                    </a>
                    @endcan

                    @can('manage addresses')
                    <a href="{{ route('addresses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('addresses.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Addresses') }}
                    </a>
                    @endcan

                    @can('manage permissions')
                    <a href="{{ route('roles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('roles.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        {{ __('Roles & Permissions') }}
                    </a>
                    @endcan

                    @can('manage orders')
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('orders.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        {{ __('Orders') }}
                    </a>
                    @endcan

                    @can('manage contact requests')
                    <a href="{{ route('contact_requests.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('contact_requests.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('Contact Requests') }}
                    </a>
                    @endcan

                    @can('manage coupons')
                    <a href="{{ route('coupons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('coupons.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ __('Coupons') }}
                    </a>
                    @endcan

                    @can('manage shipping')
                    <a href="{{ route('governorates.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('governorates.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Governorates') }}
                    </a>
                    <a href="{{ route('regions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('regions.*') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.491V6.509a2 2 0 011.553-1.943L9 3m0 17l6-3m-6 3V3m6 14l5.447 2.724A2 2 0 0021 17.509V8.509a2 2 0 00-1.553-1.943L15 3m0 17V3" />
                        </svg>
                        {{ __('Regions & Shipping') }}
                    </a>
                    <a href="{{ route('admin.settings.points') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.settings.points') ? 'bg-yasmina-50 text-yasmina-600 font-bold' : 'text-gray-600 hover:bg-yasmina-50/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Points Settings') }}
                    </a>
                    @endcan
                </nav>

                <div class="p-4 border-t border-yasmina-50">
                    <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-2xl text-white bg-primary hover:opacity-90 transition-all shadow-lg shadow-primary/20 font-bold w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Back to Site') }}
                    </a>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                <header class="bg-white border-b border-yasmina-50 h-20 flex items-center justify-between px-10 sticky top-0 z-50 backdrop-blur-md bg-white/80 shrink-0">
                    <div class="flex items-center gap-4">
                        <h2 class="text-xl font-bold text-gray-800">{{ env('APP_NAME') }}</h2>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <!-- Theme Switcher -->
                        <div class="flex items-center bg-yasmina-50 rounded-2xl p-1 shadow-sm border border-yasmina-100">
                            <button onclick="changeTheme('yasmina')" class="p-1.5 rounded-xl transition-all hover:bg-white group" title="Yasmina Rose">
                                <div class="w-4 h-4 rounded-lg" style="background: linear-gradient(to right, #865d58, #d6a6a1);"></div>
                            </button>
                            <button onclick="changeTheme('barbie')" class="p-1.5 rounded-xl transition-all hover:bg-white group" title="Barbie Pink">
                                <div class="w-4 h-4 rounded-lg" style="background: linear-gradient(to right, #e0218a, #ff64b1);"></div>
                            </button>
                        </div>

                        <!-- Language Switcher -->
                        <div class="flex items-center bg-yasmina-50 rounded-2xl p-1 shadow-sm border border-yasmina-100">
                            <a href="{{ route('lang.switch', 'en') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-yasmina-600 shadow-sm' : 'text-gray-500 hover:text-yasmina-500' }}">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'ar' ? 'bg-white text-yasmina-600 shadow-sm' : 'text-gray-500 hover:text-yasmina-500' }}">AR</a>
                        </div>

                        <div class="relative border-s border-yasmina-100 ps-6" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-yasmina-50 p-2 rounded-2xl transition-all">
                                <div class="flex flex-col items-end">
                                    <span class="text-sm font-bold text-gray-800">{{ auth('admin')->user()->name }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-widest">{{ __('Administrator') }}</span>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-yasmina-500 flex items-center justify-center text-white font-bold shadow-lg shadow-yasmina-100">
                                    {{ substr(auth('admin')->user()->name, 0, 1) }}
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-3xl shadow-2xl border border-yasmina-50 p-2 z-[60]"
                                 style="display: none;">
                                
                                <div class="px-4 py-3 border-b border-yasmina-50 mb-2">
                                    <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">{{ __('Signed in as') }}</p>
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ auth('admin')->user()->email }}</p>
                                </div>

                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50 rounded-2xl transition-all">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </div>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>
                
                <main class="flex-1 overflow-y-auto p-10 relative">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-yasmina-100 rounded-full opacity-10 blur-3xl -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-yasmina-200 rounded-full opacity-10 blur-3xl -ml-32 -mb-32"></div>
                    
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        <script>
            function changeTheme(themeName) {
                document.documentElement.setAttribute('data-theme', themeName);
                localStorage.setItem('yasmina-theme', themeName);
            }

            // Load saved theme
            const savedTheme = localStorage.getItem('yasmina-theme') || 'yasmina';
            document.documentElement.setAttribute('data-theme', savedTheme);
        </script>
        @stack('scripts')
    </body>
</html>

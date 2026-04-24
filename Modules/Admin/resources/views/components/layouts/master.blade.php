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
                    <!-- Catalog Management -->
                    <div x-data="{ open: {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.vendors.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl transition-all text-gray-600 hover:bg-yasmina-50/50">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Catalog') }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 space-y-1 px-4">
                            @can('manage categories')
                                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.categories.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Categories') }}
                                </a>
                            @endcan
                            @can('manage products')
                                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.products.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ auth()->user()->vendor_id ? __('Your Items') : __('Products') }}
                                </a>
                            @endcan
                            @can('manage vendors')
                                <a href="{{ route('admin.vendors.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.vendors.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Vendors') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Sales Management -->
                    <div x-data="{ open: {{ request()->routeIs('admin.orders.*') || request()->routeIs('admin.coupons.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl transition-all text-gray-600 hover:bg-yasmina-50/50">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Sales') }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 space-y-1 px-4">
                            @can('manage orders')
                                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.orders.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Orders') }}
                                </a>
                            @endcan
                            @can('manage coupons')
                                <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.coupons.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Coupons') }}
                                </a>
                                <a href="{{ route('admin.promotions.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.promotions.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Promotions') }}
                                </a>
                            @endcan
                            @can('manage vendors')
                                <a href="{{ route('admin.finances.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.finances.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Financial Reports') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Customers -->
                    <div x-data="{ open: {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.addresses.*') || request()->routeIs('admin.contact_requests.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl transition-all text-gray-600 hover:bg-yasmina-50/50">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Customers') }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 space-y-1 px-4">
                            @can('manage users')
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.users.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Users List') }}
                                </a>
                            @endcan
                            @can('manage addresses')
                                <a href="{{ route('admin.addresses.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.addresses.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Addresses') }}
                                </a>
                            @endcan
                            @can('manage contact requests')
                                <a href="{{ route('admin.contact_requests.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.contact_requests.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Contact Requests') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div x-data="{ open: {{ request()->routeIs('admin.governorates.*') || request()->routeIs('admin.regions.*') || request()->routeIs('admin.shipping_zones.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl transition-all text-gray-600 hover:bg-yasmina-50/50">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Shipping') }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 space-y-1 px-4">
                            @can('manage shipping')
                                <a href="{{ route('admin.governorates.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.governorates.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Governorates') }}
                                </a>
                                <a href="{{ route('admin.regions.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.regions.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Regions') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Appearance & Content -->
                    <div x-data="{ open: {{ request()->routeIs('admin.slides.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl transition-all text-gray-600 hover:bg-yasmina-50/50">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Appearance') }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 space-y-1 px-4">
                            @can('manage slides')
                                <a href="{{ route('admin.slides.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.slides.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Slider Settings') }}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- System Settings -->
                    <div x-data="{ open: {{ request()->routeIs('admin.currencies.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl transition-all text-gray-600 hover:bg-yasmina-50/50">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Settings') }}</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-1 space-y-1 px-4">
                            @can('manage currencies')
                                <a href="{{ route('admin.currencies.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.currencies.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Currencies') }}
                                </a>
                            @endcan
                            @can('manage permissions')
                                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.roles.*') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Permissions') }}
                                </a>
                            @endcan
                            @can('manage points')
                                <a href="{{ route('admin.settings.points') }}" class="flex items-center gap-3 px-4 py-2 rounded-xl text-xs transition-all {{ request()->routeIs('admin.settings.points') ? 'text-yasmina-600 font-bold' : 'text-gray-500 hover:text-yasmina-500' }}">
                                    • {{ __('Points Settings') }}
                                </a>
                            @endcan
                        </div>
                    </div>
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

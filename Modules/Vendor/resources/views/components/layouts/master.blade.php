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
                            primary: '#865d58',
                            'primary-hover': '#75514c',
                            secondary: '#d6a6a1',
                            'bg-soft': '#fdf8f7',
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
                --yasmina-primary: #865d58;
                --yasmina-secondary: #d6a6a1;
                --yasmina-bg-soft: #fdf8f7;
            }
            body {
                background-color: #f8fafc;
                font-family: 'Outfit', 'Tajawal', sans-serif;
            }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-72 bg-white border-r border-gray-100 flex flex-col fixed h-full z-40">
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

                <nav class="flex-1 p-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('vendor.dashboard') ? 'bg-primary text-white font-bold shadow-lg shadow-primary/20' : 'text-gray-500 hover:bg-gray-50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>

                    <div class="pt-4 pb-2 px-4">
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ __('Management') }}</span>
                    </div>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-400 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        {{ __('Our Products') }}
                    </a>

                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-400 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        {{ __('Orders') }}
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
            <main class="flex-1 ml-72 relative">
                <!-- Header -->
                <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-30">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary font-bold">
                            {{ substr(auth('vendor')->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ auth('vendor')->user()->name }}</p>
                            <p class="text-[10px] text-gray-400 font-medium">{{ auth('vendor')->user()->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-50 transition-all">
                            {{ __('Visit Store') }}
                        </a>
                    </div>
                </header>

                <!-- Content Area -->
                <div class="p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
    </body>
</html>

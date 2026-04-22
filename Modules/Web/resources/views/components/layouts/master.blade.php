<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Yasmina - Luxury Store')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: 'var(--yasmina-primary)',
                            'primary-hover': 'var(--yasmina-primary-hover)',
                            secondary: 'var(--yasmina-secondary)',
                            'bg-soft': 'var(--yasmina-bg-soft)',
                        },
                        fontFamily: {
                            outfit: ['Outfit', 'Tajawal', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <style>
            :root {
                --yasmina-primary: #865d58;
                --yasmina-primary-hover: #75514c;
                --yasmina-secondary: #d6a6a1;
                --yasmina-bg-soft: #fdf8f7;
            }

            [data-theme="barbie"] {
                --yasmina-primary: #e0218a;
                --yasmina-primary-hover: #c2146e;
                --yasmina-secondary: #ff64b1;
                --yasmina-bg-soft: #fffafb;
            }

            body {
                font-family: 'Outfit', 'Tajawal', sans-serif;
                background-color: var(--yasmina-bg-soft);
            }

            .soft-shadow {
                box-shadow: 0 20px 40px -15px rgba(134, 93, 88, 0.1);
            }
        </style>
    </head>
    <body class="antialiased text-gray-900 transition-colors duration-500">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-rose-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo.png') }}" alt="Yasmina Logo" class="h-16 w-auto object-contain">
                    </a>
                    
                    <div class="hidden md:flex gap-8 text-sm font-bold uppercase tracking-widest text-gray-600 items-center">
                        <a href="{{ route('home') }}" class="hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary' : '' }}">{{ __('Home') }}</a>
                        
                        <div class="relative group">
                            <button class="flex items-center gap-1 hover:text-primary transition-colors py-8">
                                {{ __('Categories') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 top-full w-64 bg-white rounded-2xl shadow-2xl border border-rose-50 p-4 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                                <div class="grid gap-2">
                                   
                                    @foreach($globalCategories as $category)
                                        <a href="{{ route('web.shop', ['category_id' => $category->id]) }}" class="px-4 py-3 hover:bg-rose-50 rounded-xl transition-all flex items-center justify-between group/item">
                                            <span class="font-bold text-gray-700 group-hover/item:text-primary">{{ $category->name }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover/item:text-primary opacity-0 group-hover/item:opacity-100 -translate-x-2 group-hover/item:translate-x-0 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endforeach


                                    <div class="mt-2 pt-2 border-t border-rose-50">
                                        <a href="{{ route('web.shop') }}" class="block text-center py-2 text-xs font-bold text-primary hover:underline">
                                            {{ __('View All Categories') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('web.shop') }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.shop') ? 'text-primary' : '' }}">{{ __('Shop') }}</a>
                        
                        <a href="{{ route('web.about') }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.about') ? 'text-primary' : '' }}">{{ __('About Us') }}</a>
                        
                        <a href="{{ route('web.contact') }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.contact') ? 'text-primary' : '' }}">{{ __('Contact Us') }}</a>
                        
                        @guest
                            <a href="{{ route('login') }}" class="hover:text-primary transition-colors">{{ __('Login') }}</a>
                        @else
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-primary text-white rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">{{ __('Dashboard') }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="hover:text-primary transition-colors">{{ __('Logout') }}</button>
                            </form>
                        @endguest

                        <!-- Theme Switcher -->
                        <div class="flex items-center gap-2 pl-6 border-l border-rose-100">
                            <button onclick="setTheme('yasmina')" class="w-6 h-6 rounded-full bg-[#865d58] border-2 border-white shadow-sm hover:scale-110 transition-transform active:scale-95" title="Yasmina Theme"></button>
                            <button onclick="setTheme('barbie')" class="w-6 h-6 rounded-full bg-[#e0218a] border-2 border-white shadow-sm hover:scale-110 transition-transform active:scale-95" title="Barbie Theme"></button>
                        </div>
                        <!-- Language Switcher -->
                        <div class="flex items-center bg-rose-50 rounded-2xl p-1 shadow-sm border border-rose-100 ml-6">
                            <a href="{{ route('lang.switch', 'en') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary' }}">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'ar' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary' }}">AR</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary rounded-full opacity-10 blur-3xl -mr-32 -mt-32"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
                    <div>
                        <img src="{{ asset('logo.png') }}" alt="Yasmina Logo" class="h-12 w-auto object-contain mb-6 grayscale invert brightness-0">
                        <p class="mt-6 text-gray-400">{{ __('Defining elegance and quality since 2026.') }}</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">{{ __('Quick Links') }}</h4>
                        <ul class="space-y-4 text-gray-400">
                            <li><a href="{{ route('web.shop') }}" class="hover:text-primary transition-colors">{{ __('Shop') }}</a></li>
                            <li><a href="{{ route('home') }}#categories" class="hover:text-primary transition-colors">{{ __('Categories') }}</a></li>
                            <li><a href="{{ route('web.about') }}" class="hover:text-primary transition-colors">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('web.contact') }}" class="hover:text-primary transition-colors">{{ __('Contact Us') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">{{ __('Newsletter') }}</h4>
                        <p class="text-gray-400 mb-6">{{ __('Subscribe to get special offers and updates.') }}</p>
                        <form class="flex">
                            <input type="email" placeholder="{{ __('Email address') }}" class="bg-gray-800 border-none rounded-l-full px-6 py-3 w-full focus:ring-2 focus:ring-primary outline-none text-white">
                            <button type="button" class="bg-primary rounded-r-full px-6 py-3 font-bold hover:opacity-90 transition-colors">{{ __('Join') }}</button>
                        </form>
                    </div>
                </div>
                <div class="mt-20 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                    &copy; 2026 {{ __('Yasmina Website') }}. All rights reserved.
                </div>
            </div>
        </footer>

        <script>
            function setTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('yasmina-theme', theme);
            }
            
            // Initial sync
            const savedTheme = localStorage.getItem('yasmina-theme') || 'yasmina';
            document.documentElement.setAttribute('data-theme', savedTheme);
        </script>
    </body>
</html>

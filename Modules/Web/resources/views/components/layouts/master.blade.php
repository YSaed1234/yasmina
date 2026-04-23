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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
                        
                        <!-- Cart Icon -->
                        <a href="{{ route('web.cart') }}" class="relative group p-2 hover:bg-rose-50 rounded-xl transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @php $cartCount = count(session()->get('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-[10px] font-bold flex items-center justify-center rounded-full shadow-lg shadow-primary/20 border-2 border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Notifications -->
                        @auth
                            <div class="relative group">
                                <button class="relative p-2 hover:bg-rose-50 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                                    @if($unreadCount > 0)
                                        <span id="notification-badge" class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-bold flex items-center justify-center rounded-full border border-white">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                
                                <div class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-rose-50 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-[60] overflow-hidden">
                                    <div class="p-4 border-b border-rose-50 flex justify-between items-center bg-rose-50/10">
                                        <span class="font-bold text-gray-900 text-sm">{{ __('Notifications') }}</span>
                                        @if($unreadCount > 0)
                                            <form action="{{ route('web.notifications.mark-all-read') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[10px] font-bold text-primary hover:underline">{{ __('Mark all as read') }}</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(auth()->user()->notifications->take(10) as $notification)
                                            <div id="notification-{{ $notification->id }}" class="p-4 border-b border-rose-50/50 hover:bg-rose-50/30 transition-all {{ $notification->read_at ? 'opacity-60' : 'bg-rose-50/10' }}">
                                                <div class="flex gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        @if(isset($notification->data['action_url']))
                                                            <a href="{{ $notification->data['action_url'] }}" class="block">
                                                                <p class="text-xs font-bold text-gray-800 leading-relaxed hover:text-primary transition-colors">{{ $notification->data['message'] ?? '' }}</p>
                                                            </a>
                                                        @else
                                                            <p class="text-xs font-bold text-gray-800 leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>
                                                        @endif
                                                        <span class="text-[10px] text-gray-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    @unless($notification->read_at)
                                                        <button onclick="markAsRead('{{ $notification->id }}', this)" class="w-2 h-2 bg-primary rounded-full mt-2" title="{{ __('Mark as read') }}"></button>
                                                    @endunless
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-8 text-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                </svg>
                                                <p class="text-xs">{{ __('No notifications yet') }}</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    <a href="{{ route('web.notifications') }}" class="block py-3 text-center text-xs font-bold text-primary bg-rose-50/20 hover:bg-rose-50/50 transition-all border-t border-rose-50">
                                        {{ __('View All Notifications') }}
                                    </a>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="hover:text-primary transition-colors">{{ __('Login') }}</a>
                        @else
                            <div class="relative group">
                                <button class="flex items-center gap-2 hover:text-primary transition-colors py-2">
                                    <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-primary font-bold text-xs border border-rose-100 uppercase">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                    <span class="text-xs font-bold text-gray-700">{{ auth()->user()->name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute right-0 top-full w-56 bg-white rounded-2xl shadow-2xl border border-rose-50 p-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                                    <div class="grid gap-1">
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.index') }}" class="px-4 py-2.5 hover:bg-rose-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-gray-700 text-xs">{{ __('Admin Dashboard') }}</span>
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('web.profile') }}" class="px-4 py-2.5 hover:bg-rose-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover/item:text-primary transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-700 text-xs">{{ __('My Account') }}</span>
                                        </a>

                                        <a href="{{ route('web.profile.orders') }}" class="px-4 py-2.5 hover:bg-rose-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover/item:text-primary transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-700 text-xs">{{ __('My Orders') }}</span>
                                        </a>

                                        <a href="{{ route('web.profile.addresses') }}" class="px-4 py-2.5 hover:bg-rose-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover/item:text-primary transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-700 text-xs">{{ __('My Addresses') }}</span>
                                        </a>

                                        <div class="border-t border-rose-50 my-1"></div>

                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2.5 hover:bg-red-50 text-red-500 rounded-xl transition-all flex items-center gap-3 group/item">
                                                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-xs text-left">{{ __('Logout') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (document.querySelector('.hero-swiper')) {
                    const swiper = new Swiper('.hero-swiper', {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                    });
                }
            });

            function setTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('yasmina-theme', theme);
            }
            
            // Initial sync
            const savedTheme = localStorage.getItem('yasmina-theme') || 'yasmina';
            document.documentElement.setAttribute('data-theme', savedTheme);

            // Flash Message Handler
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    Swal.fire({
                        title: '{{ __("Success!") }}',
                        text: '{{ session("success") }}',
                        icon: 'success',
                        confirmButtonText: '{{ __("OK") }}',
                        confirmButtonColor: 'var(--yasmina-primary)',
                        customClass: {
                            popup: 'rounded-3xl border-none',
                            confirmButton: 'rounded-2xl px-8 py-3 font-bold uppercase tracking-widest text-xs'
                        }
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        title: '{{ __("Error!") }}',
                        text: '{{ session("error") }}',
                        icon: 'error',
                        confirmButtonText: '{{ __("OK") }}',
                        confirmButtonColor: 'var(--yasmina-primary)',
                        customClass: {
                            popup: 'rounded-3xl border-none',
                            confirmButton: 'rounded-2xl px-8 py-3 font-bold uppercase tracking-widest text-xs'
                        }
                    });
                @endif
            });

            function toggleWishlist(productId, btn) {
                fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const svg = btn.querySelector('svg');
                    if (data.status === 'added') {
                        svg.classList.add('text-red-500', 'fill-current');
                        svg.classList.remove('text-gray-400');
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("Success!") }}',
                            text: '{{ __("Added to favorites") }}',
                            timer: 1500,
                            showConfirmButton: false,
                            confirmButtonColor: 'var(--yasmina-primary)'
                        });
                    } else {
                        svg.classList.remove('text-red-500', 'fill-current');
                        svg.classList.add('text-gray-400');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: '{{ __("Error!") }}',
                        text: '{{ __("Something went wrong. Please try again.") }}',
                        icon: 'error',
                        confirmButtonText: '{{ __("OK") }}',
                        confirmButtonColor: 'var(--yasmina-primary)',
                    });
                });
            }

            function markAsRead(id, btn) {
                fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = document.getElementById(`notification-${id}`);
                        item.classList.add('opacity-60');
                        item.classList.remove('bg-rose-50/10');
                        btn.remove();
                        
                        const badge = document.getElementById('notification-badge');
                        if (badge) {
                            let count = parseInt(badge.innerText);
                            if (count > 1) {
                                badge.innerText = count - 1;
                            } else {
                                badge.remove();
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        </script>
        @stack('scripts')
    </body>
</html>

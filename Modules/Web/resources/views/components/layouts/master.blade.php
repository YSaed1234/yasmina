<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- SEO Metadata -->
        <title>{{ $title ?? ($currentVendor ? $currentVendor->name . ' - ' : '') . 'Yasmina' }}</title>
        <meta name="description" content="{{ $meta_description ?? ($currentVendor ? $currentVendor->description : __('The most premium marketplace for luxury products and institutions.')) }}">
        <meta name="keywords" content="{{ $meta_keywords ?? ($currentVendor ? $currentVendor->name . ', ' . __('Luxury, Boutique, Store') : __('Yasmina, Luxury, E-commerce')) }}">
        <link rel="canonical" href="{{ url()->current() }}">
        
        <!-- Open Graph / Social Media -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $title ?? ($currentVendor ? $currentVendor->name . ' - ' : '') . 'Yasmina' }}">
        <meta property="og:description" content="{{ $meta_description ?? ($currentVendor ? $currentVendor->description : __('The most premium marketplace for luxury products and institutions.')) }}">
        @if($currentVendor && $currentVendor->logo)
            <meta property="og:image" content="{{ asset('storage/' . $currentVendor->logo) }}">
        @else
            <meta property="og:image" content="{{ asset('logo.png') }}">
        @endif
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $title ?? ($currentVendor ? $currentVendor->name . ' - ' : '') . 'Yasmina' }}">
        <meta property="twitter:description" content="{{ $meta_description ?? ($currentVendor ? $currentVendor->description : __('The most premium marketplace for luxury products and institutions.')) }}">
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
                --yasmina-primary-base: {{ ($currentVendor && $currentVendor->primary_color) ? $currentVendor->primary_color : '#865d58' }};
                --yasmina-secondary-base: {{ ($currentVendor && $currentVendor->secondary_color) ? $currentVendor->secondary_color : '#d6a6a1' }};

                /* Main UI Variables */
                --yasmina-primary: var(--yasmina-primary-base);
                --yasmina-primary-hover: color-mix(in srgb, var(--yasmina-primary-base), black 10%);
                --yasmina-secondary: var(--yasmina-secondary-base);
                --yasmina-bg-soft: color-mix(in srgb, var(--yasmina-primary-base), white 95%);

                /* Detailed Shades for utility classes (yasmina-50, etc) */
                --yasmina-50: var(--yasmina-bg-soft);
                --yasmina-100: color-mix(in srgb, var(--yasmina-primary-base), white 90%);
                --yasmina-200: color-mix(in srgb, var(--yasmina-primary-base), white 80%);
                --yasmina-300: color-mix(in srgb, var(--yasmina-primary-base), white 60%);
                --yasmina-400: var(--yasmina-secondary-base);
                --yasmina-500: var(--yasmina-primary-base);
                --yasmina-600: var(--yasmina-primary-hover);
                --yasmina-700: color-mix(in srgb, var(--yasmina-primary-base), black 20%);
                --yasmina-800: color-mix(in srgb, var(--yasmina-primary-base), black 30%);
                --yasmina-900: color-mix(in srgb, var(--yasmina-primary-base), black 40%);

                /* Footer Variables */
                --yasmina-footer-bg: color-mix(in srgb, var(--yasmina-primary-base), black 92%);
                --yasmina-footer-item: color-mix(in srgb, var(--yasmina-primary-base), black 85%);
                --yasmina-footer-border: color-mix(in srgb, var(--yasmina-primary-base), black 80%);
            }

            [data-theme="barbie"] {
                --yasmina-primary-base: #e0218a;
                --yasmina-secondary-base: #ff64b1;

                --yasmina-primary: var(--yasmina-primary-base);
                --yasmina-primary-hover: #c2146e;
                --yasmina-secondary: var(--yasmina-secondary-base);
                --yasmina-bg-soft: #fffafb;

                --yasmina-50: var(--yasmina-bg-soft);
                --yasmina-500: var(--yasmina-primary-base);
                --yasmina-600: var(--yasmina-primary-hover);
            }

            body {
                font-family: 'Outfit', 'Tajawal', sans-serif;
                background-color: var(--yasmina-bg-soft);
            }

            .soft-shadow {
                box-shadow: 0 20px 40px -15px color-mix(in srgb, var(--yasmina-primary), transparent 90%);
            }
            .ql-size-small { font-size: 0.75em; }
            .ql-size-large { font-size: 1.5em; }
            .ql-size-huge { font-size: 2.5em; }
        </style>
    </head>
    <body class="antialiased text-gray-900 transition-colors duration-500 overflow-x-hidden" 
          x-data="{ mobileMenu: false }" 
          :class="mobileMenu ? 'overflow-hidden' : ''">
        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-yasmina-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center gap-x-4 lg:gap-x-12">
                    <div class="flex items-center gap-4 lg:gap-6 me-4 lg:me-12">
                        
                        
                        @if($currentVendor && $currentVendor->logo)
          
                        <a href="{{ route('home') }}" class="flex items-center shrink-0">
                            <img src="{{ asset('storage/' . $currentVendor->logo) }}" alt="{{ $currentVendor->name }}" class="h-12 max-w-[180px] w-auto object-contain">
                        </a>
                        @else
                            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                            <img src="{{ asset('logo.png') }}" alt="Yasmina Logo" class="h-12 max-w-[180px] w-auto object-contain">
                        </a>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <!-- Desktop Navigation -->
                        <div class="hidden lg:flex gap-8 text-sm font-bold uppercase tracking-widest text-gray-600 items-center">
                        <a href="{{ route('home', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary' : '' }}">{{ __('Home') }}</a>
                        
                        <div class="relative group">
                            <button class="flex items-center gap-1 hover:text-primary transition-colors py-8">
                                {{ __('Institutions') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 top-full w-64 bg-white rounded-2xl shadow-2xl border border-yasmina-50 p-4 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                                <div class="grid gap-2">
                                    <a href="{{ route('home') }}" class="px-4 py-3 hover:bg-yasmina-50 rounded-xl transition-all flex items-center justify-between group/item">
                                        <span class="font-bold text-gray-700 group-hover/item:text-primary">{{ __('Main Store') }}</span>
                                        @if(!$currentVendor)
                                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                                        @endif
                                    </a>
                                    @foreach($globalVendors as $vendor)
                                        <a href="{{ route('home', ['vendor_id' => $vendor->slug]) }}" class="px-4 py-3 hover:bg-yasmina-50 rounded-xl transition-all flex items-center justify-between group/item">
                                            <div class="flex items-center gap-3">
                                                @if($vendor->logo)
                                                    <img src="{{ asset('storage/' . $vendor->logo) }}" class="w-6 h-6 rounded-full object-contain bg-gray-50">
                                                @endif
                                                <span class="font-bold text-gray-700 group-hover/item:text-primary">{{ $vendor->name }}</span>
                                            </div>
                                            @if($currentVendor && $currentVendor->id == $vendor->id)
                                                <span class="w-2 h-2 bg-primary rounded-full"></span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="relative group">
                            <button class="flex items-center gap-1 hover:text-primary transition-colors py-8">
                                {{ __('Categories') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 top-full w-64 bg-white rounded-2xl shadow-2xl border border-yasmina-50 p-4 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                                <div class="grid gap-2">
                                   
                                    @foreach($globalCategories as $category)
                                        <a href="{{ route('web.shop', ['category_id' => $category->id, 'vendor_id' => request('vendor_id')]) }}" class="px-4 py-3 hover:bg-yasmina-50 rounded-xl transition-all flex items-center justify-between group/item">
                                            <span class="font-bold text-gray-700 group-hover/item:text-primary">{{ $category->name }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover/item:text-primary opacity-0 group-hover/item:opacity-100 -translate-x-2 group-hover/item:translate-x-0 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endforeach


                                    <div class="mt-2 pt-2 border-t border-yasmina-50">
                                        <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="block text-center py-2 text-xs font-bold text-primary hover:underline">
                                            {{ __('View All Categories') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.shop') ? 'text-primary' : '' }}">{{ __('Shop') }}</a>
                        
                        <a href="{{ route('web.promotions.index', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.promotions.index') ? 'text-primary' : '' }}">{{ __('Promotions') }}</a>
                        
                        <a href="{{ route('web.about', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.about') ? 'text-primary' : '' }}">{{ __('About Us') }}</a>
                        
                        <a href="{{ route('web.contact', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.contact') ? 'text-primary' : '' }}">{{ __('Contact Us') }}</a>
                        
                        <a href="{{ route('web.returns', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors {{ request()->routeIs('web.returns') ? 'text-primary' : '' }}">{{ __('Return Policy') }}</a>
                        
                        <a href="{{ route('web.become-vendor',['vendor_id'=>request('vendor_id')]) }}" class="px-6 py-2 bg-primary text-white rounded-full text-xs font-bold hover:bg-primary-hover transition-all shadow-lg shadow-primary/20">
                            {{ __('Join Us') }}
                        </a>
                        
                        <!-- Cart Icon -->
                        <a href="{{ route('web.cart', ['vendor_id' => request('vendor_id')]) }}" class="relative group p-2 hover:bg-yasmina-50 rounded-xl transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @php $cartCount = app(\Modules\Web\Services\CartService::class)->getCartCount(); @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-[10px] font-bold flex items-center justify-center rounded-full shadow-lg shadow-primary/20 border-2 border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Notifications -->
                        @auth
                            <div class="relative group">
                                <button class="relative p-2 hover:bg-yasmina-50 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @php 
                                        $vendorId = request()->vendor_id;
                                        $unreadCount = auth()->user()->vendorUnreadNotifications($vendorId)->count(); 
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span id="notification-badge" class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-bold flex items-center justify-center rounded-full border border-white">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                
                                <div class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-yasmina-50 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-[60] overflow-hidden">
                                    <div class="p-4 border-b border-yasmina-50 flex justify-between items-center bg-yasmina-50/10">
                                        <span class="font-bold text-gray-900 text-sm">{{ __('Notifications') }}</span>
                                        @if($unreadCount > 0)
                                            <form action="{{ route('web.notifications.mark-all-read', ['vendor_id' => request('vendor_id')]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[10px] font-bold text-primary hover:underline">{{ __('Mark all as read') }}</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(auth()->user()->vendorNotifications($vendorId)->take(10)->get() as $notification)
                                            <div id="notification-{{ $notification->id }}" class="p-4 border-b border-yasmina-50/50 hover:bg-yasmina-50/30 transition-all {{ $notification->read_at ? 'opacity-60' : 'bg-yasmina-50/10' }}">
                                                <div class="flex gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        @if(isset($notification->data['action_url']))
                                                            <a href="{{ $notification->data['action_url'] }}" onclick="markAsRead('{{ $notification->id }}', this)" class="block">
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
                                    <a href="{{ route('web.notifications', ['vendor_id' => request('vendor_id')]) }}" class="block py-3 text-center text-xs font-bold text-primary bg-yasmina-50/20 hover:bg-yasmina-50/50 transition-all border-t border-yasmina-50">
                                        {{ __('View All Notifications') }}
                                    </a>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors">{{ __('Login') }}</a>
                        @else
                            <div class="relative group">
                                <button class="flex items-center gap-2 hover:text-primary transition-colors py-2">
                                    <div class="w-8 h-8 rounded-full bg-yasmina-50 flex items-center justify-center text-primary font-bold text-xs border border-yasmina-100 uppercase">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                    <span class="text-xs font-bold text-gray-700">{{ auth()->user()->name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="absolute right-0 top-full w-56 bg-white rounded-2xl shadow-2xl border border-yasmina-50 p-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                                    <div class="grid gap-1">
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.index') }}" class="px-4 py-2.5 hover:bg-yasmina-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-gray-700 text-xs">{{ __('Admin Dashboard') }}</span>
                                            </a>
                                        @endif

                                        @if(auth()->user()->vendor_id)
                                            <a href="{{ route('vendor.dashboard') }}" class="px-4 py-2.5 hover:bg-yasmina-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                                <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                                <span class="font-bold text-gray-700 text-xs">{{ __('Vendor Panel') }}</span>
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('web.profile', ['vendor_id' => request('vendor_id')]) }}" class="px-4 py-2.5 hover:bg-yasmina-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover/item:text-primary transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-700 text-xs">{{ __('My Account') }}</span>
                                        </a>

                                        <a href="{{ route('web.profile.orders', ['vendor_id' => request('vendor_id')]) }}" class="px-4 py-2.5 hover:bg-yasmina-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover/item:text-primary transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-700 text-xs">{{ __('My Orders') }}</span>
                                        </a>

                                        <a href="{{ route('web.profile.addresses', ['vendor_id' => request('vendor_id')]) }}" class="px-4 py-2.5 hover:bg-yasmina-50 rounded-xl transition-all flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover/item:text-primary transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold text-gray-700 text-xs">{{ __('My Addresses') }}</span>
                                        </a>

                                        <div class="border-t border-yasmina-50 my-1"></div>

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
                        <div class="hidden lg:flex items-center gap-2 pl-6 border-l border-yasmina-100">
                            <button onclick="setTheme('yasmina')" 
                                class="w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-transform active:scale-95" 
                                style="background: linear-gradient(to right, {{ ($currentVendor && $currentVendor->primary_color) ? $currentVendor->primary_color : '#865d58' }}, {{ ($currentVendor && $currentVendor->secondary_color) ? $currentVendor->secondary_color : '#d6a6a1' }})"
                                title="{{ $currentVendor ? __('Institution Theme') : __('Yasmina Theme') }}"></button>
                            <button onclick="setTheme('barbie')" class="w-6 h-6 rounded-full bg-[#e0218a] border-2 border-white shadow-sm hover:scale-110 transition-transform active:scale-95" title="{{ __('Barbie Theme') }}"></button>
                        </div>
                        <!-- Language Switcher -->
                        <div class="hidden lg:flex items-center bg-yasmina-50 rounded-2xl p-1 shadow-sm border border-yasmina-100 ml-6">
                            <a href="{{ route('lang.switch', 'en') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary' }}">EN</a>
                            <a href="{{ route('lang.switch', 'ar') }}" class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all {{ app()->getLocale() == 'ar' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary' }}">AR</a>
                        </div>
                        </div>
                    </div>

                    <!-- Mobile Navigation Actions (Cart + Hamburger) -->
                    <div class="flex lg:hidden items-center gap-2">
                        <!-- Mobile Cart -->
                        <a href="{{ route('web.cart', ['vendor_id' => request('vendor_id')]) }}" class="relative p-2 text-gray-700 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @if($cartCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-primary text-white text-[8px] font-bold flex items-center justify-center rounded-full border border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                        
                        <!-- Hamburger Toggle -->
                        <button @click="mobileMenu = true" class="p-2 text-gray-700 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Drawer (App Style) -->
            <div x-show="mobileMenu" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="{{ app()->getLocale() == 'ar' ? 'translate-x-full' : '-translate-x-full' }}"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="{{ app()->getLocale() == 'ar' ? 'translate-x-full' : '-translate-x-full' }}"
                 class="fixed inset-0 z-[100] lg:hidden" style="display: none;" x-cloak>
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md" @click="mobileMenu = false"></div>
                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-[85%] sm:w-80 bg-white shadow-2xl flex flex-col border-{{ app()->getLocale() == 'ar' ? 'l' : 'r' }} border-yasmina-50/50">
                    <div class="p-6 border-b border-yasmina-50 flex items-center justify-between bg-yasmina-50/20">
                        <img src="{{ ($currentVendor && $currentVendor->logo) ? asset('storage/' . $currentVendor->logo) : asset('logo.png') }}" class="h-10 w-auto object-contain">
                        <button @click="mobileMenu = false" class="p-2 text-gray-400 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto py-8 px-6 space-y-8">
                        <!-- Navigation -->
                        <div class="flex flex-col gap-5">
                            <a href="{{ route('home', ['vendor_id' => request('vendor_id')]) }}" class="text-xl font-bold {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-900' }}">{{ __('Home') }}</a>
                            <a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="text-xl font-bold {{ request()->routeIs('web.shop') ? 'text-primary' : 'text-gray-900' }}">{{ __('Shop') }}</a>
                            <a href="{{ route('web.promotions.index', ['vendor_id' => request('vendor_id')]) }}" class="text-xl font-bold {{ request()->routeIs('web.promotions.index') ? 'text-primary' : 'text-gray-900' }}">{{ __('Promotions') }}</a>
                            <a href="{{ route('web.about', ['vendor_id' => request('vendor_id')]) }}" class="text-xl font-bold {{ request()->routeIs('web.about') ? 'text-primary' : 'text-gray-900' }}">{{ __('About Us') }}</a>
                            <a href="{{ route('web.contact', ['vendor_id' => request('vendor_id')]) }}" class="text-xl font-bold {{ request()->routeIs('web.contact') ? 'text-primary' : 'text-gray-900' }}">{{ __('Contact Us') }}</a>
                            <a href="{{ route('web.returns', ['vendor_id' => request('vendor_id')]) }}" class="text-xl font-bold {{ request()->routeIs('web.returns') ? 'text-primary' : 'text-gray-900' }}">{{ __('Return Policy') }}</a>
                        </div>

                        <!-- Categories Section -->
                        <div class="pt-8 border-t border-yasmina-50">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">{{ __('Explore Categories') }}</h4>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($globalCategories->take(6) as $category)
                                    <a href="{{ route('web.shop', ['category_id' => $category->id, 'vendor_id' => request('vendor_id')]) }}" class="flex items-center justify-between group">
                                        <span class="text-sm font-bold text-gray-600 group-hover:text-primary transition-colors">{{ $category->name }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Settings on Mobile -->
                        <div class="pt-8 border-t border-yasmina-50">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">{{ __('Settings & Language') }}</h4>
                            <div class="flex items-center gap-4 mb-6">
                                <button onclick="setTheme('yasmina')" class="flex-1 py-3 rounded-2xl border-2 border-yasmina-50 flex items-center justify-center gap-2" style="background: linear-gradient(to right, {{ ($currentVendor && $currentVendor->primary_color) ? $currentVendor->primary_color : '#865d58' }}22, {{ ($currentVendor && $currentVendor->secondary_color) ? $currentVendor->secondary_color : '#d6a6a1' }}22)">
                                    <div class="w-4 h-4 rounded-full" style="background: var(--yasmina-primary)"></div>
                                    <span class="text-xs font-bold text-primary">{{ __('Theme') }}</span>
                                </button>
                                <button onclick="setTheme('barbie')" class="flex-1 py-3 rounded-2xl border-2 border-yasmina-50 flex items-center justify-center gap-2 bg-[#e0218a11]">
                                    <div class="w-4 h-4 rounded-full bg-[#e0218a]"></div>
                                    <span class="text-xs font-bold text-[#e0218a]">{{ __('Barbie') }}</span>
                                </button>
                            </div>
                            <div class="flex bg-yasmina-50 rounded-2xl p-1">
                                <a href="{{ route('lang.switch', 'en') }}" class="flex-1 py-3 rounded-xl text-center text-sm font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-primary shadow-sm' : 'text-gray-500' }}">English</a>
                                <a href="{{ route('lang.switch', 'ar') }}" class="flex-1 py-3 rounded-xl text-center text-sm font-bold transition-all {{ app()->getLocale() == 'ar' ? 'bg-white text-primary shadow-sm' : 'text-gray-500' }}">العربية</a>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 border-t border-yasmina-50 bg-yasmina-50/10">
                        @guest
                            <a href="{{ route('login', ['vendor_id' => request('vendor_id')]) }}" class="w-full py-4 bg-primary text-white rounded-2xl text-center font-bold block shadow-lg shadow-primary/20 mb-3">{{ __('Login') }}</a>
                            <a href="{{ route('web.become-vendor') }}" class="w-full py-4 bg-white border border-yasmina-100 rounded-2xl text-center font-bold text-gray-700 block shadow-sm">{{ __('Register as Provider') }}</a>
                        @else
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg shadow-inner">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-gray-900">{{ auth()->user()->name }}</p>
                                    <a href="{{ route('web.profile', ['vendor_id' => request('vendor_id')]) }}" class="text-[10px] font-bold text-primary uppercase tracking-widest">{{ __('View Profile') }}</a>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-red-50 text-red-500 rounded-2xl text-center font-bold">{{ __('Log Out') }}</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="overflow-x-hidden pt-20 lg:pt-0">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="text-white py-20 relative overflow-hidden" style="background-color: var(--yasmina-footer-bg)">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary rounded-full opacity-10 blur-3xl -mr-32 -mt-32"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-center md:text-left">
                    <div>
                        <img src="{{ ($currentVendor && $currentVendor->logo) ? asset('storage/' . $currentVendor->logo) : asset('logo.png') }}" alt="{{ ($currentVendor) ? $currentVendor->name : 'Yasmina Logo' }}" class="h-16 w-auto object-contain mb-6 {{ (!$currentVendor || !$currentVendor->logo) ? 'grayscale invert brightness-0' : '' }}">
                        <p class="mt-6 text-gray-400 text-sm leading-relaxed mb-6">{{ ($currentVendor && $currentVendor->description) ? $currentVendor->description : __('Defining elegance and quality since 2026.') }}</p>
                        
                        @if($currentVendor)
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                @if($currentVendor->facebook)
                                    <a href="{{ $currentVendor->facebook }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all" style="background-color: var(--yasmina-footer-item)">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                @endif
                                @if($currentVendor->instagram)
                                    <a href="{{ $currentVendor->instagram }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all" style="background-color: var(--yasmina-footer-item)">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                @endif
                                @if($currentVendor->twitter)
                                    <a href="{{ $currentVendor->twitter }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all" style="background-color: var(--yasmina-footer-item)">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                    </a>
                                @endif
                                @if($currentVendor->whatsapp)
                                    <a href="https://wa.me/{{ $currentVendor->whatsapp }}" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all" style="background-color: var(--yasmina-footer-item)">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">{{ __('Quick Links') }}</h4>
                        <ul class="space-y-4 text-gray-400 text-sm">
                            <li><a href="{{ route('web.shop', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors">{{ __('Shop') }}</a></li>
                            <li><a href="{{ route('home', ['vendor_id' => request('vendor_id')]) }}#categories" class="hover:text-primary transition-colors">{{ __('Categories') }}</a></li>
                            <li><a href="{{ route('web.about', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('web.contact', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors">{{ __('Contact Us') }}</a></li>
                            <li><a href="{{ route('web.returns', ['vendor_id' => request('vendor_id')]) }}" class="hover:text-primary transition-colors">{{ __('Return Policy') }}</a></li>
                            <li><a href="{{ route('web.become-vendor') }}" class="hover:text-primary transition-colors">{{ __('Become a Service Provider') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">{{ __('Contact Info') }}</h4>
                        <ul class="space-y-4 text-gray-400 text-sm">
                            @if($currentVendor)
                                @if($currentVendor->phone)
                                    <li class="flex items-center justify-center md:justify-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $currentVendor->phone }}
                                    </li>
                                @endif
                                @if($currentVendor->phone_secondary)
                                    <li class="flex items-center justify-center md:justify-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $currentVendor->phone_secondary }}
                                    </li>
                                @endif
                                <li class="flex items-center justify-center md:justify-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $currentVendor->email }}
                                </li>
                                @if($currentVendor->address)
                                    <li class="flex items-start justify-center md:justify-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $currentVendor->address }}
                                    </li>
                                @endif
                            @else
                                <li class="flex items-center justify-center md:justify-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    +33 1 23 45 67 89
                                </li>
                                <li class="flex items-center justify-center md:justify-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    contact@yasmina.com
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-6">{{ __('Newsletter') }}</h4>
                        <p class="text-gray-400 mb-6 text-sm">{{ __('Subscribe to get special offers and updates.') }}</p>
                        <form class="flex">
                            <input type="email" placeholder="{{ __('Email address') }}" class="border-none rounded-l-full px-6 py-3 w-full focus:ring-2 focus:ring-primary outline-none text-white text-sm" style="background-color: var(--yasmina-footer-item)">
                            <button type="button" class="bg-primary rounded-r-full px-6 py-3 font-bold hover:opacity-90 transition-colors text-sm">{{ __('Join') }}</button>
                        </form>
                    </div>
                </div>
                <div class="mt-20 pt-8 text-center text-gray-500 text-sm" style="border-top: 1px solid var(--yasmina-footer-border)">
                    &copy; {{ date('Y') }} {{ $currentVendor ? $currentVendor->name : __('Yasmina Website') }}. All rights reserved.
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
                
                // If we select 'yasmina' in vendor context, it should actually reset to vendor colors
                if (theme === 'yasmina' && {{ $currentVendor ? 'true' : 'false' }}) {
                    document.documentElement.setAttribute('data-theme', 'vendor');
                }
            }
            
            // Initial sync
            (function() {
                const savedTheme = localStorage.getItem('yasmina-theme');
                @if($currentVendor)
                    if (savedTheme === 'barbie') {
                        document.documentElement.setAttribute('data-theme', 'barbie');
                    } else {
                        document.documentElement.setAttribute('data-theme', 'vendor');
                    }
                @else
                    document.documentElement.setAttribute('data-theme', savedTheme || 'yasmina');
                @endif
            })();

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
                fetch(`/wishlist/toggle/${productId}?vendor_id={{ request()->vendor_id }}`, {
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
                            text: data.message || '{{ __("Added to favorites") }}',
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

            function copyToClipboard(text, btn) {
                const copyAction = (txt) => {
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                    btn.classList.remove('bg-primary/10', 'text-primary');
                    btn.classList.add('bg-green-500', 'text-white');
                    
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("Copied!") }}',
                        text: '{{ __("Referral code copied to clipboard") }}',
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });

                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.classList.add('bg-primary/10', 'text-primary');
                        btn.classList.remove('bg-green-500', 'text-white');
                    }, 2000);
                };

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => copyAction(text));
                } else {
                    // Fallback
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        copyAction(text);
                    } catch (err) {
                        console.error('Fallback copy failed', err);
                    }
                    document.body.removeChild(textArea);
                }
            }

            function markAsRead(id, btn) {
                // If it's already marked as read in UI, don't do anything
                const item = document.getElementById(`notification-${id}`);
                if (item && item.classList.contains('opacity-60')) return;

                fetch(`/notifications/${id}/read?vendor_id={{ request()->vendor_id }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (item) {
                            item.classList.add('opacity-60');
                            item.classList.remove('bg-yasmina-50/10');
                            
                            // Remove the blue dot if exists
                            const dot = item.querySelector('button.bg-primary');
                            if (dot) dot.remove();
                        }
                        
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

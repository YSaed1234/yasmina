<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>{{ __('Admin Dashboard 2026') }} - Yasmina</title>

        <meta name="description" content="{{ $description ?? '' }}">
        <meta name="keywords" content="{{ $keywords ?? '' }}">
        <meta name="author" content="{{ $author ?? '' }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>

    <body class="bg-[#fffafb]">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-r border-rose-100 shadow-sm">
                <div class="p-6">
                    <span class="text-2xl font-bold text-rose-500">Yasmina Admin</span>
                </div>
                <nav class="mt-6 px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('dashboard') ? 'bg-rose-50 text-rose-500' : '' }} font-bold">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('categories.*') ? 'bg-rose-50 text-rose-500' : '' }} font-bold">
                        {{ __('Categories') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('products.*') ? 'bg-rose-50 text-rose-500' : '' }} font-bold">
                        {{ __('Products') }}
                    </a>
                    <a href="{{ route('currencies.index') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('currencies.*') ? 'bg-rose-50 text-rose-500' : '' }} font-bold">
                        {{ __('Currencies') }}
                    </a>

                    <div class="pt-6 mt-6 border-t border-rose-50">
                        <a href="{{ url('/') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-white bg-rose-500 hover:bg-rose-600 transition-all shadow-lg shadow-rose-100 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            {{ __('Back to Site') }}
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto">
                <header class="bg-white border-b border-rose-50 h-20 flex items-center justify-between px-10 sticky top-0 z-10 backdrop-blur-md bg-white/80">
                    <h2 class="text-xl font-bold text-gray-800">{{ __('Admin Dashboard 2026') }}</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500 font-medium">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-rose-500 hover:text-rose-600 font-bold transition-all">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </header>
                <div class="p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>

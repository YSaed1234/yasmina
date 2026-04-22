<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Yasmina') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
        
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #d6a6a1 0%, #865d58 100%); }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#fdf8f7]">
        <div class="min-h-screen relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-yasmina-100 rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-yasmina-200 rounded-full opacity-10 blur-3xl"></div>

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/50 backdrop-blur-sm shadow-sm border-b border-yasmina-50 relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        {{ $header }}
                        <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" class="px-4 py-2 bg-white border border-yasmina-100 rounded-full text-sm font-bold text-yasmina-500 hover:bg-yasmina-50 transition-all shadow-sm">
                            {{ app()->getLocale() == 'ar' ? 'English' : 'عربي' }}
                        </a>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative z-10">
                {{ $slot }}
            </main>
        </div>
        <script>
            // Load saved theme
            const savedTheme = localStorage.getItem('selectedTheme') || 'yasmina';
            document.documentElement.setAttribute('data-theme', savedTheme === 'barbie' ? 'barbie' : 'yasmina');
        </script>
    </body>
</html>

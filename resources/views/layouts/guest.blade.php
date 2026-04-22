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
            .gradient-bg { background: linear-gradient(135deg, #fb7185 0%, #db2777 100%); }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-gray-900 antialiased bg-[#fffafb]">
        <div class="absolute top-4 right-4 z-50">
            <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" class="px-4 py-2 bg-white/80 backdrop-blur-sm border border-rose-100 rounded-full text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all shadow-sm">
                {{ app()->getLocale() == 'ar' ? 'English' : 'عربي' }}
            </a>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 gradient-bg rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-pink-300 rounded-full opacity-10 blur-3xl"></div>
            
            <div class="z-10">
                <a href="/">
                    <span class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-rose-500 to-pink-600">Yasmina</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl shadow-rose-100/50 overflow-hidden sm:rounded-3xl border border-rose-50 z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

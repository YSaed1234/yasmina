<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Admin Dashboard - Yasmina</title>

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
                    <a href="{{ route('admin.index') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('admin.index') ? 'bg-rose-50 text-rose-500' : '' }}">Dashboard</a>
                    <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('categories.*') ? 'bg-rose-50 text-rose-500' : '' }}">Categories</a>
                    <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all {{ request()->routeIs('products.*') ? 'bg-rose-50 text-rose-500' : '' }}">Products</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Yasmina Website - Premium Products</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
            .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 glass border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Yasmina</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:text-indigo-600 transition-colors">Home</a>
                            @foreach($categories as $category)
                                <a href="#category-{{ $category->id }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 mr-4">Login</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="lg:w-1/2">
                    <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-gray-900 leading-tight">
                        Elegance in <br>
                        <span class="text-indigo-600">Every Detail</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 leading-relaxed">
                        Discover our curated collection of premium products, designed for those who appreciate quality and style.
                    </p>
                    <div class="mt-10 flex space-x-4">
                        <a href="#products" class="px-8 py-4 bg-indigo-600 text-white rounded-full font-semibold shadow-lg hover:bg-indigo-700 transition-all hover:-translate-y-1">Shop Now</a>
                        <a href="#" class="px-8 py-4 bg-white text-indigo-600 rounded-full font-semibold shadow-md hover:shadow-lg transition-all hover:-translate-y-1">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-3/4 h-full gradient-bg rounded-full opacity-10 blur-3xl"></div>
        </section>

        <!-- Products Section -->
        <section id="products" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Featured Products</h2>
                    <p class="mt-4 text-gray-600">Handpicked items just for you</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($featuredProducts as $product)
                        <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <div class="aspect-square w-full overflow-hidden bg-gray-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <span class="text-xs font-semibold text-indigo-600 uppercase tracking-widest">{{ $product->category->name }}</span>
                                <h3 class="mt-2 text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    <button class="p-2 rounded-full bg-gray-50 text-gray-900 hover:bg-indigo-600 hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-500">No products available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        @foreach($categories as $category)
            @if($category->products->count() > 0)
                <section id="category-{{ $category->id }}" class="py-20 border-t border-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-end mb-10">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h2>
                                <p class="mt-2 text-gray-600">Explore items in this category</p>
                            </div>
                            <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">View All</a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach($category->products->sortBy('rank')->take(4) as $product)
                                <div class="group relative">
                                    <div class="aspect-square w-full rounded-xl overflow-hidden bg-gray-100">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-300 text-4xl">?</div>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <h3 class="text-sm text-gray-700">{{ $product->name }}</h3>
                                        <p class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div>
                        <span class="text-2xl font-bold text-white">Yasmina</span>
                        <p class="mt-6 text-gray-400">Defining elegance and quality since 2024.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                        <ul class="space-y-4 text-gray-400">
                            <li><a href="#" class="hover:text-white">Shop</a></li>
                            <li><a href="#" class="hover:text-white">Categories</a></li>
                            <li><a href="#" class="hover:text-white">About Us</a></li>
                            <li><a href="#" class="hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Newsletter</h4>
                        <p class="text-gray-400 mb-6">Subscribe to get special offers and updates.</p>
                        <form class="flex">
                            <input type="email" placeholder="Email address" class="bg-gray-800 border-none rounded-l-full px-6 py-3 w-full focus:ring-2 focus:ring-indigo-500">
                            <button class="bg-indigo-600 rounded-r-full px-6 py-3 font-semibold hover:bg-indigo-700 transition-colors">Join</button>
                        </form>
                    </div>
                </div>
                <div class="mt-20 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                    &copy; 2024 Yasmina Website. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>

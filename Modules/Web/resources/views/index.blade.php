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
            :root {
                --primary: #f43f5e;
                --primary-hover: #e11d48;
                --secondary: #ec4899;
                --bg-soft: #fffafb;
                --accent-light: rgba(244, 63, 94, 0.1);
                --shadow-color: rgba(244, 63, 94, 0.2);
            }

            body { font-family: 'Outfit', sans-serif; background-color: var(--bg-soft); transition: background-color 0.3s ease; }
            .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
            .gradient-bg { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); }
            .soft-shadow { box-shadow: 0 10px 30px -10px var(--shadow-color); }
            
            .text-primary { color: var(--primary); }
            .bg-primary { background-color: var(--primary); }
            .border-primary { border-color: var(--primary); }
            .hover-bg-primary:hover { background-color: var(--primary-hover); }
            .from-primary { --tw-gradient-from: var(--primary) !important; --tw-gradient-to: rgb(255 255 255 / 0) !important; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important; }
            .to-secondary { --tw-gradient-to: var(--secondary) !important; }
            
            .theme-dot { width: 24px; height: 24px; border-radius: 50%; cursor: pointer; border: 2px solid white; transition: transform 0.2s; }
            .theme-dot:hover { transform: scale(1.2); }
            .theme-dot.active { transform: scale(1.3); border-color: #333; }
        </style>
    </head>
    <body class="text-gray-900">
        <!-- Theme Switcher -->
        <div class="fixed bottom-8 right-8 z-[100]">
            <div id="theme-panel" class="hidden absolute bottom-16 right-0 bg-white p-4 rounded-2xl shadow-2xl border border-gray-100 flex-col space-y-3 min-w-[150px]">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pick a Theme</p>
                <div class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition-colors" onclick="setTheme('classic')">
                    <div class="theme-dot" style="background: linear-gradient(to right, #f43f5e, #ec4899);"></div>
                    <span class="text-sm font-medium">Classic Pink</span>
                </div>
                <div class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition-colors" onclick="setTheme('peach')">
                    <div class="theme-dot" style="background: linear-gradient(to right, #fb923c, #f43f5e);"></div>
                    <span class="text-sm font-medium">Soft Peach</span>
                </div>
                <div class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition-colors" onclick="setTheme('lavender')">
                    <div class="theme-dot" style="background: linear-gradient(to right, #a855f7, #ec4899);"></div>
                    <span class="text-sm font-medium">Lavender</span>
                </div>
                <div class="flex items-center space-x-3 cursor-pointer p-2 hover:bg-gray-50 rounded-lg transition-colors" onclick="setTheme('sakura')">
                    <div class="theme-dot" style="background: linear-gradient(to right, #fbcfe8, #f472b6);"></div>
                    <span class="text-sm font-medium">Sakura</span>
                </div>
            </div>
            <button onclick="toggleThemePanel()" class="w-14 h-14 bg-white rounded-full shadow-2xl flex items-center justify-center text-rose-500 hover:scale-110 transition-all border border-rose-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.172-1.172a4 4 0 115.656 5.656l-1.172 1.172" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="fixed w-full z-50 glass border-b border-rose-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">Yasmina</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-900 hover:text-primary transition-colors">Home</a>
                            @foreach($categories as $category)
                                <a href="#category-{{ $category->id }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-colors">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-primary mr-4">Login</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-full text-white bg-primary hover-bg-primary shadow-lg shadow-rose-200 transition-all">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="lg:w-1/2">
                    <div class="inline-block px-4 py-1.5 mb-6 text-sm font-semibold tracking-wide text-primary uppercase bg-rose-50 rounded-full" id="new-tag">New Collection 2024</div>
                    <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-gray-900 leading-tight">
                        Elegance in <br>
                        <span class="text-primary">Every Detail</span>
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 leading-relaxed">
                        Discover our curated collection of premium products, designed for those who appreciate quality and style.
                    </p>
                    <div class="mt-10 flex space-x-4">
                        <a href="#products" class="px-8 py-4 bg-primary text-white rounded-full font-semibold shadow-lg shadow-rose-200 hover-bg-primary transition-all hover:-translate-y-1">Shop Now</a>
                        <a href="#" class="px-8 py-4 bg-white text-primary border border-rose-100 rounded-full font-semibold shadow-sm hover:shadow-md transition-all hover:-translate-y-1">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-3/4 h-full gradient-bg rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 w-1/2 h-1/2 bg-secondary rounded-full opacity-10 blur-3xl"></div>
        </section>

        <!-- Products Section -->
        <section id="products" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900">Featured Products</h2>
                    <p class="mt-4 text-gray-600 italic">Handpicked items just for you</p>
                    <div class="mt-4 flex justify-center">
                        <div class="h-1 w-20 bg-gradient-to-r from-primary to-secondary rounded-full"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($featuredProducts as $product)
                        <div class="group relative bg-white rounded-3xl overflow-hidden soft-shadow transition-all duration-500 border border-rose-50">
                            <div class="aspect-square w-full overflow-hidden bg-rose-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-primary opacity-20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <span class="text-xs font-semibold text-primary uppercase tracking-widest">{{ $product->category->name }}</span>
                                <h3 class="mt-2 text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    <button class="p-2.5 rounded-full bg-rose-50 text-primary hover:bg-primary hover:text-white transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-rose-50/30 rounded-3xl border-2 border-dashed border-rose-100">
                            <p class="text-primary opacity-60">No products available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        @foreach($categories as $category)
            @if($category->products->count() > 0)
                <section id="category-{{ $category->id }}" class="py-20 border-t border-rose-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-end mb-10">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h2>
                                <p class="mt-2 text-gray-600">Explore items in this category</p>
                            </div>
                            <a href="#" class="text-primary font-semibold hover:text-primary transition-colors">View All</a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach($category->products->sortBy('rank')->take(4) as $product)
                                <div class="group relative">
                                    <div class="aspect-square w-full rounded-2xl overflow-hidden bg-rose-50 shadow-sm">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-primary opacity-20 text-4xl font-light">?</div>
                                        @endif
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-primary/5 transition-all duration-500"></div>
                                    </div>
                                    <div class="mt-4">
                                        <h3 class="text-sm text-gray-700 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
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
        <footer class="bg-gray-900 text-white py-20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary rounded-full opacity-10 blur-3xl -mr-32 -mt-32"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div>
                        <span class="text-2xl font-bold text-white">Yasmina</span>
                        <p class="mt-6 text-gray-400">Defining elegance and quality since 2024.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                        <ul class="space-y-4 text-gray-400">
                            <li><a href="#" class="hover:text-primary transition-colors">Shop</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Categories</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-6">Newsletter</h4>
                        <p class="text-gray-400 mb-6">Subscribe to get special offers and updates.</p>
                        <form class="flex">
                            <input type="email" placeholder="Email address" class="bg-gray-800 border-none rounded-l-full px-6 py-3 w-full focus:ring-2 focus:ring-primary outline-none">
                            <button class="bg-primary rounded-r-full px-6 py-3 font-semibold hover:opacity-90 transition-colors">Join</button>
                        </form>
                    </div>
                </div>
                <div class="mt-20 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                    &copy; 2024 Yasmina Website. All rights reserved.
                </div>
            </div>
        </footer>

        <script>
            const themes = {
                classic: {
                    primary: '#f43f5e',
                    'primary-hover': '#e11d48',
                    secondary: '#ec4899',
                    'bg-soft': '#fffafb',
                    'shadow-color': 'rgba(244, 63, 94, 0.2)'
                },
                peach: {
                    primary: '#fb923c',
                    'primary-hover': '#ea580c',
                    secondary: '#f43f5e',
                    'bg-soft': '#fffcf9',
                    'shadow-color': 'rgba(251, 146, 60, 0.2)'
                },
                lavender: {
                    primary: '#a855f7',
                    'primary-hover': '#9333ea',
                    secondary: '#ec4899',
                    'bg-soft': '#faf9ff',
                    'shadow-color': 'rgba(168, 85, 247, 0.2)'
                },
                sakura: {
                    primary: '#f472b6',
                    'primary-hover': '#db2777',
                    secondary: '#fbcfe8',
                    'bg-soft': '#fffafd',
                    'shadow-color': 'rgba(244, 114, 182, 0.2)'
                }
            };

            function setTheme(themeName) {
                const theme = themes[themeName];
                const root = document.documentElement;
                
                Object.keys(theme).forEach(key => {
                    root.style.setProperty('--' + key, theme[key]);
                });
                
                localStorage.setItem('yasmina-theme', themeName);
                toggleThemePanel();
            }

            function toggleThemePanel() {
                const panel = document.getElementById('theme-panel');
                panel.classList.toggle('hidden');
                panel.classList.toggle('flex');
            }

            // Load saved theme
            const savedTheme = localStorage.getItem('yasmina-theme');
            if (savedTheme && themes[savedTheme]) {
                // Apply theme without closing panel (since it's hidden by default)
                const theme = themes[savedTheme];
                const root = document.documentElement;
                Object.keys(theme).forEach(key => {
                    root.style.setProperty('--' + key, theme[key]);
                });
            }
        </script>
    </body>
</html>

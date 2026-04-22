<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-rose-600 leading-tight">
            {{ __('Admin Dashboard 2026') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar Menu -->
                <aside class="w-full md:w-64 shrink-0">
                    <div class="bg-white/70 backdrop-blur-md p-6 shadow-xl shadow-rose-100/50 rounded-3xl border border-rose-50 sticky top-24">
                        <h3 class="text-xs font-bold text-rose-400 uppercase tracking-widest mb-6">{{ __('Main Menu') }}</h3>
                        <nav class="space-y-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-rose-600 bg-rose-50 font-bold transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                {{ __('Categories') }}
                            </a>
                            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                {{ __('Products') }}
                            </a>
                            <a href="{{ route('currencies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-rose-50 hover:text-rose-500 transition-all font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Currencies') }}
                            </a>
                            
                            <div class="pt-4 mt-4 border-t border-rose-50">
                                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-white bg-rose-500 hover:bg-rose-600 transition-all shadow-lg shadow-rose-100 font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    {{ __('Back to Site') }}
                                </a>
                            </div>
                        </nav>
                    </div>
                </aside>

                <!-- Main Dashboard Content -->
                <div class="flex-1">
                    <div class="bg-white/70 backdrop-blur-md overflow-hidden shadow-xl shadow-rose-100/50 rounded-3xl border border-rose-50">
                        <div class="p-8 text-gray-900">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Overview') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <a href="{{ route('categories.index') }}" class="p-6 bg-rose-50 rounded-3xl border border-rose-100 hover:border-rose-300 transition-all group text-center">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-rose-500 mb-4 mx-auto shadow-sm group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </div>
                                    <span class="block font-bold text-rose-700">{{ __('Categories') }}</span>
                                </a>
                                <a href="{{ route('products.index') }}" class="p-6 bg-pink-50 rounded-3xl border border-pink-100 hover:border-pink-300 transition-all group text-center">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-pink-500 mb-4 mx-auto shadow-sm group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <span class="block font-bold text-pink-700">{{ __('Products') }}</span>
                                </a>
                                <a href="{{ route('currencies.index') }}" class="p-6 bg-rose-50 rounded-3xl border border-rose-100 hover:border-rose-300 transition-all group text-center">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-rose-500 mb-4 mx-auto shadow-sm group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="block font-bold text-rose-700">{{ __('Currencies') }}</span>
                                </a>
                            </div>

                            <div class="mt-12 bg-rose-50/50 p-8 rounded-3xl border border-dashed border-rose-200 text-center">
                                <h4 class="text-lg font-bold text-rose-800">{{ __('Welcome to your new Admin Dashboard!') }}</h4>
                                <p class="text-rose-600 mt-2">{{ __('From here you can manage all aspects of your store with ease.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

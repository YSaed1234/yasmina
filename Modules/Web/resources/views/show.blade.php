<x-web::layouts.master>
    <x-slot:title>{{ $product->name }} - Yasmina</x-slot:title>
    
    <main class="pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                <!-- Product Image -->
                <div class="relative">
                    <div class="aspect-square rounded-[3rem] overflow-hidden bg-white soft-shadow border border-yasmina-50 p-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-[2.5rem]">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-primary opacity-20 text-6xl">?</div>
                        @endif
                    </div>
                    @if($badge = $product->getBadge())
                        <div class="absolute top-8 left-8 {{ $badge['color'] }} text-sm font-black uppercase tracking-widest px-6 py-2 rounded-full shadow-2xl z-20">
                            {{ $badge['label'] }}
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="space-y-8">
                    <div>
                        <span class="inline-block px-4 py-1.5 bg-yasmina-50 text-primary text-xs font-bold uppercase tracking-[0.2em] rounded-full mb-4">
                            {{ $product->category->name }}
                        </span>
                        <h1 class="text-5xl font-bold text-gray-900 leading-tight">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <div class="flex flex-col">
                      @if($product->flash_sale_price && $product->flash_sale_expires_at && $product->flash_sale_expires_at->isFuture())
                            <div class="flex items-baseline gap-3 mb-2">
                                <span class="text-4xl font-black text-amber-600">{{ number_format($product->flash_sale_price, 2) }}</span>
                                <span class="text-xl font-bold text-amber-600">{{ $product->currency?->symbol ?? '$' }}</span>
                                <span class="text-lg text-gray-400 line-through ml-2">{{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="mt-4 bg-amber-50/50 border border-amber-100 rounded-3xl p-6 flex flex-col items-center gap-4 shadow-sm">
                                    <div class="flex items-center gap-2 text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm font-bold uppercase tracking-widest">{{ __('Special Offer Ends In') }}</span>
                                    </div>
                                    <div class="flex items-center gap-6 text-amber-600" data-countdown="{{ $product->flash_sale_expires_at->toIso8601String() }}">
                                        <div class="text-center">
                                            <span class="hours block text-3xl font-black tabular-nums">00</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ __('Hrs') }}</span>
                                        </div>
                                        <div class="w-px h-10 bg-amber-200"></div>
                                        <div class="text-center">
                                            <span class="minutes block text-3xl font-black tabular-nums">00</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ __('Min') }}</span>
                                        </div>
                                        <div class="w-px h-10 bg-amber-200"></div>
                                        <div class="text-center">
                                            <span class="seconds block text-3xl font-black tabular-nums">00</span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ __('Sec') }}</span>
                                        </div>
                                    </div>
                                </div>
                        @elseif($product->discount_price && $product->discount_price < $product->price)
                            <div class="flex flex-col items-center">
                                <span class="text-xs text-red-400 line-through">{{ number_format($product->price, 2) }}</span>
                                <span class="text-lg font-black text-gray-900">{{ number_format($product->discount_price, 2) }}</span>
                                <span class="text-[10px] font-bold text-yasmina-500">{{ $product->currency?->symbol ?? '$' }}</span>
                            </div>
                        @else
                            <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }}</span>
                            <span class="text-sm font-bold text-yasmina-500 ml-1">{{ $product->currency?->symbol ?? '$' }}</span>
                        @endif
                    </div>

                    <div class="prose pyasmina-rose max-w-none">
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="pt-8 border-t border-yasmina-50 space-y-6">
                        <form action="{{ route('web.cart.add', ['id' => $product->id, 'vendor_id' => request('vendor_id')]) }}" method="POST">
                            @csrf
                            <button type="submit" @if($product->stock <= 0) disabled @endif class="w-full py-5 {{ $product->stock <= 0 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-primary text-white hover:opacity-90 shadow-primary/20' }} rounded-2xl font-bold text-lg transition-all shadow-xl flex items-center justify-center gap-3">
                                @if($product->stock <= 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    {{ __('Sold Out') }}
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    {{ __('Add to Bag') }}
                                @endif
                            </button>
                        </form>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white rounded-2xl border border-yasmina-50 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-yasmina-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ __('Authentic Product') }}</span>
                            </div>
                            <div class="p-4 bg-white rounded-2xl border border-yasmina-50 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-yasmina-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold text-gray-600">{{ __('Global Shipping') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-web::layouts.master>

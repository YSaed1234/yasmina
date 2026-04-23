<x-web::layouts.master>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-rose-50 sticky top-24">
                        <div class="text-center mb-8">
                            <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-lg">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <nav class="space-y-2">
                            <a href="{{ route('web.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('Personal Details') }}</span>
                            </a>
                            <a href="{{ route('web.profile.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile.orders') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('My Orders') }}</span>
                            </a>
                            <a href="{{ route('web.wishlist') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.wishlist') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('My Favorites') }}</span>
                            </a>
                            <a href="{{ route('web.profile.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('web.profile.addresses') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-600 hover:bg-rose-50' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="font-bold text-sm">{{ __('My Addresses') }}</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-rose-50">
                        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Order History') }}</h1>
                        
                        @if($orders->count() > 0)
                            <div class="space-y-6">
                                @foreach($orders as $order)
                                    <div class="border border-gray-100 rounded-[2.5rem] overflow-hidden bg-white hover:border-primary transition-all duration-300">
                                        <div class="bg-rose-50/30 p-6 flex flex-wrap justify-between items-center gap-4 border-b border-gray-100">
                                            <div class="flex gap-8">
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Order Placed') }}</span>
                                                    <p class="text-sm font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Total Amount') }}</span>
                                                    <p class="text-sm font-bold text-primary">{{ number_format($order->total_amount, 2) }} {{ $order->items->first()?->product?->currency?->symbol ?? '$' }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __('Order ID') }}</span>
                                                    <p class="text-sm font-bold text-gray-900">#{{ $order->id }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-white text-primary border border-primary/10 shadow-sm">
                                                    {{ __($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-8">
                                            <div class="space-y-6">
                                                @foreach($order->items as $item)
                                                    <div class="flex items-center gap-6">
                                                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100">
                                                            @if($item->product && $item->product->image)
                                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-xl font-bold">?</div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <h4 class="font-bold text-gray-900">{{ $item->product->name ?? __('Product Not Found') }}</h4>
                                                            <p class="text-sm text-gray-500 mt-1">{{ __('Qty') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }}</p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            @if($item->product)
                                                                @php 
                                                                    $existingReview = auth()->user()->reviews()->where('product_id', $item->product->id)->first();
                                                                @endphp
                                                                <button onclick="toggleRatingForm({{ $item->id }})" class="px-6 py-2 {{ $existingReview ? 'bg-green-50 text-green-600' : 'bg-primary/5 text-primary' }} rounded-xl text-xs font-bold hover:opacity-80 transition-all flex items-center gap-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="{{ $existingReview ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                                    </svg>
                                                                    {{ $existingReview ? __('Rated') : __('Rate') }}
                                                                </button>
                                                                <a href="{{ route('web.products.show', $item->product->id) }}" class="px-6 py-2 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all">
                                                                    {{ __('Buy Again') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if($item->product)
                                                        <div id="rating-form-{{ $item->id }}" class="hidden mt-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                                            <form action="{{ route('web.reviews.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                                <div class="flex flex-wrap gap-6">
                                                                    <div class="flex-1 min-w-[200px]">
                                                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Your Rating') }}</label>
                                                                        <div class="flex gap-2 rating-stars">
                                                                            @for($i = 1; $i <= 5; $i++)
                                                                                <label class="cursor-pointer">
                                                                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ ($existingReview?->rating == $i) ? 'checked' : '' }} required>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200 peer-checked:text-yellow-400 hover:text-yellow-300 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                                    </svg>
                                                                                </label>
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-[2] min-w-[300px]">
                                                                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Review Comment') }} ({{ __('Optional') }})</label>
                                                                        <textarea name="comment" rows="2" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="{{ __('What did you think of this product?') }}">{{ $existingReview?->comment }}</textarea>
                                                                    </div>
                                                                    <div class="flex items-end">
                                                                        <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                                                            {{ __('Submit Review') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-10">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="p-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No orders yet') }}</h3>
                                <p class="text-gray-500 mb-8">{{ __('Your order history will appear here once you make your first purchase.') }}</p>
                                <a href="{{ route('web.shop') }}" class="inline-block px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                    {{ __('Start Shopping') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function toggleRatingForm(id) {
            const form = document.getElementById(`rating-form-${id}`);
            form.classList.toggle('hidden');
        }
    </script>
    @endpush
</x-web::layouts.master>

<x-web::layouts.master>
    <x-slot:title>{{ $promotion->name }} - {{ __('Yasmina') }}</x-slot:title>
    
    <main class="pt-32 pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Promotion Header -->
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 bg-rose-50 text-primary text-xs font-black uppercase tracking-[0.2em] rounded-full mb-4">
                    {{ $promotion->type === 'bogo_same' ? __('BOGO Deal') : __('Special Bundle') }}
                </span>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    {{ $promotion->name }}
                </h1>
                <div class="w-20 h-1 bg-primary mx-auto rounded-full"></div>
            </div>

            <!-- Promotion Logic Section -->
            <div class="bg-white rounded-[3rem] p-8 md:p-12 soft-shadow border border-rose-100 relative overflow-hidden mb-16">
                <!-- Background Decoration -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-rose-50 rounded-full opacity-50"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-rose-50 rounded-full opacity-50"></div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-3 px-6 py-3 bg-primary/10 rounded-2xl text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                            </svg>
                            <span class="font-bold text-lg">{{ __('Promotion Details') }}</span>
                        </div>
                        
                        <p class="text-xl text-gray-600 leading-relaxed">
                            @if($promotion->type === 'bogo_same')
                                {{ __('Buy :buy get :get free on :product', ['buy' => $promotion->buy_quantity, 'get' => $promotion->get_quantity, 'product' => $promotion->buyProduct->name]) }}
                            @elseif($promotion->type === 'bogo_different')
                                {{ __('Buy :buy from :product1 and get :get from :product2 for free!', [
                                    'buy' => $promotion->buy_quantity,
                                    'product1' => $promotion->buyProduct->name,
                                    'get' => $promotion->get_quantity,
                                    'product2' => $promotion->getProduct->name
                                ]) }}
                            @endif
                        </p>

                        @if($promotion->expires_at)
                            <div class="flex items-center gap-3 text-red-500 font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ __('Offer valid until') }}: {{ $promotion->expires_at->format('Y-m-d') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-center">
                        <div class="relative">
                            <div class="w-48 h-48 bg-primary rounded-full flex items-center justify-center text-white text-5xl font-black shadow-2xl shadow-primary/40 rotate-12">
                                {{ __('FREE') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Involved -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Buy Product -->
                <div class="group bg-white rounded-[2.5rem] p-6 soft-shadow border border-rose-50 hover:border-primary/20 transition-all duration-500">
                    <div class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">{{ __('Buy Item') }}</div>
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-rose-50 flex-shrink-0">
                            @if($promotion->buyProduct->image)
                                <img src="{{ asset('storage/' . $promotion->buyProduct->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-primary/20">?</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">
                                <a href="{{ route('web.products.show', ['id' => $promotion->buyProduct->id, 'vendor_id' => request('vendor_id')]) }}">
                                    {{ $promotion->buyProduct->name }}
                                </a>
                            </h3>
                            <p class="text-primary font-black mt-1">
                                {{ number_format($promotion->buyProduct->price, 2) }} {{ $promotion->buyProduct->currency?->symbol ?? '$' }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($promotion->type === 'bogo_different')
                    <!-- Get Product -->
                    <div class="group bg-white rounded-[2.5rem] p-6 soft-shadow border border-rose-50 hover:border-primary/20 transition-all duration-500">
                        <div class="text-xs font-black text-primary uppercase tracking-widest mb-4">{{ __('Get Item Free') }}</div>
                        <div class="flex items-center gap-6">
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-rose-50 flex-shrink-0">
                                @if($promotion->getProduct->image)
                                    <img src="{{ asset('storage/' . $promotion->getProduct->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-primary/20">?</div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">
                                    <a href="{{ route('web.products.show', ['id' => $promotion->getProduct->id, 'vendor_id' => request('vendor_id')]) }}">
                                        {{ $promotion->getProduct->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-400 line-through mt-1">
                                    {{ number_format($promotion->getProduct->price, 2) }} {{ $promotion->getProduct->currency?->symbol ?? '$' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                   <!-- Same Product -->
                   <div class="group bg-white rounded-[2.5rem] p-6 soft-shadow border border-rose-50 hover:border-primary/20 transition-all duration-500">
                        <div class="text-xs font-black text-primary uppercase tracking-widest mb-4">{{ __('Get Item Free') }}</div>
                        <div class="flex items-center gap-6">
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-rose-50 flex-shrink-0 opacity-50 grayscale">
                                @if($promotion->buyProduct->image)
                                    <img src="{{ asset('storage/' . $promotion->buyProduct->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-primary/20">?</div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $promotion->buyProduct->name }}
                                </h3>
                                <div class="mt-2 px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full inline-block uppercase tracking-widest">
                                    {{ __('Same Item Reward') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Call to Action -->
            <!-- Call to Action -->
            @if($promotion->buyProduct->price)
                <div class="mt-16 text-center">
                    <a href="{{ route('web.products.show', ['id' => $promotion->buyProduct->id, 'vendor_id' => request('vendor_id')]) }}" 
                    class="inline-flex items-center gap-3 px-12 py-5 bg-primary text-white rounded-2xl font-bold text-xl hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        {{ __('Shop This Deal') }}
                    </a>
                </div>
            @endif

            <!-- Vendor Contact Info -->
            @if($currentVendor)
                <div class="mt-16 bg-white rounded-[3rem] p-8 md:p-12 soft-shadow border border-rose-100 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Contact Info') }}</h2>
                                <p class="text-gray-500">{{ __('Have questions about this deal? Reach out to us!') }}</p>
                            </div>
                            <div class="flex flex-wrap gap-4">
                                @if($currentVendor->phone)
                                    <a href="tel:{{ $currentVendor->phone }}" class="flex items-center gap-3 px-6 py-3 bg-rose-50 text-primary rounded-2xl font-bold hover:bg-primary hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $currentVendor->phone }}
                                    </a>
                                @endif
                                @if($currentVendor->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $currentVendor->whatsapp) }}" target="_blank" class="flex items-center gap-3 px-6 py-3 bg-green-50 text-green-600 rounded-2xl font-bold hover:bg-green-600 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.29-4.143c1.589.943 3.14 1.42 4.78 1.421 5.421 0 9.833-4.412 9.836-9.835.002-2.628-1.022-5.1-2.885-6.964-1.862-1.863-4.331-2.887-6.956-2.888-5.422 0-9.835 4.412-9.838 9.835-.001 1.838.513 3.633 1.488 5.192l-.988 3.61 3.703-.971zm11.233-7.558c-.309-.154-1.826-.901-2.108-1.004-.283-.103-.489-.154-.696.154-.205.308-.797 1.004-.976 1.208-.18.203-.359.23-.668.077-.309-.154-1.303-.48-2.483-1.533-.918-.818-1.537-1.83-1.717-2.137-.18-.308-.02-.475.134-.629.14-.139.309-.359.464-.539.154-.18.206-.308.309-.514.103-.205.051-.385-.026-.539-.077-.154-.696-1.673-.952-2.289-.249-.601-.502-.519-.696-.529-.18-.009-.385-.011-.59-.011-.205 0-.539.077-.822.385-.283.308-1.079 1.054-1.079 2.57s1.105 2.978 1.259 3.184c.154.205 2.174 3.32 5.267 4.654.735.317 1.309.507 1.755.65.74.235 1.411.202 1.942.123.592-.088 1.826-.745 2.084-1.464.257-.719.257-1.335.18-1.464-.077-.128-.283-.205-.591-.359z" />
                                        </svg>
                                        {{ __('WhatsApp') }}
                                    </a>
                                @endif
                                @if($currentVendor->email)
                                    <a href="mailto:{{ $currentVendor->email }}" class="flex items-center gap-3 px-6 py-3 bg-blue-50 text-blue-600 rounded-2xl font-bold hover:bg-blue-600 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ __('Email Us') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
</x-web::layouts.master>

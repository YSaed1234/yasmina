<x-web::layouts.master>
    <x-slot:title>{{ __('About Us') }} - Yasmina</x-slot:title>

    <x-web::sections.hero 
        :slides="$slides"
        :showButton="false"
    />

    <div class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                <div>
                    @if($vendor)
                        <h2 class="text-4xl font-bold text-gray-900 mb-8">{{ $vendor->name }}</h2>
                        <div class="prose prose-rose max-w-none">
                            <p class="text-lg text-gray-600 leading-relaxed mb-6 whitespace-pre-line">
                                {{ app()->getLocale() == 'ar' ? ($vendor->about_ar ?? $vendor->description) : ($vendor->about_en ?? $vendor->description) }}
                            </p>
                        </div>
                    @else
                        <h2 class="text-4xl font-bold text-gray-900 mb-8">{{ __('Craftsmanship & Quality') }}</h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            {{ __('At Yasmina, we believe that true luxury lies in the details. Every product in our collection is carefully selected for its superior quality, timeless design, and exceptional craftsmanship.') }}
                        </p>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ __('Our mission is to provide an unparalleled shopping experience for those who seek elegance and sophistication in every aspect of their lives.') }}
                        </p>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="aspect-square bg-rose-50 rounded-3xl overflow-hidden shadow-lg">
                        <img src="{{ ($vendor && $vendor->about_image1) ? asset('storage/' . $vendor->about_image1) : 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&q=80&w=600' }}" class="w-full h-full object-cover" alt="Fashion">
                    </div>
                    <div class="aspect-square bg-rose-50 rounded-3xl overflow-hidden shadow-lg translate-y-12">
                        <img src="{{ ($vendor && $vendor->about_image2) ? asset('storage/' . $vendor->about_image2) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=600' }}" class="w-full h-full object-cover" alt="Product">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

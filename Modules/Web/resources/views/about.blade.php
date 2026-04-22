<x-web::layouts.master>
    <x-slot:title>{{ __('About Us') }} - Yasmina</x-slot:title>

    <x-web::sections.hero 
        :title="__('Our Story & <br> <span class=\'text-primary\'>Vision</span>')"
        :subtitle="__('About Yasmina')"
        :description="__('Since 2026, Yasmina has been at the forefront of luxury fashion and lifestyle, bringing you the most exclusive products from around the world.')"
        image="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2000"
        :showButton="false"
    />

    <div class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-8">{{ __('Craftsmanship & Quality') }}</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        {{ __('At Yasmina, we believe that true luxury lies in the details. Every product in our collection is carefully selected for its superior quality, timeless design, and exceptional craftsmanship.') }}
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        {{ __('Our mission is to provide an unparalleled shopping experience for those who seek elegance and sophistication in every aspect of their lives.') }}
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="aspect-square bg-rose-50 rounded-3xl overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover" alt="Fashion">
                    </div>
                    <div class="aspect-square bg-rose-50 rounded-3xl overflow-hidden shadow-lg translate-y-12">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover" alt="Product">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

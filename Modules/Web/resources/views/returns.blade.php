<x-web::layouts.master>
    <x-slot:title>{{ __('Return Policy') }} - Yasmina</x-slot:title>

    <x-web::sections.hero 
        :title="__('Return & Exchange Policy')"
        :subtitle="__('Our Commitment to You')"
        :description="__('We want you to be completely satisfied with your purchase. Read our policies below to understand how we handle returns and exchanges.')"
        :slides="$slides"
    />

    <div class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="prose prose-lg prose-yasmina max-w-none">
                <div class="bg-yasmina-50/30 rounded-[3rem] p-12 border border-yasmina-100 shadow-sm">
                    
                    @php 
                        $policyField = 'return_policy_' . app()->getLocale();
                        $vendorPolicy = $currentVendor ? $currentVendor->$policyField : null;
                    @endphp

                    @if($vendorPolicy)
                        <div class="text-gray-700 leading-relaxed text-lg font-medium">
                            {!! $vendorPolicy !!}
                        </div>
                    @else
                        <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b border-yasmina-100 pb-4">
                            {{ __('1. General Conditions') }}
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ __('To be eligible for a return, your item must be in the same condition that you received it, unworn or unused, with tags, and in its original packaging. You’ll also need the receipt or proof of purchase.') }}
                        </p>

                        <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b border-yasmina-100 pb-4">
                            {{ __('2. Return Period') }}
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ __('We have a 14-day return policy, which means you have 14 days after receiving your item to request a return.') }}
                        </p>

                        <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b border-yasmina-100 pb-4">
                            {{ __('3. Non-Returnable Items') }}
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            {{ __('Certain types of items cannot be returned, like:') }}
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2 mb-8">
                            <li>{{ __('Perishable goods (such as food, flowers, or plants)') }}</li>
                            <li>{{ __('Custom products (such as special orders or personalized items)') }}</li>
                            <li>{{ __('Personal care goods (such as beauty products)') }}</li>
                            <li>{{ __('Sale items or gift cards') }}</li>
                        </ul>

                        <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b border-yasmina-100 pb-4">
                            {{ __('4. Process') }}
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ __('To start a return, you can contact us at our customer support. If your return is accepted, we’ll send you a return shipping label, as well as instructions on how and where to send your package. Items sent back to us without first requesting a return will not be accepted.') }}
                        </p>

                        <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b border-yasmina-100 pb-4">
                            {{ __('5. Refunds') }}
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ __('We will notify you once we’ve received and inspected your return, and let you know if the refund was approved or not. If approved, you’ll be automatically refunded on your original payment method within 10 business days.') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="mt-16 text-center">
                <p class="text-gray-500 mb-6">{{ __('Have more questions about our policies?') }}</p>
                <a href="{{ route('web.contact', ['vendor_id' => request('vendor_id')]) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary-hover transition-all shadow-xl shadow-primary/20">
                    {{ __('Contact Support') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-web::layouts.master>

<x-web::layouts.master>
    <x-slot:title>{{ __('Contact Us') }} - Yasmina</x-slot:title>

    <x-web::sections.hero 
        :slides="$slides"
        :showButton="false"
    />

    <div class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                    <!-- Contact Info -->
                    <div class="space-y-12">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Our Boutique') }}</h2>
                            <p class="text-gray-600 leading-relaxed">
                                {{ __('Yasmina is a global online luxury destination, bringing the finest products directly to your doorstep.') }}
                            </p>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ __('Location') }}</h4>
                                    <p class="text-gray-600">{{ __('Online Site') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ __('Email') }}</h4>
                                    <p class="text-gray-600">contact@yasmina.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-rose-50/50 p-10 rounded-[3rem] border border-rose-100">
                        @if(session('success'))
                            <div class="mb-8 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 text-sm font-bold">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('web.contact.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Name') }}</label>
                                <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" required class="w-full px-6 py-4 bg-white border border-rose-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Email') }}</label>
                                <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" required class="w-full px-6 py-4 bg-white border border-rose-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Subject') }}</label>
                                <input type="text" name="subject" class="w-full px-6 py-4 bg-white border border-rose-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Message') }}</label>
                                <textarea name="message" rows="5" required class="w-full px-6 py-4 bg-white border border-rose-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all shadow-sm"></textarea>
                            </div>

                            <button type="submit" class="w-full py-5 bg-primary text-white rounded-2xl font-bold text-lg hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                                {{ __('Send Message') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

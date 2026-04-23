<x-web::layouts.master>
    <x-slot:title>{{ __('Become a Service Provider') }} - Yasmina</x-slot:title>

    <div class="relative min-h-[60vh] flex items-center justify-center py-32 overflow-hidden bg-white">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-rose-50/30 -skew-x-12 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/5 rounded-full -translate-x-1/2 translate-y-1/2 blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight">
                        {{ __('Join Our') }} <span class="text-primary">{{ __('Network') }}</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        {{ __('Are you a luxury service provider? Join Yasmina and reach thousands of customers looking for exclusive products and services.') }}
                    </p>
                </div>

                <div class="bg-white p-10 md:p-16 rounded-[3rem] shadow-2xl shadow-rose-100/50 border border-rose-50">
                    @if(session('success'))
                        <div class="mb-10 p-6 bg-green-50 text-green-700 rounded-3xl border border-green-100 flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('web.register-vendor') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Store Name -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Store Name') }}</label>
                                <input type="text" name="name" value="{{ old('name') }}" required 
                                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('name') border-red-500 @enderror"
                                    placeholder="{{ __('e.g. My Luxury Boutique') }}">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Business Email') }}</label>
                                <input type="email" name="email" value="{{ old('email') }}" required 
                                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('email') border-red-500 @enderror"
                                    placeholder="contact@yourbusiness.com">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required 
                                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('phone') border-red-500 @enderror"
                                    placeholder="+20 1XX XXX XXXX">
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Secondary Phone -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Secondary Phone (Optional)') }}</label>
                                <input type="text" name="phone_secondary" value="{{ old('phone_secondary') }}" 
                                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                    placeholder="{{ __('Other contact number') }}">
                            </div>

                            <!-- Password -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Password') }}</label>
                                <input type="password" name="password" required 
                                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('password') border-red-500 @enderror">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" required 
                                    class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Store Logo') }}</label>
                            <div class="relative group">
                                <input type="file" name="logo" accept="image/*"
                                    class="w-full px-6 py-4 bg-gray-50 border border-dashed border-rose-200 rounded-2xl cursor-pointer hover:bg-rose-50 transition-all text-sm text-gray-500 file:hidden">
                                <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('About Your Business') }}</label>
                            <textarea name="description" rows="4" 
                                class="w-full px-6 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none"
                                placeholder="{{ __('Tell us about your services and what makes you unique...') }}">{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-6">
                            <button type="submit" 
                                class="w-full py-5 bg-primary text-white rounded-2xl font-bold uppercase tracking-widest hover:bg-primary-hover hover:shadow-2xl hover:shadow-primary/30 transition-all transform hover:-translate-y-1">
                                {{ __('Submit Application') }}
                            </button>
                        </div>

                        <p class="text-center text-sm text-gray-500 italic">
                            {{ __('Your application will be reviewed by our team. We will contact you at the provided email/phone for further coordination.') }}
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

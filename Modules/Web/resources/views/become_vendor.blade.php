<x-web::layouts.master>
    <x-slot:title>{{ __('Become a Service Provider') }} - Yasmina</x-slot:title>

    <div class="relative min-h-[50vh] flex items-center justify-center py-4 lg:py-24 overflow-hidden bg-white">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-yasmina-50/30 -skew-x-12 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/5 rounded-full -translate-x-1/2 translate-y-1/2 blur-3xl"></div>

        <div class="container mx-auto px-4 lg:px-6 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-4 lg:mb-16">
                    <h1 class="text-lg lg:text-6xl font-black text-gray-900 mb-2 lg:mb-6 tracking-tight leading-tight">
                        {{ __('Join Our') }} <span class="text-primary">{{ __('Network') }}</span>
                    </h1>
                    <p class="text-[10px] lg:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed px-2">
                        {{ __('Are you a luxury service provider? Join Yasmina and reach thousands of customers looking for exclusive products and services.') }}
                    </p>
                </div>

                <div class="bg-white p-3.5 lg:p-16 rounded-2xl lg:rounded-[3rem] shadow-2xl shadow-yasmina-100/50 border border-yasmina-50">
                    @if(session('success'))
                        <div class="mb-5 lg:mb-10 p-3 lg:p-6 bg-green-50 text-green-700 rounded-xl lg:rounded-3xl border border-green-100 flex items-center gap-2.5 lg:gap-4">
                            <div class="w-8 h-8 lg:w-12 lg:h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-6 lg:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-[10px] lg:text-base">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('web.register-vendor') }}" method="POST" enctype="multipart/form-data" class="space-y-3 lg:space-y-8">
                        @csrf
                        <input type="hidden" name="vendor_id" value="{{ request('vendor_id') }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 lg:gap-8">
                            <!-- Store Name -->
                            <div class="space-y-1">
                                <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Store Name') }}</label>
                                <input type="text" name="name" value="{{ old('name') }}" required 
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('name') border-red-500 @enderror text-[11px] lg:text-base"
                                    placeholder="{{ __('e.g. My Luxury Boutique') }}">
                                @error('name') <p class="text-red-500 text-[8px] lg:text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-1">
                                <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Business Email') }}</label>
                                <input type="email" name="email" value="{{ old('email') }}" required 
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('email') border-red-500 @enderror text-[11px] lg:text-base"
                                    placeholder="contact@yourbusiness.com">
                                @error('email') <p class="text-red-500 text-[8px] lg:text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="space-y-1">
                                <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required 
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('phone') border-red-500 @enderror text-[11px] lg:text-base"
                                    placeholder="+20 1XX XXX XXXX">
                                @error('phone') <p class="text-red-500 text-[8px] lg:text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Secondary Phone -->
                            <div class="space-y-1">
                                <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Secondary Phone (Optional)') }}</label>
                                <input type="text" name="phone_secondary" value="{{ old('phone_secondary') }}" 
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-[11px] lg:text-base"
                                    placeholder="{{ __('Other contact number') }}">
                            </div>

                            <!-- Password -->
                            <div class="space-y-1">
                                <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Password') }}</label>
                                <input type="password" name="password" required 
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('password') border-red-500 @enderror text-[11px] lg:text-base">
                                @error('password') <p class="text-red-500 text-[8px] lg:text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-1">
                                <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" required 
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-[11px] lg:text-base">
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="space-y-1">
                            <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('Store Logo') }}</label>
                            <div class="relative group">
                                <input type="file" name="logo" accept="image/*"
                                    class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-dashed border-yasmina-200 rounded-xl lg:rounded-2xl cursor-pointer hover:bg-yasmina-50 transition-all text-[9px] lg:text-sm text-gray-500 file:hidden">
                                <div class="absolute inset-y-0 right-4 lg:right-6 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 lg:h-6 lg:w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('logo') <p class="text-red-500 text-[8px] lg:text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-1">
                            <label class="text-[8px] lg:text-sm font-bold text-gray-700 uppercase tracking-widest">{{ __('About Your Business') }}</label>
                            <textarea name="description" rows="2" 
                                class="w-full px-4 py-2 lg:px-6 lg:py-4 bg-gray-50 border border-transparent rounded-xl lg:rounded-2xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none text-[11px] lg:text-base"
                                placeholder="{{ __('Tell us about your services and what makes you unique...') }}">{{ old('description') }}</textarea>
                        </div>

                        <div class="pt-1.5 lg:pt-6">
                            <button type="submit" 
                                class="w-full py-3 lg:py-5 bg-primary text-white rounded-xl lg:rounded-2xl font-bold uppercase tracking-widest hover:bg-primary-hover hover:shadow-2xl hover:shadow-primary/30 transition-all transform hover:-translate-y-1 text-xs lg:text-base">
                                {{ __('Submit Application') }}
                            </button>
                        </div>

                        <p class="text-center text-[9px] lg:text-sm text-gray-500 italic px-2 leading-tight">
                            {{ __('Your application will be reviewed by our team. We will contact you at the provided email/phone for further coordination.') }}
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

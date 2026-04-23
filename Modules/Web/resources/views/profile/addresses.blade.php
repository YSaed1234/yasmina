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
                        <div class="flex justify-between items-center mb-10">
                            <h1 class="text-3xl font-bold text-gray-900">{{ __('My Addresses') }}</h1>
                            <button onclick="toggleAddressForm()" class="px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                {{ __('Add New Address') }}
                            </button>
                        </div>

                        <!-- Address Form (Hidden by default) -->
                        <div id="addressForm" class="hidden mb-12 bg-rose-50/30 p-8 rounded-[2.5rem] border border-rose-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('Add a New Address') }}</h3>
                            <form action="{{ route('web.profile.addresses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @csrf
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Address Name (e.g. Home, Office)') }}</label>
                                    <input type="text" name="name" required class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" required class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Country') }}</label>
                                    <input type="text" name="country" value="Egypt" required class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:col-span-2">
                                    <div>
                                        <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Governorate') }}</label>
                                        <select name="governorate_id" id="governorate_select" required onchange="loadRegions(this.value)" class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm bg-white">
                                            <option value="">{{ __('Select Governorate') }}</option>
                                            @foreach($governorates as $gov)
                                                <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('governorate_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Area / Region') }}</label>
                                        <select name="region_id" id="region_select" required class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm bg-white disabled:opacity-50" disabled>
                                            <option value="">{{ __('Select area') }}</option>
                                        </select>
                                        @error('region_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Street Address') }}</label>
                                    <input type="text" name="address_line1" required class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('City') }}</label>
                                    <input type="text" name="city" required class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-primary uppercase tracking-widest mb-2">{{ __('Postal Code') }}</label>
                                    <input type="text" name="postal_code" class="w-full px-5 py-3 rounded-xl border border-rose-100 focus:ring-2 focus:ring-primary outline-none text-sm">
                                </div>
                                <div class="md:col-span-2 flex justify-end gap-4">
                                    <button type="button" onclick="toggleAddressForm()" class="px-6 py-3 text-gray-500 font-bold text-sm">{{ __('Cancel') }}</button>
                                    <button type="submit" class="px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20">{{ __('Save Address') }}</button>
                                </div>
                            </form>
                        </div>
                        
                        @if($addresses->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($addresses as $address)
                                    <div class="p-8 border border-gray-100 rounded-3xl bg-white hover:border-primary transition-all group relative">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                    </svg>
                                                </div>
                                                <h4 class="font-bold text-gray-900">{{ $address->name }}</h4>
                                            </div>
                                            <form action="{{ route('web.profile.addresses.delete', $address->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $address->address_line1 }}<br>
                                            {{ $address->region?->name ?? $address->city }}@if($address->governorate), {{ $address->governorate->name }}@endif, {{ $address->country }}<br>
                                            {{ $address->phone }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                <p class="text-gray-400 mb-6">{{ __('You haven\'t saved any addresses yet.') }}</p>
                                <button onclick="toggleAddressForm()" class="text-primary font-bold hover:underline">{{ __('Add your first address') }}</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAddressForm() {
            const form = document.getElementById('addressForm');
            form.classList.toggle('hidden');
        }

        async function loadRegions(govId) {
            const regionSelect = document.getElementById('region_select');
            regionSelect.innerHTML = '<option value="">{{ __("Loading...") }}</option>';
            regionSelect.disabled = true;

            if (!govId) {
                regionSelect.innerHTML = '<option value="">{{ __("Select area") }}</option>';
                return;
            }

            try {
                const response = await fetch(`/api/governorates/${govId}/regions`);
                const regions = await response.json();
                
                regionSelect.innerHTML = '<option value="">{{ __("Select area") }}</option>';
                regions.forEach(region => {
                    const option = document.createElement('option');
                    option.value = region.id;
                    option.textContent = `${region.name} (${parseFloat(region.rate).toFixed(2)})`;
                    regionSelect.appendChild(option);
                });
                regionSelect.disabled = false;
            } catch (error) {
                console.error('Error loading regions:', error);
                regionSelect.innerHTML = '<option value="">{{ __("Error loading areas") }}</option>';
            }
        }
    </script>
</x-web::layouts.master>

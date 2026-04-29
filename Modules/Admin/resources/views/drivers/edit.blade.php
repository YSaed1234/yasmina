<x-admin::layouts.master>
    <div class="mb-10">
        <a href="{{ route('admin.drivers.index') }}" class="text-primary font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Drivers') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Edit Driver') }}: {{ $driver->name }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Update driver profile and availability.') }}</p>
    </div>

    <form action="{{ route('admin.drivers.update', $driver) }}" method="POST" class="max-w-4xl">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Full Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $driver->name) }}" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                    @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone Number') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $driver->phone) }}" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                    @error('phone') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Email Address') }} ({{ __('Optional') }})</label>
                    <input type="email" name="email" value="{{ old('email', $driver->email) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Institution') }} ({{ __('Optional') }})</label>
                    <select name="vendor_id" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all appearance-none">
                        <option value="">{{ __('Global Driver (All Institutions)') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id', $driver->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vehicle Type') }}</label>
                    <input type="text" name="vehicle_type" value="{{ old('vehicle_type', $driver->vehicle_type) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vehicle Number') }}</label>
                    <input type="text" name="vehicle_number" value="{{ old('vehicle_number', $driver->vehicle_number) }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none font-bold text-gray-700 transition-all">
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $driver->is_active) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-checked:bg-primary transition-all"></div>
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:left-7"></div>
                    </div>
                    <span class="text-sm font-bold text-gray-600 group-hover:text-primary transition-colors">{{ __('Driver is Active') }}</span>
                </label>
            </div>

            <div class="pt-10">
                <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-3">
                    {{ __('Update Driver') }}
                </button>
            </div>
        </div>
    </form>
</x-admin::layouts.master>

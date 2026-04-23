<x-admin::layouts.master>
    <div class="mb-10">
        <a href="{{ route('admin.vendors.index') }}" class="text-primary font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Vendors') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Edit Vendor') }}: {{ $vendor->name }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Update institution or service provider details.') }}</p>
    </div>

    <div class="max-w-4xl bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
        <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Logo') }}</label>
                    <div class="flex items-center gap-6">
                        @if($vendor->logo)
                            <img src="{{ asset('storage/' . $vendor->logo) }}" class="w-20 h-20 rounded-2xl object-cover shadow-md">
                        @endif
                        <input type="file" name="logo" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Vendor Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $vendor->name) }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Status') }}</label>
                    <select name="status" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        <option value="active" {{ $vendor->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ $vendor->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $vendor->email) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Password') }}</label>
                    <input type="password" name="password" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium" placeholder="{{ __('Leave blank to keep current') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Address') }}</label>
                    <textarea name="address" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">{{ old('address', $vendor->address) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Description') }}</label>
                    <textarea name="description" rows="5" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">{{ old('description', $vendor->description) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="px-12 py-5 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                    {{ __('Update Vendor') }}
                </button>
            </div>
        </form>
    </div>
</x-admin::layouts.master>

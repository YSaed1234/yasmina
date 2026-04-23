<x-vendor::layouts.master>
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ __('Contact Message') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Detailed view of the customer inquiry.') }}</p>
        </div>
        <a href="{{ route('vendor.contacts.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-10">
                <h3 class="text-xl font-bold text-gray-900 mb-8 border-b border-gray-50 pb-6">{{ $contact->subject ?? __('No Subject') }}</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $contact->message }}
                </div>
            </div>
        </div>

        <div class="space-y-10">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8">
                <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6">{{ __('Sender Information') }}</h4>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $contact->name }}</p>
                            <p class="text-xs text-gray-500">{{ __('Customer') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 truncate max-w-[150px]">{{ $contact->email }}</p>
                            <a href="mailto:{{ $contact->email }}" class="text-xs text-primary hover:underline">{{ __('Reply via Email') }}</a>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ __('Received On') }}</p>
                        <p class="text-sm text-gray-700 font-bold">{{ $contact->created_at->format('M d, Y - h:i A') }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('vendor.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this message?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-4 bg-red-50 text-red-500 rounded-2xl font-bold hover:bg-red-500 hover:text-white transition-all">
                    {{ __('Delete Message') }}
                </button>
            </form>
        </div>
    </div>
</x-vendor::layouts.master>

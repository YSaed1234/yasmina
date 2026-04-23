<x-vendor::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Contact Requests') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('View messages sent to your boutique.') }}</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 text-sm font-bold flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        <table class="w-full text-left rtl:text-right">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">#</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Sender') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Subject') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-sm font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50/50 transition-colors group {{ $contact->status === 'pending' ? 'bg-primary/5 font-bold' : '' }}">
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-400">{{ $loop->iteration + ($contacts->firstItem() - 1) }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-gray-900">{{ $contact->name }}</p>
                        <p class="text-xs text-gray-400 font-normal">{{ $contact->email }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-gray-700 truncate max-w-xs">{{ $contact->subject ?? __('No Subject') }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs text-gray-500">{{ $contact->created_at->format('Y-m-d H:i') }}</p>
                    </td>
                    <td class="px-8 py-5">
                        @if($contact->status === 'new')
                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider border border-amber-100">
                                {{ __('New') }}
                            </span>
                        @elseif($contact->status === 'read')
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                                {{ __('Read') }}
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider border border-green-100">
                                {{ __('Replied') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-3">
                            @if($contact->status !== 'replied')
                                <button type="button" 
                                        onclick="confirmAction({{ $contact->id }}, 'replied')"
                                        class="p-2 text-gray-400 hover:text-green-500 transition-colors" 
                                        title="{{ __('Mark as replied') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            @endif
                            @if($contact->status === 'pending')
                                <button type="button" 
                                        onclick="confirmAction({{ $contact->id }}, 'read')"
                                        class="p-2 text-gray-400 hover:text-blue-500 transition-colors" 
                                        title="{{ __('Mark as read') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            @endif
                            <a href="{{ route('vendor.contacts.show', $contact->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <form action="{{ route('vendor.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-gray-400 font-medium">
                        {{ __('No contact requests found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
    <div class="mt-8">
        {{ $contacts->links() }}
    </div>
    @endif

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500/30 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left rtl:text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-primary/10 mb-6">
                        <svg class="h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" id="modal-title">
                        {{ __('Confirm Action') }}
                    </h3>
                    <p class="text-gray-500 mb-10">
                        {{ __('Are you sure you want to mark this message as read? This will move it from your active inquiries.') }}
                    </p>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                        {{ __('Cancel') }}
                    </button>
                    <form id="confirmForm" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                            {{ __('Confirm') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmAction(id, action) {
            const modal = document.getElementById('confirmModal');
            const form = document.getElementById('confirmForm');
            const title = document.getElementById('modal-title');
            const text = modal.querySelector('p');
            
            if (action === 'read') {
                form.action = `/vendor-panel/contact-requests/${id}/read`;
                title.innerText = '{{ __('Confirm Read') }}';
                text.innerText = '{{ __('Are you sure you want to mark this message as read?') }}';
            } else {
                form.action = `/vendor-panel/contact-requests/${id}/replied`;
                title.innerText = '{{ __('Confirm Reply') }}';
                text.innerText = '{{ __('Are you sure you want to mark this message as replied?') }}';
            }
            
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-vendor::layouts.master>

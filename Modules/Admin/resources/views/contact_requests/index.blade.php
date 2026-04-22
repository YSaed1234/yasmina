<x-admin::layouts.master>
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Contact Requests') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('Manage and respond to customer inquiries.') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl border border-green-100 text-sm font-bold flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-center text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">
                        <th class="pb-4 px-6">{{ __('Name') }}</th>
                        <th class="pb-4 px-6">{{ __('Email') }}</th>
                        <th class="pb-4 px-6">{{ __('Subject') }}</th>
                        <th class="pb-4 px-6">{{ __('Message') }}</th>
                        <th class="pb-4 px-6">{{ __('Status') }}</th>
                        <th class="pb-4 px-6">{{ __('Date') }}</th>
                        <th class="pb-4 px-6">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr class="bg-gray-50/50 hover:bg-rose-50/30 transition-colors rounded-2xl">
                            <td class="py-6 px-6 text-center text-sm font-bold text-gray-900 first:rounded-l-2xl">{{ $request->name }}</td>
                            <td class="py-6 px-6 text-center text-sm text-gray-600">{{ $request->email }}</td>
                            <td class="py-6 px-6 text-center text-sm text-gray-600">{{ $request->subject ?? '-' }}</td>
                            <td class="py-6 px-6 text-center text-sm text-gray-600 max-w-xs truncate" title="{{ $request->message }}">{{ $request->message }}</td>
                            <td class="py-6 px-6 text-center">
                                @if($request->status == 'new')
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-blue-100">
                                        {{ __('New') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-green-100">
                                        {{ __('Replied') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-6 px-6 text-center text-sm text-gray-500 font-medium">
                                {{ $request->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="py-6 px-6 text-center last:rounded-r-2xl">
                                @if($request->status == 'new')
                                    <button type="button" 
                                            onclick="confirmReplied({{ $request->id }})"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:opacity-90 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('Mark Replied') }}
                                    </button>
                                @else
                                    <span class="text-gray-400 italic text-xs">{{ __('Replied') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="bg-gray-50 rounded-3xl p-10 inline-block border-2 border-dashed border-gray-100">
                                    <p class="text-gray-400 font-bold tracking-wider">{{ __('No contact requests found.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-10">
            {{ $requests->links() }}
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-rose-50 mb-6">
                        <svg class="h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4" id="modal-title">
                        {{ __('Confirm Reply') }}
                    </h3>
                    <p class="text-gray-500 mb-10">
                        {{ __('Are you sure you want to mark this request as replied? This action cannot be undone.') }}
                    </p>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-gray-100 text-gray-700 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                        {{ __('Cancel') }}
                    </button>
                    <form id="confirmForm" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                            {{ __('Confirm') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmReplied(id) {
            const modal = document.getElementById('confirmModal');
            const form = document.getElementById('confirmForm');
            form.action = `/admin-dashboard-2026/contact-requests/${id}/replied`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    </script>
</x-admin::layouts.master>

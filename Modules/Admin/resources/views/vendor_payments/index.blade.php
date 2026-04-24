<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Vendor Payments') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage Yasmina commission collections from vendors.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Total Commission Expected') }}</p>
            <h3 class="text-3xl font-black text-gray-900">{{ number_format($stats['total_commission'], 2) }} <span class="text-sm font-bold text-gray-400">LE</span></h3>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">{{ __('Total Amount Collected') }}</p>
            <h3 class="text-3xl font-black text-emerald-600">{{ number_format($stats['total_paid'], 2) }} <span class="text-sm font-bold text-gray-400">LE</span></h3>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm ring-2 ring-red-50">
            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-2">{{ __('Total Outstanding Balance') }}</p>
            <h3 class="text-3xl font-black text-red-600">{{ number_format($stats['remaining_balance'], 2) }} <span class="text-sm font-bold text-gray-400">LE</span></h3>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">{{ __('Vendors Balance Summary') }}</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Vendor') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Total Commission') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Total Paid') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-red-600">{{ __('Remaining Balance') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($vendors as $vendor)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            @if($vendor->logo)
                                <img src="{{ asset('storage/' . $vendor->logo) }}" class="w-10 h-10 rounded-xl object-cover shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <span class="font-bold text-gray-900 block">{{ $vendor->name }}</span>
                                <span class="text-[10px] text-gray-400 uppercase font-black tracking-widest">{{ $vendor->phone }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 font-bold text-gray-900">
                        {{ number_format($vendor->total_commission, 2) }} LE
                    </td>
                    <td class="px-8 py-6 font-bold text-emerald-600">
                        {{ number_format($vendor->total_paid, 2) }} LE
                    </td>
                    <td class="px-8 py-6 font-black text-red-600">
                        {{ number_format($vendor->remaining_balance, 2) }} LE
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick="openPaymentModal({{ $vendor->id }}, '{{ $vendor->name }}')" class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                                {{ __('Add Payment') }}
                            </button>
                            <a href="{{ route('admin.vendor_payments.show', $vendor) }}" class="px-4 py-2 bg-primary/10 text-primary rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all">
                                {{ __('View History') }}
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-8 py-6 bg-gray-50/50">
            {{ $vendors->links() }}
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.vendor_payments.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
                    @csrf
                    <input type="hidden" name="vendor_id" id="modal_vendor_id">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-gray-900 mb-1">{{ __('Record New Payment') }}</h3>
                        <p class="text-gray-500 text-sm" id="modal_vendor_name"></p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">{{ __('Amount (LE)') }}</label>
                            <input type="number" step="0.01" name="amount" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all font-bold">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">{{ __('Payment Date') }}</label>
                            <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all font-bold">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">{{ __('Receipt / Attachment') }}</label>
                            <div class="relative group">
                                <input type="file" name="receipt" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="px-6 py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl group-hover:border-primary transition-all flex items-center justify-center gap-2 text-gray-500 font-bold text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    {{ __('Upload Image') }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">{{ __('Notes (Optional)') }}</label>
                            <textarea name="notes" rows="2" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all font-bold"></textarea>
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closePaymentModal()" class="flex-1 py-4 bg-gray-100 text-gray-600 rounded-2xl font-bold hover:bg-gray-200 transition-all">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-xl shadow-primary/20">
                            {{ __('Save Payment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openPaymentModal(vendorId, vendorName) {
            document.getElementById('modal_vendor_id').value = vendorId;
            document.getElementById('modal_vendor_name').innerText = vendorName;
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-admin::layouts.master>

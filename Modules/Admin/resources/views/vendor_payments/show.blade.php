<x-admin::layouts.master>
    <div class="mb-10 flex items-center gap-6">
        <a href="{{ route('admin.vendor_payments.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 hover:text-primary shadow-sm border border-gray-100 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $vendor->name }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Payment history and commission summary.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 group transition-all">
            <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Due Commission') }}</h3>
            <p class="text-3xl font-black text-gray-900">{{ number_format($vendor->total_commission, 2) }} <span class="text-xs font-bold text-gray-400">LE</span></p>
        </div>

        <div class="bg-emerald-50 p-8 rounded-[2.5rem] shadow-sm border border-emerald-100 group transition-all">
            <h3 class="text-emerald-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Total Paid') }}</h3>
            <p class="text-3xl font-black text-emerald-600">{{ number_format($vendor->total_paid, 2) }} <span class="text-xs font-bold text-emerald-400">LE</span></p>
        </div>

        <div class="bg-red-50 p-8 rounded-[2.5rem] shadow-sm border border-red-100 group transition-all">
            <h3 class="text-red-500 text-[10px] font-black uppercase tracking-widest mb-1">{{ __('Remaining Balance') }}</h3>
            <p class="text-3xl font-black text-red-600">{{ number_format($vendor->remaining_balance, 2) }} <span class="text-xs font-bold text-red-400">LE</span></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50">
            <h3 class="text-xl font-bold text-gray-800">{{ __('Payment History') }}</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Amount') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Receipt') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Recorded By') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Notes') }}</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($payments as $payment)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-6 font-bold text-gray-900">
                        {{ $payment->payment_date->format('Y-m-d') }}
                    </td>
                    <td class="px-8 py-6 font-black text-emerald-600">
                        {{ number_format($payment->amount, 2) }} LE
                    </td>
                    <td class="px-8 py-6">
                        @if($payment->receipt_path)
                            <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="flex items-center gap-2 text-primary font-bold text-xs hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ __('View Receipt') }}
                            </a>
                        @else
                            <span class="text-gray-300 text-xs italic">{{ __('No Receipt') }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-sm font-bold text-gray-600">{{ $payment->creator->name ?? 'System' }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs text-gray-500 max-w-xs">{{ $payment->notes }}</p>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <form action="{{ route('admin.vendor_payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this payment record?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900">{{ __('No payment records found') }}</h4>
                            <p class="text-gray-500 text-sm mt-1">{{ __('Records will appear here after they are added.') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-8 py-6 bg-gray-50/50">
            {{ $payments->links() }}
        </div>
    </div>
</x-admin::layouts.master>

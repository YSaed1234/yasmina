<x-admin::layouts.master>
    <div class="p-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.returns.index') }}" class="p-2 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-yasmina-600 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Return Request') }} #{{ $returnRequest->id }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Items -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Items for Return') }}</h3>
                    <div class="space-y-4">
                        @foreach($returnRequest->items as $item)
                            <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <img src="{{ $item->orderItem->product->image_url }}" alt="{{ $item->orderItem->product->name }}" class="w-16 h-16 rounded-xl object-cover border border-gray-100">
                                <div class="ms-4 flex-1">
                                    <p class="font-bold text-gray-900">{{ $item->orderItem->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ __('Quantity') }}: <span class="font-bold text-yasmina-600">{{ $item->quantity }}</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-gray-400 uppercase">{{ __('Item Price') }}</p>
                                    <p class="font-bold text-gray-900">{{ number_format($item->orderItem->price, 2) }} {{ $returnRequest->order->vendor->currency_code ?? 'LE' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reason & Notes -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Reason for Return') }}</h4>
                            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-amber-800">
                                {{ $returnRequest->reason }}
                            </div>
                        </div>
                        @if($returnRequest->vendor_notes)
                            <div>
                                <h4 class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-3">{{ __('Institution Notes') }}</h4>
                                <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 text-blue-800">
                                    {{ $returnRequest->vendor_notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                @php
                    $isLocked = in_array($returnRequest->status, ['approved', 'completed']) && !auth()->user()->isAdmin();
                @endphp

                <!-- Action Form -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Process Return') }}</h3>
                    <form action="{{ route('admin.returns.update-status', $returnRequest) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Status') }}</label>
                            <select name="status" class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 font-bold text-gray-700 h-12"
                                {{ $isLocked ? 'disabled' : '' }}>
                                <option value="pending" {{ $returnRequest->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="approved" {{ $returnRequest->status === 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                <option value="rejected" {{ $returnRequest->status === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                <option value="completed" {{ $returnRequest->status === 'completed' ? 'selected' : '' }}>{{ __('Completed & Refunded') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Refund Amount') }}</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="refund_amount" value="{{ $returnRequest->refund_amount }}" 
                                    class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 font-bold text-gray-900 ps-10 h-12"
                                    {{ $isLocked ? 'disabled' : '' }}>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs">{{ $returnRequest->order->vendor->currency_code ?? 'LE' }}</div>
                            </div>
                            <p class="mt-2 text-[10px] text-gray-400 uppercase tracking-widest">{{ __('Total Order') }}: {{ number_format($returnRequest->order->total, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Refund Method') }}</label>
                            <select name="refund_method" class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 font-bold text-gray-700 h-12"
                                {{ $isLocked ? 'disabled' : '' }}>
                                <option value="wallet" {{ $returnRequest->refund_method === 'wallet' ? 'selected' : '' }}>{{ __('Refund to Wallet') }} ({{ __('Automatic') }})</option>
                                <option value="manual" {{ $returnRequest->refund_method === 'manual' ? 'selected' : '' }}>{{ __('Manual / Other') }}</option>
                            </select>
                            @if(!$isLocked)
                                <p class="mt-2 text-[10px] text-amber-600 font-bold uppercase tracking-widest">{{ __('Wallet refund happens automatically on Approval') }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Admin Notes') }}</label>
                            <textarea name="admin_notes" rows="4" class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 text-sm" placeholder="{{ __('Notes for the customer...') }}" {{ $isLocked ? 'disabled' : '' }}>{{ $returnRequest->admin_notes }}</textarea>
                        </div>

                        @if(!$isLocked)
                            <button type="submit" class="w-full py-4 bg-yasmina-600 text-white rounded-2xl font-bold shadow-lg shadow-yasmina-600/20 hover:bg-yasmina-700 transition-all">
                                {{ __('Update Return Request') }}
                            </button>
                        @endif
                    </form>
                    @if($isLocked)
                        <p class="mt-4 text-[10px] text-rose-600 font-black uppercase text-center tracking-widest">{{ __('Only Super-Admins can modify approved returns') }}</p>
                    @endif
                </div>

                <!-- Info -->
                <div class="bg-yasmina-50/50 rounded-[2.5rem] p-8 border border-yasmina-100">
                    <h4 class="text-xs font-bold text-yasmina-600 uppercase tracking-widest mb-6">{{ __('Request Info') }}</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ __('Customer') }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $returnRequest->user->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ __('Institution') }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $returnRequest->vendor->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ __('Order Total') }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($returnRequest->order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts.master>

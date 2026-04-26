<x-vendor::layouts.master>
    <div class="p-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('vendor.returns.index') }}" class="p-2 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-yasmina-600 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Return Request') }} #{{ $returnRequest->id }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Items -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Items for Return') }}</h3>
                    <div class="space-y-4">
                        @foreach($returnRequest->items as $item)
                            <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <img src="{{ $item->orderItem->product->image_url }}" alt="{{ $item->orderItem->product->name }}" class="w-16 h-16 rounded-xl object-cover">
                                <div class="ms-4 flex-1">
                                    <p class="font-bold text-gray-900">{{ $item->orderItem->product->name }}</p>
                                    <div class="flex items-center gap-4 mt-1">
                                        <p class="text-sm text-gray-500">{{ __('Qty') }}: <span class="font-bold text-yasmina-600">{{ $item->quantity }}</span></p>
                                        <p class="text-sm text-gray-500">{{ __('Price') }}: <span class="font-bold text-gray-900">{{ number_format($item->orderItem->price, 2) }}</span></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ __('Subtotal') }}</p>
                                    <p class="font-black text-yasmina-600">{{ number_format($item->quantity * $item->orderItem->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reason -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Customer Reason') }}</h4>
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-amber-800 italic">
                        "{{ $returnRequest->reason }}"
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                @php
                    $isLocked = in_array($returnRequest->status, ['approved', 'completed']);
                @endphp

                <!-- Status -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Status') }}</h3>
                    <span class="px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest block text-center
                        {{ $returnRequest->status === 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                        {{ $returnRequest->status === 'approved' ? 'bg-blue-100 text-blue-600' : '' }}
                        {{ $returnRequest->status === 'rejected' ? 'bg-rose-100 text-rose-600' : '' }}
                        {{ $returnRequest->status === 'completed' ? 'bg-green-100 text-green-600' : '' }}
                    ">
                        {{ __($returnRequest->status) }}
                    </span>
                    @if($returnRequest->refund_amount > 0)
                        <div class="mt-4 text-center">
                            <p class="text-xs font-bold text-gray-400 uppercase">{{ __('Refund Amount') }}</p>
                            <p class="text-xl font-bold text-yasmina-600">{{ number_format($returnRequest->refund_amount, 2) }} {{ auth('vendor')->user()->currency_code ?? 'LE' }}</p>
                        </div>
                    @endif
                </div>

                <!-- Notes Form -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Return Processing') }}</h3>
                    <form action="{{ route('vendor.returns.update-notes', $returnRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Status') }}</label>
                            <select name="status" class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 font-bold text-gray-700 h-12"
                                {{ $isLocked ? 'disabled' : '' }}>
                                <option value="pending" {{ $returnRequest->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="approved" {{ $returnRequest->status === 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                <option value="rejected" {{ $returnRequest->status === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                @if($returnRequest->status === 'completed')
                                    <option value="completed" selected>{{ __('Completed') }}</option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Refund Amount') }}</label>
                            <input type="number" step="0.01" name="refund_amount" value="{{ $returnRequest->refund_amount }}" 
                                class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 text-sm font-bold h-12" 
                                placeholder="0.00" 
                                {{ $isLocked ? 'disabled' : '' }}>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Refund Method') }}</label>
                            <select name="refund_method" class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 font-bold text-gray-700 h-12"
                                {{ $isLocked ? 'disabled' : '' }}>
                                <option value="wallet" {{ $returnRequest->refund_method === 'wallet' ? 'selected' : '' }}>{{ __('Refund to Wallet') }}</option>
                                <option value="manual" {{ $returnRequest->refund_method === 'manual' ? 'selected' : '' }}>{{ __('Manual / Other') }}</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Vendor Notes') }}</label>
                            <textarea name="vendor_notes" rows="4" 
                                class="w-full rounded-xl border-gray-100 focus:border-yasmina-500 focus:ring-yasmina-500 text-sm" 
                                placeholder="{{ __('Provide info to the admin about these items...') }}"
                                {{ $isLocked ? 'disabled' : '' }}>{{ $returnRequest->vendor_notes }}</textarea>
                        </div>

                        @if(!$isLocked)
                            <button type="submit" class="w-full py-4 bg-yasmina-600 text-white rounded-2xl font-bold hover:bg-yasmina-700 transition-all shadow-lg shadow-yasmina-600/20">
                                {{ __('Save Details') }}
                            </button>
                        @endif
                    </form>
                    <p class="mt-4 text-[10px] text-gray-400 uppercase text-center tracking-widest">
                        @if($isLocked)
                            {{ __('This request is locked and cannot be edited by the institution.') }}
                        @else
                            {{ __('Admin will review your notes before finalizing') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-vendor::layouts.master>

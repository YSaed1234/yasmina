<x-web::layouts.master>
    <div class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-web::profile-sidebar />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-yasmina-50">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ __('Return Request') }} #{{ $returnRequest->id }}</h1>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-sm text-gray-400 font-medium">{{ __('Order') }} #{{ $returnRequest->order_id }}</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-sm text-gray-400 font-medium">{{ $returnRequest->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div>
                                <span class="px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-sm
                                    {{ $returnRequest->status === 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                                    {{ $returnRequest->status === 'approved' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $returnRequest->status === 'rejected' ? 'bg-rose-100 text-rose-600' : '' }}
                                    {{ $returnRequest->status === 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                ">
                                    {{ __($returnRequest->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">{{ __('Returned Items') }}</h3>
                                <div class="space-y-4">
                                    @foreach($returnRequest->items as $item)
                                        <div class="flex items-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                            <div class="w-14 h-14 rounded-xl overflow-hidden border border-white shadow-sm shrink-0">
                                                <img src="{{ $item->orderItem->product->image_url }}" alt="{{ $item->orderItem->product->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="ms-4 flex-1">
                                                <p class="font-bold text-gray-900 text-sm">{{ $item->orderItem->product->name }}</p>
                                                <p class="text-xs text-gray-400 font-bold mt-1 uppercase">{{ __('Quantity') }}: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">{{ __('Return Details') }}</h3>
                                <div class="p-8 bg-yasmina-50/30 rounded-[2.5rem] border border-yasmina-50 space-y-8">
                                    <div>
                                        <p class="text-[10px] font-black text-yasmina-300 uppercase tracking-widest mb-2">{{ __('Reason') }}</p>
                                        <p class="text-gray-700 leading-relaxed font-medium">"{{ $returnRequest->reason }}"</p>
                                    </div>
                                    
                                    @if($returnRequest->refund_amount > 0)
                                        <div class="pt-6 border-t border-yasmina-50">
                                            <p class="text-[10px] font-black text-yasmina-300 uppercase tracking-widest mb-2">{{ __('Refund Amount') }}</p>
                                            <p class="text-2xl font-bold text-primary">{{ number_format($returnRequest->refund_amount, 2) }} {{ $returnRequest->order->vendor->currency_code ?? 'LE' }}</p>
                                            <div class="mt-3 flex items-center gap-2 text-green-600 font-bold text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ __('Refunded to your wallet balance') }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($returnRequest->admin_notes)
                                        <div class="pt-6 border-t border-yasmina-50">
                                            <p class="text-[10px] font-black text-rose-300 uppercase tracking-widest mb-2">{{ __('Admin Response') }}</p>
                                            <p class="text-gray-600 italic leading-relaxed">"{{ $returnRequest->admin_notes }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 pt-8 border-t border-gray-50 flex justify-start">
                            <a href="{{ route('web.profile.orders') }}" class="flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-primary transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                {{ __('Back to Order History') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-web::layouts.master>

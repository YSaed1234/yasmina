<x-admin::layouts.master>
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Contracts Expiration Report') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Monitor vendor contracts and their expiration status.') }}</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Vendor') }}</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Signed Date') }}</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Expiration Date') }}</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Status') }}</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Remaining Days') }}</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($vendors as $vendor)
                    @php
                        $signedAt = $vendor->contract_signed_at;
                        $expiresAt = $signedAt ? $signedAt->addYear() : null;
                        $daysLeft = $expiresAt ? now()->diffInDays($expiresAt, false) : null;
                        $isExpired = $expiresAt && $expiresAt->isPast();
                        $isExpiringSoon = $expiresAt && !$isExpired && $daysLeft <= 30;
                    @endphp
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
                                    <span class="font-bold text-gray-900 block text-sm">{{ $vendor->name }}</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $vendor->manager_name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-sm font-bold text-gray-600">{{ $signedAt ? $signedAt->format('Y-m-d') : '---' }}</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-sm font-bold {{ $isExpired ? 'text-red-500' : ($isExpiringSoon ? 'text-amber-500' : 'text-gray-600') }}">
                                {{ $expiresAt ? $expiresAt->format('Y-m-d') : '---' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if(!$signedAt)
                                <span class="px-3 py-1 bg-gray-100 text-gray-400 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    {{ __('Not Signed') }}
                                </span>
                            @elseif($isExpired)
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-100">
                                    {{ __('Expired') }}
                                </span>
                            @elseif($isExpiringSoon)
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100">
                                    {{ __('Expiring Soon') }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-100">
                                    {{ __('Valid') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($signedAt)
                                <div class="flex flex-col items-center">
                                    <span class="text-sm font-black {{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-amber-600' : 'text-gray-900') }}">
                                        {{ $isExpired ? __('Expired since') : '' }} {{ abs($daysLeft) }} {{ __('Days') }}
                                    </span>
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full mt-2 overflow-hidden">
                                        @php
                                            $progress = $signedAt ? min(100, max(0, (now()->diffInDays($signedAt) / 365) * 100)) : 0;
                                        @endphp
                                        <div class="h-full {{ $isExpired ? 'bg-red-500' : ($isExpiringSoon ? 'bg-amber-500' : 'bg-green-500') }}" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-300">---</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.vendors.contract', $vendor) }}" title="{{ __('Legal Contract') }}" class="p-2 text-gray-400 hover:text-yasmina-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.vendors.edit', $vendor) }}" title="{{ __('Edit') }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-gray-50/50">
            {{ $vendors->links() }}
        </div>
    </div>
</x-admin::layouts.master>

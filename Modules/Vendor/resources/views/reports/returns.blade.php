<x-vendor::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Returns Analysis') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Track and analyze product return requests for your institution.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-12">
        @foreach($returnStats as $stat)
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __($stat->status) }}</p>
                    <p class="text-3xl font-black text-gray-900">{{ $stat->count }}</p>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                    </svg>
                </div>
            </div>
        @endforeach
        @if($returnStats->isEmpty())
             <div class="col-span-4 bg-white p-12 rounded-3xl border border-dashed border-gray-200 text-center text-gray-400 italic">
                {{ __('No return data available for your products.') }}
            </div>
        @endif
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 bg-gray-50/30">
            <h2 class="text-xl font-bold text-gray-900">{{ __('Recent Return Requests') }}</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Request') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ __('Status') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Date') }}</th>
                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentReturns as $request)
                    <tr class="hover:bg-gray-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <span class="block font-bold text-gray-900">#{{ $request->id }}</span>
                            <span class="text-xs text-gray-400">{{ __('Order') }} #{{ $request->order_id }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="block font-bold text-gray-900">{{ $request->user->name }}</span>
                            <span class="text-xs text-gray-400">{{ $request->user->email }}</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                {{ $request->status === 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                                {{ $request->status === 'approved' ? 'bg-blue-100 text-blue-600' : '' }}
                                {{ $request->status === 'rejected' ? 'bg-rose-100 text-rose-600' : '' }}
                                {{ $request->status === 'completed' ? 'bg-green-100 text-green-600' : '' }}
                            ">
                                {{ __($request->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right text-xs text-gray-500 font-medium">
                            {{ $request->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('vendor.returns.show', $request) }}" class="text-primary font-bold text-sm hover:underline">
                                {{ __('View Details') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic">
                            {{ __('No recent return requests found for your products.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-vendor::layouts.master>

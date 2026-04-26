<x-vendor::layouts.master>
    <div class="p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Return Requests') }}</h1>
                <p class="text-gray-500 mt-1">{{ __('Monitor return requests for your products.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('ID') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($requests as $request)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-5 font-bold text-gray-900">#{{ $request->id }}</td>
                                <td class="px-8 py-5 text-sm text-gray-700 font-bold">{{ $request->user->name }}</td>
                                <td class="px-8 py-5 text-sm font-bold text-gray-500">#{{ $request->order_id }}</td>
                                <td class="px-8 py-5">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                        {{ $request->status === 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                                        {{ $request->status === 'approved' ? 'bg-blue-100 text-blue-600' : '' }}
                                        {{ $request->status === 'rejected' ? 'bg-rose-100 text-rose-600' : '' }}
                                        {{ $request->status === 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                    ">
                                        {{ __($request->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500">{{ $request->created_at->format('Y-m-d') }}</td>
                                <td class="px-8 py-5">
                                    <a href="{{ route('vendor.returns.show', $request) }}" class="px-4 py-2 bg-yasmina-50 text-yasmina-600 rounded-xl text-xs font-bold hover:bg-yasmina-500 hover:text-white transition-all inline-block border border-yasmina-100 shadow-sm">
                                        {{ __('View Details') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($requests->hasPages())
                <div class="px-8 py-5 bg-gray-50/50 border-t border-gray-100">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-vendor::layouts.master>

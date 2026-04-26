<x-admin::layouts.master>
    <div class="p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Return Requests') }}</h1>
                <p class="text-gray-500 mt-1">{{ __('Manage and process customer return requests.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('ID') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Customer') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Order') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Institution') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                            <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($requests as $request)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="font-bold text-gray-900">#{{ $request->id }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-xl bg-yasmina-100 flex items-center justify-center text-yasmina-600 font-bold">
                                            {{ substr($request->user->name, 0, 1) }}
                                        </div>
                                        <div class="ms-3">
                                            <p class="font-bold text-gray-900">{{ $request->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $request->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm font-bold text-gray-700">
                                    #{{ $request->order_id }}
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">
                                        {{ $request->vendor->name }}
                                    </span>
                                </td>
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
                                <td class="px-8 py-5 text-sm text-gray-500">
                                    {{ $request->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-8 py-5">
                                    <a href="{{ route('admin.returns.show', $request) }}" class="p-2 bg-yasmina-50 text-yasmina-600 rounded-xl hover:bg-yasmina-500 hover:text-white transition-all inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
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
</x-admin::layouts.master>

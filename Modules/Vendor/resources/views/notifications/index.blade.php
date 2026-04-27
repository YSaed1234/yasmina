<x-vendor::layouts.master :title="__('All Notifications')">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">{{ __('Notifications') }}</h1>
            <p class="text-gray-500 font-medium">{{ __('Keep track of your institution activities and alerts.') }}</p>
        </div>
        
        <form action="{{ route('vendor.notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-white border border-gray-100 text-gray-600 font-bold hover:bg-gray-50 transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Mark all as read') }}
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-50">
            @forelse($notifications as $notification)
                <div class="p-6 flex items-start gap-4 transition-colors {{ $notification->read_at ? 'opacity-60 bg-white' : 'bg-primary/5' }}">
                    <div class="w-12 h-12 rounded-2xl {{ $notification->read_at ? 'bg-gray-100 text-gray-400' : 'bg-primary/10 text-primary' }} flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-bold text-gray-900">{{ $notification->data['title'] ?? __('Notification') }}</h3>
                            <span class="text-xs text-gray-400 font-bold">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">{{ $notification->data['message'] }}</p>
                        
                        <div class="flex items-center gap-3">
                            @if(isset($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                    {{ __('View Details') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            @endif
                            
                            @if(!$notification->read_at)
                                <form action="{{ route('vendor.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">
                                        {{ __('Mark as read') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-20 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No notifications found') }}</h3>
                    <p class="text-gray-500">{{ __('You are all caught up!') }}</p>
                </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-vendor::layouts.master>

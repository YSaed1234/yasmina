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
                    <div class="bg-white rounded-3xl p-10 shadow-sm border border-rose-50">
                        <div class="flex justify-between items-center mb-8">
                            <h1 class="text-3xl font-bold text-gray-900">{{ __('Notifications') }}</h1>
                            <form action="{{ route('web.notifications.mark-all-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm font-bold text-primary hover:underline">{{ __('Mark all as read') }}</button>
                            </form>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($notifications as $notification)
                                <div id="notification-page-{{ $notification->id }}" class="group p-6 rounded-3xl border border-rose-50 transition-all hover:border-primary/30 relative {{ $notification->read_at ? 'bg-white' : 'bg-rose-50/10' }}">
                                    <div class="flex gap-6 items-start">
                                        <div class="w-12 h-12 rounded-2xl {{ $notification->read_at ? 'bg-gray-50 text-gray-400' : 'bg-primary/10 text-primary' }} flex items-center justify-center shrink-0 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-1">
                                                <p class="font-bold text-gray-900 leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>
                                                <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex items-center gap-4 mt-4">
                                                @if(isset($notification->data['action_url']))
                                                    <a href="{{ $notification->data['action_url'] }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                                        {{ __('View Details') }}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                @unless($notification->read_at)
                                                    <button onclick="markNotificationPageAsRead('{{ $notification->id }}', this)" class="text-[10px] font-bold text-gray-400 hover:text-primary transition-colors flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        {{ __('Mark as read') }}
                                                    </button>
                                                @endunless
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No notifications yet') }}</h3>
                                    <p class="text-gray-500">{{ __('You will receive alerts here about your orders and account.') }}</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-12">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function markNotificationPageAsRead(id, btn) {
            markAsRead(id, btn.parentElement); // Use existing function in master layout
            const item = document.getElementById(`notification-page-${id}`);
            item.classList.add('bg-white');
            item.classList.remove('bg-rose-50/10');
            item.classList.add('opacity-60');
            btn.remove();
        }
    </script>
    @endpush
</x-web::layouts.master>

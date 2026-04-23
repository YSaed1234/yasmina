<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Slideshow Settings') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Manage the images and text on your homepage hero slider.') }}</p>
        </div>
        <a href="{{ route('admin.slides.create') }}" class="px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Add New Slide') }}
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-400">{{ __('Image') }}</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-400">{{ __('Title') }}</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-400">{{ __('Order') }}</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-400">{{ __('Status') }}</th>
                    <th class="px-8 py-5 text-xs font-black uppercase tracking-widest text-gray-400 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($slides as $slide)
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="w-24 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-100">
                                <img src="{{ asset('storage/' . $slide->image) }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="font-bold text-gray-900">{{ $slide->title_en }}</div>
                            <div class="text-xs text-gray-400 mt-1 font-medium">{{ $slide->title_ar }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">{{ $slide->order }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $slide->active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                {{ $slide->active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.slides.edit', $slide->id) }}" class="p-2 text-gray-400 hover:text-primary transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L11.707 13.5a1 1 0 01-.44.284l-2.42.807a1 1 0 01-1.284-1.284l.807-2.42a1 1 0 01.284-.44L16.5 3.5z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No slides found') }}</h3>
                            <p class="text-gray-500 mb-8">{{ __('Get started by creating your first hero slide.') }}</p>
                            <a href="{{ route('admin.slides.create') }}" class="inline-block px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all">
                                {{ __('Add First Slide') }}
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin::layouts.master>

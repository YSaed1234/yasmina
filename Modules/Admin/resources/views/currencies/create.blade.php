<x-admin::layouts.master>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Add New Currency</h1>

        <div class="bg-white rounded-3xl shadow-sm border border-rose-50 p-8">
            <form action="{{ route('currencies.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Currency Name</label>
                    <input type="text" name="name" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" placeholder="e.g. US Dollar" required>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Code</label>
                        <input type="text" name="code" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" placeholder="e.g. USD" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Symbol</label>
                        <input type="text" name="symbol" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" placeholder="e.g. $" required>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-rose-500 text-white rounded-full font-bold hover:bg-rose-600 transition-all shadow-lg shadow-rose-100">Create Currency</button>
                </div>
            </form>
        </div>
    </div>
</x-admin::layouts.master>

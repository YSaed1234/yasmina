<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('categories.index') }}" class="block p-6 bg-indigo-50 border border-indigo-100 rounded-xl hover:bg-indigo-100 transition-colors">
                            <h3 class="text-lg font-bold text-indigo-700">Manage Categories</h3>
                            <p class="text-indigo-600/70 mt-1">Add, edit or delete product categories.</p>
                        </a>
                        <a href="{{ route('products.index') }}" class="block p-6 bg-purple-50 border border-purple-100 rounded-xl hover:bg-purple-100 transition-colors">
                            <h3 class="text-lg font-bold text-purple-700">Manage Products</h3>
                            <p class="text-purple-600/70 mt-1">Add, edit or delete products with details.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

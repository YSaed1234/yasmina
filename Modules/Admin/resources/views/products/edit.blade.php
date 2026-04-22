<x-admin::layouts.master>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Product</h1>

        <div class="bg-white rounded-3xl shadow-sm border border-rose-50 p-8">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                        <select name="category_id" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Currency</label>
                        <select name="currency_id" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" required>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ $product->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->name }} ({{ $currency->symbol }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Price</label>
                        <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Rank</label>
                        <input type="number" name="rank" value="{{ $product->rank }}" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-2xl border-rose-100 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/20">{{ $product->description }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Product Image</label>
                        @if($product->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-32 w-32 object-cover rounded-2xl border border-rose-100">
                            </div>
                        @endif
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 transition-all cursor-pointer">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-4 bg-rose-500 text-white rounded-full font-bold hover:bg-rose-600 transition-all shadow-lg shadow-rose-100">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</x-admin::layouts.master>

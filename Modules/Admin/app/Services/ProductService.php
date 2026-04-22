<?php

namespace Modules\Admin\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with('category')->orderBy('rank')->get();
    }

    public function storeProduct(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('products', 'public');
        }
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $data['image']->store('products', 'public');
        }
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return $product->delete();
    }

    public function findProduct(string $id)
    {
        return Product::with('category')->findOrFail($id);
    }
}

<?php

namespace Modules\Admin\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with(['category', 'translations', 'category.translations', 'currency'])->orderBy('rank')->get();
    }

    public function storeProduct(array $data)
    {
        $product = new Product();
        $product->category_id = $data['category_id'];
        $product->currency_id = $data['currency_id'];
        $product->price = $data['price'];
        $product->rank = $data['rank'] ?? 0;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $product->image = $data['image']->store('products', 'public');
        }

        foreach (['ar', 'en'] as $locale) {
            if (isset($data[$locale])) {
                foreach (['name', 'description'] as $attr) {
                    if (isset($data[$locale][$attr])) {
                        $product->translateOrNew($locale)->$attr = $data[$locale][$attr];
                    }
                }
            }
        }

        $product->save();
        return $product;
    }

    public function updateProduct(Product $product, array $data)
    {
        $product->category_id = $data['category_id'] ?? $product->category_id;
        $product->currency_id = $data['currency_id'] ?? $product->currency_id;
        $product->price = $data['price'] ?? $product->price;
        $product->rank = $data['rank'] ?? $product->rank;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $data['image']->store('products', 'public');
        }

        foreach (['ar', 'en'] as $locale) {
            if (isset($data[$locale])) {
                foreach (['name', 'description'] as $attr) {
                    if (isset($data[$locale][$attr])) {
                        $product->translateOrNew($locale)->$attr = $data[$locale][$attr];
                    }
                }
            }
        }

        $product->save();
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

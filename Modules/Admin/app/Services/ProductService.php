<?php

namespace Modules\Admin\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts(array $filters = [])
    {
        $query = Product::with(['category', 'translations', 'category.translations', 'currency'])->orderBy('rank');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereTranslationLike('name', "%{$search}%");
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function storeProduct(array $data)
    {
        $product = new Product();
        $product->category_id = $data['category_id'];
        $product->currency_id = $data['currency_id'];
        $product->price = $data['price'];
        $product->discount_price = $data['discount_price'] ?? null;
        $product->flash_sale_price = $data['flash_sale_price'] ?? null;
        $product->flash_sale_expires_at = $data['flash_sale_expires_at'] ?? null;
        $product->is_gift = isset($data['is_gift']) && $data['is_gift'];
        $product->gift_threshold = $data['gift_threshold'] ?? null;
        $product->vendor_id = $data['vendor_id'] ?? null;
        $product->rank = $data['rank'] ?? 0;
        $product->stock = $data['stock'] ?? 0;

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
        $product->discount_price = array_key_exists('discount_price', $data) ? $data['discount_price'] : $product->discount_price;
        $product->flash_sale_price = array_key_exists('flash_sale_price', $data) ? $data['flash_sale_price'] : $product->flash_sale_price;
        $product->flash_sale_expires_at = array_key_exists('flash_sale_expires_at', $data) ? $data['flash_sale_expires_at'] : $product->flash_sale_expires_at;
        $product->is_gift = isset($data['is_gift']) && $data['is_gift'];
        $product->gift_threshold = array_key_exists('gift_threshold', $data) ? $data['gift_threshold'] : $product->gift_threshold;
        $product->vendor_id = $data['vendor_id'] ?? $product->vendor_id;
        $product->rank = $data['rank'] ?? $product->rank;
        $product->stock = $data['stock'] ?? $product->stock;

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

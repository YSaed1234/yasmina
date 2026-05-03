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
        $product->custom_badge = $data['custom_badge'] ?? null;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $product->image = $data['image']->store('products', 'public');
        }

        $product->save();

        // Handle Variants
        if (isset($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $index => $variantData) {
                if (!empty($variantData['color']) || !empty($variantData['size'])) {
                    $imagePath = null;
                    if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $imagePath = $variantData['image']->store('products/variants', 'public');
                    }

                    $product->variants()->create([
                        'color' => $variantData['color'],
                        'size' => $variantData['size'],
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'] ?? 0,
                        'sku' => $variantData['sku'] ?? null,
                        'image' => $imagePath,
                    ]);
                }
            }
        }

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
        $product->custom_badge = array_key_exists('custom_badge', $data) ? $data['custom_badge'] : $product->custom_badge;

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

        // Handle Variants Sync
        if (isset($data['variants']) && is_array($data['variants'])) {
            $variantIds = [];
            foreach ($data['variants'] as $index => $variantData) {
                if (!empty($variantData['color']) || !empty($variantData['size'])) {
                    $vData = [
                        'color' => $variantData['color'],
                        'size' => $variantData['size'],
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'] ?? 0,
                        'sku' => $variantData['sku'] ?? null,
                    ];

                    if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $vData['image'] = $variantData['image']->store('products/variants', 'public');
                    }

                    $variant = $product->variants()->updateOrCreate(
                        ['id' => $variantData['id'] ?? null],
                        $vData
                    );
                    $variantIds[] = $variant->id;
                }
            }
            // Delete variants not in the request
            $product->variants()->whereNotIn('id', $variantIds)->delete();
        } else if (array_key_exists('variants', $data)) {
            $product->variants()->delete();
        }

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

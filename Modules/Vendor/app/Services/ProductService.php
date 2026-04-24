<?php

namespace Modules\Vendor\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function getVendorProducts($vendorId)
    {
        return Product::where('vendor_id', $vendorId)
            ->with(['category', 'translations', 'currency'])
            ->latest()
            ->paginate(10);
    }

    public function storeProduct(array $data, $vendorId)
    {
        $product = new Product();
        $product->vendor_id = $vendorId;
        $product->category_id = $data['category_id'];
        $product->price = $data['price'];
        $product->discount_price = $data['discount_price'] ?? null;
        $product->flash_sale_price = $data['flash_sale_price'] ?? null;
        $product->flash_sale_expires_at = $data['flash_sale_expires_at'] ?? null;
        $product->is_gift = isset($data['is_gift']) && $data['is_gift'];
        $product->gift_threshold = $data['gift_threshold'] ?? null;
        $product->currency_id = $data['currency_id'] ?? 1;
        $product->stock = $data['stock'] ?? 0;
        $product->custom_badge = $data['custom_badge'] ?? null;

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
        $product->price = $data['price'] ?? $product->price;
        $product->discount_price = array_key_exists('discount_price', $data) ? $data['discount_price'] : $product->discount_price;
        $product->flash_sale_price = array_key_exists('flash_sale_price', $data) ? $data['flash_sale_price'] : $product->flash_sale_price;
        $product->flash_sale_expires_at = array_key_exists('flash_sale_expires_at', $data) ? $data['flash_sale_expires_at'] : $product->flash_sale_expires_at;
        $product->is_gift = isset($data['is_gift']) && $data['is_gift'];
        $product->gift_threshold = array_key_exists('gift_threshold', $data) ? $data['gift_threshold'] : $product->gift_threshold;
        $product->currency_id = $data['currency_id'] ?? $product->currency_id;
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
        return $product;
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return $product->delete();
    }
}

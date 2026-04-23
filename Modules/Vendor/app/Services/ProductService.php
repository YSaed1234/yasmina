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
            ->with(['category', 'translations'])
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
        $product->currency_id = 1;

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

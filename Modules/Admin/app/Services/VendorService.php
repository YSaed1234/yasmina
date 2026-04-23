<?php

namespace Modules\Admin\Services;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VendorService
{
    /**
     * Get paginated vendors.
     */
    public function getPaginatedVendors(int $perPage = 10)
    {
        return Vendor::latest()->paginate($perPage);
    }

    /**
     * Store a new vendor.
     */
    public function storeVendor(array $data)
    {
        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['password'] = bcrypt($data['password']);

        if (isset($data['logo']) && is_file($data['logo'])) {
            $data['logo'] = $data['logo']->store('vendors', 'public');
        }

        if (isset($data['about_image1']) && is_file($data['about_image1'])) {
            $data['about_image1'] = $data['about_image1']->store('vendors/about', 'public');
        }

        if (isset($data['about_image2']) && is_file($data['about_image2'])) {
            $data['about_image2'] = $data['about_image2']->store('vendors/about', 'public');
        }

        return Vendor::create($data);
    }

    /**
     * Update an existing vendor.
     */
    public function updateVendor(Vendor $vendor, array $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        }

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['logo']) && is_file($data['logo'])) {
            if ($vendor->logo) {
                Storage::disk('public')->delete($vendor->logo);
            }
            $data['logo'] = $data['logo']->store('vendors', 'public');
        }

        if (isset($data['about_image1']) && is_file($data['about_image1'])) {
            if ($vendor->about_image1) {
                Storage::disk('public')->delete($vendor->about_image1);
            }
            $data['about_image1'] = $data['about_image1']->store('vendors/about', 'public');
        }

        if (isset($data['about_image2']) && is_file($data['about_image2'])) {
            if ($vendor->about_image2) {
                Storage::disk('public')->delete($vendor->about_image2);
            }
            $data['about_image2'] = $data['about_image2']->store('vendors/about', 'public');
        }

        return $vendor->update($data);
    }

    /**
     * Delete a vendor.
     */
    public function deleteVendor(Vendor $vendor)
    {
        if ($vendor->logo) {
            Storage::disk('public')->delete($vendor->logo);
        }
        if ($vendor->about_image1) {
            Storage::disk('public')->delete($vendor->about_image1);
        }
        if ($vendor->about_image2) {
            Storage::disk('public')->delete($vendor->about_image2);
        }
        
        return $vendor->delete();
    }
}

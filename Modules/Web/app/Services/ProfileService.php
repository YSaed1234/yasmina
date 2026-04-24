<?php

namespace Modules\Web\Services;

use App\Models\Address;
use App\Models\Order;
use App\Models\Review;
use App\Models\Governorate;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function getOrders($vendorId, int $perPage = 10)
    {
        return Order::where('vendor_id', $vendorId)
            ->where('user_id', Auth::id())
            ->with(['items.product'])
            ->latest()
            ->paginate($perPage);
    }

    public function getTotalPromotionalSavings($vendorId)
    {
        return Order::where('vendor_id', $vendorId)
            ->where('user_id', Auth::id())
            ->selectRaw('SUM(vendor_discount_amount + promotional_discount_amount) as total')
            ->value('total') ?? 0;
    }

    public function getAddresses($vendorId)
    {
        return Auth::user()->addresses()
            ->with(['governorate', 'region'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->get();
    }

    public function getGovernorates()
    {
        return Governorate::orderBy('name')->get();
    }

    public function storeAddress(array $data)
    {
        return Auth::user()->addresses()->create($data);
    }

    public function updateAddress(Address $address, array $data)
    {
        if ($address->user_id !== Auth::id()) {
            return false;
        }
        return $address->update($data);
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            return false;
        }
        return $address->delete();
    }

    public function storeReview(array $data, $vendorId)
    {
        // Check if user has an order with this product
        $hasOrdered = Auth::user()->orders()
            ->whereHas('items', function ($q) use ($data) {
                $q->where('product_id', $data['product_id']);
            })->exists();

        if (!$hasOrdered) {
            return ['success' => false, 'error' => __('You can only rate products you have purchased.')];
        }

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $data['product_id'], 'vendor_id' => $vendorId],
            ['rating' => $data['rating'], 'comment' => $data['comment'] ?? null]
        );

        return ['success' => true, 'message' => __('Thank you for your review!')];
    }

    public function convertPoints(int $points)
    {
        try {
            $money = Auth::user()->convertPointsToBalance($points);
            return ['success' => true, 'money' => $money];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}

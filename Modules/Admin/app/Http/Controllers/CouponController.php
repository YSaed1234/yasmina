<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Modules\Admin\Services\CouponService;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $this->authorize('manage coupons');
        $coupons = $this->couponService->getAllPaginated($request->all());
        return view('admin::coupons.index', compact('coupons'));
    }

    public function create()
    {
        $this->authorize('manage coupons');
        return view('admin::coupons.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage coupons');
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $this->couponService->create($validated);
        return redirect()->route('admin.coupons.index')->with('success', __('Coupon created successfully.'));
    }

    public function edit(Coupon $coupon)
    {
        $this->authorize('manage coupons');
        return view('admin::coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('manage coupons');
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        $this->couponService->update($coupon, $validated);
        return redirect()->route('admin.coupons.index')->with('success', __('Coupon updated successfully.'));
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('manage coupons');
        $this->couponService->delete($coupon);
        return redirect()->route('admin.coupons.index')->with('success', __('Coupon deleted successfully.'));
    }
}

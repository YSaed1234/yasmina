<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $vendorId = $user->vendor_id;

        $stats = [
            'products_count' => \App\Models\Product::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->count(),
            'categories_count' => \App\Models\Category::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId)->orWhereNull('vendor_id'))->count(),
            'orders_count' => \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->count(),
            'users_count' => $vendorId ? \App\Models\Order::where('vendor_id', $vendorId)->distinct('user_id')->count() : \App\Models\User::count(),
            'coupons_count' => \App\Models\Coupon::count(), // Coupons are global for now
            'contact_requests_count' => \App\Models\ContactRequest::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->count(),
            'total_revenue' => \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->where('payment_status', 'paid')->sum('total'),
        ];

        return view('admin::index', compact('stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}

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

        // Base statistics
        $stats = [
            'products_count' => \App\Models\Product::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->count(),
            'categories_count' => \App\Models\Category::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId)->orWhereNull('vendor_id'))->count(),
            'orders_count' => \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->count(),
            'users_count' => $vendorId ? \App\Models\Order::where('vendor_id', $vendorId)->distinct('user_id')->count() : \App\Models\User::count(),
            'total_revenue' => \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('total'),
            'total_commission' => \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('commission_amount'),
            'total_vendor_net' => \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('vendor_net_amount'),
        ];

        $statusBreakdown = \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->select('status', \DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [$item->status->value => $item->count])
            ->toArray();

        // Top Vendors (Only for Global Admin)
        $topVendors = [];
        if (!$vendorId) {
            $topVendors = \App\Models\Vendor::withCount('orders')
                ->with(['orders' => function($q) {
                    $q->where('status', '!=', \App\Enums\OrderStatus::CANCELLED);
                }])
                ->get()
                ->map(function($vendor) {
                    return [
                        'name' => $vendor->name,
                        'logo' => $vendor->logo,
                        'orders_count' => $vendor->orders_count,
                        'revenue' => $vendor->orders->sum('total'),
                        'commission' => $vendor->orders->sum('commission_amount')
                    ];
                })
                ->sortByDesc('revenue')
                ->take(5);
        }

        // Monthly Sales Trend
        $monthlySales = \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                \DB::raw('YEAR(created_at) as year'),
                \DB::raw('MONTH(created_at) as month'),
                \DB::raw('SUM(total) as revenue'),
                \DB::raw('SUM(commission_amount) as commission')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Recent Orders
        $recentOrders = \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Top Selling Products
        $topProducts = \App\Models\OrderItem::query()
            ->when($vendorId, function ($q) use ($vendorId) {
                $q->whereHas('order', fn($o) => $o->where('vendor_id', $vendorId));
            })
            ->select('product_id', \DB::raw('SUM(quantity) as total_qty'), \DB::raw('SUM(quantity * price) as total_revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin::index', compact('stats', 'statusBreakdown', 'topVendors', 'monthlySales', 'recentOrders', 'topProducts'));
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

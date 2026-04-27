<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $vendorId = auth('vendor')->id();

        // Winning Products (Top 10 by quantity)
        $winningProducts = \App\Models\OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as revenue'))
            ->whereHas('order', function ($q) use ($vendorId) {
                $q->where('status', 'delivered')->where('vendor_id', $vendorId);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with(['product' => fn($p) => $p->with('vendor')])
            ->take(10)
            ->get();

        // Losing Products (Bottom 10 by quantity)
        $losingProducts = \App\Models\Product::where('vendor_id', $vendorId)
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->groupBy('products.id')
            ->orderBy('total_sold', 'asc')
            ->take(10)
            ->get();

        return view('vendor::reports.sales', compact('winningProducts', 'losingProducts'));
    }

    public function customers(Request $request)
    {
        $vendorId = auth('vendor')->id();
        $search = $request->get('search');

        // Customer Behavior (All non-admin users for this vendor)
        $customers = \App\Models\User::where(function ($q) {
            // $q->where('role', '!=', 'admin')->orWhereNull('role');
        })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->select('users.*')
            ->whereHas('orders', fn($o) => $o->where('vendor_id', $vendorId))
            ->withCount(['orders' => fn($q) => $q->where('vendor_id', $vendorId)])
            ->withSum([
                'orders' => function ($q) use ($vendorId) {
                    $q->where('status', 'delivered')->where('vendor_id', $vendorId);
                }
            ], 'total')
            ->orderByDesc('orders_count')
            ->take(20)
            ->get();
        return view('vendor::reports.customers', compact('customers', 'search'));
    }

    public function returns(Request $request)
    {
        $vendorId = auth('vendor')->id();

        $returnStats = \App\Models\ReturnRequest::select('status', DB::raw('count(*) as count'))
            ->where('vendor_id', $vendorId)
            ->groupBy('status')
            ->get();

        $recentReturns = \App\Models\ReturnRequest::with(['order', 'user'])
            ->where('vendor_id', $vendorId)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('vendor::reports.returns', compact('returnStats', 'recentReturns'));
    }

    public function inventory(Request $request)
    {
        $vendorId = auth('vendor')->id();

        $products = Product::with(['variants'])
            ->where('vendor_id', $vendorId)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'base_stock' => $product->stock,
                    'variant_stock' => $product->variants->sum('stock'),
                    'total_stock' => $product->total_stock,
                    'low_stock' => $product->total_stock <= 5,
                ];
            })
            ->sortBy('total_stock');

        return view('vendor::reports.inventory', compact('products'));
    }

    public function traffic(Request $request)
    {
        $vendorId = auth('vendor')->id();

        $visitQuery = \App\Models\Visit::where('vendor_id', $vendorId);

        $totalViews = $visitQuery->count();
        $uniqueVisitors = $visitQuery->distinct('ip')->count();

        $orderCount = Order::where('vendor_id', $vendorId)->count();
        $conversionRate = $uniqueVisitors > 0 ? round(($orderCount / $uniqueVisitors) * 100, 1) . '%' : '0%';

        $stats = [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'conversion_rate' => $conversionRate,
        ];

        return view('vendor::reports.traffic', compact('stats'));
    }
}

<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use DB;

class ReportController extends Controller
{
    public function inventory(Request $request)
    {
        $user = auth()->user();
        $vendorSearch = $request->get('vendor_search');
        $vendorId = $user->vendor_id ?: $request->get('vendor_id');
        
        $vendors = [];
        if (!$user->vendor_id) {
            $vendors = \App\Models\Vendor::when($vendorSearch, function($q) use ($vendorSearch) {
                $q->where('name', 'like', "%{$vendorSearch}%");
            })->take(20)->get();
        }

        $products = Product::with(['variants', 'vendor'])
            ->when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->when(!$vendorId && $vendorSearch, function($q) use ($vendorSearch) {
                $q->whereHas('vendor', fn($v) => $v->where('name', 'like', "%{$vendorSearch}%"));
            })
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'vendor' => $product->vendor->name ?? 'N/A',
                    'base_stock' => $product->stock,
                    'variant_stock' => $product->variants->sum('stock'),
                    'total_stock' => $product->total_stock,
                    'low_stock' => $product->total_stock <= 5,
                ];
            })
            ->sortBy('total_stock');

        return view('admin::reports.inventory', compact('products', 'vendors', 'vendorId', 'vendorSearch'));
    }

    public function traffic(Request $request)
    {
        $user = auth()->user();
        $vendorSearch = $request->get('vendor_search');
        $vendorId = $user->vendor_id ?: $request->get('vendor_id');
        
        $vendors = [];
        if (!$user->vendor_id) {
            $vendors = \App\Models\Vendor::when($vendorSearch, function($q) use ($vendorSearch) {
                $q->where('name', 'like', "%{$vendorSearch}%");
            })->take(20)->get();
        }

        // Real Stats
        $visitQuery = \App\Models\Visit::query()
            ->when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->when(!$vendorId && $vendorSearch, function($q) use ($vendorSearch) {
                $q->whereHas('vendor', fn($v) => $v->where('name', 'like', "%{$vendorSearch}%"));
            });

        $totalViews = $visitQuery->count();
        $uniqueVisitors = $visitQuery->distinct('ip')->count();
        
        // Simple conversion rate: Orders / Unique Visitors
        $orderCount = \App\Models\Order::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))->count();
        $conversionRate = $uniqueVisitors > 0 ? round(($orderCount / $uniqueVisitors) * 100, 1) . '%' : '0%';

        $stats = [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'conversion_rate' => $conversionRate,
        ];

        return view('admin::reports.traffic', compact('stats', 'vendors', 'vendorId', 'vendorSearch'));
    }
    public function sales(Request $request)
    {
        $user = auth()->user();
        $vendorSearch = $request->get('vendor_search');
        $vendorId = $user->vendor_id ?: $request->get('vendor_id');
        
        $vendors = [];
        if (!$user->vendor_id) {
            $vendors = \App\Models\Vendor::when($vendorSearch, function($q) use ($vendorSearch) {
                $q->where('name', 'like', "%{$vendorSearch}%");
            })->take(20)->get();
        }

        // Winning Products (Top 10 by quantity)
        $winningProducts = \App\Models\OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as revenue'))
            ->whereHas('order', function($q) use ($vendorId) {
                $q->where('status', 'delivered');
                if ($vendorId) $q->where('vendor_id', $vendorId);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with(['product' => fn($p) => $p->with('vendor')])
            ->take(10)
            ->get();

        // Losing Products (Bottom 10 by quantity)
        $losingProducts = \App\Models\Product::when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->when(!$vendorId && $vendorSearch, function($q) use ($vendorSearch) {
                $q->whereHas('vendor', fn($v) => $v->where('name', 'like', "%{$vendorSearch}%"));
            })
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->groupBy('products.id')
            ->orderBy('total_sold', 'asc')
            ->with('vendor')
            ->take(10)
            ->get();

        return view('admin::reports.sales', compact('winningProducts', 'losingProducts', 'vendors', 'vendorId', 'vendorSearch'));
    }

    public function customers(Request $request)
    {
        $user = auth()->user();
        $vendorSearch = $request->get('vendor_search');
        $vendorId = $user->vendor_id ?: $request->get('vendor_id');
        $search = $request->get('search');
        
        $vendors = [];
        if (!$user->vendor_id) {
            $vendors = \App\Models\Vendor::when($vendorSearch, function($q) use ($vendorSearch) {
                $q->where('name', 'like', "%{$vendorSearch}%");
            })->take(20)->get();
        }

        // Customer Behavior (All non-admin users)
        $customers = \App\Models\User::where(function($q) {
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
            ->when($vendorId, function($q) use ($vendorId) {
                $q->whereHas('orders', fn($o) => $o->where('vendor_id', $vendorId));
            })
            ->withCount(['orders' => function($q) use ($vendorId) {
                if ($vendorId) $q->where('vendor_id', $vendorId);
            }])
            ->withSum(['orders' => function($q) use ($vendorId) {
                $q->where('status', 'delivered');
                if ($vendorId) $q->where('vendor_id', $vendorId);
            }], 'total')
            ->orderByDesc('orders_count')
            ->take(20)
            ->get();

        return view('admin::reports.customers', compact('customers', 'vendors', 'vendorId', 'vendorSearch', 'search'));
    }

    public function returns(Request $request)
    {
        $user = auth()->user();
        $vendorSearch = $request->get('vendor_search');
        $vendorId = $user->vendor_id ?: $request->get('vendor_id');
        
        $vendors = [];
        if (!$user->vendor_id) {
            $vendors = \App\Models\Vendor::when($vendorSearch, function($q) use ($vendorSearch) {
                $q->where('name', 'like', "%{$vendorSearch}%");
            })->take(20)->get();
        }

        $returnStats = \App\Models\ReturnRequest::select('status', DB::raw('count(*) as count'))
            ->when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->groupBy('status')
            ->get();

        $recentReturns = \App\Models\ReturnRequest::with(['order', 'user'])
            ->when($vendorId, fn($q) => $q->where('vendor_id', $vendorId))
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('admin::reports.returns', compact('returnStats', 'recentReturns', 'vendors', 'vendorId', 'vendorSearch'));
    }
}

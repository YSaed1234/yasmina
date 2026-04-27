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
}

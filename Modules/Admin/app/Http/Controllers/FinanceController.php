<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $vendors = Vendor::withCount(['orders' => function($q) {
            $q->where('status', '!=', OrderStatus::CANCELLED);
        }])->paginate(15);
        
        $vendors->getCollection()->transform(function($vendor) {
            $stats = Order::where('vendor_id', $vendor->id)
                ->where('status', '!=', OrderStatus::CANCELLED)
                ->selectRaw('SUM(total) as total_sales, SUM(commission_amount) as total_commission, SUM(vendor_net_amount) as total_net')
                ->first();
            
            $vendor->total_sales = $stats->total_sales ?? 0;
            $vendor->total_commission = $stats->total_commission ?? 0;
            $vendor->total_net = $stats->total_net ?? 0;
            
            return $vendor;
        });

        $grand_stats = Order::where('status', '!=', OrderStatus::CANCELLED)
            ->selectRaw('SUM(total) as total_sales, SUM(commission_amount) as total_commission, SUM(vendor_net_amount) as total_net')
            ->first();
            
        $grand_stats->total_sales = $grand_stats->total_sales ?? 0;
        $grand_stats->total_commission = $grand_stats->total_commission ?? 0;
        $grand_stats->total_net = $grand_stats->total_net ?? 0;

        return view('admin::finances.index', compact('vendors', 'grand_stats'));
    }

    public function show(Vendor $vendor)
    {
        $orders = Order::where('vendor_id', $vendor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = Order::where('vendor_id', $vendor->id)
            ->where('status', '!=', OrderStatus::CANCELLED)
            ->selectRaw('SUM(total) as total_sales, SUM(commission_amount) as total_commission, SUM(vendor_net_amount) as total_net')
            ->first();

        $stats->total_sales = $stats->total_sales ?? 0;
        $stats->total_commission = $stats->total_commission ?? 0;
        $stats->total_net = $stats->total_net ?? 0;

        return view('admin::finances.show', compact('vendor', 'orders', 'stats'));
    }
}

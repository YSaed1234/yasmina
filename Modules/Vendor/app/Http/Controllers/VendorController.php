<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = auth('vendor')->user();
        
        // Base query for vendor orders
        $orderQuery = \App\Models\Order::where('vendor_id', $vendor->id);
        
        // Revenue Stats
        $stats = [
            'total_sales' => (clone $orderQuery)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('total'),
            'net_earnings' => (clone $orderQuery)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('vendor_net_amount'),
            'total_commission' => (clone $orderQuery)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('commission_amount'),
            'total_promotional_discounts' => (clone $orderQuery)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum(\DB::raw('vendor_discount_amount + promotional_discount_amount')),
            'orders_count' => (clone $orderQuery)->count(),
            'products_count' => $vendor->products()->count(),
        ];

        // Order Status Breakdown
        $statusBreakdown = (clone $orderQuery)
            ->select('status', \DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [$item->status->value => $item->count])
            ->toArray();

        // Recent Orders
        $recentOrders = (clone $orderQuery)
            ->with(['user'])
            ->latest()
            ->take(5)
            ->get();

        // Top Products
        $topProducts = \App\Models\OrderItem::whereHas('order', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })
            ->select('product_id', \DB::raw('SUM(quantity) as total_qty'), \DB::raw('SUM(quantity * price) as total_revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Monthly Sales (Last 6 months)
        $monthlySales = (clone $orderQuery)
            ->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                \DB::raw('YEAR(created_at) as year'),
                \DB::raw('MONTH(created_at) as month'),
                \DB::raw('SUM(total) as revenue'),
                \DB::raw('SUM(vendor_net_amount) as net')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('vendor::index', compact('stats', 'statusBreakdown', 'recentOrders', 'topProducts', 'monthlySales'));
    }

    public function finances()
    {
        $vendor = auth('vendor')->user();
        $orders = \App\Models\Order::where('vendor_id', $vendor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total_sales' => \App\Models\Order::where('vendor_id', $vendor->id)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('total'),
            'total_commission' => \App\Models\Order::where('vendor_id', $vendor->id)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('commission_amount'),
            'total_promotional_discounts' => \App\Models\Order::where('vendor_id', $vendor->id)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum(\DB::raw('vendor_discount_amount + promotional_discount_amount')),
            'net_earnings' => \App\Models\Order::where('vendor_id', $vendor->id)->where('status', '!=', \App\Enums\OrderStatus::CANCELLED)->sum('vendor_net_amount'),
        ];

        return view('vendor::finances.index', compact('orders', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor::create');
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
        return view('vendor::show');
    }

    /**
     * Show the form for editing the vendor profile.
     */
    public function editProfile()
    {
        $vendor = auth('vendor')->user();
        return view('vendor::profile.edit', compact('vendor'));
    }

    /**
     * Update the vendor profile.
     */
    public function updateProfile(Request $request)
    {
        $vendor = auth('vendor')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:vendors,slug,' . $vendor->id,
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'about_ar' => 'nullable|string',
            'about_en' => 'nullable|string',
            'address' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'return_policy_ar' => 'nullable|string',
            'return_policy_en' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'about_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'about_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'password' => 'nullable|string|min:8|confirmed',
            'order_threshold' => 'nullable|numeric|min:0',
            'order_threshold_discount' => 'nullable|numeric|min:0',
            'order_threshold_discount_type' => 'required|in:fixed,percentage',
            'min_items_for_discount' => 'nullable|integer|min:0',
            'items_discount_amount' => 'nullable|numeric|min:0',
            'items_discount_type' => 'required|in:fixed,percentage',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
        ]);

        $data = $request->only([
            'name', 'slug', 'email', 'phone', 'phone_secondary', 'description', 'about_ar', 'about_en', 
            'address', 'facebook', 'instagram', 'twitter', 'whatsapp',
            'order_threshold', 'order_threshold_discount', 'order_threshold_discount_type',
            'min_items_for_discount', 'items_discount_amount', 'items_discount_type',
            'free_shipping_threshold', 'primary_color', 'secondary_color',
            'return_policy_ar', 'return_policy_en'
        ]);
        $data['slug'] = $request->slug ? \Str::slug($request->slug) : \Str::slug($request->name);

        if ($request->hasFile('logo')) {
            if ($vendor->logo && \Storage::disk('public')->exists($vendor->logo)) {
                \Storage::disk('public')->delete($vendor->logo);
            }
            $data['logo'] = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->hasFile('about_image1')) {
            if ($vendor->about_image1 && \Storage::disk('public')->exists($vendor->about_image1)) {
                \Storage::disk('public')->delete($vendor->about_image1);
            }
            $data['about_image1'] = $request->file('about_image1')->store('vendors/about', 'public');
        }

        if ($request->hasFile('about_image2')) {
            if ($vendor->about_image2 && \Storage::disk('public')->exists($vendor->about_image2)) {
                \Storage::disk('public')->delete($vendor->about_image2);
            }
            $data['about_image2'] = $request->file('about_image2')->store('vendors/about', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
        }

        $vendor->update($data);

        return back()->with('success', __('Profile updated successfully.'));
    }

    /**
     * Display all notifications for the vendor.
     */
    public function notifications()
    {
        $notifications = auth('vendor')->user()->notifications()->latest()->paginate(20);
        return view('vendor::notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markNotificationRead($id)
    {
        $notification = auth('vendor')->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead()
    {
        auth('vendor')->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
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

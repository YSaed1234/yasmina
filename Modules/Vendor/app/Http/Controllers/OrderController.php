<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $vendorId = Auth::guard('vendor')->id();
        
        // Find orders that have at least one product belonging to this vendor
        $orders = Order::whereHas('items.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->with(['items' => function($query) use ($vendorId) {
            $query->whereHas('product', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product');
        }])
        ->latest()
        ->paginate(10);

        return view('vendor::orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $vendorId = Auth::guard('vendor')->id();
        
        // Ensure the order belongs to this vendor (has at least one of their products)
        if (!$order->items()->whereHas('product', fn($q) => $q->where('vendor_id', $vendorId))->exists()) {
            abort(403);
        }

        // Load only the items belonging to this vendor
        $order->load(['items' => function($query) use ($vendorId) {
            $query->whereHas('product', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product');
        }]);

        return view('vendor::orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $vendorId = Auth::guard('vendor')->id();
        if (!$order->items()->whereHas('product', fn($q) => $q->where('vendor_id', $vendorId))->exists()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'string'],
            'rejection_reason' => ['required_if:status,cancelled', 'nullable', 'string', 'max:1000'],
        ]);

        $updateData = ['status' => $request->status];
        if ($request->status === 'cancelled' && $request->rejection_reason) {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        $order->update($updateData);

        if ($order->user) {
            if ($request->status === 'cancelled') {
                $order->user->notify(new \App\Notifications\OrderCancelledNotification($order, $request->rejection_reason));
            } else {
                $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
            }
        }

        return back()->with('success', __('Order status updated successfully.'));
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $vendorId = Auth::guard('vendor')->id();
        if (!$order->items()->whereHas('product', fn($q) => $q->where('vendor_id', $vendorId))->exists()) {
            abort(403);
        }

        $request->validate(['payment_status' => 'required|string|in:pending,paid,failed']);
        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', __('Payment status updated successfully.'));
    }
}

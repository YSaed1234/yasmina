<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Modules\Admin\Services\OrderService;
use Modules\Admin\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $orders = $this->orderService->getAllPaginated(10, $request->all());
        return view('admin::orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->getOrderDetails($order);
        
        $drivers = \App\Models\Driver::with('vendor')->where('is_active', true)
            ->when($order->vendor_id, function($query) use ($order) {
                return $query->where(function($q) use ($order) {
                    $q->where('vendor_id', $order->vendor_id)
                      ->orWhereNull('vendor_id');
                });
            })
            ->get();

        return view('admin::orders.show', compact('order', 'drivers'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->orderService->updateStatus($order, $request->validated());
        return back()->with('success', __('Order status updated successfully.'));
    }

    public function updatePaymentStatus(\Illuminate\Http\Request $request, Order $order)
    {
        $request->validate(['payment_status' => 'required|string|in:pending,paid,failed']);
        $this->orderService->updatePaymentStatus($order, $request->payment_status);
        return back()->with('success', __('Payment status updated successfully.'));
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return redirect()->route('admin.orders.index')->with('success', __('Order deleted successfully.'));
    }

    public function assignDriver(\Illuminate\Http\Request $request, Order $order)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id'
        ]);

        $order->update(['driver_id' => $request->driver_id]);

        if ($order->user) {
            $order->user->notify(new \App\Notifications\DriverAssignedNotification($order));
        }

        return back()->with('success', __('Driver assigned successfully.'));
    }
}

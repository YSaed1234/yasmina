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

    public function index()
    {
        $orders = $this->orderService->getAllPaginated(10);
        return view('admin::orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->getOrderDetails($order);
        return view('admin::orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->orderService->updateStatus($order, $request->validated());
        return back()->with('success', __('Order updated successfully.'));
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return redirect()->route('orders.index')->with('success', __('Order deleted successfully.'));
    }
}

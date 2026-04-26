<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestItem;
use Illuminate\Support\Facades\DB;

class ReturnRequestController extends Controller
{
    public function create(Order $order)
    {
        // Ensure the order belongs to the user and is delivered
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status->value !== 'delivered') {
            return redirect()->back()->with('error', __('Only delivered orders can be returned.'));
        }

        return view('web::profile.returns.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
            'items' => 'required|array',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request, $order) {
            $returnRequest = ReturnRequest::create([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'vendor_id' => $order->vendor_id,
                'reason' => $request->reason,
                'status' => 'pending',
            ]);

            foreach ($request->items as $item) {
                // Verify item belongs to order
                $orderItem = $order->items()->find($item['order_item_id']);
                if ($orderItem) {
                    $qty = min($item['quantity'], $orderItem->quantity);
                    ReturnRequestItem::create([
                        'return_request_id' => $returnRequest->id,
                        'order_item_id' => $orderItem->id,
                        'quantity' => $qty,
                    ]);
                }
            }

            return redirect()->route('web.profile.orders')->with('success', __('Return request submitted successfully.'));
        });
    }

    public function show(ReturnRequest $returnRequest)
    {
        if ($returnRequest->user_id !== auth()->id()) {
            abort(403);
        }

        return view('web::profile.returns.show', compact('returnRequest'));
    }
}

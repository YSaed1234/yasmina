<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnRequest;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $vendor = auth('vendor')->user();
        $requests = ReturnRequest::where('vendor_id', $vendor->id)
            ->with(['order', 'user'])
            ->latest()
            ->paginate(15);

        return view('vendor::returns.index', compact('requests'));
    }

    public function show(ReturnRequest $returnRequest)
    {
        $vendor = auth('vendor')->user();
        if ($returnRequest->vendor_id !== $vendor->id) {
            abort(403);
        }

        $returnRequest->load(['order.items.product', 'items.orderItem.product', 'user']);
        return view('vendor::returns.show', compact('returnRequest'));
    }

    public function updateNotes(Request $request, ReturnRequest $returnRequest)
    {
        $vendor = auth('vendor')->user();
        if ($returnRequest->vendor_id !== $vendor->id) {
            abort(403);
        }

        if (in_array($returnRequest->status, ['approved', 'completed'])) {
            return redirect()->back()->with('error', __('Cannot update approved or completed return request.'));
        }

        $request->validate([
            'vendor_notes' => 'nullable|string|max:1000',
            'refund_amount' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:pending,approved,rejected',
            'refund_method' => 'nullable|in:wallet,manual',
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $returnRequest) {
            $oldStatus = $returnRequest->status;
            $newStatus = $request->status ?? $oldStatus;
            $refundAmount = (float) ($request->refund_amount ?? $returnRequest->refund_amount);

            $returnRequest->update([
                'vendor_notes' => $request->vendor_notes,
                'refund_amount' => $refundAmount,
                'status' => $newStatus,
                'refund_method' => $request->refund_method ?? $returnRequest->refund_method,
            ]);

            // If status is approved, process the refund (consistency with Admin flow)
            if ($newStatus === 'approved' && $oldStatus !== 'approved') {
                // Process Refund
                if ($refundAmount > 0 && $returnRequest->refund_method === 'wallet') {
                    $returnRequest->user->addWalletBalance(
                        $refundAmount,
                        __('Refund for order #:id', ['id' => $returnRequest->order_id]),
                        $returnRequest
                    );
                }

                // Restore Stock
                foreach ($returnRequest->items as $item) {
                    $orderItem = $item->orderItem;
                    if ($orderItem) {
                        if ($orderItem->variant_id) {
                            $orderItem->variant()->increment('stock', $item->quantity);
                        } else {
                            $orderItem->product()->increment('stock', $item->quantity);
                        }
                    }
                }
            }

            return redirect()->back()->with('success', __('Return details updated successfully.'));
        });
    }
}

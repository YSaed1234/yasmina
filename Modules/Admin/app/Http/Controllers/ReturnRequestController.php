<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\DB;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $requests = ReturnRequest::with(['order', 'user', 'vendor'])
            ->latest()
            ->paginate(15);

        return view('admin::returns.index', compact('requests'));
    }

    public function show(ReturnRequest $returnRequest)
    {
        $returnRequest->load(['order.items.product', 'items.orderItem.product', 'user', 'vendor']);
        return view('admin::returns.show', compact('returnRequest'));
    }

    public function updateStatus(Request $request, ReturnRequest $returnRequest)
    {
        if (in_array($returnRequest->status, ['approved', 'completed']) && !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', __('Only super-admins can update approved or completed returns.'));
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000',
            'refund_amount' => 'nullable|numeric|min:0',
            'refund_method' => 'required|in:wallet,manual',
        ]);

        return DB::transaction(function () use ($request, $returnRequest) {
            $oldStatus = $returnRequest->status;
            $newStatus = $request->status;
            $refundAmount = (float) ($request->refund_amount ?? $returnRequest->refund_amount);

            $returnRequest->update([
                'status' => $newStatus,
                'admin_notes' => $request->admin_notes,
                'refund_method' => $request->refund_method,
                'refund_amount' => $refundAmount,
            ]);

            // If status is completed, process the refund
            if ($newStatus === 'approved' && $oldStatus !== 'approved' && $refundAmount > 0) {
                if ($request->refund_method === 'wallet') {
                    $returnRequest->user->addWalletBalance(
                        $refundAmount,
                        __('Refund for order #:id', ['id' => $returnRequest->order_id]),
                        $returnRequest
                    );
                }
            }

            return redirect()->back()->with('success', __('Return request status updated successfully.'));
        });
    }
}

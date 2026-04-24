<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Vendor;
use App\Models\VendorPayment;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorPaymentController extends Controller
{
    public function index()
    {
        $vendors = Vendor::paginate(15);
        
        $totalCommission = Order::where('status', '!=', OrderStatus::CANCELLED)->sum('commission_amount');
        $totalPaid = VendorPayment::where('status', 'confirmed')->sum('amount');
        
        $stats = [
            'total_commission' => $totalCommission,
            'total_paid' => $totalPaid,
            'remaining_balance' => $totalCommission - $totalPaid,
        ];

        return view('admin::vendor_payments.index', compact('vendors', 'stats'));
    }

    public function show(Vendor $vendor)
    {
        $payments = $vendor->payments()->latest()->paginate(20);
        return view('admin::vendor_payments.show', compact('vendor', 'payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'receipt' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->only(['vendor_id', 'amount', 'payment_date', 'notes']);
        $data['created_by'] = auth('admin')->id();
        $data['status'] = 'confirmed';

        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('vendor_payments', 'public');
        }

        VendorPayment::create($data);

        return back()->with('success', __('Payment recorded successfully.'));
    }

    public function destroy(VendorPayment $payment)
    {
        if ($payment->receipt_path) {
            Storage::disk('public')->delete($payment->receipt_path);
        }
        $payment->delete();
        return back()->with('success', __('Payment deleted successfully.'));
    }
}

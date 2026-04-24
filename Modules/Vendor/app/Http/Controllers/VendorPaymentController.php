<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    public function index()
    {
        $vendor = auth('vendor')->user();
        $payments = $vendor->payments()->latest()->paginate(20);
        return view('vendor::payments.index', compact('vendor', 'payments'));
    }
}

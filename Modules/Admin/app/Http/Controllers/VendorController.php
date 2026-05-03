<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Modules\Admin\Http\Requests\StoreVendorRequest;
use Modules\Admin\Http\Requests\UpdateVendorRequest;
use Modules\Admin\Services\VendorService;

class VendorController extends Controller
{
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function index()
    {
        $vendors = $this->vendorService->getPaginatedVendors(10);
        return view('admin::vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin::vendors.create');
    }

    public function store(StoreVendorRequest $request)
    {
        $this->vendorService->storeVendor($request->all());

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor created successfully.'));
    }

    public function edit(Vendor $vendor)
    {
        return view('admin::vendors.edit', compact('vendor'));
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $this->vendorService->updateVendor($vendor, $request->all());

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor updated successfully.'));
    }

    public function destroy(Vendor $vendor)
    {
        $this->vendorService->deleteVendor($vendor);
        return redirect()->route('admin.vendors.index')->with('success', __('Vendor deleted successfully.'));
    }

    public function contract(Vendor $vendor)
    {
        return view('admin::vendors.contract', compact('vendor'));
    }

    public function contractsReport()
    {
        $vendors = $this->vendorService->getPaginatedVendors(20);
        return view('admin::vendors.contracts_report', compact('vendors'));
    }
}

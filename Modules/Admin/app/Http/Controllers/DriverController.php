<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('vendor')->latest()->paginate(10);
        return view('admin::drivers.index', compact('drivers'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('admin::drivers.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:drivers,phone',
            'email' => 'nullable|email',
            'vehicle_type' => 'nullable|string',
            'vehicle_number' => 'nullable|string',
            'is_active' => 'boolean',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        Driver::create($request->all());

        return redirect()->route('admin.drivers.index')->with('success', __('Driver created successfully.'));
    }

    public function edit(Driver $driver)
    {
        $vendors = Vendor::all();
        return view('admin::drivers.edit', compact('driver', 'vendors'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:drivers,phone,' . $driver->id,
            'email' => 'nullable|email',
            'vehicle_type' => 'nullable|string',
            'vehicle_number' => 'nullable|string',
            'is_active' => 'boolean',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        $driver->update($request->all());

        return redirect()->route('admin.drivers.index')->with('success', __('Driver updated successfully.'));
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('admin.drivers.index')->with('success', __('Driver deleted successfully.'));
    }
}

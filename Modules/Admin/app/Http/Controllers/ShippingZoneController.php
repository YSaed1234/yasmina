<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::latest()->paginate(10);
        return view('admin::shipping_zones.index', compact('zones'));
    }

    public function create()
    {
        return view('admin::shipping_zones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        ShippingZone::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.shipping_zones.index')->with('success', __('Shipping zone created successfully.'));
    }

    public function edit(ShippingZone $shippingZone)
    {
        return view('admin::shipping_zones.edit', compact('shippingZone'));
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $shippingZone->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.shipping_zones.index')->with('success', __('Shipping zone updated successfully.'));
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();
        return redirect()->route('admin.shipping_zones.index')->with('success', __('Shipping zone deleted successfully.'));
    }
}

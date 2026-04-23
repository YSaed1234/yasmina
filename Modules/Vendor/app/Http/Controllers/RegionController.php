<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::with('governorate')
            ->where('vendor_id', Auth::guard('vendor')->id())
            ->latest()
            ->paginate(15);
        return view('vendor::shipping.index', compact('regions'));
    }

    public function create()
    {
        $governorates = Governorate::orderBy('name')->get();
        return view('vendor::shipping.create', compact('governorates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'governorate_id' => 'required|exists:governorates,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        Region::create([
            'governorate_id' => $request->governorate_id,
            'vendor_id' => Auth::guard('vendor')->id(),
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('vendor.shipping.index')->with('success', __('Shipping rate created successfully.'));
    }

    public function edit(Region $shipping)
    {
        $region = $shipping;
        if ($region->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }
        $governorates = Governorate::orderBy('name')->get();
        return view('vendor::shipping.create', compact('region', 'governorates'));
    }

    public function update(Request $request, Region $shipping)
    {
        $region = $shipping;
        if ($region->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $request->validate([
            'governorate_id' => 'required|exists:governorates,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $region->update([
            'governorate_id' => $request->governorate_id,
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('vendor.shipping.index')->with('success', __('Shipping rate updated successfully.'));
    }

    public function destroy(Region $shipping)
    {
        $region = $shipping;
        if ($region->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }
        $region->delete();
        return redirect()->route('vendor.shipping.index')->with('success', __('Shipping rate deleted successfully.'));
    }
}

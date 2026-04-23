<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::with(['governorate', 'vendor'])->latest();

        if ($request->has('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $regions = $query->paginate(15);
        return view('admin::regions.index', compact('regions'));
    }

    public function create()
    {
        $governorates = Governorate::orderBy('name')->get();
        $vendors = \App\Models\Vendor::orderBy('name')->get();
        return view('admin::regions.create', compact('governorates', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'governorate_id' => 'required|exists:governorates,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        Region::create([
            'governorate_id' => $request->governorate_id,
            'vendor_id' => $request->vendor_id,
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('regions.index')->with('success', __('Region created successfully.'));
    }

    public function edit(Region $region)
    {
        $governorates = Governorate::orderBy('name')->get();
        $vendors = \App\Models\Vendor::orderBy('name')->get();
        return view('admin::regions.create', compact('region', 'governorates', 'vendors'));
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'governorate_id' => 'required|exists:governorates,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $region->update([
            'governorate_id' => $request->governorate_id,
            'vendor_id' => $request->vendor_id,
            'name' => $request->name,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('regions.index')->with('success', __('Region updated successfully.'));
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('regions.index')->with('success', __('Region deleted successfully.'));
    }
}

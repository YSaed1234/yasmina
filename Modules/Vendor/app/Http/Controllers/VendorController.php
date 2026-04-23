<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = auth('vendor')->user();
        $stats = [
            'products_count' => $vendor->products()->count(),
            'orders_count' => \App\Models\OrderItem::whereHas('product', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })->count(),
            'total_sales' => \App\Models\OrderItem::whereHas('product', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })->sum(\DB::raw('price * quantity')),
        ];

        return view('vendor::index', compact('stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('vendor::show');
    }

    /**
     * Show the form for editing the vendor profile.
     */
    public function editProfile()
    {
        $vendor = auth('vendor')->user();
        return view('vendor::profile.edit', compact('vendor'));
    }

    /**
     * Update the vendor profile.
     */
    public function updateProfile(Request $request)
    {
        $vendor = auth('vendor')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'description', 'address']);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($vendor->logo && \Storage::disk('public')->exists($vendor->logo)) {
                \Storage::disk('public')->delete($vendor->logo);
            }
            $data['logo'] = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = \Hash::make($request->password);
        }

        $vendor->update($data);

        return back()->with('success', __('Profile updated successfully.'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}

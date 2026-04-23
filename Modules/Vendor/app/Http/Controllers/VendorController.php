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
            'about_ar' => 'nullable|string',
            'about_en' => 'nullable|string',
            'address' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'about_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'about_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only([
            'name', 'email', 'phone', 'description', 'about_ar', 'about_en', 
            'address', 'facebook', 'instagram', 'twitter', 'whatsapp'
        ]);

        if ($request->hasFile('logo')) {
            if ($vendor->logo && \Storage::disk('public')->exists($vendor->logo)) {
                \Storage::disk('public')->delete($vendor->logo);
            }
            $data['logo'] = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->hasFile('about_image1')) {
            if ($vendor->about_image1 && \Storage::disk('public')->exists($vendor->about_image1)) {
                \Storage::disk('public')->delete($vendor->about_image1);
            }
            $data['about_image1'] = $request->file('about_image1')->store('vendors/about', 'public');
        }

        if ($request->hasFile('about_image2')) {
            if ($vendor->about_image2 && \Storage::disk('public')->exists($vendor->about_image2)) {
                \Storage::disk('public')->delete($vendor->about_image2);
            }
            $data['about_image2'] = $request->file('about_image2')->store('vendors/about', 'public');
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

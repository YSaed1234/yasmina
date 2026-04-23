<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);
        return view('admin::vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin::vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('vendors', 'public');
        }

        Vendor::create($data);

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor created successfully.'));
    }

    public function edit(Vendor $vendor)
    {
        return view('admin::vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('password');
        $data['slug'] = Str::slug($request->name);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('vendors', 'public');
        }

        $vendor->update($data);

        return redirect()->route('admin.vendors.index')->with('success', __('Vendor updated successfully.'));
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('admin.vendors.index')->with('success', __('Vendor deleted successfully.'));
    }
}

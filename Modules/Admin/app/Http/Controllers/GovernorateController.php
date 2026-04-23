<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function index()
    {
        $governorates = Governorate::latest()->paginate(10);
        return view('admin::governorates.index', compact('governorates'));
    }

    public function create()
    {
        return view('admin::governorates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Governorate::create($request->all());

        return redirect()->route('admin.governorates.index')->with('success', __('Governorate created successfully.'));
    }

    public function edit(Governorate $governorate)
    {
        return view('admin::governorates.edit', compact('governorate'));
    }

    public function update(Request $request, Governorate $governorate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $governorate->update($request->all());

        return redirect()->route('admin.governorates.index')->with('success', __('Governorate updated successfully.'));
    }

    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
        return redirect()->route('admin.governorates.index')->with('success', __('Governorate deleted successfully.'));
    }
}

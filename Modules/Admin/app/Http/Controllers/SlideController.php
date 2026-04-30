<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('order')->get();
        return view('admin::slides.index', compact('slides'));
    }

    public function create()
    {
        $vendors = \App\Models\Vendor::where('status', 'active')->orderBy('name')->get();
        return view('admin::slides.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'title_ar' => 'required',
            'title_en' => 'required',
            'order' => 'integer',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        Slide::create($data);

        return redirect()->route('admin.slides.index')->with('success', __('Slide created successfully.'));
    }

    public function edit(Slide $slide)
    {
        $vendors = \App\Models\Vendor::where('status', 'active')->orderBy('name')->get();
        return view('admin::slides.edit', compact('slide', 'vendors'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'title_ar' => 'required',
            'title_en' => 'required',
            'order' => 'integer',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        $slide->update($data);

        return redirect()->route('admin.slides.index')->with('success', __('Slide updated successfully.'));
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', __('Slide deleted successfully.'));
    }
}

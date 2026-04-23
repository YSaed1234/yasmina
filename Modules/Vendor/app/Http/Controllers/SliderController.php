<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        $slides = Slide::where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(10);

        return view('vendor::sliders.index', compact('slides'));
    }

    public function create()
    {
        return view('vendor::sliders.create');
    }

    public function store(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();
        
        $request->validate([
            'image' => 'required|image|max:5120',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->except('image');
        $data['vendor_id'] = $vendor->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        Slide::create($data);

        return redirect()->route('vendor.sliders.index')->with('success', __('Slider created successfully.'));
    }

    public function edit(Slide $slider)
    {
        if ($slider->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        return view('vendor::sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slide $slider)
    {
        if ($slider->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $request->validate([
            'image' => 'nullable|image|max:5120',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        $slider->update($data);

        return redirect()->route('vendor.sliders.index')->with('success', __('Slider updated successfully.'));
    }

    public function destroy(Slide $slider)
    {
        if ($slider->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('vendor.sliders.index')->with('success', __('Slider deleted successfully.'));
    }
}

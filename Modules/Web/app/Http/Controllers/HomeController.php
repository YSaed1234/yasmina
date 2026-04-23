<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendor = $request->attributes->get('current_vendor');
        $vendor_id = $vendor ? $vendor->id : null;
        
        $categoriesQuery = \App\Models\Category::with('products')->orderBy('rank');
        $featuredProductsQuery = \App\Models\Product::orderBy('rank');
        
        if ($vendor_id) {
            $categoriesQuery->where('vendor_id', $vendor_id);
            $featuredProductsQuery->where('vendor_id', $vendor_id);
        } else {
            $categoriesQuery->whereNull('vendor_id');
            $featuredProductsQuery->whereNull('vendor_id');
        }
        
        $categories = $categoriesQuery->get();
        $featuredProducts = $featuredProductsQuery->take(8)->get();
        
        $slidesQuery = \App\Models\Slide::where('active', true);
        if ($vendor_id) {
            $slidesQuery->where('vendor_id', $vendor_id);
        } else {
            $slidesQuery->whereNull('vendor_id');
        }
        $slides = $slidesQuery->orderBy('order')->get();

        return view('web::index', compact('categories', 'featuredProducts', 'slides'));
    }

    public function about()
    {
        $vendor = request()->attributes->get('current_vendor');
        $vendor_id = $vendor ? $vendor->id : null;

        $slidesQuery = \App\Models\Slide::where('active', true);
        if ($vendor_id) {
            $slidesQuery->where('vendor_id', $vendor_id);
        } else {
            $slidesQuery->whereNull('vendor_id');
        }
        $slides = $slidesQuery->orderBy('order')->get();

        return view('web::about', compact('slides', 'vendor'));
    }

    public function contact()
    {
        $vendor = request()->attributes->get('current_vendor');
        $vendor_id = $vendor ? $vendor->id : null;

        $slidesQuery = \App\Models\Slide::where('active', true);
        if ($vendor_id) {
            $slidesQuery->where('vendor_id', $vendor_id);
        } else {
            $slidesQuery->whereNull('vendor_id');
        }
        $slides = $slidesQuery->orderBy('order')->get();

        return view('web::contact', compact('slides', 'vendor'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['vendor_id'] = $request->get('vendor_id');

        \App\Models\ContactRequest::create($validated);

        return back()->with('success', __('Your message has been sent successfully!'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web::create');
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
        return view('web::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('web::edit');
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

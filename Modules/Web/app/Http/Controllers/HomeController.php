<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Web\Http\Requests\VendorRegistrationRequest;
use Modules\Web\Services\VendorRegistrationService;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendor = $request->attributes->get('current_vendor');
        $vendor_id = $vendor ? $vendor->id : null;

        // Record Visit
        \App\Models\Visit::record([
            'vendor_id' => $vendor_id
        ]);

        $categoriesQuery = \App\Models\Category::with(['products' => function($q) {
            $q->withValidPrice();
        }])->orderBy('rank');
        $featuredProductsQuery = \App\Models\Product::withValidPrice()->orderBy('rank');
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

        $promotionsQuery = \App\Models\Promotion::with(['buyProduct', 'getProduct'])
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });

        if ($vendor_id) {
            $promotionsQuery->where('vendor_id', $vendor_id);
        } else {
            $promotionsQuery->whereNull('vendor_id');
        }

        $promotions = $promotionsQuery->latest()->get();
        
        $coupons = \App\Models\Coupon::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')->orWhereRaw('used_count < usage_limit');
            })
            ->latest()
            ->get();

        return view('web::index', compact('categories', 'featuredProducts', 'slides', 'vendor', 'promotions', 'coupons'));
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

        $vendor = $request->attributes->get('current_vendor');
        $validated['vendor_id'] = $vendor ? $vendor->id : null;

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
    public function store(Request $request)
    {
    }

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
    public function update(Request $request, $id)
    {
    }

    public function becomeVendor()
    {
        return view('web::become_vendor');
    }

    public function registerVendor(VendorRegistrationRequest $request, VendorRegistrationService $registrationService)
    {
        $currentVendorContext = $request->attributes->get('current_vendor');
        $registrationService->register($request->validated(), $currentVendorContext);

        return redirect()->route('home', ['vendor_id' => $request->get('vendor_id')])
            ->with('success', __('Your application has been submitted successfully! We will contact you soon.'));
    }

    public function returns()
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

        return view('web::returns', compact('slides', 'vendor'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}

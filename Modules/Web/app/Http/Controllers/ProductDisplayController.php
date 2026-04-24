<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Web\Services\ProductDisplayService;

class ProductDisplayController extends Controller
{
    protected $productService;

    public function __construct(ProductDisplayService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendor = $request->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;
        $data = $this->productService->getShopData($request, $vendorId);

        return view('web::shop', $data);
    }

    /**
     * Display a listing of promotions.
     */
    public function promotions(Request $request)
    {
        $vendor = $request->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;
        $data = $this->productService->getPromotionsData($request, $vendorId);

        return view('web::promotions.index', $data);
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request, $id)
    {
        $vendor = $request->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;

        $product = $this->productService->getProductDetails($id, $vendorId);

        if (!$product) {
            abort(404);
        }

        return view('web::show', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web::create');
    }

    /**
     * Show the specified promotion.
     */
    public function showPromotion(Request $request, $id)
    {
        $vendor = $request->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;

        $promotion = $this->productService->getPromotionDetails($id, $vendorId);

        if (!$promotion) {
            abort(404);
        }

        return view('web::promotions.show', compact('promotion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}

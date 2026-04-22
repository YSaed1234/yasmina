<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::with('products')->orderBy('rank')->get();
        $featuredProducts = \App\Models\Product::orderBy('rank')->take(8)->get();
        return view('web::index', compact('categories', 'featuredProducts'));
    }

    public function about()
    {
        return view('web::about');
    }

    public function contact()
    {
        return view('web::contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

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

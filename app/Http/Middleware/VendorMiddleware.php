<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->vendor_id) {
            return redirect()->route('home')->with('error', __('You do not have access to the vendor panel.'));
        }

        if (auth()->user()->vendor->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->with('error', __('Your institution account is inactive.'));
        }

        return $next($request);
    }
}

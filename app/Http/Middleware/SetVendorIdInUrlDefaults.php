<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetVendorIdInUrlDefaults
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->filled('vendor_id')) {
            URL::defaults([
                'vendor_id' => $request->vendor_id,
            ]);
        }

        return $next($request);
    }
}
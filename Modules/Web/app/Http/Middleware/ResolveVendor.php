<?php

namespace Modules\Web\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Vendor;

class ResolveVendor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $vendorIdentifier = $request->get('vendor_id');

        if ($vendorIdentifier) {
            // Check if it's already an ID (numeric) or a slug
            $vendor = Vendor::where('id', $vendorIdentifier)
                ->orWhere('slug', $vendorIdentifier)
                ->first();

            if ($vendor) {
                // Store the vendor object in the request attributes instead of merging
                // This keeps the original 'vendor_id' (slug) in the request parameters
                $request->attributes->set('current_vendor', $vendor);
            }
        }

        return $next($request);
    }
}

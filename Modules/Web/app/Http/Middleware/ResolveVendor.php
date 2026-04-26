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

        // If explicitly requested a vendor, store it in session
        if ($vendorIdentifier) {
            if ($vendorIdentifier === 'main') {
                session()->forget('current_vendor_id');
                $vendor = null;
            } else {
                $vendor = Vendor::where('id', $vendorIdentifier)
                    ->orWhere('slug', $vendorIdentifier)
                    ->first();
                
                if ($vendor) {
                    session(['current_vendor_id' => $vendor->id]);
                }
            }
        } else {
            // Otherwise, try to get from session
            $sessionVendorId = session('current_vendor_id');
            if ($sessionVendorId) {
                $vendor = Vendor::find($sessionVendorId);
            } else {
                $vendor = null;
            }
        }

        if ($vendor) {
            $request->attributes->set('current_vendor', $vendor);
        }

        return $next($request);
    }
}

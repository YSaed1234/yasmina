<?php

namespace Modules\Web\Services;

use Modules\Admin\Services\VendorService;
use App\Notifications\VendorApplicationReceivedNotification;
use Illuminate\Support\Facades\Auth;

class VendorRegistrationService
{
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function register(array $data, $currentVendorContext = null)
    {
        $data['status'] = 'inactive'; // Set as inactive by default

        if ($currentVendorContext) {
            $data['referred_by_id'] = $currentVendorContext->id;
        }

        $vendor = $this->vendorService->storeVendor($data);

        // Send notification to the new vendor account
        $vendor->notify(new VendorApplicationReceivedNotification($vendor));

        // Send notification to the logged-in user (if any)
        if (Auth::check()) {
            Auth::user()->notify(new VendorApplicationReceivedNotification($currentVendorContext));
        }

        return $vendor;
    }
}

<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Modules\Web\Http\Requests\UpdateAddressRequest;
use Modules\Web\Http\Requests\StoreReviewRequest;
use Modules\Web\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $user = auth()->user();
        return view('web::profile.index', compact('user'));
    }

    public function orders()
    {
        $vendor = request()->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;
        $orderId = request('order_id');
        
        $orders = $this->profileService->getOrders($vendorId);
        $totalPromotionalSavings = $this->profileService->getTotalPromotionalSavings($vendorId);
        
        $targetOrder = null;
        if ($orderId) {
            $targetOrder = \App\Models\Order::with(['items.product', 'driver'])
                ->where('user_id', auth()->id())
                ->find($orderId);
        }
        
        return view('web::profile.orders', compact('orders', 'totalPromotionalSavings', 'targetOrder'));
    }

    public function wallet()
    {
        $user = auth()->user();
        $pointTransactions = $this->profileService->getPointTransactions();
        $walletTransactions = $this->profileService->getWalletTransactions();
        $rate = (float) \App\Models\PointSetting::getValue('currency_per_point', 0.1);
        $minPoints = (int) \App\Models\PointSetting::getValue('min_points_to_convert', 100);

        return view('web::profile.wallet', compact('user', 'pointTransactions', 'walletTransactions', 'rate', 'minPoints'));
    }

    public function addresses()
    {
        $vendor = request()->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;
        
        $addresses = $this->profileService->getAddresses($vendorId);
        $governorates = $this->profileService->getGovernorates();
        
        return view('web::profile.addresses', compact('addresses', 'governorates'));
    }

    public function storeAddress(UpdateAddressRequest $request)
    {
        $this->profileService->storeAddress($request->all());

        return back()->with('success', __('Address added successfully.'));
    }

    public function updateAddress(UpdateAddressRequest $request, Address $address)
    {
        $success = $this->profileService->updateAddress($address, $request->all());

        if (!$success) {
            abort(403);
        }

        return back()->with('success', __('Address updated successfully.'));
    }

    public function storeReview(StoreReviewRequest $request)
    {
        $vendor = request()->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;

        $result = $this->profileService->storeReview($request->validated(), $vendorId);

        if (!$result['success']) {
            return back()->with('error', $result['error']);
        }

        return back()->with('success', $result['message']);
    }

    public function deleteAddress(Address $address)
    {
        $success = $this->profileService->deleteAddress($address);

        if (!$success) {
            abort(403);
        }

        return back()->with('success', __('Address deleted successfully.'));
    }

    public function convertPoints(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        $result = $this->profileService->convertPoints($request->points);

        if (!$result['success']) {
            return back()->with('error', $result['error']);
        }

        return back()->with('success', __('Successfully converted :points points to :money in your wallet.', [
            'points' => $request->points,
            'money' => $result['money']
        ]));
    }
}

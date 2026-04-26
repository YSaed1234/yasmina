<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
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
        $orders = $this->profileService->getOrders($vendorId);
        $totalPromotionalSavings = $this->profileService->getTotalPromotionalSavings($vendorId);
        
        return view('web::profile.orders', compact('orders', 'totalPromotionalSavings'));
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

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^(\+20|0)?1[0125][0-9]{8}$|^(\+966|0)?5[0-9]{8}$/'],
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
            'region_id' => 'required|exists:regions,id',
        ], [
            'phone.regex' => __('Please enter a valid Egyptian or Saudi phone number.'),
            'governorate_id.required' => __('Please select a governorate.'),
            'region_id.required' => __('Please select an area.')
        ]);
        
        $this->profileService->storeAddress($request->all());

        return back()->with('success', __('Address added successfully.'));
    }

    public function updateAddress(Request $request, Address $address)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^(\+20|0)?1[0125][0-9]{8}$|^(\+966|0)?5[0-9]{8}$/'],
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
            'region_id' => 'required|exists:regions,id',
        ], [
            'phone.regex' => __('Please enter a valid Egyptian or Saudi phone number.'),
            'governorate_id.required' => __('Please select a governorate.'),
            'region_id.required' => __('Please select an area.')
        ]);

        $success = $this->profileService->updateAddress($address, $request->all());

        if (!$success) {
            abort(403);
        }

        return back()->with('success', __('Address updated successfully.'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $vendor = request()->attributes->get('current_vendor');
        $vendorId = $vendor ? $vendor->id : null;

        $result = $this->profileService->storeReview($request->all(), $vendorId);

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

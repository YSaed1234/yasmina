<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Order;
use App\Models\Review;
use App\Models\Governorate;
use App\Models\Region;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('web::profile.index', compact('user'));
    }

    public function orders()
    {
        $vendorId = request()->vendor_id;
        $orders = Order::where('vendor_id', $vendorId)
            ->where('user_id', auth()->id())
            ->with([
                'items.product'
            ])
            ->latest()
            ->paginate(10);

        return view('web::profile.orders', compact('orders'));
    }

    public function addresses()
    {
        $vendorId = request()->vendor_id;
        $addresses = auth()->user()->addresses()->with(['governorate', 'region'])->where('vendor_id', $vendorId)->latest()->get();
        $governorates = Governorate::orderBy('name')->get();
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
        auth()->user()->addresses()->create($request->all());

        return back()->with('success', __('Address added successfully.'));
    }

    public function updateAddress(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id())
            abort(403);

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

        $address->update($request->all());

        return back()->with('success', __('Address updated successfully.'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $vendor_id = request('vendor_id');

        // Check if user has an order with this product
        $hasOrdered = auth()->user()->orders()
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })->exists();

        if (!$hasOrdered) {
            return back()->with('error', __('You can only rate products you have purchased.'));
        }

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id, 'vendor_id' => $vendor_id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', __('Thank you for your review!'));
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', __('Address deleted successfully.'));
    }

    public function convertPoints(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
        ]);

        try {
            $money = auth()->user()->convertPointsToBalance($request->points);
            return back()->with('success', __('Successfully converted :points points to :money in your wallet.', [
                'points' => $request->points,
                'money' => $money
            ]));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

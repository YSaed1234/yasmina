<?php

namespace Modules\Web\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('web::profile.index', compact('user'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('web::profile.orders', compact('orders'));
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('web::profile.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^(\+20|0)?1[0125][0-9]{8}$|^(\+966|0)?5[0-9]{8}$/'],
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ], [
            'phone.regex' => __('Please enter a valid Egyptian or Saudi phone number.')
        ]);

        auth()->user()->addresses()->create($request->all());

        return back()->with('success', __('Address added successfully.'));
    }

    public function updateAddress(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^(\+20|0)?1[0125][0-9]{8}$|^(\+966|0)?5[0-9]{8}$/'],
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ], [
            'phone.regex' => __('Please enter a valid Egyptian or Saudi phone number.')
        ]);

        $address->update($request->all());

        return back()->with('success', __('Address updated successfully.'));
    }

    public function deleteAddress(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return back()->with('success', __('Address deleted successfully.'));
    }
}

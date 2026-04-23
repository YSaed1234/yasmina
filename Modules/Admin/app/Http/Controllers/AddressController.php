<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use Modules\Admin\Services\AddressService;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(Request $request)
    {
        $addresses = $this->addressService->getPaginatedAddresses($request);
        $users = User::orderBy('name')->get();

        return view('admin::addresses.index', compact('addresses', 'users'));
    }

    public function destroy(Address $address)
    {
        $this->addressService->deleteAddress($address);
        return back()->with('success', __('Address deleted successfully.'));
    }
}

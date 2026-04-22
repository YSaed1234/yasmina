<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $query = Address::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('address_line1', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($qu) use ($request) {
                      $qu->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $addresses = $query->latest()->paginate(20);
        $users = User::orderBy('name')->get();

        return view('admin::addresses.index', compact('addresses', 'users'));
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return back()->with('success', __('Address deleted successfully.'));
    }
}

<?php

namespace Modules\Admin\Services;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressService
{
    /**
     * Get paginated addresses with optional filtering.
     *
     * @param Request $request
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedAddresses(Request $request, int $perPage = 20)
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

        return $query->latest()->paginate($perPage);
    }

    /**
     * Delete an address.
     *
     * @param Address $address
     * @return bool|null
     */
    public function deleteAddress(Address $address)
    {
        return $address->delete();
    }
}

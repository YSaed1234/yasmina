<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactRequest::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(10);
        return view('admin::contact_requests.index', compact('requests'));
    }

    public function markAsReplied($id)
    {
        $request = ContactRequest::findOrFail($id);
        $request->update(['status' => 'replied']);

        return back()->with('success', __('Contact request marked as replied.'));
    }
}

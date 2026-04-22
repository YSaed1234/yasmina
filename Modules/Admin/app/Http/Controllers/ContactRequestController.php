<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    public function index()
    {
        $requests = ContactRequest::latest()->paginate(10);
        return view('admin::contact_requests.index', compact('requests'));
    }

    public function markAsReplied($id)
    {
        $request = ContactRequest::findOrFail($id);
        $request->update(['status' => 'replied']);

        return back()->with('success', __('Contact request marked as replied.'));
    }
}

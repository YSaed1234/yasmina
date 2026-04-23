<?php

namespace Modules\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        $contacts = ContactRequest::where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(10);

        return view('vendor::contacts.index', compact('contacts'));
    }

    public function show(ContactRequest $contact)
    {
        if ($contact->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        // Mark as read if status is pending
        if ($contact->status === 'pending') {
            $contact->update(['status' => 'read']);
        }

        return view('vendor::contacts.show', compact('contact'));
    }

    public function markAsRead(ContactRequest $contact)
    {
        if ($contact->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $contact->update(['status' => 'read']);

        return back()->with('success', __('Message marked as read.'));
    }

    public function markAsReplied(ContactRequest $contact)
    {
        if ($contact->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $contact->update(['status' => 'replied']);

        return back()->with('success', __('Message marked as replied.'));
    }

    public function destroy(ContactRequest $contact)
    {
        if ($contact->vendor_id !== Auth::guard('vendor')->id()) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('vendor.contacts.index')->with('success', __('Contact request deleted successfully.'));
    }
}

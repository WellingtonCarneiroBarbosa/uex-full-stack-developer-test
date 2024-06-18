<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    public function __invoke(Contact $contact)
    {
        Gate::authorize('delete', $contact);

        $contact->delete();

        $this->response(
            web: fn () => redirect()->route('dash.contacts.index')->with('flash', [
                'type'    => 'success',
                'message' => __('messages.contacts.deleted'),
            ]),
            api: fn () => response()->json(__('messages.contacts.deleted'))
        );
    }
}

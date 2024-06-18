<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\UpdateRequest;
use App\Http\Resources\Contacts\ContactResource;
use App\Models\Contact;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Contact $contact)
    {
        $data = $request->validated();

        $contact->forceFill($data);
        $contact->save();

        return $this->response(
            web: fn () => redirect()->route('dash.contacts.index')->with('flash', [
                'type'    => 'success',
                'message' => __('messages.contacts.updated'),
            ]),
            api: fn () => (new ContactResource($contact))->response()->setStatusCode(200)
        );
    }
}

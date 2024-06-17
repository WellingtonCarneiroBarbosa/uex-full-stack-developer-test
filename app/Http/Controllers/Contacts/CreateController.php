<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\CreateRequest;
use App\Http\Resources\Contacts\ContactResource;
use App\Models\Contact;

class CreateController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        $data = $request->validated();

        $contact = new Contact();
        $contact->forceFill($data);
        $contact->user()->associate($request->user());
        $contact->save();

        return $this->response(
            web: fn () => redirect()->route('dash.contacts.index')->with('flash', [
                'type'    => 'success',
                'message' => __('messages.contacts.created'),
            ]),
            api: fn () => (new ContactResource($contact))->response()->setStatusCode(201)
        );
    }
}

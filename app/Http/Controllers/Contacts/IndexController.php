<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contacts\ContactPagination;
use App\Models\Contact;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke()
    {
        Gate::authorize('viewAny', Contact::class);

        $contacts = Contact::orderBy('name', 'asc')->paginate(50);

        return $this->response(
            web: fn () => Inertia::render('Contacts/Contacts', [
                'contacts' => $contacts,
            ]),
            api: fn () => new ContactPagination($contacts)
        );
    }
}

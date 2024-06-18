<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Contacts/Contacts', [
            'contacts' => Contact::orderBy('name', 'asc')->paginate(50),
        ]);
    }
}

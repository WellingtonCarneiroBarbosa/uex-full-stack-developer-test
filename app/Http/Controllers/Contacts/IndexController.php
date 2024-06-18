<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contacts\ContactPagination;
use App\Models\Contact;
use App\Rules\CPF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        Gate::authorize('viewAny', Contact::class);

        $contacts = $this->query(
            $request,
            Contact::query()
        )->orderBy('name', 'asc')->paginate(50);

        return $this->response(
            web: fn () => Inertia::render('Contacts/Contacts', [
                'contacts' => $contacts,
            ]),
            api: fn () => new ContactPagination($contacts)
        );
    }

    protected function query(Request $request, Builder $query): Builder
    {
        $params = $request->validate([
            'cpf'  => ['nullable', new CPF()],
            'name' => ['nullable'],
        ]);

        foreach ($params as $key => $param) {
            match ($key) {
                'cpf'   => $query->where('cpf', extractDigitsRegex($param)),
                'name'  => $query->where('name', 'like', "%{$param}%"),
                default => null
            };
        }

        return $query;
    }
}

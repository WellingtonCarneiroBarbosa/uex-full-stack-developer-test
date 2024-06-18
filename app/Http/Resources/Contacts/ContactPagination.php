<?php

namespace App\Http\Resources\Contacts;

use App\Http\Resources\Concerns\Pagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactPagination extends ResourceCollection
{
    use Pagination;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => $this->collection->map(fn ($contact) => new ContactResource($contact)),
            ...$this->getPagination(),
        ];
    }
}

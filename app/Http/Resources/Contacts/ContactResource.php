<?php

namespace App\Http\Resources\Contacts;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var Contact $resource
         */
        $resource = $this->resource;

        return [
            'name'                 => $resource->name,
            'email'                => $resource->email,
            'cpf'                  => $resource->cpf,
            'phone'                => $resource->phone,
            'address_cep'          => $resource->address_cep,
            'address_uf'           => $resource->address_uf,
            'address_state_name'   => $resource->address_state_name,
            'address_city'         => $resource->address_city,
            'address_neighborhood' => $resource->address_neighborhood,
            'address_street'       => $resource->address_street,
            'address_number'       => $resource->address_number,
            'address_complement'   => $resource->address_complement,
            'full_address'         => $resource->full_address,
        ];
    }
}

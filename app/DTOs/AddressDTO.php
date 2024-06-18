<?php

namespace App\DTOs;

class AddressDTO
{
    public function __construct(public $street, public $neighborhood, public $city, public $state, public $cep)
    {
    }

    public function toArray()
    {
        return [
            'street'       => mb_strtolower($this->street, 'UTF-8'),
            'neighborhood' => mb_strtolower($this->neighborhood, 'UTF-8'),
            'city'         => mb_strtolower($this->city, 'UTF-8'),
            'state'        => mb_strtolower($this->state, 'UTF-8'),
            'cep'          => $this->cep,
        ];
    }
}

<?php

namespace App\Http\Requests\Contacts;

use App\Rules\CPF;
use App\Utils\BrazilianStates;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'cpf'            => extractDigitsRegex($this->input('cpf', '')),
            'phone'          => extractDigitsRegex($this->input('phone', '')),
            'address_cep'    => extractDigitsRegex($this->input('address_cep', '')),
            'address_number' => extractDigitsRegex($this->input('address_number', '')),

            'address_uf' => mb_strtoupper($this->input('address_uf', '')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'  => ['required'],
            'email' => ['required', 'email:filter', 'unique:contacts,email'],
            'phone' => ['required', 'size:11', 'unique:contacts,phone'],
            'cpf'   => ['required', new CPF(), 'unique:contacts,cpf'],

            'address_cep'          => ['required', 'size:8'],
            'address_uf'           => ['required', 'size:2', 'in:' . implode(",", (new BrazilianStates())->getStateInitials())],
            'address_city'         => ['required'],
            'address_neighborhood' => ['required'],
            'address_street'       => ['required'],
            'address_number'       => ['required'],
            'address_complement'   => ['nullable'],
            'latitude'             => ['required',],
            'longitude'            => ['required'],
        ];
    }
}

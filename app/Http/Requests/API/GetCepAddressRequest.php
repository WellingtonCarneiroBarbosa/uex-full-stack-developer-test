<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class GetCepAddressRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'cep' => extractDigitsRegex($this->input('cep', '')),
        ]);
    }

    public function rules(): array
    {
        return [
            'cep' => ['required', 'size:8'],
        ];
    }
}

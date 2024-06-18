<?php

namespace App\Services\BrasilAPI\Cep;

use App\Contracts\CepProviderInterface;
use App\DTOs\AddressDTO;
use App\Exceptions\CepProviderUnavailable;
use App\Services\BrasilAPI\BrasilAPI;
use Http;
use Illuminate\Validation\ValidationException;

class CepProvider extends BrasilAPI implements CepProviderInterface
{
    public function getAddressByCep(string $cep): AddressDTO
    {
        $response = Http::acceptJson()->get("{$this->config['base-url']}/v1/{$cep}");

        throw_if($response->failed() && $response->status() !== 404, new CepProviderUnavailable('brasilAPI'));

        $data = $response->json();

        throw_if(
            !isset($data['state']) || isset($data['erros']) || $response->status() === 404,
            ValidationException::withMessages([
                'address_cep' => __('validation.invalid_cep', ['cep' => format($cep, '#####-###')]),
            ])
        );

        return new AddressDTO(
            $data['street'] ?? '',
            $data['neighborhood'] ?? '',
            $data['city'] ?? '',
            $data['state'] ?? '',
            $cep
        );
    }
}

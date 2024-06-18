<?php

namespace App\Services\ViaCep;

use App\Contracts\CepProviderInterface;
use App\DTOs\AddressDTO;
use App\Exceptions\CepProviderUnavailable;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ViaCepProvider implements CepProviderInterface
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('services.via-cep');
    }

    public function getAddressByCep(string $cep): AddressDTO
    {
        $response = Http::get("{$this->config['base-url']}/ws/{$cep}/json/");

        throw_if($response->failed(), new CepProviderUnavailable('viacep'));

        $data = $response->json();

        throw_if(isset($data['erro']) && $data['erro'] === true, ValidationException::withMessages([
            'address_cep' => __('validation.invalid_cep', ['cep' => format($cep, '#####-###')]),
        ]));

        return new AddressDTO(
            $data['logradouro'] ?? '',
            $data['bairro'] ?? '',
            $data['localidade'] ?? '',
            $data['uf'] ?? '',
            $cep
        );
    }
}

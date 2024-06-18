<?php

namespace App\Services\CepProviderManager;

use App\Contracts\CepProviderInterface;
use App\DTOs\AddressDTO;
use App\Exceptions\CepProviderUnavailable;
use App\Exceptions\InvalidCep;

class CepProviderManager implements CepProviderInterface
{
    protected $providers;

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function getAddressByCep(string $cep): AddressDTO
    {
        foreach ($this->providers as $provider) {
            try {
                return $provider->getAddressByCep($cep);
            } catch (InvalidCep | \Exception $e) {
                throw $e;
            } catch (CepProviderUnavailable $e) {
                continue;
            }
        }

        throw new CepProviderUnavailable('all');
    }
}

<?php

namespace App\Contracts;

use App\DTOs\AddressDTO;

interface CepProviderInterface
{
    /**
     * Get full address from a cep
     *
     * @param string $cep
     * @return AddressDTO
     *
     * @throws CepProviderUnavailable If the provider is unavailable
     * @throws InvalidCep If the provided cep does not exists or is invalid
     */
    public function getAddressByCep(string $cep): AddressDTO;
}

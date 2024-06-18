<?php

namespace App\Contracts;

use App\DTOs\AddressDTO;

interface AddressProviderInterface
{
    /**
     * Get full address from a partial address name
     *
     * @param string $partialAddress
     * @return Array<AddressDTO>
     *
     * @throws ValidationException If the provided address is invalid
     */
    public function getPotentialAddressesFromPartialAddress(string $partialAddress): array;
}

<?php

namespace App\Contracts;

use App\DTOs\LatitudeLongitudeDTO;

interface CoordinatesProviderInterface
{
    /**
     * Get latitude and longitude from a full address string
     *
     * @param string $address
     * @return LatitudeLongitudeDTO
     *
     * @throws Exception If the address can not be parsed
     */
    public function getCoordinatesFromAddress(string $address): LatitudeLongitudeDTO;
}

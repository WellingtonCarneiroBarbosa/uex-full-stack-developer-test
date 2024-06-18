<?php

namespace App\Services\GoogleGeocodingAPI;

use App\Contracts\AddressProviderInterface;
use App\DTOs\AddressDTO;
use Illuminate\Validation\ValidationException;

class AddressProvider extends GoogleGeocodingAPI implements AddressProviderInterface
{
    /**
     * TODO: Return coordinates too
     *
     * @param string $partialAddress
     * @return Array<AddressDTO>
     */
    public function getPotentialAddressesFromPartialAddress(string $partialAddress): array
    {
        $response = $this->getLocationInformation($partialAddress)->json();

        if (!isset($response['results']) || count($response['results']) === 0) {
            throw ValidationException::withMessages([
                'address' => 'Endereço inválido. Inclua pelo menos o nome de um logradouro.',
            ]);
        }

        $data = [];

        foreach ($response['results'] as $locations) {
            foreach ($locations as $key => $location) {
                $street       = "";
                $neighborhood = "";
                $city         = "";
                $state        = "";
                $postalCode   = "";

                if ($key === "address_components") {
                    /**
                     * 0 = street
                     * 1 = neighborhood
                     * 2 = city
                     * 3 = state
                     * 4 = country
                     * 5 = postal code
                     */
                    foreach ($location as $addressKey => $addressComponent) {
                        match ($addressKey) {
                            0       => $street       = $addressComponent['long_name'],
                            1       => $neighborhood = $addressComponent['long_name'],
                            2       => $city         = $addressComponent['long_name'],
                            3       => $state        = $addressComponent['short_name'],
                            5       => $postalCode   = $this->normalizePostalCode(extractDigitsRegex($addressComponent['long_name'])),
                            default => null,
                        };
                    }

                    array_push($data, new AddressDTO(
                        $street,
                        $neighborhood,
                        $city,
                        $state,
                        $postalCode
                    ));
                }
            }
        }

        return $data;
    }
}

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
                    foreach ($location as $addressComponent) {
                        match ($addressComponent['types'][0]) {
                            "route"                       => $street     = $addressComponent['long_name'],
                            "administrative_area_level_2" => $city       = $addressComponent['long_name'],
                            "administrative_area_level_1" => $state      = $addressComponent['short_name'],
                            "postal_code"                 => $postalCode = $this->normalizePostalCode(extractDigitsRegex($addressComponent['long_name'])),
                            default                       => null,
                        };

                        if (isset($addressComponent['types'][1]) && $addressComponent['types'][1] === "sublocality") {
                            $neighborhood = $addressComponent['long_name'];
                        }
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

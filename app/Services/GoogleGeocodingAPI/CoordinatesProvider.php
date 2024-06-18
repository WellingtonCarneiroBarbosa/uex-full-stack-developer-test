<?php

namespace App\Services\GoogleGeocodingAPI;

use App\Contracts\CoordinatesProviderInterface;
use App\DTOs\LatitudeLongitudeDTO;
use Exception;

class CoordinatesProvider extends GoogleGeocodingAPI implements CoordinatesProviderInterface
{
    public function getCoordinatesFromAddress(string $address): LatitudeLongitudeDTO
    {
        $response = $this->getLocationInformation($address)->json();

        if (!isset($response['results'][0]['geometry'])) {
            throw new Exception('Can not retrieve data from google api');
        }

        $coordinates = $response['results'][0]['geometry']['location'];

        return new LatitudeLongitudeDTO($coordinates['lat'], $coordinates['lng']);
    }
}

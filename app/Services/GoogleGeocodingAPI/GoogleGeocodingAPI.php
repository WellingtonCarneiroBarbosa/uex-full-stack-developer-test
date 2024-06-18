<?php

namespace App\Services\GoogleGeocodingAPI;

use App\Contracts\CoordinatesProviderInterface;
use App\DTOs\LatitudeLongitudeDTO;
use Exception;
use Http;

class GoogleGeocodingAPI implements CoordinatesProviderInterface
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('services.google-geocoding-api');
    }

    public function getCoordinatesFromAddress(string $address): LatitudeLongitudeDTO
    {
        $response = Http::get("{$this->config['base-url']}/maps/api/geocode/json", [
            'address' => $address,
            'key'     => $this->config['token'],
        ]);

        $response = $response->json();

        if (!isset($response['results'][0]['geometry'])) {
            throw new Exception('Can not retrieve data from google api');
        }

        $coordinates = $response['results'][0]['geometry']['location'];

        return new LatitudeLongitudeDTO($coordinates['lat'], $coordinates['lng']);
    }
}

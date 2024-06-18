<?php

namespace App\Services\GoogleGeocodingAPI;

use Http;
use Illuminate\Http\Client\Response;

class GoogleGeocodingAPI
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('services.google-geocoding-api');
    }

    protected function getLocationInformation(string $address): Response
    {
        return Http::get("{$this->config['base-url']}/maps/api/geocode/json", [
            'address' => $address,
            'key'     => $this->config['token'],
        ]);
    }

    protected function normalizePostalCode(string $validPostalCode): string
    {
        if (strlen($validPostalCode) < 8) {
            $validPostalCode = str_pad($validPostalCode, 8, '0', STR_PAD_RIGHT);
        }

        return $validPostalCode;
    }
}

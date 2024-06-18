<?php

namespace App\DTOs;

class LatitudeLongitudeDTO
{
    public function __construct(
        public $latitude,
        public $longitude
    ) {
    }

    public function __toArray(): array
    {
        return [
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}

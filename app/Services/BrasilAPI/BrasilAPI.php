<?php

namespace App\Services\BrasilAPI;

class BrasilAPI
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('services.brasil-api');
    }
}

<?php

namespace App\Providers;

use App\Contracts\CepProviderInterface;
use App\Contracts\CoordinatesProviderInterface;
use App\Services\BrasilAPI;
use App\Services\CepProviderManager\CepProviderManager;
use App\Services\GoogleGeocodingAPI\GoogleGeocodingAPI;
use App\Services\ViaCep\ViaCepProvider;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CepProviderInterface::class, function ($app) {
            return new CepProviderManager([
                new ViaCepProvider(),
                new BrasilAPI\Cep\CepProvider(),
            ]);
        });

        $this->app->singleton(CoordinatesProviderInterface::class, function ($app) {
            return new GoogleGeocodingAPI();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });

        Scramble::extendOpenApi(function () {
            SecurityScheme::apiKey('Authentication header', 'api_token');
        });
    }
}

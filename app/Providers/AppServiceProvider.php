<?php

namespace App\Providers;

use App\Contracts\CepProviderInterface;
use App\Contracts\CoordinatesProviderInterface;
use App\Services\BrasilAPI;
use App\Services\CepProviderManager\CepProviderManager;
use App\Services\GoogleGeocodingAPI\GoogleGeocodingAPI;
use App\Services\ViaCep\ViaCepProvider;
use Illuminate\Support\ServiceProvider;

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
        //
    }
}

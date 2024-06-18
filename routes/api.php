<?php

use App\Http\Controllers\API\GetCepAddressController;
use App\Http\Controllers\API\GetCoordinatesFromAddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/cep/{cep}', GetCepAddressController::class)->name('get-cep-address');

    Route::get('/coordinates/{address}', GetCoordinatesFromAddressController::class)->name('get-coordinates');

    require __DIR__ . '/api/contacts.php';
});

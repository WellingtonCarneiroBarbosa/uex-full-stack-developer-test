<?php

use App\Http\Controllers\API\GetCepAddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/cep/{cep}', GetCepAddressController::class)->name('get-cep-address');

    return include_once __DIR__ . '/api/contacts.php';
});

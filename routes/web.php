<?php

use App\Http\Controllers\API\GetCepAddressController;
use App\Http\Controllers\API\GetCoordinatesFromAddressController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('/dashboard')->name('dash.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dash.contacts.index');
    })->name('index');

    Route::get('/teste', function () {
        return Inertia::render('Test');
    })->name('test');

    Route::get('/cep/{cep}', GetCepAddressController::class)->name('get-cep-address');

    Route::get('/coordinates/{address}', GetCoordinatesFromAddressController::class)->name('get-coordinates');

    require __DIR__ . "/web/contacts.php";
});

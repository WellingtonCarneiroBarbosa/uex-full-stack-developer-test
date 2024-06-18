<?php

use App\Http\Controllers\Contacts\CreateController;
use App\Http\Controllers\Contacts\DeleteController;
use App\Http\Controllers\Contacts\IndexController;
use App\Http\Controllers\Contacts\UpdateController;

Route::prefix('/contact')->name('contact.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::post('/', CreateController::class)->name('store');
    Route::put('/{contact}', UpdateController::class)->name('update');
    Route::delete('/{contact}', DeleteController::class)->name('delete');
});

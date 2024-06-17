<?php

use App\Http\Controllers\Contacts\IndexController;

Route::prefix('contacts')->name('contacts.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
});

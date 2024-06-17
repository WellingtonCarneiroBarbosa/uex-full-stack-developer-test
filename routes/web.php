<?php

use Illuminate\Support\Facades\Route;

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

    include_once __DIR__ . "/web/contacts.php";
});

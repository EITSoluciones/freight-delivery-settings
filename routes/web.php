<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('clients', ClientController::class)->except([
    'show'
]);
Route::get('/api/clients/{activation_code}', [ClientController::class, 'getByActivationCode']);

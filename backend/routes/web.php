<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('pasien/all', [PasienController::class, 'getAllPasien']);
Route::get('pasien/{id}', [PasienController::class, 'getDetailPasien']);




Route::get('/edit/{id}', [PasienController::class, 'showUpdate']);
Route::get('/data/{id}', [PasienController::class, 'show'])->whereNumber('id');
Route::post('/data/input', [PasienController::class, 'store']);
Route::get('/data/input', [PasienController::class, 'inputPage']);

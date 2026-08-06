<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

// 
Route::get('/cars', [CarController::class, 'index']);

// localhost/cars
// Route::get('/cars', function () {
//     // dd('hello route cars');
//     // return view('welcome');
//     return view('car.index');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

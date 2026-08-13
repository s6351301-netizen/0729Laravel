<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// hotel
Route::get('/hotel', function () {
    // view folder name
    // views/hotel/index.blade.php
    return view('hotel.index');
});

// hotel f1
Route::get('/f1', function () {
    // view folder name
    // views/hotel/index.blade.php
    return view('hotel.f1');
});

// hotel f2
Route::get('/f2', function () {
    // view folder name
    // views/hotel/index.blade.php
    return view('hotel.f2');
});

// hotel f1
Route::get('/f3', function () {
    // view folder name
    // views/hotel/index.blade.php
    return view('hotel.f3');
});

// localhost/num1/1000/num2/200
Route::get('/num1/{num1}/num2/{num2}', function ($num1, $num2) {
    $result = $num1 + $num2;
    $data = [
        'num1' => $num1,
        'num2' => $num2,
        'result' => $result
    ];
    return view('sum')->with(['data' => $data]);
});

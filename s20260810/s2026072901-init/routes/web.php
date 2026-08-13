<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


// get('/網址','執行動作function') 這個字串 網址 localhost/hello222
// view('') 頁面
Route::get('/hello222', function () {
    return view('table222');
});

Route::get('/hello444', function () {
    return view('table444');
});

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/calculator', function () {
    // echo "hihi calculator";
    $data = [1, 2, 3];
    $assocArr = [
        [
            'id' => 1,
            'name' => 'amy',
            'mobile' => '0911'
        ],
        [
            'id' => 2,
            'name' => 'bob',
            'mobile' => '0922'
        ],
        [
            'id' => 3,
            'name' => 'cat',
            'mobile' => '0933'
        ]
    ];

    // dd() 會中斷
    // dump() 不會中斷
    // laravel helper
    dump($data);
    dump($assocArr);
    dd('hello dd');

    // return 'Hello World';
});

Route::get('/user/{id}', function (string $id) {
    return 'User ' . $id;
});


// Route::get('/posts/{post}/comments/{comment}', function (num1 $num1, num2 $num2) {
//     $tmpText = "post $postId comment $commentId";
//     return $tmpText;
// });

// /num1/100/num2/200


Route::get('/num1/{num1}/num2/{num2}', function (string $num1, string $num2) {
    // $tmpText = "num1 $num1 num2 $num2";
    $result =  $num1 + $num2;
    $data = [
        'num1' => $num1,
        'num2' => $num2,
        'result' => $result
    ];
    // dd($data);
    // $test = compact('data');
    // dd($test);

    return view('cal')->with('data', $data);
    // return view('cal',  ['data' => $data]);

    // return view('cal', compact('data'));


    // return $tmpText;
});

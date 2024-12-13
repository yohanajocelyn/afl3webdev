<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/loginregister', function () {
    return view('log-reg', [
        "state" => "isLoggedOut"
    ]);
}); 

Route::get('/workshop-detail', function () {
    return view('workshop-detail', [
        "state" => "workshop-details"
    ]);
});

Route::get('/profile', function () {
    return view('profile', [
        "state" => "profile"
    ]);
});

Route::get('/teacherslist', function () {
    return view('teachers', [
        "state" => "teacherslist"
    ]);
});
<?php

use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [WorkshopController::class, 'getAll'])->name('home');

Route::get('/workshops', function () {
    return view('workshops');
})->name('workshops');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/loginregister', function () {
    return view('log-reg');
}); 

Route::get('/workshop/{id}', [WorkshopController::class, 'getById']);

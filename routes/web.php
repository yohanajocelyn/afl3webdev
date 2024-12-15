<?php

use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WorkshopController;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [WorkshopController::class, 'getAll'])->name('home');
Route::post('/home', [WorkshopController::class, 'getAll'])->name('home');

Route::get('/workshops', function () {
    return view('workshops');
})->name('workshops');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/loginregister', [LoginRegisterController::class, 'logRegSchool']); 
Route::post('/register', [TeacherController::class, 'register'])->name('register');
Route::post('/login', [TeacherController::class, 'login'])->name('login');
Route::post('/logout', [TeacherController::class, 'logout'])->middleware('auth:teacher')->name('logout');;

Route::get('/workshop/{id}', [WorkshopController::class, 'getById']);

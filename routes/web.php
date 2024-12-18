<?php

use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WorkshopController;
use App\Models\School;
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

Route::get('/workshop/{id}', [WorkshopController::class, 'getById']);

Route::get('/workshop-upload', function () {
    return view('workshop-upload');
})->name('workshop-upload');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/loginregister', [LoginRegisterController::class, 'logRegSchool']); 
Route::post('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->middleware('auth:teacher')->name('logout');

Route::get('/teacherprofile', [TeacherController::class, 'getProfile'])->middleware('auth:teacher');

Route::get('/teacherslist', [TeacherController::class, 'teachersListView'])->name('teachers-list');

Route::get('/schoolslist', function () {
    return view('schools', [
        "schools" => School::all()
    ]);
})->name('schools-list');

<?php

use App\Models\School;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WorkshopController;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WorkshopController::class, 'getAll'])->name('home');
Route::post('/', [WorkshopController::class, 'getAll'])->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Route::get('/teacherslist', function () {
//     return view('teachers', [
//         "state" => "teacherslist",
//         "teachers" => Teacher::all()
//     ]);
// });

Route::get('/schoolslist', function () {
    return view('schools', [
        "schools" => School::all()
    ]);
})->name('view-schools');

Route::get('/teacherslist', function () {
    $id = request()->query('schoolId');
    if($id==null){
        return view('teachers', [
            "state" => "teachers list",
            "teachers" => Teacher::all()
        ]);
    }else{
        return view('teachers', [
        "state" => "teachers list with school",
        "teachers" => Teacher::dataWithSchoolId($id),
        "school" => School::dataWithId($id)
        ]);
    }
})->name('view-teachers');

// workshop

Route::get('/workshops', function () {
    return view('workshops');
})->name('workshops');

Route::get('/workshop/{id}', [WorkshopController::class, 'getById'])->name('workshop-detail');

Route::get('/workshop-upload', function () {
    return view('workshop-upload');
})->name('workshop-upload');

Route::post('/upload', [WorkshopController::class, 'createWorkshop'])->name('upload');

Route::post('/register/{id}', [WorkshopController::class, 'registerWorkshop'])->name('register');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/loginregister', [LoginRegisterController::class, 'logRegSchool'])->name('loginregister'); 
Route::post('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->middleware('auth:teacher')->name('logout');

// Route::get('/loginregister');

Route::get('/teacherprofile', [TeacherController::class, 'getProfile'])->middleware('auth:teacher');

Route::get('/registrations', [WorkshopController::class, 'showRegistered'])->name('registrations');

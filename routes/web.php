<?php

use App\Models\School;
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

Route::get('/profile', function () {
    return view('profile');
});

// Route::get('/teacherslist', function () {
//     return view('teachers', [
//         "state" => "teacherslist",
//         "teachers" => Teacher::all()
//     ]);
// });

Route::get('/schoolslist', function () {
    return view('schools', [
        "state" => "School List",
        "schools" => School::all()
    ]);
});

Route::get('/workshop-upload', function () {
    return view('workshop-upload', [
        "state" => "workshop upload"
    ]);
});

Route::get('/teacherprofile', function () {
    $id = request()->query('teacherId');
        return view('teachersprofile', [
        "state" => "teacher's profile",
        "teacher" => Teacher::dataWithId($id)
    ]);
});

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
});
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
Route::post('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->middleware('auth:teacher')->name('logout');

Route::get('/workshop/{id}', [WorkshopController::class, 'getById']);

Route::get('/teacherprofile', [TeacherController::class, 'getProfile'])->middleware('auth:teacher');

Route::get('/workshop-upload', function () {
    return view('workshop-upload');
})->name('workshop-upload');

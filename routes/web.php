<?php

use App\Models\School;
use App\Models\Teacher;
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

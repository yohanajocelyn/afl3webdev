<?php

use App\Http\Controllers\AdminAssignmentController;
use App\Http\Controllers\AdminMeetController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AdminSchoolController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\AdminWorkshopController;
use App\Http\Controllers\AssignmentController;
use App\Models\School;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\WorkshopController;
use App\Models\Teacher;
use Illuminate\Routing\Router;
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

Route::post('/registerToWorkshop', [WorkshopController::class, 'registerWorkshop'])->name('registerToWorkshop');

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

Route::get('/registrations', [WorkshopController::class, 'showRegistration'])->name('registrations');

Route::get('/mark-presence', [PresenceController::class, 'show'])->name('mark-presence');

Route::post('/mark-present/{presenceId}', [PresenceController::class, 'update'])->name('mark-present');

Route::get('/workshop-progress', [WorkshopController::class, 'showProgress'])->name('workshop-progress');

Route::post('/add-meet', [WorkshopController::class, 'createMeet'])->name('create-meet');

Route::post('/mark-all-present/{meetId}', [PresenceController::class, 'markAllPresent'])->name('mark-all-present');

Route::post('/setApprove/{registrationId}', [RegistrationController::class, 'update'])->name('set-approve');

Route::put('/open-workshop', [WorkshopController::class, 'openWorkshop'])->name('open-workshop');

Route::get('/assignment-detail', [AssignmentController::class, 'assignmentDetail'])->name('assignment-detail');
Route::put('/edit-assignment', [AssignmentController::class, 'editAssignment'])->name('edit-assignment');

Route::post('approveSubmission/{submissionId}', [SubmissionController::class, 'update'])->name('approveSubmission');

// NEW
Route::get('/admin-home', function(){
    return view('admin-home');
})->name('admin-home');

Route::get('/admin-workshops', [AdminWorkshopController::class, 'index'])->name('admin-workshops');
Route::get('/admin-workshops/create', [AdminWorkshopController::class, 'create'])->name('admin-workshops-create');
Route::post('/admin-workshops', [AdminWorkshopController::class, 'store'])->name('workshops.store');
Route::get('/admin-workshops/{id}', [AdminWorkshopController::class, 'show'])->name('admin-workshops.show');
Route::get('/admin-workshops/{id}/edit', [AdminWorkshopController::class, 'edit'])->name('admin-workshops.edit');
Route::put('/admin-workshops/{id}', [AdminWorkshopController::class, 'update'])->name('admin-workshops.update');
Route::put('admin-workshops/{id}/toggle-status', [AdminWorkshopController::class, 'toggleStatus'])
    ->name('admin-workshops.toggle-status');

Route::prefix('admin-meets')->name('admin-meets.')->group(function () {
    Route::get('create/{workshop_id}', [AdminMeetController::class, 'create'])->name('create');
    Route::post('/', [AdminMeetController::class, 'store'])->name('store');
    Route::get('{id}', [AdminMeetController::class, 'show'])->name('show');
    Route::get('{id}/edit', [AdminMeetController::class, 'edit'])->name('edit');
    Route::put('{id}', [AdminMeetController::class, 'update'])->name('update');
});

Route::prefix('admin-assignments')->name('admin-assignments.')->group(function () {
    Route::get('create/{workshop_id}', [AdminAssignmentController::class, 'create'])->name('create');
    Route::get('{id}/edit', [AdminAssignmentController::class, 'edit'])->name('edit');
    Route::put('{id}', [AdminAssignmentController::class, 'update'])->name('update');
});

Route::prefix('admin-registrations')->name('admin-registrations.')->group(function () {
    Route::get('/', [AdminRegistrationController::class, 'index'])->name('registrations');
});

Route::prefix('admin-teachers')->name('admin-teachers.')->group(function () {
    Route::get('/', [AdminTeacherController::class, 'index'])->name('teachers');
    Route::get('/create', [AdminTeacherController::class, 'create'])->name('create');
    Route::post('/store', [AdminTeacherController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [AdminTeacherController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AdminTeacherController::class, 'update'])->name('update');
});

Route::prefix('admin-schools')->name('admin-schools.')->group(function () {
    Route::get('/', [AdminSchoolController::class, 'index'])->name('schools');
    Route::get('/create', [AdminSchoolController::class, 'create'])->name('create');
    Route::post('/store', [AdminSchoolController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [AdminSchoolController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AdminSchoolController::class, 'update'])->name('update');
});

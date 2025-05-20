<?php

use App\Filament\Pages\AssignmentDetail;
use App\Filament\Pages\MeetDetail;
use App\Filament\Pages\SubmissionDetail;
use App\Filament\Pages\WorkshopDetail;
use App\Http\Controllers\AssignmentController;
use App\Models\School;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SubmissionController;
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

Route::post('approveSubmission/{submissionId}', [SubmissionController::class, 'update'])->name('submission.approve');

//NEW
Route::get('/admin/workshops/{record}/detail', WorkshopDetail::class)->name('admin-workshops.show');
Route::get('/admin/meets/{record}/detail', MeetDetail::class)->name('admin-meets.show');
Route::get('/admin/assignments/{record}/detail', AssignmentDetail::class)->name('admin-assignments.show');
Route::get('/admin/submissions/{record}/detail', SubmissionDetail::class)->name('admin-submissions.show');
Route::get('/submissions', [SubmissionController::class, 'showSubmissions'])->name('submissions');
Route::post('approveSubmission/{submissionId}', [SubmissionController::class, 'update'])->name('approveSubmission');

Route::post('/assignment-detail/{id}/submit', [SubmissionController::class, 'submitAssignment'])->name('submit-assignment');
Route::delete('/submission/{id}', [SubmissionController::class, 'destroy'])->name('delete-submission');

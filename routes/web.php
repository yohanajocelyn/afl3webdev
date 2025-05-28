<?php

use App\Filament\Pages\AssignmentDetail;
use App\Filament\Pages\MeetDetail;
use App\Filament\Pages\SubmissionDetail;
use App\Filament\Pages\WorkshopDetail;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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

Route::get('/workshops', function () {
    return view('workshops');
})->name('workshops');

Route::get('/workshop/{id}', [WorkshopController::class, 'getById'])->name('workshop-detail');

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

Route::get('/assignment-detail', [AssignmentController::class, 'assignmentDetail'])->name('assignment-detail');
Route::put('/edit-assignment', [AssignmentController::class, 'editAssignment'])->name('edit-assignment');

//NEW
Route::get('/admin/workshops/{record}/detail', WorkshopDetail::class)->name('admin-workshops.show');
Route::get('/admin/meets/{record}/detail', MeetDetail::class)->name('admin-meets.show');
Route::get('/admin/assignments/{record}/detail', AssignmentDetail::class)->name('admin-assignments.show');
Route::get('/admin/submissions/{record}/detail', SubmissionDetail::class)->name('admin-submissions.show');
Route::get('/submissions', [SubmissionController::class, 'showSubmissions'])->name('submissions');
Route::post('approveSubmission/{submissionId}', [SubmissionController::class, 'update'])->name('approveSubmission');

Route::post('/assignment-detail/{id}/submit', [SubmissionController::class, 'submitAssignment'])->name('submit-assignment');
Route::delete('/submission/{id}', [SubmissionController::class, 'destroy'])->name('delete-submission');

Route::get('/my-courses', [TeacherController::class, 'getCourses'])->middleware('auth:teacher')->name('my-courses');

//edit profile
Route::post('/teacherprofile/edit', [TeacherController::class, 'editProfile'])->name('edit-profile');

// Request reset link
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset password form
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

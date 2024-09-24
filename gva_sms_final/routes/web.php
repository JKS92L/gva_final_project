<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExaminationTab;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GrandBoxController;
use App\Http\Controllers\Backend\teacher;
use App\Http\Controllers\GrandEbuyController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Route
Route::get('/', function () {
    return view('auth.login');
});

// Authentication Routes
Auth::routes();

// Define a middleware for authenticated users
Route::middleware(['auth'])->group(function () {

    // logout
    Route::get('/admin/login', [AdminController::class, 'Logout'])->name('admin.logout');
    // User Management Routes
    Route::prefix('/users')->group(function () {
        Route::get('/list', [UserManagementController::class, 'userList'])->name('user-list');
        Route::get('/responsibility', [UserManagementController::class, 'userResponsibility'])->name('user-responsibility');
        Route::get('/permissions', [UserManagementController::class, 'userPermissions'])->name('user-permissions');
    });
    // Dashboard Route
    Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard');

    // Profile Management Route
    Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('admin.view-profile');



    // // Teacher Management Routes
    Route::prefix('teachers')->group(function () {
        Route::get('/assign-subject', [TeachersController::class, 'assignSubject'])->name('assign-subject');
        Route::get('/assign-responsibility', [TeachersController::class, 'assignResponsibility'])->name('assign-responsibility');
        Route::get('/reports', [TeachersController::class, 'teachersReport'])->name('teacher-reports');
        // Add more teacher routes as needed
    });

    // // Student Management Routes
    // Route::prefix('students')->group(function () {
    //     Route::get('/details', [StudentController::class, 'studentDetails'])->name('student-details');
    //     Route::get('/admission', [StudentController::class, 'studentAdmission'])->name('student-admission');
    //     // Add more student routes as needed
    // });

    // // Examination Management Routes
    // Route::prefix('exams')->group(function () {
    //     Route::get('/publish-results', [ExaminationTab::class, 'publishResult'])->name('publish-results');
    //     // Add more examination routes as needed
    // });

    // // Grandbox and Grand-ebuy Applications
    // Route::get('/grandbox', [GrandBoxController::class, 'index'])->name('grandbox');
    // Route::get('/grand-ebuy', [GrandEbuyController::class, 'index'])->name('grand-ebuy');
});

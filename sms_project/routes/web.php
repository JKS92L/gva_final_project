<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashController;
use App\Http\Controllers\examinationTab;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\grandBoxController;
use App\Http\Controllers\teachersController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\grandEbuyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Grouping admin routes with role middleware
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [UserManagementController::class, 'showDashboard'])
        ->name('admin.dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'viewProfile'])
        ->name('view.profile');

    // User management routes
    Route::get('/user-list', [UserManagementController::class, 'userList'])
        ->name('admin.user-list');
    Route::get('/user-responsibility', [UserManagementController::class, 'userResponsibility'])
        ->name('admin.user-responsibility');
    Route::get('/user-permissions', [UserManagementController::class, 'userPermissions'])
        ->name('admin.user-permissions');

    // Teachers tab routes
    Route::prefix('teachers')->group(function () {
        Route::get('/assign-subject', [teachersController::class, 'assignSubject'])
            ->name('admin.assign-subjects');
        Route::get('/assign-responsibility', [teachersController::class, 'assignResponsibility'])
            ->name('admin.assign-responsibility');
        Route::get('/cpd-reports', [teachersController::class, 'cpdReport'])
            ->name('admin.cpd-reports');
        Route::get('/communication-logs', [teachersController::class, 'communicationLog'])
            ->name('admin.communication-log');
        Route::get('/teacher-reports', [teachersController::class, 'teachersReport'])
            ->name('admin.teacher-reports');
        Route::get('/lesson-observation', [teachersController::class, 'lessonObservation'])
            ->name('admin.lesson-observation');
        Route::get('/file-monitoring', [teachersController::class, 'fileMonitoring'])
            ->name('admin.file-monitoring');
    });

    // Student management routes
    Route::prefix('students')->group(function () {
        Route::get('/student-details', [studentController::class, 'studentDetails'])
            ->name('admin.student-details');
        Route::get('/student-admission', [studentController::class, 'studentAdmission'])
            ->name('admin.student-admission');
        Route::get('/online-admission', [studentController::class, 'onlineAdmission'])
            ->name('admin.online-admission');
        Route::get('/disable-students', [studentController::class, 'disableStudent'])
            ->name('admin.disable-student');
        Route::get('/bulk-delete', [studentController::class, 'bulkDelete'])
            ->name('admin.bulk-delete');
        Route::get('/student-categories', [studentController::class, 'stuentCatergories'])
            ->name('admin.student-categories');
        Route::get('/student-register', [studentController::class, 'stuentRegister'])
            ->name('admin.student-register');
    });

    // Examination routes
    Route::prefix('exams')->group(function () {
        Route::get('/publish-results', [examinationTab::class, 'publishResult'])
            ->name('admin.publish-results');
        Route::get('/view-results', [examinationTab::class, 'viewResult'])
            ->name('admin.view-results');
        Route::get('/view-results-queries', [examinationTab::class, 'viewQueries'])
            ->name('admin.view-queries');
        Route::get('/enter-results', [examinationTab::class, 'enterResults'])
            ->name('admin.enter-results');
    });

    // Grandbox and Grand-ebuy applications
    Route::get('/grandbox', [grandBoxController::class, 'index'])
        ->name('grandbox-app');
    Route::get('/grand-ebuy', [grandEbuyController::class, 'index'])
        ->name('grand-ebuy-app');
        
});






// Route::get('/admin/dashboard', [DashController::class, 'index'])->name('dashboard');

// Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Route::get('/admin/user-list', [UserListController::class, 'index'])->name('userlist');

// Route::get('notifications/get', [NotificationsController::class, 'getNotificationsData'])->name('notifications.get');

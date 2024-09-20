<?php 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExaminationTab;
use App\Http\Controllers\GrandBoxController;
use App\Http\Controllers\GrandEbuyController;

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
    return view('auth.login');
});

Auth::routes();

// Routes for authenticated admin users
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard route
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Admin login/logout
    Route::get('/login', [AdminController::class, 'Logout'])->name('logout');

    // // Profile management
    // Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('view-profile');

    // // User management routes
    // Route::prefix('users')->group(function () {
    //     Route::get('/list', [UserManagementController::class, 'userList'])->name('user-list');
    //     Route::get('/responsibility', [UserManagementController::class, 'userResponsibility'])->name('user-responsibility');
    //     Route::get('/permissions', [UserManagementController::class, 'userPermissions'])->name('user-permissions');
    // });

    // // Teachers management routes
    // Route::prefix('teachers')->group(function () {
    //     Route::get('/assign-subject', [TeachersController::class, 'assignSubject'])->name('assign-subject');
    //     Route::get('/assign-responsibility', [TeachersController::class, 'assignResponsibility'])->name('assign-responsibility');
    //     Route::get('/cpd-reports', [TeachersController::class, 'cpdReport'])->name('cpd-reports');
    //     Route::get('/communication-logs', [TeachersController::class, 'communicationLog'])->name('communication-log');
    //     Route::get('/reports', [TeachersController::class, 'teachersReport'])->name('teacher-reports');
    //     Route::get('/lesson-observation', [TeachersController::class, 'lessonObservation'])->name('lesson-observation');
    //     Route::get('/file-monitoring', [TeachersController::class, 'fileMonitoring'])->name('file-monitoring');
    // });

    // // Student management routes
    // Route::prefix('students')->group(function () {
    //     Route::get('/details', [StudentController::class, 'studentDetails'])->name('student-details');
    //     Route::get('/admission', [StudentController::class, 'studentAdmission'])->name('student-admission');
    //     Route::get('/online-admission', [StudentController::class, 'onlineAdmission'])->name('online-admission');
    //     Route::get('/disable', [StudentController::class, 'disableStudent'])->name('disable-student');
    //     Route::get('/bulk-delete', [StudentController::class, 'bulkDelete'])->name('bulk-delete');
    //     Route::get('/categories', [StudentController::class, 'stuentCatergories'])->name('student-categories');
    //     Route::get('/register', [StudentController::class, 'stuentRegister'])->name('student-register');
    // });

    // // Examination management routes
    // Route::prefix('exams')->group(function () {
    //     Route::get('/publish-results', [ExaminationTab::class, 'publishResult'])->name('publish-results');
    //     Route::get('/view-results', [ExaminationTab::class, 'viewResult'])->name('view-results');
    //     Route::get('/queries', [ExaminationTab::class, 'viewQueries'])->name('view-queries');
    //     Route::get('/enter-results', [ExaminationTab::class, 'enterResults'])->name('enter-results');
    // });

    // // Grandbox and Grand-ebuy applications
    // Route::get('/grandbox', [GrandBoxController::class, 'index'])->name('grandbox');
    // Route::get('/grand-ebuy', [GrandEbuyController::class, 'index'])->name('grand-ebuy');







    ///end...
});

<?php

use App\Models\Bedspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExaminationTab;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\teacher;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\BedspaceController;
//CRUD CONTROLLERS
use App\Http\Controllers\GrandBoxController;
use App\Http\Controllers\GrandEbuyController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\TeachersController;
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
// Route::prefix('admin')->middleware(['auth'])->group(function () {
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // logout
    Route::get('/admin/login', [AdminController::class, 'Logout'])->name('admin.logout');

    // User Management Routes
    Route::prefix('/users')->group(function () {

        Route::get('/list', [UserManagementController::class, 'view_user_List'])->name('view.users');

        // Route::get('/student/create', [UserManagementController::class, 'teacherIndex'])->name('create.teacher');

        //  Add a new route for the AJAX call to fetch bedspaces
        // Route::get('/fetch-bedspaces', [UserManagementController::class, 'fetchBedspaces'])->name('fetch.bedspaces');

        // Route::post('/list', [TeacherController::class, 'teachersForm'])->name('view.teachers.form');
        // CRUD Route
        Route::post('/teachers', [RoleController::class, 'create'])->name('teachers.store');
        Route::put('/teachers/{id}', [RoleController::class, 'edit'])->name('teachers.update');
        Route::delete('/teachers/{id}', [RoleController::class, 'destroy'])->name('teachers.destroy');

        Route::get('/responsibility', [UserManagementController::class, 'userResponsibility'])->name('user-responsibility');
        Route::get('/permissions', [UserManagementController::class, 'userPermissions'])->name('user-permissions');

        // CRUD routes for roles
        Route::get('/roles', [RoleController::class, 'index'])->name('view-roles');
        Route::post('/roles', [RoleController::class, 'create'])->name('roles.store');
        Route::put('/roles/{id}', [RoleController::class, 'edit'])->name('roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
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
    Route::prefix('students')->group(function () {
        // views 
        Route::get('/details', [studentController::class, 'studentDetails'])->name('student-details');
        Route::get('/admission', [StudentController::class, 'studentAdmission'])->name('student-admission');
        Route::get('/student-registration-form', [StudentController::class, 'viewRegForm'])->name('view.studentreg.form');
        
        // ajax call to fetch bedspaces 
        Route::get('/fetch-bedspaces', [StudentController::class, 'fetchBedspaces'])->name('fetch.bedspaces');

        // STUDENT CRUD
        Route::post('/store', [StudentController::class, 'store'])->name('students.store');
        
       

    });

    // // Examination Management Routes
    // Route::prefix('exams')->group(function () {
    //     Route::get('/publish-results', [ExaminationTab::class, 'publishResult'])->name('publish-results');
    //     // Add more examination routes as needed
    // });

    // // Grandbox and Grand-ebuy Applications
    // Route::get('/grandbox', [GrandBoxController::class, 'index'])->name('grandbox');
    // Route::get('/grand-ebuy', [GrandEbuyController::class, 'index'])->name('grand-ebuy');

    // Route::resource('departments', DepartmentController::class);
    // Route::resource('hods', HodController::class);


    // //CRUD CONTROLLERS 
    // Route::resource('/roles', 
    // [RoleController::class,'index'])->name('user-roles');

    // grade and frade teachers
    // Route::resource('grades', GradeController::class);
    // Route::resource('grade-teachers', GradeTeacherController::class);

});

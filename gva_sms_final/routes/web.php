<?php

use App\Models\Bedspace;
use App\Models\ExamController;
use App\Models\ResultsController;
use App\Models\AssignClassSubject;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamResultsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExaminationTab;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\teacher;
//CRUD CONTROLLERS
use App\Http\Controllers\StudentController;
// use App\Http\Controllers\TeacherController;
use App\Http\Controllers\BedspaceController;
use App\Http\Controllers\GrandBoxController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\AccountsAndDepositsController;
use App\Http\Controllers\GrandEbuyController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\TeachersController;
use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\tuckshopController;

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
        Route::get('/responsibility', [UserManagementController::class, 'userResponsibility'])->name('user-responsibility');
        Route::get('/permissions', [UserManagementController::class, 'userPermissions'])->name('user-permissions');

        // CRUD routes for roles
        Route::get('/roles', [RoleController::class, 'index'])->name('view-roles');
        Route::post('/roles', [RoleController::class, 'storeRole'])->name('roles.store');
        Route::put('/roles/{id}', [RoleController::class, 'edit'])->name('roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

        //edit user roles/permissions
        Route::get('/users/{id}/edit-user-roles', [RoleController::class, 'editUserPermissions'])->name('edit.user.roles');
        //save the assigned permissions
        Route::post('/roles/{role_id}/save-permissions', [RoleController::class, 'saveUserRolePermissions'])->name('save.UserRolePermissions');
    });


    // Dashboard Route
    Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard');

    // Profile Management Route
    Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('admin.view-profile');

    // // Teacher Management Routes
    Route::prefix('teachers')->group(function () {
        Route::get('/assign-subject', [TeachersController::class, 'assignSubject'])->name('assign-subject');
        Route::get('/assign-responsibility', [TeachersController::class, 'assignResponsibility'])->name('assign-responsibility');
        // 
        Route::get('/reports', [TeachersController::class, 'teachersReport'])->name('teacher-reports');
        // Manage Teachers
        Route::get('/manage-teachers', [TeachersController::class, 'viewTeachersList'])->name('teachers.manage-teachers');
        //registration form
        Route::get('/teachers-registration', [TeachersController::class, 'viewTeachersRegForm'])->name('teacher.regForm');
        // teacher.regForm
        Route::get('/teachers-list', [TeachersController::class, 'viewTeachersList'])->name('teachers.list');
        // CRUD
        Route::post('/create-teacher', [TeachersController::class, 'storeTeachers'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [TeachersController::class, 'editTeacher'])->name('teachers.edit');
        Route::put('/teachers/{id}', [TeachersController::class, 'updateTeacher'])->name('teachers.update');
        Route::delete('/teachers/{id}', [TeachersController::class, 'destroyTeacher'])->name('teachers.destroy');
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

        // Route for editing a student (GET request to show the edit form)
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');

        // Route for updating a student (PUT or PATCH request to submit the edited data)
        Route::put('/update/{id}', [StudentController::class, 'update'])->name('students.update');

        // Route for deleting a student (DELETE request)
        Route::delete('/delete/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    });

    // // Examination Management Routes
    Route::prefix('exams')->group(function () {
        // Route::get('/publish-results', [ExamController::class, 'publishResult'])->name('publish-results');
        Route::get('/enter-results', [ExamResultsController::class, 'enterResults'])->name('exam.enter-results');
        // Add more examination routes as needed 
    });

    // // ACADEMICS TAB
    Route::prefix('academics')->group(function () {
        Route::get('/assign-class-subjects', [AcademicsController::class, 'viewAssignClassSubjects'])->name('academics.assign-class-subjects');
        //CRUD assigned class subjects
        Route::post('/assign-subjects', [AcademicsController::class, 'assignClassSubjects'])->name('academics.assign.classSubjects');
        Route::put('/update-class-subjects', [AcademicsController::class, 'updateClassSubjects'])->name('academics.update.class.subjects');
        Route::delete('/delete-class-subjects', [AcademicsController::class, 'destroyClassSubjects'])->name('academics.delete.class.subjects');

        //class subject teachers view
        Route::get('/class-subject-teacher', [AcademicsController::class, 'viewClassSubjectsTeachers'])->name('academics.class.subject.teacher');
        // fetch subjects in each grade by teacher
        Route::get('/fetch-subjects-teachers/{id}', [AcademicsController::class, 'fetchSubjectsAndTeachers']);
        //assign class subject class
        Route::post('/assign-subject-teachers', [AcademicsController::class, 'assignSubjectTeachers'])->name('assign.subject.teachers');



        // Add more examination routes as needed 
    });

    //TUCKSHOP MENU
    Route::prefix('tuckshop')->group(function () {
        Route::get('/sales', [tuckshopController::class, 'viewSales'])->name('tuckShop.sales');
        // //CRUD assigned class subjects
        // Route::post('/assign-subjects', [AcademicsController::class, 'assignClassSubjects'])->name('academics.assign.classSubjects');
        // Route::put('/update-class-subjects', [AcademicsController::class, 'updateClassSubjects'])->name('academics.update.class.subjects');
        // Route::delete('/delete-class-subjects', [AcademicsController::class, 'destroyClassSubjects'])->name('academics.delete.class.subjects');

        // //class subject teachers view
        // Route::get('/class-subject-teacher', [AcademicsController::class, 'viewClassSubjectsTeachers'])->name('academics.class.subject.teacher');
        // // fetch subjects in each grade by teacher
        // Route::get('/fetch-subjects-teachers/{id}', [AcademicsController::class, 'fetchSubjectsAndTeachers']);
        // //assign class subject class
        // Route::post('/assign-subject-teachers', [AcademicsController::class, 'assignSubjectTeachers'])->name('assign.subject.teachers');

    });


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

    // // System Setting Routes
    Route::prefix('systemSettings')->group(function () {

        // General Settings
        Route::get('/general', [SystemSettingsController::class, 'ShowgeneralSettings'])->name('system.general-settings');

        // Routes for Results Efforts
        Route::post('/efforts', [SystemSettingsController::class, 'storeEffort'])->name('efforts.store'); // Store new effort
        Route::put('/efforts/{id}', [SystemSettingsController::class, 'updateEffort'])->name('efforts.update'); // Update existing effort
        Route::delete('/efforts/{id}', [SystemSettingsController::class, 'destroyEffort'])->name('efforts.destroy'); // Delete effort

        // Routes for Results Grading
        Route::post('/grading', [SystemSettingsController::class, 'storeGrade'])->name('results_grades.store'); // Store new grade
        Route::put('/grading/{id}', [SystemSettingsController::class, 'updateGrade'])->name('results_grades.update'); // Update existing results grade
        Route::delete('/grading/{id}', [SystemSettingsController::class, 'destroyGrade'])->name('results_grades.destroy'); // Delete results grade

        // passing percentage 
        Route::put('/settings/passing-percentage', [SystemSettingsController::class, 'updatePassingPercentage'])->name('settings.updatePassingPercentage');

        //subject teacher comment routes
        Route::post('/comments', [SystemSettingsController::class, 'storeComment'])->name('comments.store');
        Route::put('/comments/{id}', [SystemSettingsController::class, 'updateComment'])->name('comments.update');
        Route::delete('/comments/{id}', [SystemSettingsController::class, 'destroyComment'])->name('comments.destroy');

        //Exam Type
        Route::post('/examtypes', [SystemSettingsController::class, 'storeExamtype'])->name('examTypes.store');
        Route::put('/examtypes/{id}', [SystemSettingsController::class, 'updateExamtype'])->name('examType.update');
        Route::delete('/examtypes/{id}', [SystemSettingsController::class, 'destroyExamtype'])->name('examType.destroy');

        // Route to display the school fees settings page (Read/Display)
        Route::post('/schoolFees', [SystemSettingsController::class, 'storeFee'])->name('fees.store');
        Route::put('/schoolFees/{id}', [SystemSettingsController::class, 'updateFee'])->name('fees.update');
        Route::delete('/schoolFees/{id}', [SystemSettingsController::class, 'destroyFee'])->name('fees.destroy');


        // Session Settings
        Route::get('/academic-sessions', [SystemSettingsController::class, 'ShowSessionSettings'])->name('system.academic-sessions');
        // Route to create a new academic session (store)
        Route::post('/academic-sessions', [SystemSettingsController::class, 'storeAcademicSession'])->name('academic-session.store');
        // Route to update an existing academic session (edit + update)
        Route::put('academic-sessions/{id}', [SystemSettingsController::class, 'updateAcademicSession'])->name('academic-session.update');
        // Route to delete an academic session
        Route::delete('academic-sessions/{id}', [SystemSettingsController::class, 'destroyAcademicSession'])->name('academic-session.destroy');

















        // Notification Settings
        Route::get('/notification', [SystemSettingsController::class, 'notificationSettings'])->name('system.notification-settings');

        // SMS Settings
        Route::get('/sms', [SystemSettingsController::class, 'smsSettings'])->name('system.sms-settings');

        // Email Settings
        Route::get('/email', [SystemSettingsController::class, 'emailSettings'])->name('system.email-settings');

        // Payment Methods
        Route::get('/payment-methods', [SystemSettingsController::class, 'paymentMethods'])->name('system.payment-methods');

        // Print Header Footer
        Route::get('/print-header-footer', [SystemSettingsController::class, 'printHeaderFooter'])->name('system.print-header-footer');

        // Front CMS Settings
        Route::get('/cms-settings', [SystemSettingsController::class, 'cmsSettings'])->name('system.cms-settings');

        // Roles Permissions
        Route::get('/roles-permissions', [SystemSettingsController::class, 'rolesPermissions'])->name('system.roles-permissions');

        // Backup Restore
        Route::get('/backup-restore', [SystemSettingsController::class, 'backupRestore'])->name('system.backup-restore');

        // Languages
        Route::get('/languages', [SystemSettingsController::class, 'languages'])->name('system.languages');

        // Currency
        Route::get('/currency', [SystemSettingsController::class, 'currency'])->name('system.currency');

        // Users
        Route::get('/users', [SystemSettingsController::class, 'users'])->name('system.users');

        // Modules
        Route::get('/modules', [SystemSettingsController::class, 'modules'])->name('system.modules');

        // Custom Fields
        Route::get('/custom-fields', [SystemSettingsController::class, 'customFields'])->name('system.custom-fields');

        // Captcha Settings
        Route::get('/captcha-settings', [SystemSettingsController::class, 'captchaSettings'])->name('system.captcha-settings');

        // System Fields
        Route::get('/system-fields', [SystemSettingsController::class, 'systemFields'])->name('system.system-fields');

        // Student Profile Update
        Route::get('/student-profile-update', [SystemSettingsController::class, 'studentProfileUpdate'])->name('system.student-profile-update');

        // Online Admission
        Route::get('/online-admission', [SystemSettingsController::class, 'onlineAdmission'])->name('system.online-admission');

        // File Types
        Route::get('/file-types', [SystemSettingsController::class, 'fileTypes'])->name('system.file-types');

        // Sidebar Menu
        Route::get('/sidebar-menu', [SystemSettingsController::class, 'sidebarMenu'])->name('system.sidebar-menu');

        // System Update
        Route::get('/system-update', [SystemSettingsController::class, 'systemUpdate'])->name('system.system-update');
    });






    Route::prefix('accounts/expenses')->group(function () {
        // Route for Deposit Records
        Route::get('/deposit-records', [AccountsAndDepositsController::class, 'showDepositRecords'])
            ->name('accounts.expenses.deposit-records');

        // Route for Add New Deposit
        Route::post('/deposit-new-record', [AccountsAndDepositsController::class, 'storeDeposit'])
            ->name('deposit-record.store');
        // Route to update deposit record (submits the edit form)
        Route::put('/deposit-record/{id}', [AccountsAndDepositsController::class, 'updateDeposit'])->name('deposits.update');

        // Route to delete deposit record
        Route::delete('/deposit-record/{id}', [AccountsAndDepositsController::class, 'destroyDeposit'])->name('deposits.destroy');


        // Route for Bank Deposit Reconciliation
        Route::get('/bank-reconciliation', [AccountsAndDepositsController::class, 'showBankReconciliation'])
            ->name('accounts.expenses.bank-reconciliation');
        // Route to store a new bank reconciliation record
        Route::post('/bank-reconciliation/store',
            [AccountsAndDepositsController::class, 'storeBankReconciliation']
        )
        ->name('accounts.expenses.bank-reconciliation.store');
        Route::put('accounts/expenses/bank-reconciliation/update/{id}', [AccountsAndDepositsController::class, 'updateBankReconciliation'])
        ->name('accounts.expenses.bank-reconciliation.update');

        // Route to delete a bank reconciliation record
        Route::delete('/bank-reconciliation/{id}', [AccountsAndDepositsController::class, 'destroyBankReconciliation'])
        ->name('accounts.expenses.bank-reconciliation.destroy');

        //filter ajax route
        Route::get('accounts/expenses/bank-reconciliation/filter', [AccountsAndDepositsController::class, 'filterBankReconciliation'])->name('accounts.expenses.bank-reconciliation.filter');


        // Route for Balance Report
        Route::get('/balance-report', [AccountsAndDepositsController::class, 'showBalanceReport'])
            ->name('accounts.expenses.balance-report');


        // Route::get('/', [TransactionReportController::class, 'index'])->name('reports.index'); // List all reports
        // Route::get('/create', [TransactionReportController::class, 'create'])->name('reports.create'); // Show form to create a new report
        // Route::post('/', [TransactionReportController::class, 'store'])->name('reports.store'); // Store a new report
        // Route::get('/{id}/edit', [TransactionReportController::class, 'edit'])->name('reports.edit'); // Show form to edit a report
        // Route::put('/{id}', [TransactionReportController::class, 'update'])->name('reports.update'); // Update a report
        // Route::delete('/{id}', [TransactionReportController::class, 'destroy'])->name('reports.destroy'); // Delete a report


    });

    ///end 
});

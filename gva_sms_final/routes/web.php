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
use App\Http\Controllers\tuckshopController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\GrandEbuyController;
use App\Http\Controllers\StudentFeeController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\TeachersController;
use App\Http\Controllers\AccountsAndDepositsController;
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
// default dashboard for redirects for the page not found, check RouteServiceProvider for any changes
// Route::get('/dashboard', function () {
//     $user = Auth::user();
//     switch ($user->role_id) {
//         case 1:
//             return redirect('/admin/home');
//         case 2:
//             return redirect('/teacher/home');
//         case 3:
//             return redirect('/student/home');
//         case 5:
//             return redirect('/parent/home');
//         default:
//             return redirect('/'); // Fallback
//     }
// })->middleware(['auth']);

// logout
Route::get('/admin/login', [AdminController::class, 'Logout'])->name('logout');

// Group dashboard routes by role dynamically
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Dynamically redirect based on role_id
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('teacher.dashboard');
            case 3:
                return redirect()->route('student.dashboard');
            case 5:
                return redirect()->route('parent.dashboard');
            default:
                return redirect('/'); // Fallback
        }
    })->name('dashboard');

    // Define dashboard routes for each role
    $dashboards = [
        1 => ['prefix' => 'admin', 'name' => 'admin.dashboard', 'action' => 'dashboard'],
        2 => ['prefix' => 'teacher', 'name' => 'teacher.dashboard', 'action' => 'dashboard'],
        3 => ['prefix' => 'student', 'name' => 'student.dashboard', 'action' => 'studentDashboard'],
        5 => ['prefix' => 'parent', 'name' => 'parent.dashboard', 'action' => 'parentDashboard'],
    ];

    foreach ($dashboards as $roleId => $config) {
        Route::prefix($config['prefix'])
            ->middleware(['auth', "role:$roleId"])
            ->group(function () use ($config) {
                Route::get('/home', [HomeController::class, $config['action']])->name($config['name']);
            });
    }
});

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
    //STUDENT DETAILS SUB-MENU ROUTES
    // views 
    Route::get('/details', [studentController::class, 'viewStudentDetails'])->name('student-details');
    //student-register
    Route::get('/student-registration-form', [StudentController::class, 'viewRegForm'])->name('view.studentreg.form');
    // Ajax Call fetch sibling's guardian details
    Route::post('/fetch-guardian-details', [StudentController::class, 'fetchGuardianDetails']);

    //ajax call - fetch hostels by gender
    Route::get('/get-hostels/{gender}', [StudentController::class, 'getHostelsByGender'])->name('getHostelsByGender');
    // ajax call to fetch bedspaces 
    Route::get('/fetch-bedspaces', [StudentController::class, 'fetchBedspaces'])->name('fetch.bedspaces');
    // STUDENT CRUD
    Route::post('/store', [StudentController::class, 'storeStudentAndParentDetails'])->name('students.store');

    // Route for editing a student (GET request to show the edit form)
    Route::get('/edit/{id}', [StudentController::class, 'editStudent'])->name('students.edit');

    // Route for updating a student (PUT or PATCH request to submit the edited data)
    Route::put('/update/{id}', [StudentController::class, 'updateStudentAllSection'])->name('students.update');

    // Route for deleting a student (DELETE request)
    Route::delete('/delete/{id}', [StudentController::class, 'destroyStudent'])->name('students.destroy');

    //STUDENT ENROLLMENT PROCESSES
    Route::get('/enrollment-process', [StudentController::class, 'viewEnrollmentProcess'])->name('enrollment-process');
    Route::get('/enrollment-register', [StudentController::class, 'viewEnrollmentRegister'])->name('enrollment-process-register');
    Route::post('/store-enrollment', [StudentController::class, 'storeEnrollmentRecord'])->name('store.enrollment.record');
    // AJAX CALL - FETCH ENROLMENT BY YEAR
    Route::get('/enrollmentFilterByYear', [StudentController::class, 'enrollmentFilterByYear'])->name('students.filterEnrollmentByYear');

    //STUDENT PERMISSION ROUTES - CRUD
    Route::put('/student-admission-approve/{id}', [StudentController::class, 'studentAdmissionApprove'])->name('studentsAdmission.approve');
    Route::put('/student-admission-reject/{id}', [StudentController::class, 'studentAdmissionReject'])->name('studentsAdmission.reject');

    //STUDENT TERMLY ADMISSIONS
    Route::get('/termly-reports', [StudentController::class, 'viewStudentTermlyReport'])->name('student.termly.report');
    Route::get('/fetch-student-termly-report', [StudentController::class, 'fetchStudentTermlyReport'])->name('fetch.student.termly.report');
    Route::get('/get-parents', [StudentController::class, 'getParentsByStudentId'])->name('fetch.parentByStudentId');
    Route::post('/termly-report/store', [StudentController::class, 'storeDayscholarStudentReport'])->name('dayscholars.student.termly-report.store');

    Route::post('/student-home-permission/store', [StudentController::class, 'storeStudentHomePermission'])->name('student-home-permission.store');
    Route::put('/update-student-permission/{id}', [StudentController::class, 'updateStudentPermission'])->name('student.permission.update');
    Route::delete('/student-homepermission-destroy/{id}', [StudentController::class, 'destroyStudentPermission'])->name('students.homepermission.destroy');

    // ajax call fetchStudentPermissionsByYearAndStatus
    Route::post('/filter-permission-byYearsNstatus', [StudentController::class, 'fetchStudentPermissionsByYearAndStatus'])->name('filter.permission.byYears.status');

    // DISCIPLINARY ACTION ROUTES
    Route::get('/student-permissions', [StudentController::class, 'viewStudentPermissions'])->name('student.permissions');
    //disciplinary action
    Route::get('/student-disciplinary', [StudentController::class, 'viewstudentDisciplinaryAction'])->name('student.disciplinaryList.view');
    // viewstudentDisciplinaryform
    Route::get('/student-disciplinary-form', [StudentController::class, 'viewstudentDisciplinaryform'])->name('student.disciplinaryForm.view');
    Route::get('/disciplinary/{id}/attachments', [StudentController::class, 'viewAttachments'])->name('disciplinary.attachments.view');
    // Route::get('/attachments/download/{path}', [StudentController::class, 'downloadAttachment'])->name('download.attachment');
    // CRUD
    Route::post('/student-disciplinary-store', [StudentController::class, 'storestudentDisciplinaryAction'])->name('student.disciplinary.store');
    Route::patch('/disciplinary/{id}/approve', [StudentController::class, 'approveStudentDisciplinary'])->name('disciplinary.approve');
    Route::patch('/disciplinary/{id}/reject', [StudentController::class, 'rejectStudentDisciplinary'])->name('disciplinary.reject');
    Route::patch('/disciplinary/{id}/withdraw', [StudentController::class, 'withdrawStudentDisciplinary'])->name('disciplinary.withdraw');
    Route::delete('/disciplinary/{id}/delete', [StudentController::class, 'deleteStudentDisciplinary'])->name('disciplinary.delete');



    // STUDENT TRANSFER RECORD
    Route::get('/student-tranfers', [StudentController::class, 'viewstudentTransfer'])->name('student.transfer.view');
    Route::post('/students/transfer', [StudentController::class, 'storeStudentSchoolTransfer'])->name('students.transfer.store');
    Route::patch('/students/{id}/transfer-approve', [StudentController::class, 'approveStudentSchoolTransfer'])->name('students.transfer.approve');
    Route::patch('/students/{id}/transfer-update', [StudentController::class, 'updateStudentSchoolTransfer'])->name('students.transfer.update');
    Route::delete('/students/tranfer-destroy/{id}', [StudentController::class, 'destroyStudentSchoolTransfe'])->name('students.transfer.destroy');

    // STUDENT CLEAR IN AND OUT
    Route::post('/student-clear-in', [StudentController::class, 'storeStudentCheckIn'])->name('student-clear-in.store');
    Route::post('/student-clear-out', [StudentController::class, 'storeStudentCheckOut'])->name('student-clear-out.store');


    //STUDENT CLASS REGISTER
    Route::get('/class-registers', [StudentController::class, 'viewStudentClassRegister'])->name('student.class.register');
    Route::post('/students-termly-register/search', [StudentController::class, 'searchTermlyStudentsRegister'])->name('students.termly.register.search');


    //BULK DISABLE ROUTES
    Route::get('/student-disable', [StudentController::class, 'viewStudentBulkDisable'])->name('student.bulk.disable.view');
    Route::post('/students/bulk/disable', [StudentController::class, 'bulkDisable'])->name('students.bulk.disable');
    Route::post('/students/bulk/enable', [StudentController::class, 'bulkEnable'])->name('students.bulk.enable');
    Route::post('/students/disable', [StudentController::class, 'disable'])->name('students.disable');
    Route::post('/students/enable', [StudentController::class, 'enable'])->name('students.enable');
});

// // Examination Management Routes
Route::prefix('exams')->group(function () {
    // Route::get('/publish-results', [ExamController::class, 'publishResult'])->name('publish-results');
    Route::get('/enter-results', [ExamResultsController::class, 'viewEnterResults'])->name('exam.enter-results');
    // Add save results
    Route::get('', [ExamResultsController::class, 'storeResults'])->name('save.results');
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
    Route::post('/assign-class-subject-teachers', [AcademicsController::class, 'assignSubjectTeachersToClass'])->name('assign.subject.teachers');



    // Add more examination routes as needed 
});

//TUCKSHOP MENU
Route::prefix('tuckshop')->group(function () {
    // SALES
    Route::get('/sales', [tuckshopController::class, 'viewSales'])->name('tuckShop.sales');
    // SALES CRUD 
    Route::post('/process-sale', [TuckShopController::class, 'processTransaction'])->name('tuckshop.processTransaction');

    // INVENTORY MANAGEMENT
    Route::get('/inventory', [tuckshopController::class, 'viewInventory'])->name('tuckShop.inventory.management');
    // ajax get data
    Route::get('/inventory/view', [tuckshopController::class, 'fetchInventory'])->name('tuckshop.inventory.view');

    //CRUD
    // Route::post('/inventory/add', [tuckshopController::class, 'addInventory'])->name('tuckshop.inventory.add');
    Route::post('/inventory/add', [tuckshopController::class, 'addInventory'])->name('tuckshop.inventory.add');
    Route::put('/inventory/edit/{id}', [tuckshopController::class, 'editInventory'])->name('tuckshop.inventory.edit');
    Route::delete('/inventory/delete/{id}', [tuckshopController::class, 'deleteInventory'])->name('tuckshop.inventory.delete');
});

//FEE COLLECTION 
// Grouping routes under a prefix for cleaner structure
Route::prefix('fees')->group(function () {
    // Fee Refunds
    Route::get('/refunds', [StudentFeeController::class, 'viewStudentRefund'])->name('fee.refund.view');

    // Fee Structures
    Route::get('/structures', [StudentFeeController::class, 'viewFeeStructures'])->name('fees.structure.view');
    Route::post('/sturcture/store', [StudentFeeController::class, 'storeStructure'])->name('fees.structure.store');
    Route::put('/schoolFees/{id}', [StudentFeeController::class, 'updateFeeStructure'])->name('fees.structure.update');
    Route::delete('/schoolFees/{id}', [StudentFeeController::class, 'destroyFeeStructure'])->name('fees.structure.destroy');


    // Class Fee assignment
    Route::post('/class-fees', [StudentFeeController::class, 'storeStudentAndClassFee'])->name('class.fees.store');
    Route::delete('/class-fees-delete/{id}', [StudentFeeController::class, 'destroyClassFees'])->name('classFees.destroy');
    Route::delete('/student-fees-delete/{id}', [StudentFeeController::class, 'destroyStudentFees'])->name('studentFees.destroy');

    //Fee adjustimeent route
    Route::post('/fee-adjustments-store', [StudentFeeController::class, 'storeFeeAdjustment'])->name('fee.adjustments.store');
    Route::delete('delete-classAdjustFee/{id}', [StudentFeeController::class, 'destroyClassAdjustFee'])->name('classFeeAdjustments.destroy');
    Route::delete('delete-studentAdjustFee/{id}', [StudentFeeController::class, 'destroystudentAdjustFee'])->name('studentFeeAdjustments.destroy');

    // Fee Payment Report 
    Route::get('/payment-report', [StudentFeeController::class, 'viewpaymentReport'])->name('fees.payment.report');
    Route::post('/fee/fetch-outstanding-balances', [StudentFeeController::class, 'fetchOutstandingBalances'])->name('fee.fetchOutstandingBalances');
    Route::post('/send/payment-reminder', [StudentFeeController::class, 'sendFeePaymentReminder'])->name('fee.sendReminder'); // the button in the front-end is disabled. WIP
    Route::put('/approve/fee-payment', [StudentFeeController::class, 'approveFeePayment'])->name('approve.payment');
    Route::put('/reject/fee-payment', [StudentFeeController::class, 'rejectFeePayment'])->name('reject.payment');


    // Payment routes
    Route::get('/payment-history', [StudentFeeController::class, 'viewPaymentHistory'])->name('fee.payment.history.view');
    Route::get('/payment-history/{id}/receipt', [StudentFeeController::class, 'showReceipt'])->name('fee.payment.receipt.view');
    Route::get('/pay/{student_id}', [StudentFeeController::class, 'viewStudentPayment'])->name('fees.pay.view');
    // web.php
    Route::post('/fee-payments', [StudentFeeController::class, 'storeFeePayment'])->name('feePayments.store');
    //ajax call
    Route::get('/filter-fee-categories', [StudentFeeController::class, 'filterFeeCategories'])->name('filterFeeCategories');



    // Submit Payments (Collect Fees)
    Route::get('/collect', [StudentFeeController::class, 'viewSubmitPayments'])->name('fees.collect.view');

    // Pending Balances
    Route::get('/pending-balances', [StudentFeeController::class, 'viewPendingBalances'])->name('pending.balances.view');

    // Fee Adjustments
    Route::get('/adjustments', [StudentFeeController::class, 'viewFeeAdjustments'])->name('fees.adjustments.view');

    // Generate Invoices
    Route::get('/generate-invoices', [StudentFeeController::class, 'viewGenerateInvoices'])->name('fees.invoices.view');

    // Generate Reports
    Route::get('/reports', [StudentFeeController::class, 'viewGenerateReports'])->name('fees.reports.view');
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

    // File Types
    Route::get('/file-types', [SystemSettingsController::class, 'fileTypes'])->name('system.file-types');

    // Sidebar Menu
    Route::get('/sidebar-menu', [SystemSettingsController::class, 'sidebarMenu'])->name('system.sidebar-menu');

    // System Update
    Route::get('/system-update', [SystemSettingsController::class, 'systemUpdate'])->name('system.system-update');
});




Route::prefix('accounts/transactions')->group(function () {
    // Route for Deposit Records
    Route::get('/deposit-records', [AccountsAndDepositsController::class, 'showDepositRecords'])
        ->name('accounts.expenses.deposit-records');

    //withdraw pocket money
    Route::post('/withdraws', [AccountsAndDepositsController::class, 'storeWithdrawal'])->name('pocket-money.withdraw');

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
    Route::post('/bank-reconciliation/store', [AccountsAndDepositsController::class, 'storeBankReconciliation'])
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

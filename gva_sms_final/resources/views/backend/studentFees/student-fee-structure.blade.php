@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py- bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Student Fees Structure</h2>
                    <p class="text-muted">Manage student fees from here.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    {{-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#submitPaymentModal">
                        <i class="fas fa-plus-circle"></i> Add Payment Record
                    </button> --}}
                </div>

            </div>
        </div>
    </div>
    @if (session('success') || $errors->any())
        <div class="mt-3">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Something went wrong.
                    <button type="button" class="btn btn-link text-decoration-none collapsed" data-toggle="collapse"
                        data-target="#errorDetails" aria-expanded="false" aria-controls="errorDetails">
                        View Errors
                    </button>
                    <div id="errorDetails" class="collapse mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif
    <div class="container container-fluid mt-2 shadow-lg">

        <!-- Tabs for Navigation -->
        <ul class="nav nav-tabs" id="feeManagementTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link " id="fee-categories-tab" data-toggle="tab" href="#fee-categories" role="tab"
                    aria-controls="fee-categories" aria-selected="true">Fee Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="bulk-assign-tab" data-toggle="tab" href="#bulk-assign" role="tab"
                    aria-controls="bulk-assign" aria-selected="false">Bulk Assignment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="individual-adjustments-tab" data-toggle="tab" href="#individual-adjustments"
                    role="tab" aria-controls="individual-adjustments" aria-selected="false">Individual Adjustments</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4" id="feeManagementContent">
            <!-- Create Fee Category Modal -->
            <div class="modal fade" id="createFeeCategoryModal" tabindex="-1" aria-labelledby="createFeeCategoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="card-header">
                            <h4>Create New Fee Category</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('fees.structure.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Fee Type Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fee_type" class="form-label small">Fee Type Name</label>
                                            <input type="text" class="form-control form-control-sm" id="fee_type"
                                                name="fee_type" required>
                                        </div>
                                    </div>
                                    <!-- Interval Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="interval" class="form-label small">Interval</label>
                                            <select class="form-control form-control-sm" id="interval" name="interval"
                                                required>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="termly">Termly</option>
                                                <option value="yearly">Yearly</option>
                                                <option value="once_off">Once-Off</option>
                                                <option value="circumstantial">Circumstantial</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Hidden Circumstance Explanation Input -->
                                    <div class="col-md-6" id="circumstance-explanation-container" style="display: none;">
                                        <div class="form-group">
                                            <label for="circumstance_explanation" class="form-label small">Explain the
                                                Circumstance</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="circumstance_explanation" name="circumstance_explanation"
                                                placeholder="Explain the circumstance">
                                        </div>
                                    </div>

                                    <!-- Amount Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount" class="form-label small">Amount</label>
                                            <input type="number" class="form-control form-control-sm" id="amount"
                                                name="amount" required>
                                        </div>
                                    </div>
                                    <!-- Student Type Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_type" class="form-label small">Student Type</label>
                                            <select class="form-control form-control-sm" id="student_type"
                                                name="student_type" required>
                                                <option value="boarder">Boarder</option>
                                                <option value="day">Day</option>
                                                <option value="all">All</option>
                                                <option value="subject_takers">Subject Takers</option>
                                                <option value="selective">Selective</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Account ID Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_id" class="form-label small">Account ID</label>
                                            <input type="text" class="form-control form-control-sm" id="account_id"
                                                name="account_id" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_type" class="form-label small">Active Status</label>
                                            <select class="form-control form-control-sm" id="status" name="status"
                                                required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <!-- Submit Button -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success btn-sm">Save Fee Category</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Fee Categories -->
            <div class="tab-pane fade " id="fee-categories" role="tabpanel" aria-labelledby="fee-categories-tab">
                <h3>Manage Fee Categories</h3>
                <button class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#createFeeCategoryModal">
                    Create New Fee Category
                </button>
                <div class=" table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fee Type</th>
                                <th>Interval</th>
                                <th>Amount (ZMK)</th>
                                <th>Student Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feeCategories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->fee_type }}</td>
                                    <td>{{ $category->fee_interval }}</td>
                                    <td>{{ number_format($category->amount, 2) }}</td>
                                    <td>{{ ucfirst($category->student_type) }}</td>
                                    <td>{{ $category->status }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#editFeeCategoryModal{{ $category->id }}">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteFeeCategory{{ $category->id }}">Delete</button>

                                    </td>
                                </tr>

                                <!-- Edit Fee Category Modal -->
                                <div class="modal fade" id="editFeeCategoryModal{{ $category->id }}" tabindex="-1"
                                    aria-labelledby="editFeeCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('fees.structure.update', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editFeeCategoryModalLabel{{ $category->id }}">Edit Fee
                                                        Category
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- Fee Type -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="feeType{{ $category->id }}"
                                                                    class="form-label small">Fee Type</label>
                                                                <input type="text" id="feeType{{ $category->id }}"
                                                                    name="fee_type" class="form-control form-control-sm"
                                                                    value="{{ $category->fee_type }}" required>
                                                            </div>
                                                        </div>

                                                        <!-- Interval -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="feeInterval{{ $category->id }}"
                                                                    class="form-label small">Interval</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="feeInterval{{ $category->id }}"
                                                                    name="fee_interval" required>
                                                                    <option value="weekly"
                                                                        {{ $category->fee_interval === 'weekly' ? 'selected' : '' }}>
                                                                        Weekly</option>
                                                                    <option value="monthly"
                                                                        {{ $category->fee_interval === 'monthly' ? 'selected' : '' }}>
                                                                        Monthly</option>
                                                                    <option value="termly"
                                                                        {{ $category->fee_interval === 'termly' ? 'selected' : '' }}>
                                                                        Termly</option>
                                                                    <option value="yearly"
                                                                        {{ $category->fee_interval === 'yearly' ? 'selected' : '' }}>
                                                                        Yearly</option>
                                                                    <option value="once_off"
                                                                        {{ $category->fee_interval === 'once_off' ? 'selected' : '' }}>
                                                                        Once-Off</option>
                                                                    <option value="circumstantial"
                                                                        {{ $category->fee_interval === 'circumstantial' ? 'selected' : '' }}>
                                                                        Circumstantial</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Circumstantial Explanation -->
                                                        <div class="col-md-6"
                                                            id="circumstantialExplanation{{ $category->id }}"
                                                            style="{{ $category->fee_interval === 'circumstantial' ? '' : 'display: none;' }}">
                                                            <div class="form-group">
                                                                <label for="explanation{{ $category->id }}"
                                                                    class="form-label small">Explanation</label>
                                                                <input type="text" id="explanation{{ $category->id }}"
                                                                    name="comment" class="form-control form-control-sm"
                                                                    value="{{ $category->comment }}">
                                                            </div>
                                                        </div>

                                                        <!-- Amount -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="amount{{ $category->id }}"
                                                                    class="form-label small">Amount</label>
                                                                <input type="number" id="amount{{ $category->id }}"
                                                                    name="amount" class="form-control form-control-sm"
                                                                    value="{{ $category->amount }}" step="0.01"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <!-- Student Type -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="studentType{{ $category->id }}"
                                                                    class="form-label small">Student Type</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="studentType{{ $category->id }}"
                                                                    name="student_type" required>
                                                                    <option value="boarder"
                                                                        {{ $category->student_type === 'boarder' ? 'selected' : '' }}>
                                                                        Boarder</option>
                                                                    <option value="day"
                                                                        {{ $category->student_type === 'day' ? 'selected' : '' }}>
                                                                        Day</option>
                                                                    <option value="all"
                                                                        {{ $category->student_type === 'all' ? 'selected' : '' }}>
                                                                        All</option>
                                                                    <option value="subject_takers"
                                                                        {{ $category->student_type === 'subject_takers' ? 'selected' : '' }}>
                                                                        Subject Takers</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Account Number -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="accountNo{{ $category->id }}"
                                                                    class="form-label small">Account No</label>
                                                                <input type="text" id="accountNo{{ $category->id }}"
                                                                    name="account_no" class="form-control form-control-sm"
                                                                    value="{{ $category->account_no }}" required>
                                                            </div>
                                                        </div>

                                                        <!-- Status -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="status{{ $category->id }}"
                                                                    class="form-label small">Status</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="status{{ $category->id }}" name="status"
                                                                    required>
                                                                    <option value="1"
                                                                        {{ $category->status ? 'selected' : '' }}>Active
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ !$category->status ? 'selected' : '' }}>Inactive
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success btn-sm">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--Delete modal -->
                                <div class="modal fade" id="deleteFeeCategory{{ $category->id }}" tabindex="-1"
                                    aria-labelledby="deleteFeeCategoryLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('fees.structure.destroy', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deleteFeeCategoryLabel{{ $category->id }}">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the fee category
                                                        <strong>{{ $category->fee_type }}</strong>? This action cannot be
                                                        undone.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>



            <!-- Bulk fee Assignment -->
            <div class="tab-pane fade show active" id="bulk-assign" role="tabpanel" aria-labelledby="bulk-assign-tab">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="mb-4 m-2">Create Bulk / Individual Fee (Invoices)</h3>
                    </div>
                    <div class="col-md-4">
                        <label for="changeBulkFeeView" class="form-label small">Change View</label>
                        <select id="changeBulkFeeView" name="change_view" class="form-control form-control-sm">

                            <option value="speficFeeGroup" selected>Assign Students fees</option>
                            <option value="viewClassFeeData">View Class Fee Data </option>
                            <option value="viewClassSpecificData">View Student Spefic Fee Data</option>
                        </select>
                    </div>
                </div>



                <form id="classFeeAssign" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Academic Year -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="academic_year_id" class="small">Academic Year</label>
                                    <select name="academic_year_id" class="form-control form-control-sm" required>
                                        <option value="" disabled selected>Select Academic Year</option>
                                        @foreach ($academicYears as $year)
                                            <option value="{{ $year['id'] }}">{{ $year['academic_year'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Term -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="term_no" class="small">Term</label>
                                    <select name="term_no" class="form-control form-control-sm" required>
                                        <option value="" disabled selected>Select Term</option>
                                        <option value="1">Term 1</option>
                                        <option value="2">Term 2</option>
                                        <option value="3">Term 3</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Select Option (Individual/Bulk) -->
                            <div class="col-md-4">
                                <label for="feeScope" class="form-label small">Fee Scope</label>
                                <select id="feeScope" name="feeScope" class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Fee Scope --</option>
                                    <option value="individual">Individual</option>
                                    <option value="class">Class</option>
                                </select>
                            </div>


                            <!-- Class Selection -->
                            <div class="col-md-4" id="classSelection">
                                <label for="classId" class="form-label small">Class</label>
                                <select id="classId" name="class_id" class="form-control form-control-sm">
                                    <option value="" selected disabled>--Select Class--</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->gradeno }}
                                            {{ $grade->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Student Type Input -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="student_type" class="form-label small">Student Type</label>
                                    <select class="form-control form-control-sm" id="student_type" name="student_type"
                                        required>
                                        <option value="boarder">Boarder</option>
                                        <option value="day">Day</option>
                                        <option value="all">All</option>
                                        <option value="selective">Selective</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Individual Student Selection -->
                            <div id="bulkPupilsSelect" class="col-md-4 d-none">
                                <div class="col-md-12">
                                    <label for="studentId" class="form-label small">Select Student</label>
                                    <select id="studentIds" name="student_ids[]" class="form-control form-control-sm"
                                        multiple>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">
                                                {{ $student->lastname }} {{ $student->firstname }} -
                                                {{ $student->grade->gradeno }} {{ $student->grade->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <!-- Fee Category -->
                            <div class="col-md-4">
                                <label for="feeCategory" class="form-label small">Fee Category</label>
                                <select id="feeCategory" name="fee_category_id[]" class="form-control form-control-sm"
                                    selected multiple>
                                    @foreach ($feeCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->fee_type }} - K
                                            {{ number_format($category->amount, 2) }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary btn-sm col-md-12">Assign Fees</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Class Fees Table -->
                <div class="card-body classFeeTble table-responsive">
                    <h3>Class Fees</h3>
                    <table id="classFeesTable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Class</th>
                                <th>Fee Category</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="classFeesTableBody">
                            @foreach ($classFees as $fee)
                                <tr>
                                    <td>Term {{ $fee->term_no }} - {{ $fee->academicYear->academic_year }}</td>
                                    <td>{{ $fee->grade->gradeno }} {{ $fee->grade->class_name }}</td>
                                    <td>{{ $fee->feeCategory->fee_type }}</td>
                                    <td>{{ $fee->feeCategory->amount }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal-{{ $fee->id }}">
                                            Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $fee->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this fee record?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Close</button>
                                                        <form action="{{ route('classFees.destroy', $fee->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Student Fees Table -->
                <div class="card-body studentFeeTable table-responsive">
                    <h3>Student Fees</h3>
                    <table id="studentFeesTable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Student</th>
                                <th>Fee Category</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentFeesTableBody">
                            @foreach ($studentFees as $fee)
                                <tr>
                                    <td>Term {{ $fee->term_no }} - {{ $fee->academicYear->academic_year }}</td>
                                    <td>{{ $fee->student->firstname }} {{ $fee->student->lastname }}</td>
                                    <td>{{ $fee->feeCategory->fee_type }}</td>
                                    <td>{{ $fee->feeCategory->amount }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal-{{ $fee->id }}">
                                            Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $fee->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>

                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this fee record?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Close</button>
                                                        <form action="{{ route('studentFees.destroy', $fee->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>





            <!-- Individual Adjustments -->
            <div class="tab-pane fade" id="individual-adjustments" role="tabpanel"
                aria-labelledby="individual-adjustments-tab">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="">Manage Individual/Bulk Fee Adjustments</h3>
                    </div>
                    <div class="col-md-4">
                        <label for="changeView" class="form-label small">Change View</label>
                        <select id="changeView" name="change_view" class="form-control form-control-sm">
                            <option value="adjustmentForm" selected>Fee Adjustment Form</option>
                            <option value="studentFeeAdjustmentTable">View student adjustment Data</option>
                            <option value="classFeeAdjustmentTable">View class adjustment Data</option>
                        </select>
                    </div>

                </div>
                <!-- Adjustment Form -->
                <div id="adjustmentForm" class="card-body">
                    <form action="{{ route('fee.adjustments.store') }}" method="POST" id="feeAdjustmentForm">
                        @csrf
                        <div class="row">
                            <!-- Select Year -->
                            <div class="col-md-4">
                                <label for="academicYear" class="form-label small">Select Year</label>
                                <select id="academicYear" name="academic_year_id" class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Academic Year --</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year->id }}">{{ $year->academic_year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Term -->
                            <div class="col-md-4">
                                <label for="termNo" class="form-label small">Select Term</label>
                                <select id="termNo" name="term_no" class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Term --</option>
                                    <option value="1">Term 1</option>
                                    <option value="2">Term 2</option>
                                    <option value="3">Term 3</option>
                                </select>
                            </div>

                            <!-- Select Option (Individual/Bulk) -->
                            <div class="col-md-4">
                                <label for="adjustmentScope" class="form-label small">Adjustment Scope</label>
                                <select id="adjustmentScope" name="adjustment_scope"
                                    class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Adjustment Scope --</option>
                                    <option value="bulkStudent">Bulk Target Student(s)</option>
                                    <option value="classAdjustment"> Within a Class</option>
                                </select>
                            </div>

                        </div>

                        <!-- Dynamic Individual Input -->
                        <div id="bulkStudent" class="row mt-3 d-none">
                            <div class="col-md-12">
                                <label for="studentId" class="form-label small">Select Student</label>
                                <select id="studentId" name="student_ids[]" class="form-control form-control-sm select2"
                                    multiple>
                                    <option value="" disabled>-- Select a Student --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->lastname }}
                                            {{ $student->firstname }}
                                            - {{ $student->grade->gradeno }} {{ $student->grade->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Dynamic Bulk Inputs -->
                        <div id="classAdjustment" class="row mt-3 d-none">
                            <div class="col-md-6">
                                <label for="studentType" class="form-label small">Student Type</label>
                                <select id="studentType" name="student_type" class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Student Type --</option>
                                    <option value="day">Day</option>
                                    <option value="boarder">Boarder</option>
                                    <option value="all">All</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="classId" class="form-label small">Class</label>
                                <select id="classId" name="class_id" class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Class --</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->gradeno }}
                                            {{ $grade->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Shared Inputs -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="adjustmentType" class="form-label small">Adjustment Type</label>
                                <select id="adjustmentType" name="adjustment_type" class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select Adjustment Type --</option>
                                    <option value="waiver">Waiver</option>
                                    <option value="penalty">Penalty</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="waver_penalty_feeId" class="form-label small"> Applied to:</label>
                                <select id="waver_penalty_feeId" name="waver_penalty_feeId"
                                    class="form-control form-control-sm">
                                    <option value="" disabled selected>-- Select --</option>
                                    @foreach ($feeCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->fee_type }} - K
                                            {{ number_format($category->amount, 2) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="amount" class="form-label small">Amount</label>
                                <input type="number" step="0.01" id="amount" name="amount"
                                    class="form-control form-control-sm" placeholder="Enter amount">
                            </div>
                            <div class="col-md-4">
                                <label for="adjustmentDate" class="form-label small">Adjustment Date</label>
                                <input type="date" id="adjustmentDate" name="adjustment_date"
                                    class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="reason" class="form-label small">Reason</label>
                                <textarea id="reason" name="reason" class="form-control form-control-sm" rows="3"
                                    placeholder="Enter reason"></textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm col-md-12">Submit Adjustment</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Adjustment Table -->
                <!-- Student Fee Adjustments Table -->
                <div class="card-body studentFeeAdjustmentTable table-responsive">
                    <h3>Student Fee Adjustments</h3>
                    <table id="studentFeeAdjustmentsTable" class="table table-bordered table-hover table-sm text-nowrap">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Student</th>
                                <th>Adjustment Type</th>
                                <th>Amount</th>
                                <th>Applied To</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentFeeAdjustmentsTableBody">
                            @foreach ($studentFeeAdjustments as $adjustment)
                                <tr>
                                    <td>
                                        Term {{ $adjustment->term_no }} -
                                        {{ $adjustment->academicYear->academic_year }}
                                    </td>
                                    <td>
                                        {{ $adjustment->student->firstname }}
                                        {{ $adjustment->student->lastname }}
                                    </td>
                                    <td>{{ ucfirst($adjustment->adjustment_type) }}</td>
                                    <td>{{ $adjustment->amount }}</td>
                                    <td>{{ $adjustment->adjustmentFeeCategory->fee_type }}</td>
                                    <td>{{ $adjustment->reason }}</td>
                                    <td>{{ $adjustment->adjustment_date }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal-studentAdjustment-{{ $adjustment->id }}">
                                            Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal-studentAdjustment-{{ $adjustment->id }}"
                                            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this adjustment record?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Close</button>
                                                        <form
                                                            action="{{ route('studentFeeAdjustments.destroy', $adjustment->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <!-- Class Fee Adjustments Table -->
                <div class="card-body classFeeAdjustmentTable table-responsive">
                    <h3>Class Fee Adjustments</h3>
                    <table id="classFeeAdjustmentsTable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Class</th>
                                <th>Adjustment Type</th>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="classFeeAdjustmentsTableBody">
                            @foreach ($classFeeAdjustments as $adjustment)
                                <tr>
                                    <td>
                                        Term {{ $adjustment->term_no }} -
                                        {{ $adjustment->academicYear->academic_year }}
                                    </td>
                                    <td>
                                        {{ $adjustment->grade->gradeno }}
                                        {{ $adjustment->grade->class_name }}
                                    </td>
                                    <td>{{ ucfirst($adjustment->adjustment_type) }}</td>
                                    <td>{{ $adjustment->amount }}</td>
                                    <td>{{ $adjustment->reason }}</td>
                                    <td>{{ $adjustment->adjustment_date }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal-classAdjustment-{{ $adjustment->id }}">
                                            Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal-classAdjustment-{{ $adjustment->id }}"
                                            tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this adjustment record?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-dismiss="modal">Close</button>
                                                        <form
                                                            action="{{ route('classFeeAdjustments.destroy', $adjustment->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for multi-select
            $("#studentIds").select2({
                placeholder: "-- Select Students --", // Placeholder text
                allowClear: true, // Allow clearing of selected options
                width: '100%' // Set width to match parent container
            });

            $('#interval').change(function() {
                if ($(this).val() === 'circumstantial') {
                    $('#circumstance-explanation-container').show();
                    $('#circumstance_explanation').prop('required', true);
                } else {
                    $('#circumstance-explanation-container').hide();
                    $('#circumstance_explanation').prop('required', false);
                }
            });

            document.getElementById('changeView').addEventListener('change', function() {
                const adjustmentForm = document.getElementById('adjustmentForm');
                const adjustmentTable = document.getElementById('adjustmentTable');
                if (this.value === 'adjustmentForm') {
                    adjustmentForm.classList.remove('d-none');
                    adjustmentTable.classList.add('d-none');
                } else if (this.value === 'adjustmentTable') {
                    adjustmentTable.classList.remove('d-none');
                    adjustmentForm.classList.add('d-none');
                }
            });

            // hide an unhide inputs from the fee assignment tab
            $("#feeScope").on("change", function() {
                const selectedScope = $(this).val();
                if (selectedScope === "class") {
                    $("#classSelection").show(); // Show class selection
                    $("#bulkPupilsSelect").addClass("d-none"); // Hide individual student selection
                } else if (selectedScope === "individual") {
                    $("#classSelection").hide(); // Hide class selection
                    $("#bulkPupilsSelect").removeClass("d-none"); // Show individual student selection
                } else {
                    $("#classSelection").hide(); // Default: hide both
                    $("#bulkPupilsSelect").addClass("d-none");
                }
            });



            $('#feeCategory').select2({
                placeholder: '--Select Fee Categories--',
                allowClear: true,
                width: '100%' // Ensures the dropdown adjusts to the container width
            });

            // Initialize Select2 for Student Dropdown
            $('#studentId').select2({
                placeholder: '-- Select a Student --',
                allowClear: true,
                width: '100%'
            });
            $('#classFeesTable').DataTable({
                responsive: true,
                autoWidth: false,
                lengthChange: true,
            });
            $('#studentFeesTable').DataTable({
                responsive: true,
                autoWidth: false,
                // lengthChange: false,
            });
            $('#studentFeeAdjustmentsTable').DataTable({
                responsive: true,
                autoWidth: false,
                lengthChange: true,
                lengthChange: true,
            });
            $('#classFeeAdjustmentsTable').DataTable({
                responsive: true,
                autoWidth: false,
                lengthChange: true,
            });

            // Listen for change event on the adjustmentScope dropdown
            $('#adjustmentScope').on('change', function() {
                // Get the selected value
                var selectedValue = $(this).val();

                // Hide all dynamic sections first
                $('#bulkStudent, #classAdjustment').addClass('d-none');

                // Show the corresponding section based on the selected value
                if (selectedValue === 'bulkStudent') {
                    $('#bulkStudent').removeClass('d-none');
                } else if (selectedValue === 'classAdjustment') {
                    $('#classAdjustment').removeClass('d-none');
                }
            });

            // Toggle Inputs Based on Adjustment Scope
            // Initially show only the adjustment form
            $("#adjustmentForm").show();
            $(".studentFeeAdjustmentTable").hide();
            $(".classFeeAdjustmentTable").hide();


            // Handle change event for the dropdown
            $("#changeView").on("change", function() {
                // Get the selected value
                const selectedView = $(this).val();

                // Hide all views initially
                $("#adjustmentForm").hide();
                $(".studentFeeAdjustmentTable").hide();
                $(".classFeeAdjustmentTable").hide();

                // Show the selected view
                if (selectedView === "adjustmentForm") {
                    $("#adjustmentForm").show();
                } else if (selectedView === "studentFeeAdjustmentTable") {
                    $(".studentFeeAdjustmentTable").show();
                } else if (selectedView === "classFeeAdjustmentTable") {
                    $(".classFeeAdjustmentTable").show();
                }
            });



            $('select[name="fee_interval"]').on('change', function() {
                const selectedValue = $(this).val();
                const explanationField = $(this).closest('.modal-body').find(
                    '[id^="circumstantialExplanation"]');
                if (selectedValue === 'circumstantial') {
                    explanationField.show();
                } else {
                    explanationField.hide();
                }
            });


            $('#classFeeAssign').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                let formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: "{{ route('class.fees.store') }}", // Define the route for storing fees
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token header
                    },
                    success: function(response) {
                        if (response.success) {

                            // Display success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3500,
                                timerProgressBar: true,
                            });

                            // Reload the page to reflect changes (if needed)
                            location.reload();
                        } else {
                            // Display generic error alert for non-duplicate issues
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message ||
                                    'Something went wrong. Please try again.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3500,
                                timerProgressBar: true,
                            });
                        }
                    },
                    error: function(xhr) {
                        let response = xhr.responseJSON;

                        // Check if the response contains duplicates
                        if (response && response.duplicates) {
                            let duplicateIds = response.duplicates.join(", ");
                            Swal.fire({
                                icon: 'warning',
                                title: 'Duplicate Entries!',
                                text: `The following fee categories are already assigned: ${duplicateIds}`,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 7000,
                                timerProgressBar: true,
                            });
                        } else {
                            // Handle other validation errors
                            let errors = response.errors || {};
                            let errorMessages = "";

                            $.each(errors, function(key, value) {
                                errorMessages += value + "\n";
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error!',
                                text: errorMessages || 'An unexpected error occurred.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3500,
                                timerProgressBar: true,
                            });
                        }
                    },
                });
            });



            //
            // Hide all sections initially
            // $("#classFeeAssign").hide();
            $(".classFeeTble").hide();
            $(".studentFeeTable").hide();

            // Show/hide based on the dropdown value
            $("#changeBulkFeeView").change(function() {
                var selectedValue = $(this).val(); // Get the selected value

                // Hide all sections
                $("#classFeeAssign").hide();
                $(".classFeeTble").hide();
                $(".studentFeeTable").hide();

                // Show the section based on the selected value
                if (selectedValue === "speficFeeGroup") {
                    $("#classFeeAssign").show(); // Show the form
                } else if (selectedValue === "viewClassFeeData") {
                    $(".classFeeTble").show(); // Show the class fee table
                } else if (selectedValue === "viewClassSpecificData") {
                    $(".studentFeeTable").show(); // Show the student-specific fee table
                }
            });



            // Submit form via AJAX
            $('#feeAdjustmentForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Create a FormData object
                var formData = new FormData(this);

                // Perform the Ajax request
                $.ajax({
                    url: $(this).attr('action'), // Use the form's action attribute
                    type: 'POST',
                    data: formData,
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    success: function(response) {
                        if (response.success) {
                            // Display success alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3500,
                                timerProgressBar: true,
                            });

                            // Reset the form
                            $('#feeAdjustmentForm')[0].reset();
                        } else {
                            // Display error alert for server-side errors
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3500,
                                timerProgressBar: true,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Extract error message
                        let errorMessage = xhr.responseJSON?.message ||
                            'An error occurred. Please try again.';

                        // Display error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true,
                        });

                        console.error('Error:', error);
                    }
                });
            });






        });
    </script>
@endsection

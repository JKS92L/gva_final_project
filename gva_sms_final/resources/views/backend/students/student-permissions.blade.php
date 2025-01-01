@extends('admin.admim-master')
@section('admin_content')
    <style>
        /* General Button Styling */
        .custom-btn-permission,
        .custom-btn-edit,
        .custom-btn-clear-in,
        .custom-btn-clear-out,
        .custom-btn-disciplinary,
        .custom-btn-delete {
            font-size: 0.9em;
            padding: 6px 10px;
            border-radius: 4px;
            border: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }

        /* Permission Button */
        .custom-btn-permission {
            background-color: #007bff;
            /* Blue */
        }

        .custom-btn-edit:hover {
            background-color: #0b9d56;
            transform: scale(1.1);
            /* Smooth enlarge */
        }

        .custom-btn-edit {
            background-color: #d37e0f;
        }

        .custom-btn-permission:hover {
            background-color: #0056b3;
            /* Darker Blue */
            transform: scale(1.1);
            /* Smooth enlarge */
        }

        /* Clean-In Button */
        .custom-btn-clear-in {
            background-color: #28a745;
            /* Green */
        }

        .custom-btn-clear-in:hover {
            background-color: #1e7e34;
            /* Darker Green */
            transform: scale(1.1);
        }

        /* Clean-Out Button */
        .custom-btn-clear-out {
            background-color: #ffc107;
            /* Yellow */
            color: #212529;
        }

        .custom-btn-clear-out:hover {
            background-color: #e0a800;
            /* Darker Yellow */
            transform: scale(1.1);
        }

        /* Disciplinary Action Button */
        .custom-btn-disciplinary {
            background-color: #dc3545;
            /* Red */
        }

        .custom-btn-disciplinary:hover {
            background-color: #bd2130;
            /* Darker Red */
            transform: scale(1.1);
        }

        .custom-btn-delete {
            color: #fff;
            background-color: #dc3545;
            border: none;
        }

        .custom-btn-delete:hover {
            background-color: #c82333;
        }

        /* Tooltip Styling */
        .custom-btn-permission[title]:hover::after,
        .custom-btn-edit[title]:hover::after,
        .custom-btn-clear-in[title]:hover::after,
        .custom-btn-clear-out[title]:hover::after,
        .custom-btn-disciplinary[title]:hover::after,
        .custom-btn-delete[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.75);
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            white-space: nowrap;
            font-size: 0.8em;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #eafbed;
            /* Card header background */
            color: #fff;

            /* Slightly darker border */
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Student Permission</h2>
                    <p class="text-muted">Student Permission Management</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#admitStudentModal">
                        <i class="fas fa-user-plus"></i> View 
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content p-2">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">

                <div class="tab-pane fade show active" id="student-permissions" role="tabpanel"
                    aria-labelledby="custom-tabs-four-all-staff-tab">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="card-title">Student Permissions</h1>

                                {{-- <button type="button" class="btn btn-primary btn-sm card-tools ext-right p-2"
                                        data-toggle="modal" data-target="#addTeacherModal">
                                        <i class="fas fa-user-plus"></i> Add New Teacher
                                    </button> --}}
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-2">

                                {{-- <div class="form-group col-md-3">
                                        <label for="term" class="small">Select Term</label>
                                        <select class="form-control form-control-sm" id="academic_term" name="academic_term"
                                            required>
                                            <option value="">--Select a term--</option>
                                            @foreach ($academicYearsWithTerms as $year)
                                                @foreach ($year->terms as $term)
                                                    <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                        {{ $year->academic_year }} - Term {{ $term->term_number }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4" style="max-width: 300px;">
                                        <label for="permission_status" class="d-block">Filter By Status</label>
                                        <select class="form-control form-control-sm" id="permission_status"
                                            name="permission_status">
                                            <option value="">--Select Status--</option>
                                            <option value="permission_granted">On Permission</option>
                                            <option value="not_permitted">Not Permitted</option>
                                            <option value="permission_rejected">Rejected Permission</option>
                                            <option value="permission_pending">Pending Permissions</option>
                                            <option value="permission_expired">Expired Permissions</option>
                                            <option value="permission_withdrawn">Withdrawn Permissions</option>
                                            <option value="permission_cancelled">Cancelled Permissions</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2 align-self-end">
                                        <button type="button" id="search_button"
                                            class="btn btn-primary btn-sm">Search</button>
                                    </div> --}}
                                <form id="filterForm" class="col-md-12 p-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="academic_year_id">Academic Year</label>
                                            <select id="academic_year_id" name="academic_year_id"
                                                class="form-control form-control-sm">
                                                <option value="">--Select year--
                                                </option>
                                                @foreach ($academicYearsWithTerms as $year)
                                                    <option value="{{ $year->id }}">{{ $year->academic_year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="term">Term</label>
                                            <select id="term" name="term" class="form-control form-control-sm">
                                                <option value="">--Select Term--</option>
                                                <option value="1">Term 1</option>
                                                <option value="2">Term 2</option>
                                                <option value="3">Term 3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="permission_status">Permission Status</label>
                                            <select id="permission_status" name="permission_status"
                                                class="form-control form-control-sm">
                                                <option value="">--Select Permission--</option>
                                                <option value="permission_granted">On Permission</option>
                                                <option value="not_permitted">Not Permitted</option>
                                                <option value="permission_rejected">Rejected Permission</option>
                                                <option value="permission_pending">Pending Permissions</option>
                                                <option value="permission_expired">Expired Permissions</option>
                                                <option value="permission_withdrawn">Withdrawn Permissions</option>
                                                <option value="permission_cancelled">Cancelled Permissions</option>
                                            </select>
                                        </div>
                                        <div class="mt-5 col-md-3">
                                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                        </div>
                                    </div>


                                </form>




                                <table class="table table-bordered table-hover text-nowrap mb-4 table-sm"
                                    id="studentPermissions">
                                    <thead>
                                        <tr>
                                            <th>Pupil's Name (Gender)</th>
                                            <th>Grade</th>
                                            <th>Student Type</th>
                                            <th>Hostel-Room</th>
                                            <th>Permission Status</th>
                                            <th>Year-Term</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Reason</th>
                                            <th>Authorized By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pupil_data">
                                        @foreach ($students as $student)
                                            @php
                                                $latestPermission = $student->homePermissions->last(); // Fetch the latest permission for the student
                                                $latestCheckIn = $student->checkIns->last();
                                                $roomStatus = $latestCheckIn ? $latestCheckIn->room_status : null;

                                                // Fetch the latest permission status from the logs
                                                $latestLog = $latestPermission ? $latestPermission->logs->last() : null;
                                                $status = $latestLog ? $latestLog->permission_status : 'not_permitted';

                                                // Badge and label classes for the status
                                                $badgeClasses = [
                                                    'permission_granted' => 'badge badge-success',
                                                    'permission_rejected' => 'badge badge-danger',
                                                    'permission_pending' => 'badge badge-warning',
                                                    'permission_expired' => 'badge badge-info',
                                                    'not_permitted' => 'badge badge-dark',
                                                ];
                                                $statusLabels = [
                                                    'permission_granted' => 'On Permission',
                                                    'permission_rejected' => 'Rejected Permission',
                                                    'permission_pending' => 'Pending Permissions',
                                                    'permission_expired' => 'Expired Permissions',
                                                    'not_permitted' => 'Not Permitted',
                                                ];
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $student->firstname ?? 'N/A' }}
                                                    {{ $student->lastname ?? '' }}
                                                    - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                                                </td>
                                                <td>
                                                    {{ $student->grade->gradeno ?? 'N/A' }}
                                                    {{ $student->grade->class_name ?? '' }}
                                                </td>
                                                <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                                                <td>
                                                    {{ optional(optional($student->checkIns->last())->hostel)->hostel_name ?? 'N/A' }}
                                                    -
                                                    {{ optional(optional($student->checkIns->last())->bedspace)->bedspace_no ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <span class="{{ $badgeClasses[$status] }}">
                                                        {{ $statusLabels[$status] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $latestPermission && $latestPermission->academicYear ? $latestPermission->academicYear->academic_year : 'N/A' }}
                                                    -
                                                    {{ 'Term ' . Str::ucfirst($latestPermission ? $latestPermission->academic_term_no : 'N/A') }}
                                                </td>
                                                <td>
                                                    {{ $latestPermission ? $latestPermission->permission_start->format('d-m-Y') : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $latestPermission ? $latestPermission->permission_end->format('d-m-Y') : 'N/A' }}
                                                </td>
                                                <td>{{ $latestPermission->reason ?? 'N/A' }}</td>
                                                <td>{{ $latestPermission && $latestPermission->approvedBy ? $latestPermission->approvedBy->name : 'N/A' }}
                                                </td>
                                                <td>
                                                    <!-- Permission Button -->
                                                    <!-- Permission Button -->
                                                    <button class="btn custom-btn-permission" data-toggle="modal"
                                                        data-target="#permissionModal-{{ $student->id }}"
                                                        title="Grant Permission"
                                                        {{ $status === 'permission_granted' ? 'disabled' : '' }}>
                                                        <i class="fas fa-home"></i>
                                                    </button>


                                                    <!-- Edit Button with Icon -->
                                                    <button class="btn custom-btn-edit" data-toggle="modal"
                                                        data-target="#editModal-{{ $student->id }}"
                                                        title="Edit Student Permission"
                                                        {{ !$latestPermission ? 'disabled' : '' }}>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if ($latestPermission)
                                                        <!-- Delete Button -->
                                                        <button class="btn custom-btn-delete" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $latestPermission->id }}"
                                                            title="Delete Student"
                                                            {{ !$latestPermission ? 'disabled' : '' }}>
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- permmission modal --}}
                                            <div class="modal fade" id="permissionModal-{{ $student->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-ml" role="document">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="permissionModalLabel">Grant
                                                                Permission for
                                                                <span class="text-bold text-white">
                                                                    {{ $student->firstname ?? 'N/A' }}
                                                                    {{ $student->lastname ?? '' }}
                                                                </span>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form id="grantPermissionForm-{{ $student->id }}"
                                                            action="{{ route('student-home-permission.store') }}"
                                                            method="POST">
                                                            @csrf
                                                            <!-- Modal Body -->
                                                            <div class="modal-body">
                                                                {{-- student_id --}}
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $student->id }}">
                                                                <input type="hidden" name="approved_by"
                                                                    value="{{ auth()->user()->id }}">

                                                                <div class="form-row">
                                                                    <div class="form-group col-md-12">
                                                                        <label for="term" class="small">Select
                                                                            Term</label>
                                                                        <select class="form-control form-control-sm"
                                                                            id="academic_term" name="academic_term"
                                                                            required>
                                                                            <option value="">--Select a term--
                                                                            </option>
                                                                            @foreach ($academicYearsWithTerms as $year)
                                                                                @foreach ($year->terms as $term)
                                                                                    <option
                                                                                        value="{{ $year->id }}-{{ $term->term_number }}">
                                                                                        {{ $year->academic_year }} - Term
                                                                                        {{ $term->term_number }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="hostel_name-{{ $student->id }}"
                                                                                    class="small">Hostel Name</label>
                                                                                <select
                                                                                    class="form-control form-control-sm"
                                                                                    id="hostel_name-{{ $student->id }}"
                                                                                    name="hostel_id">
                                                                                    <option value="">Select Hostel
                                                                                    </option>
                                                                                    @foreach ($hostels as $hostel)
                                                                                        <option
                                                                                            value="{{ $hostel->id }}"
                                                                                            {{ $student->checkIns->last() && $student->checkIns->last()->hostel_id == $hostel->id ? 'selected' : '' }}>
                                                                                            {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="bedspaceSelect-{{ $student->id }}"
                                                                                    class="small">Bedspace Number</label>
                                                                                <select
                                                                                    class="form-control form-control-sm"
                                                                                    id="bedspaceSelect-{{ $student->id }}"
                                                                                    name="bedspace_id">
                                                                                    <option value="">Select Bedspace
                                                                                    </option>
                                                                                    @if ($student->checkIns->last() && $student->checkIns->last()->bedspace)
                                                                                        <option
                                                                                            value="{{ $student->checkIns->last()->bedspace->id }}"
                                                                                            selected>
                                                                                            {{ $student->checkIns->last()->bedspace->bedspace_no }}
                                                                                        </option>
                                                                                    @endif
                                                                                    {{-- Dynamically load other available bedspaces here via AJAX --}}
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <!-- Permission Dates and Time -->
                                                                    <div class="form-group col-md-6">
                                                                        <label for="permission_start">Permission Start
                                                                            Date</label>
                                                                        <input type="date"
                                                                            class="form-control form-control-sm"
                                                                            id="permission_start-{{ $student->id }}"
                                                                            name="permission_start" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="permission_end">Permission End
                                                                            Date</label>
                                                                        <input type="date"
                                                                            class="form-control form-control-sm"
                                                                            id="permission_end-{{ $student->id }}"
                                                                            name="permission_end" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="pickup_time">Pick-Up Time</label>
                                                                        <input type="time"
                                                                            class="form-control form-control-sm"
                                                                            id="pickup_time-{{ $student->id }}"
                                                                            name="pickup_time" required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="pickup_person">Pick-Up
                                                                            Person</label>
                                                                        <select class="form-control form-control-sm"
                                                                            id="pickup_person-{{ $student->id }}"
                                                                            name="pickup_person" required>
                                                                            <option value="parent">Parent</option>
                                                                            <option value="other">Other</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Additional Inputs for "Other" Pick-Up Person -->
                                                                <div id="other_pickup_details-{{ $student->id }}"
                                                                    class="d-none">
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="other_name">Name</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="other_name-{{ $student->id }}"
                                                                                name="other_name" placeholder="Full Name">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="other_nrc">NRC</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="other_nrc-{{ $student->id }}"
                                                                                name="other_nrc"
                                                                                placeholder="National Registration Card Number">
                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label for="other_contact">Contact
                                                                                Number</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="other_contact-{{ $student->id }}"
                                                                                name="other_contact"
                                                                                placeholder="e.g., 097xxxxxxx">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="vehicle_reg">Vehicle
                                                                                Registration #</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="vehicle_reg-{{ $student->id }}"
                                                                                name="vehicle_reg"
                                                                                placeholder="Vehicle Registration Number">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <select name="parent_id" id="parent_id"
                                                                    class="form-control form-control-sm">
                                                                    <option value="">--Select a guardian--
                                                                    </option>
                                                                    @foreach ($student->guardians as $guardian)
                                                                        <option value="{{ $guardian->id }}">
                                                                            {{ $guardian->name }}
                                                                            ({{ $guardian->contact_number }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                                <div class="form-row">
                                                                    <!-- Reason for Pick-up -->
                                                                    <div class="form-group col-md-6">
                                                                        <label for="reason">Reason for
                                                                            Pick-Up</label>
                                                                        <textarea class="form-control form-control-sm" id="reason-{{ $student->id }}" name="reason" rows="3"
                                                                            placeholder="Provide a reason for the pick-up" required></textarea>
                                                                    </div>
                                                                    <!-- Comment by Deputy -->
                                                                    <div class="form-group col-md-6">
                                                                        <label for="deputy_comment">Comment by
                                                                            Deputy</label>
                                                                        <textarea class="form-control form-control-sm" id="deputy_comment-{{ $student->id }}" name="deputy_comment"
                                                                            rows="3" placeholder="Enter comments"></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-12">
                                                                    <label for="permission_status" class="d-block">Select
                                                                        Status</label>
                                                                    <select class="form-control form-control-sm"
                                                                        id="permission_status" name="permission_status"
                                                                        required>
                                                                        <option value="">--Select Status--
                                                                        </option>
                                                                        <option value="permission_granted">On Permission
                                                                        </option>
                                                                        <option value="not_permitted">Not Permitted
                                                                        </option>
                                                                        <option value="permission_rejected">Rejected
                                                                            Permission</option>
                                                                        <option value="permission_pending">Pending
                                                                            Permissions</option>
                                                                        <option value="permission_expired">Expired
                                                                            Permissions</option>
                                                                        <option value="permission_withdrawn">Withdrawn
                                                                            Permissions</option>
                                                                        <option value="permission_cancelled">Cancelled
                                                                            Permissions</option>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    form="grantPermissionForm-{{ $student->id }}">Save
                                                                    Permission</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal-{{ $student->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModalLabel-{{ $student->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel-{{ $student->id }}">Edit
                                                                Permission for <span class="text-white text-bold">
                                                                    {{ $student->firstname }}
                                                                    {{ $student->lastname }}
                                                                </span> </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ route('student.permission.update', $student->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="permission_status-{{ $student->id }}">Permission
                                                                        Status</label>
                                                                    <select class="form-control form-control-sm"
                                                                        id="permission_status-{{ $student->id }}"
                                                                        name="permission_status" required>
                                                                        <option value="">--Select Status--</option>

                                                                        <option value="permission_granted"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'permission_granted' ? 'selected' : '' }}>
                                                                            On Permission
                                                                        </option>

                                                                        <option value="not_permitted"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'not_permitted' ? 'selected' : '' }}>
                                                                            Not Permitted
                                                                        </option>

                                                                        <option value="permission_rejected"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'permission_rejected' ? 'selected' : '' }}>
                                                                            Rejected Permission
                                                                        </option>

                                                                        <option value="permission_pending"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'permission_pending' ? 'selected' : '' }}>
                                                                            Pending Permissions
                                                                        </option>

                                                                        <option value="permission_expired"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'permission_expired' ? 'selected' : '' }}>
                                                                            Expired Permissions
                                                                        </option>

                                                                        <option value="permission_withdrawn"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'permission_withdrawn' ? 'selected' : '' }}>
                                                                            Withdrawn Permissions
                                                                        </option>

                                                                        <option value="permission_cancelled"
                                                                            {{ $latestPermission && $latestPermission->permission_status === 'permission_cancelled' ? 'selected' : '' }}>
                                                                            Cancelled Permissions
                                                                        </option>
                                                                    </select>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="permission_start-{{ $student->id }}">Permission
                                                                        Start Date</label>
                                                                    <input type="date"
                                                                        class="form-control form-control-sm"
                                                                        id="permission_start-{{ $student->id }}"
                                                                        name="permission_start"
                                                                        value="{{ $latestPermission ? $latestPermission->permission_start->format('Y-m-d') : '' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        for="permission_end-{{ $student->id }}">Permission
                                                                        End Date</label>
                                                                    <input type="date"
                                                                        class="form-control form-control-sm"
                                                                        id="permission_end-{{ $student->id }}"
                                                                        name="permission_end"
                                                                        value="{{ $latestPermission ? $latestPermission->permission_end->format('Y-m-d') : '' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="reason-{{ $student->id }}">Reason</label>
                                                                    <textarea class="form-control" id="reason-{{ $student->id }}" name="reason" rows="3">{{ $latestPermission->reason ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary btn-sm">Save
                                                                    Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Confirmation Modal -->
                                            @if ($latestPermission)
                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal-{{ $latestPermission->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="deleteModalLabel-{{ $latestPermission->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel-{{ $latestPermission->id }}">
                                                                    Confirm Delete
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete the following permission
                                                                record for:
                                                                <br>
                                                                <strong>{{ $student->firstname ?? 'N/A' }}
                                                                    {{ $student->lastname ?? '' }}</strong>
                                                                - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <form
                                                                    action="{{ route('students.homepermission.destroy', $latestPermission->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>



                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>



                <div class="tab-pane fade" id="student-disciplinary-tab" role="tabpanel"
                    aria-labelledby="student-disciplinary">
                    <div class="col-md-12">

                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->


    </div>
    </div>

    <script>
        // new DataTable('#example2', {
        //     layout: {
        //         topStart: {
        //             buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        //         }
        //     }
        // });
        $(document).ready(function() {
            // $('#studentDetails').DataTable();

            $('#studentDetails').DataTable();
            $('#studentPermissions').DataTable();
            //studentPermissions

            // grant permissions
            $('[id^="pickup_person"]').on('change', function() {
                const studentId = $(this).attr('id').split('-')[1]; // Extract student ID
                const $otherDetails = $(`#other_pickup_details-${studentId}`);
                const $parentIdInput = $(
                    `#parent_idCheckIn-${studentId}`); // Target the static parent_id input directly

                if ($(this).val() === 'other') {
                    $otherDetails.removeClass('d-none'); // Show "Other" details
                    $parentIdInput.addClass('d-none'); // Hide Parent ID input
                } else {
                    $otherDetails.addClass('d-none'); // Hide "Other" details
                    $parentIdInput.removeClass('d-none'); // Show Parent ID input
                }
            });

            // clearIn
            $('[id^="clearIn_person"]').on('change', function() {
                const studentId = $(this).attr('id').split('-')[1]; // Extract student ID
                const $otherDetails = $(`#other_clearIn_details-${studentId}`);
                const $parentIdInput = $('#parent_idCheckIn'); // Target the static parent_id input directly

                if ($(this).val() === 'other') {
                    $otherDetails.removeClass('d-none'); // Show "Other" details
                    $parentIdInput.addClass('d-none'); // Hide Parent ID input
                } else if ($(this).val() === 'parent') {
                    $otherDetails.addClass('d-none'); // Hide "Other" details
                    $parentIdInput.removeClass('d-none'); // Show Parent ID input
                } else {
                    $otherDetails.addClass('d-none'); // Hide "Other" details
                    $parentIdInput.addClass('d-none'); // Show Parent ID input
                }
            });

            // clearOut
            $('[id^="clearOut_person"]').on('change', function() {
                const studentId = $(this).attr('id').split('-')[1]; // Extract student ID
                const $otherDetails = $(`#other_clearOut_details-${studentId}`);
                const $parentIdInput = $(
                    `#parent_id_wrapper-${studentId}`); // Target the wrapper specific to this student

                if ($(this).val() === 'other') {
                    $otherDetails.removeClass('d-none'); // Show "Other" details
                    $parentIdInput.addClass('d-none'); // Hide Parent ID input
                } else if ($(this).val() === 'parent') {
                    $otherDetails.addClass('d-none'); // Hide "Other" details
                    $parentIdInput.removeClass('d-none'); // Show Parent ID input
                } else {
                    $otherDetails.addClass('d-none'); // Hide "Other" details
                    $parentIdInput.addClass('d-none'); // Hide Parent ID input
                }
            });




            //fetch bedspaces 
            // Fetch bedspaces when a hostel is selected
            $("select[id^='hostel_name-']").on("change", function() {
                var hostelId = $(this).val(); // Get selected hostel ID
                var studentId = $(this).attr('id').split('-')[
                    1]; // Extract the student ID from the element ID
                var bedspaceSelect = $("#bedspaceSelect-" +
                    studentId); // Target the corresponding bedspace select

                // Debug: Verify correct hostelId and studentId
                console.log("Hostel ID:", hostelId);
                console.log("Student ID:", studentId);

                if (hostelId) {
                    $.ajax({
                        url: "{{ route('fetch.bedspaces') }}", // Backend route
                        type: "GET",
                        data: {
                            hostel_id: hostelId
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                bedspaceSelect.empty(); // Clear previous options
                                bedspaceSelect.append(
                                    '<option value="">Select bedspace no</option>');

                                // Populate bedspaces dynamically
                                $.each(response.bedspaces, function(key, bedspace) {
                                    bedspaceSelect.append(
                                        '<option value="' +
                                        bedspace.id +
                                        '">' +
                                        bedspace.bedspace_no +
                                        "</option>"
                                    );
                                });
                            } else {
                                console.log("Unexpected response:", response);
                            }
                        },
                        error: function(xhr) {
                            console.log("Error fetching bedspaces:", xhr.responseText);
                        },
                    });
                } else {
                    // Clear the bedspace dropdown if no hostel is selected
                    bedspaceSelect.empty();
                    bedspaceSelect.append('<option value="">Select bedspace no</option>');
                }
            });


            //hide and unhide inputs from the clear-out modal



            function formatDate(dateString) {
                const date = new Date(dateString);
                return new Intl.DateTimeFormat('en-US', {
                    weekday: 'long', // Displays the full day name (e.g., Monday)
                    year: 'numeric', // Displays the full year (e.g., 2024)
                    month: 'long', // Displays the full month name (e.g., December)
                    day: 'numeric' // Displays the day of the month (e.g., 30)
                }).format(date);
            }


            // Initialize select2 for student selection
            $('.select2').select2();

            //fetch permission by term and status
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                // Get input values
                const academicYearId = $('#academic_year_id').val();
                const term = $('#term').val();
                const permissionStatus = $('#permission_status').val();

                // AJAX call to fetch filtered students
                $.ajax({
                    url: "{{ route('filter.permission.byYears.status') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        academic_year_id: academicYearId,
                        term: term,
                        permission_status: permissionStatus
                    },
                    beforeSend: function() {
                        $('#pupil_data').empty(); // Clear table content before loading
                    },
                    success: function(response) {
                        $('#pupil_data').empty();

                        const students = response.students;
                        let rows = '';

                        if (students.length > 0) {
                            students.forEach(student => {
                                const latestPermission = student.home_permissions ?
                                    student.home_permissions[student.home_permissions
                                        .length - 1] :
                                    null;

                                const latestPermissionStatus = student
                                    .latest_permission_status || 'not_permitted';
                                const latestCheckIn = student.check_ins.length > 0 ?
                                    student.check_ins[student.check_ins.length - 1] :
                                    null;

                                rows += `
                    <tr>
                        <td>${student.firstname || 'N/A'} ${student.lastname || ''} (${student.gender || 'N/A'})</td>
                        <td>${student.grade?.gradeno || 'N/A'} ${student.grade?.class_name || ''}</td>
                        <td>${student.student_type || 'N/A'}</td>
                        <td>${latestCheckIn?.hostel?.hostel_name || 'N/A'} - ${latestCheckIn?.bedspace?.bedspace_no || 'N/A'}</td>
                        <td>
                            <span class="${getBadgeClass(latestPermissionStatus)}">
                                ${getStatusLabel(latestPermissionStatus)}
                            </span>
                        </td>
                        <td>${student.enrolled_year} - Term ${latestPermission?.academic_term_no || 'N/A'}</td>
                        <td>${latestPermission?.permission_start ? formatDate(latestPermission.permission_start) : 'N/A'}</td>
                        <td>${latestPermission?.permission_end ? formatDate(latestPermission.permission_end) : 'N/A'}</td>
                        <td>${latestPermission?.reason || 'N/A'}</td>
                        <td>${latestPermission?.approved_by?.name || 'N/A'}</td>
                        <td>
                            <button class="btn custom-btn-permission" data-toggle="modal" data-target="#permissionModal-${student.id}" title="Grant Permission" ${latestPermission ? 'disabled' : ''}>
                                <i class="fas fa-home"></i>
                            </button>
                            <button class="btn custom-btn-edit" data-toggle="modal" data-target="#editModal-${student.id}" title="Edit Student Permission" ${!latestPermission ? 'disabled' : ''}>
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn custom-btn-delete" data-toggle="modal"
                                                    data-target="#deleteModal-${latestPermission?.id}" title="Delete Student" ${!latestPermission ? 'disabled' : ''}>
                                                    <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    `;
                            });
                        } else {
                            rows = `
                <tr>
                    <td colspan="11" class="text-center">No students found with the selected criteria.</td>
                </tr>
                `;
                        }

                        $('#pupil_data').html(rows);
                    },
                    error: function(error) {
                        console.error(error);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });



            function getBadgeClass(status) {
                const badgeClasses = {
                    'permission_granted': 'badge badge-success',
                    'permission_rejected': 'badge badge-danger',
                    'permission_pending': 'badge badge-warning',
                    'permission_expired': 'badge badge-info',
                    'not_permitted': 'badge badge-dark'
                };
                return badgeClasses[status] || 'badge badge-dark';
            }

            function getStatusLabel(status) {
                const statusLabels = {
                    'permission_granted': 'On Permission',
                    'permission_rejected': 'Rejected Permission',
                    'permission_pending': 'Pending Permissions',
                    'permission_expired': 'Expired Permissions',
                    'not_permitted': 'Not Permitted'
                };
                return statusLabels[status] || 'Not Permitted';
            }


        });
    </script>
@endsection

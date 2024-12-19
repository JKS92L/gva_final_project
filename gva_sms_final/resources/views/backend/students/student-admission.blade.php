@extends('admin.admim-master')
@section('admin_content')
    <style>
        /* General Button Styling */
        .custom-btn-permission,
        .custom-btn-Clear-in,
        .custom-btn-Clear-out,
        .custom-btn-disciplinary {
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

        .custom-btn-permission:hover {
            background-color: #0056b3;
            /* Darker Blue */
            transform: scale(1.1);
            /* Smooth enlarge */
        }

        /* Clean-In Button */
        .custom-btn-Clear-in {
            background-color: #28a745;
            /* Green */
        }

        .custom-btn-Clear-in:hover {
            background-color: #1e7e34;
            /* Darker Green */
            transform: scale(1.1);
        }

        /* Clean-Out Button */
        .custom-btn-Clear-out {
            background-color: #ffc107;
            /* Yellow */
            color: #212529;
        }

        .custom-btn-Clear-out:hover {
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

        /* Tooltip Styling */
        .custom-btn-permission[title]:hover::after,
        .custom-btn-Clear-in[title]:hover::after,
        .custom-btn-Clear-out[title]:hover::after,
        .custom-btn-disciplinary[title]:hover::after {
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
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Termly Student Admissions Management</h2>
                    <p class="text-muted">Clear-in/out, give permissions and disciplinary actions from here</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#admitStudentModal">
                        <i class="fas fa-user-plus"></i> Add New Enrollment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
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

            {{-- Table showing admitted students --}}
            <div class="container card">
                <div class="card-header">
                    <h5>Student Details</h5>
                </div>
                <div class="card-body table-responsive p-2">
                    <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentDetails">
                        <thead class="">
                            <tr>
                                <th>Exam Number</th>
                                <th>Pupil's Name</th>
                                <th>Grade</th>
                                <th>Student Type</th>
                                <th>Guardian/Parent</th>
                                <th>Enrollment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->ecz_no ?? 'N/A' }}</td>
                                    <td>
                                        {{ $student->firstname ?? 'N/A' }} {{ $student->lastname ?? '' }}
                                        - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                                    </td>
                                    <td>
                                        {{ $student->grade->gradeno ?? 'N/A' }} {{ $student->grade->class_name ?? '' }}
                                    </td>
                                    <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                                    <td>
                                        <ul style="list-style-type: disc; margin: 0; padding-left: 20px;">
                                            @foreach ($student->guardians as $guardian)
                                                <li>
                                                    {{ $guardian->name }}
                                                    @if ($guardian->contact_number)
                                                        ({{ $guardian->contact_number }})
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : 'warning' }}">
                                            {{ ucfirst($student->active_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Permission Button -->
                                        <button class="btn custom-btn-permission" data-toggle="modal"
                                            data-target="#permissionModal-{{ $student->id }}" title="Grant Permission">
                                            <i class="fas fa-home"></i>
                                        </button>

                                        <!-- Clean-In Button -->
                                        <button class="btn custom-btn-Clear-in" data-toggle="modal"
                                            data-target="#ClearInModal-{{ $student->id }}" title="Clear-In">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </button>

                                        <!-- Clean-Out Button -->
                                        <button class="btn custom-btn-Clear-out" data-toggle="modal"
                                            data-target="#clearOutModal-{{ $student->id }}" title="Clear-Out">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>

                                        <!-- Disciplinary Action Button -->
                                        <button class="btn custom-btn-disciplinary" data-toggle="modal"
                                            data-target="#disciplinaryModal-{{ $student->id }}"
                                            title="Disciplinary Action">
                                            <i class="fas fa-gavel"></i>
                                        </button>
                                    </td>

                                </tr>


                                {{-- MODALS  --}}
                                <!-- Permissions Modal -->
                                <div class="modal fade" id="permissionModal-{{ $student->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-ml" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="permissionModalLabel">Grant Permission for
                                                    <span class="text-bold text-white"> {{ $student->firstname ?? 'N/A' }}
                                                        {{ $student->lastname ?? '' }}</span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="grantPermissionForm-{{ $student->id }}"
                                                action="{{ route('student-home-permission.store') }}" method="POST">

                                                @csrf
                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    {{-- student_id --}}
                                                    <!-- Hidden Fields -->
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="approved_by"
                                                        value="{{ auth()->user()->id }}">

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label for="term">Select Term</label>
                                                            <select class="form-control form-control-sm" id="academic_term"
                                                                name="academic_term" required>
                                                                <option value="">--Select a term--</option>
                                                                @foreach ($terms as $term)
                                                                    <option value="{{ $term['id'] }}">
                                                                        {{ $term['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Permission Dates and Time -->
                                                        <div class="form-group col-md-6">
                                                            <label for="permission_start">Permission Start Date</label>
                                                            <input type="date" class="form-control form-control-sm"
                                                                id="permission_start-{{ $student->id }}"
                                                                name="permission_start" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="permission_end">Permission End Date</label>
                                                            <input type="date" class="form-control form-control-sm"
                                                                id="permission_end-{{ $student->id }}"
                                                                name="permission_end" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="pickup_time">Pick-Up Time</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="pickup_time-{{ $student->id }}" name="pickup_time"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="pickup_person">Pick-Up Person</label>
                                                            <select class="form-control form-control-sm"
                                                                id="pickup_person-{{ $student->id }}"
                                                                name="pickup_person" required>
                                                                <option value="parent">Parent</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <!-- Additional Inputs for "Other" Pick-Up Person -->
                                                    <div id="other_pickup_details-{{ $student->id }}" class="d-none">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="other_name">Name</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_name-{{ $student->id }}" name="other_name"
                                                                    placeholder="Full Name">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="other_nrc">NRC</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                                    placeholder="National Registration Card Number">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="other_contact">Contact Number</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_contact-{{ $student->id }}"
                                                                    name="other_contact" placeholder="e.g., 097xxxxxxx">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="vehicle_reg">Vehicle Registration #</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="vehicle_reg-{{ $student->id }}"
                                                                    name="vehicle_reg"
                                                                    placeholder="Vehicle Registration Number">
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <select name="parent_id" id="parent_id"
                                                        class="form-control form-control-sm">
                                                        <option value="">--Select a guardian--</option>
                                                        @foreach ($student->guardians as $guardian)
                                                            <option value="{{ $guardian->id }}">
                                                                {{ $guardian->name }} ({{ $guardian->contact_number }})
                                                            </option>
                                                        @endforeach
                                                    </select>


                                                    <div class="form-row">
                                                        <!-- Reason for Pick-up -->
                                                        <div class="form-group col-md-6">
                                                            <label for="reason">Reason for Pick-Up</label>
                                                            <textarea class="form-control form-control-sm" id="reason-{{ $student->id }}" name="reason" rows="3"
                                                                placeholder="Provide a reason for the pick-up" required></textarea>
                                                        </div>
                                                        <!-- Comment by Deputy -->
                                                        <div class="form-group col-md-6">
                                                            <label for="deputy_comment">Comment by Deputy</label>
                                                            <textarea class="form-control form-control-sm" id="deputy_comment-{{ $student->id }}" name="deputy_comment"
                                                                rows="3" placeholder="Enter comments"></textarea>
                                                        </div>
                                                    </div>


                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        form="grantPermissionForm-{{ $student->id }}">Grant
                                                        Permission</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- ClearIn modals --}}
                                <div class="modal fade" id="ClearInModal-{{ $student->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="ClearInModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-ml" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ClearInModalLabel">Clear-In for
                                                    <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                                        {{ $student->lastname ?? '' }}</span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form id="clearInForm-{{ $student->id }}"
                                                action="{{ route('student-clear-in.store') }}" method="POST">
                                                @csrf

                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <!-- Hidden Fields -->
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="cleared_by"
                                                        value="{{ auth()->user()->id }}">

                                                    <!-- Term and Year Selection -->
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label for="term" class="small">Select Term</label>
                                                            <select class="form-control form-control-sm"
                                                                id="academic_term-{{ $student->id }}"
                                                                name="academic_term" required>
                                                                <option value="">--Select a term--</option>
                                                                @foreach ($terms as $term)
                                                                    <option value="{{ $term['id'] }}">
                                                                        {{ $term['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Clearance Checklist -->
                                                    <div class="form-row">
                                                        <label class="small">Clearance From:</label>
                                                        <div class="form-group col-md-4">
                                                            <!-- Hidden input to send false if checkbox is unchecked -->
                                                            <input type="hidden" name="clearance_accounts"
                                                                value="false">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="clearance_accounts-{{ $student->id }}"
                                                                    name="clearance_accounts" value="true">
                                                                <label class="form-check-label"
                                                                    for="clearance_accounts-{{ $student->id }}">
                                                                    Accounts Office
                                                                </label>
                                                            </div>

                                                            <input type="hidden" name="clearance_secretary"
                                                                value="false">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="clearance_secretary-{{ $student->id }}"
                                                                    name="clearance_secretary" value="true">
                                                                <label class="form-check-label"
                                                                    for="clearance_secretary-{{ $student->id }}">
                                                                    Secretary
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <input type="hidden" name="clearance_search" value="false">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="clearance_search-{{ $student->id }}"
                                                                    name="clearance_search" value="true">
                                                                <label class="form-check-label"
                                                                    for="clearance_search-{{ $student->id }}">
                                                                    Search Team
                                                                </label>
                                                            </div>

                                                            <input type="hidden" name="clearance_patron" value="false">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="clearance_patron-{{ $student->id }}"
                                                                    name="clearance_patron" value="true">
                                                                <label class="form-check-label"
                                                                    for="clearance_patron-{{ $student->id }}">
                                                                    Patron
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="clearIn_person" class="small">Clear-In
                                                                Guardian</label>
                                                            <select class="form-control form-control-sm"
                                                                id="clearIn_person-{{ $student->id }}"
                                                                name="clearIn_person" required>
                                                                <option value="">--Select--</option>
                                                                <option value="parent">Parent</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>

                                                        <!-- Check-In Time -->
                                                        <div class="form-group col-md-12">
                                                            <label for="check_in_time-{{ $student->id }}"
                                                                class="small">Check-In Time</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="check_in_time-{{ $student->id }}"
                                                                name="check_in_time" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="hostel_name" class="small">Hostel
                                                                    Name</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="hostel_name-{{ $student->id }}" name="hostel_id"
                                                                    {{ $student->hostel ? 'disabled' : '' }}>
                                                                    <option value="">Select Hostel</option>
                                                                    @foreach ($hostels as $hostel)
                                                                        <option value="{{ $hostel->id }}"
                                                                            {{ $student->hostel && $student->hostel->id == $hostel->id ? 'selected' : '' }}>
                                                                            {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="bedspaceSelect" class="small">Bedspace
                                                                    Number</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="bedspaceSelect-{{ $student->id }}"
                                                                    name="bedspace_id"
                                                                    {{ $student->bedspace ? 'disabled' : '' }}>
                                                                    <option value="">Select Bedspace</option>
                                                                    @if ($student->bedspace)
                                                                        <option value="{{ $student->bedspace->id }}"
                                                                            selected>{{ $student->bedspace->bedspace_no }}
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>



                                                    </div>


                                                    <div id="other_clearIn_details-{{ $student->id }}" class="d-none">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="other_name">Name</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_name-{{ $student->id }}" name="other_name"
                                                                    placeholder="Full Name">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="other_nrc">NRC</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                                    placeholder="National Registration Card Number">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="other_contact">Contact Number</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_contact-{{ $student->id }}"
                                                                    name="other_contact" placeholder="e.g., 097xxxxxxx">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="vehicle_reg">Vehicle Registration #</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="vehicle_reg-{{ $student->id }}"
                                                                    name="vehicle_reg"
                                                                    placeholder="Vehicle Registration Number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label
                                                                for="brought_by_relationship">brought-by-relationship</label>
                                                            <select class="form-control form-control-sm"
                                                                id="brought_by_relationship-{{ $student->id }}"
                                                                name="brought_by_relationship">
                                                                <option value="">--Select--</option>
                                                                <option value="brother">Brother</option>
                                                                <option value="sister">Sister</option>
                                                                <option value="uncle">Uncle</option>
                                                                <option value="driver">Driver</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>


                                                    </div>

                                                    <div class="form-group" id="parent_idCheckIn">
                                                        <select name="parent_id" class="form-control form-control-sm">
                                                            <option value="">--Select a guardian--</option>
                                                            @foreach ($student->guardians as $guardian)
                                                                <option value="{{ $guardian->id }}">
                                                                    {{ $guardian->name }}
                                                                    ({{ $guardian->contact_number }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        form="clearInForm-{{ $student->id }}">
                                                        Clear-In
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            {{-- Modal for admitting students --}}
            <div class="modal fade" id="admitStudentModal" tabindex="-1" aria-labelledby="admitStudentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="admitStudentModalLabel">Admit New Students</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- Admission Form --}}
                            <form action="{{ route('student-home-permission.store') }}" method="POST">
                                @csrf
                                {{-- Academic Year --}}
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <select class="form-control" id="academic_year" name="academic_year" required>
                                        <option value="" selected disabled>Select Academic Year</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                </div>

                                {{-- Term --}}
                                <div class="form-group">
                                    <label for="term">Term</label>
                                    <select class="form-control" id="term" name="term" required>
                                        <option value="" selected disabled>Select Term</option>
                                        <option value="1">Term 1</option>
                                        <option value="2">Term 2</option>
                                        <option value="3">Term 3</option>
                                    </select>
                                </div>

                                {{-- Students List --}}
                                <div class="form-group">
                                    <label for="students">Select Students to Admit</label>
                                    <select class="form-control select2" id="students" name="students[]"
                                        multiple="multiple" required>
                                        <option value="1">John Doe - Grade 10</option>
                                        <option value="2">Jane Smith - Grade 12</option>
                                        <option value="3">Albert Banda - Grade 9</option>
                                        <option value="4">Linda Mwansa - Grade 8</option>
                                        {{-- Dynamically generated student list --}}
                                    </select>
                                </div>

                                {{-- Admission Date --}}
                                <div class="form-group">
                                    <label for="admission_date">Admission Date</label>
                                    <input type="date" class="form-control" id="admission_date" name="admission_date"
                                        required>
                                </div>

                                {{-- Submit Button --}}
                                <button type="submit" class="btn btn-success">Admit Students</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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


            // Initialize select2 for student selection
            $('.select2').select2();

        });
    </script>
@endsection

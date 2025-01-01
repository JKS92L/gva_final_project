@extends('admin.admim-master')
@section('admin_content')
    <style>
        /* General Button Styling */
        .custom-btn-permission,
        .custom-btn-edit,
        .custom-btn-clear-in,
        .custom-btn-clear-out,
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

        /* Tooltip Styling */
        .custom-btn-permission[title]:hover::after,
        .custom-btn-edit[title]:hover::after,
        .custom-btn-clear-in[title]:hover::after,
        .custom-btn-clear-out[title]:hover::after,
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
                    <h2 class="mb-0">Termly Student Report</h2>
                    <p class="text-muted">Management of all Dayscholars and Boarders who report in school in each Term</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#admitStudentModal">
                        <i class="fas fa-user-plus"></i> Checkin Dayscholars
                    </button>
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


        <div class="col-md-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header small">
                    <h1 class="card-title">Student Hostel Checkins</h1>
                </div>

                <div class="card-body table-responsive p-2">
                    <!-- Term and Year Selection -->
                    <div class="form-row">
                        {{-- <div class="form-group col-md-3">
                            <label for="academic_term">Filter By Term</label>
                            <select class="form-control form-control-sm" id="academic_term" name="academic_term" required>
                                <option value="">-- Select a Term --</option>
                                @foreach ($academicYears as $year)
                                    @foreach ($year->terms as $term)
                                        <option value="{{ $year->id }}-{{ $term->term_number }}">
                                            {{ $year->academic_year }} - Term {{ $term->term_number }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div> --}}


                    </div>

                    <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentDetails">
                        <thead>
                            <tr>
                                {{-- <th>Exam Number</th> --}}
                                <th>Pupil's Name (Gender)</th>
                                <th>Grade</th>
                                <th>Student Type</th>
                                <th>Recent Year-Term</th>
                                <th>Hostel (Bedspace #)</th>
                                <th>Check-In Status</th>
                                <th>Enrollment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                @php
                                    // Get the latest check-in for the student
                                    $latestCheckIn = $student->checkIns->last();
                                    $roomStatus = $latestCheckIn ? $latestCheckIn->room_status : null;
                                    $isDayScholar = $student->student_type === 'Day-Scholar';
                                    $checkInDate = $latestCheckIn ? $latestCheckIn->created_at->format('d-m-Y') : 'N/A';
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
                                        @if ($student->termlyReports->isNotEmpty())
                                            @php
                                                $latestReport = $student->termlyReports->last();
                                            @endphp
                                            <div>
                                                {{ $latestReport->academicYear->academic_year ?? 'N/A' }} -
                                                Term {{ $latestReport->term_number ?? 'N/A' }}
                                                - {{ '(' . $latestReport->report_status . ')' ?? 'N/A' }}
                                            </div>
                                        @else
                                            No Reports Available
                                        @endif
                                    </td>


                                    <td>
                                        {{ optional(optional($student->checkIns->last())->hostel)->hostel_name ?? 'N/A' }}
                                        -
                                        {{ optional(optional($student->checkIns->last())->bedspace)->bedspace_no ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @php
                                            $latestCheckIn = $student->checkIns->last(); // Get the most recent check-in
                                        @endphp
                                        {{ $latestCheckIn ? ucfirst($latestCheckIn->room_status) : 'No Record' }}
                                    </td>
                                    {{-- <td>{{ $checkInDate }}</td> --}}
                                    <td>
                                        <span
                                            class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : 'warning' }}">
                                            {{ ucfirst($student->active_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Clear-In Button -->
                                        {{-- Conditional button based on room_status and student_type --}}
                                        <button class="btn custom-btn-clear-in" data-toggle="modal"
                                            data-target="#ClearInModal-{{ $student->id }}" title="Clear-In"
                                            {{ $roomStatus === 'checked_in' || $isDayScholar ? 'disabled' : '' }}>
                                            <i class="fas fa-sign-in-alt"></i>
                                        </button>

                                        <!-- Clear-Out Button -->
                                        <button class="btn custom-btn-clear-out" data-toggle="modal"
                                            data-target="#clearOutModal-{{ $student->id }}" title="Clear-Out"
                                            {{ $roomStatus === 'checked_out' || $isDayScholar ? 'disabled' : '' }}>
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                {{-- ClearIn modals --}}
                                <div class="modal fade" id="ClearInModal-{{ $student->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="ClearInModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-ml" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ClearInModalLabel">Clear-In
                                                    for
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
                                                            <label for="term" class="small">Select
                                                                Term</label>
                                                            <select class="form-control form-control-sm"
                                                                id="academic_term-{{ $student->id }}" name="academic_term"
                                                                required>
                                                                <option value="">--Select a term--
                                                                </option>
                                                                @foreach ($academicYears as $year)
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
                                                    </div>

                                                    <!-- Clearance Checklist -->
                                                    <div class="form-row">
                                                        <label class="small">Clearance From:</label>
                                                        <div class="form-group col-md-4">
                                                            <!-- Hidden input to send false if checkbox is unchecked -->
                                                            <input type="hidden" name="clearance_accounts" value="false">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="clearance_accounts-{{ $student->id }}"
                                                                    name="clearance_accounts" value="true">
                                                                <label class="form-check-label"
                                                                    for="clearance_accounts-{{ $student->id }}">
                                                                    Accounts Office
                                                                </label>
                                                            </div>

                                                            <input type="hidden" name="clearance_secretary" value="false">
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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="hostel_name-{{ $student->id }}"
                                                                    class="small">Hostel Name</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="hostel_name-{{ $student->id }}"
                                                                    name="hostel_id">
                                                                    <option value="">Select Hostel</option>
                                                                    @foreach ($hostels as $hostel)
                                                                        <option value="{{ $hostel->id }}"
                                                                            {{ $student->checkIns->last() && $student->checkIns->last()->hostel_id == $hostel->id ? 'selected' : '' }}>
                                                                            {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="bedspaceSelect-{{ $student->id }}"
                                                                    class="small">Bedspace Number</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="bedspaceSelect-{{ $student->id }}"
                                                                    name="bedspace_id">
                                                                    <option value="">Select Bedspace</option>
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
                                                                <label for="other_contact">Contact
                                                                    Number</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_contact-{{ $student->id }}"
                                                                    name="other_contact" placeholder="e.g., 097xxxxxxx">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="vehicle_reg">Vehicle
                                                                    Registration #</label>
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
                                                            <option value="">--Select a guardian--
                                                            </option>
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

                                <!-- Clear-Out Modal -->
                                <div class="modal fade" id="clearOutModal-{{ $student->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="clearOutModalLabel-{{ $student->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="clearOutModalLabel-{{ $student->id }}">
                                                    Clear-Out For:
                                                    <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                                        {{ $student->lastname ?? '' }}</span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Modal Form -->
                                            <form id="clearOutForm-{{ $student->id }}"
                                                action="{{ route('student-clear-out.store') }}" method="POST">
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
                                                            <label for="term" class="small">Select
                                                                Term</label>
                                                            <select class="form-control form-control-sm"
                                                                id="academic_term-{{ $student->id }}"
                                                                name="academic_term" required>
                                                                <option value="">--Select a term--
                                                                </option>
                                                                @foreach ($academicYears as $year)
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
                                                    </div>

                                                    <!-- Clear-Out Time -->
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label for="check_out_time-{{ $student->id }}"
                                                                class="small">Clear-Out
                                                                Time</label>
                                                            <input type="time" class="form-control form-control-sm"
                                                                id="check_out_time-{{ $student->id }}"
                                                                name="check_out_time" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="hostel_name-{{ $student->id }}"
                                                                    class="small">Hostel
                                                                    Name</label>
                                                                <select class="form-control form-control-sm"
                                                                    id="hostel_name-{{ $student->id }}" name="hostel_id"
                                                                    {{ $student->checkIns->last() ? 'disabled' : '' }}>
                                                                    <option value="">Select Hostel
                                                                    </option>
                                                                    @foreach ($hostels as $hostel)
                                                                        <option value="{{ $hostel->id }}"
                                                                            {{ $student->checkIns->last() && $student->checkIns->last()->hostel_id == $hostel->id ? 'selected' : '' }}>
                                                                            {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="bedspaceSelect-{{ $student->id }}"
                                                                class="small">Bedspace
                                                                Number</label>
                                                            <select class="form-control form-control-sm"
                                                                id="bedspaceSelect-{{ $student->id }}"
                                                                name="bedspace_id"
                                                                {{ $student->checkIns->last() ? 'disabled' : '' }}>
                                                                <option value="">Select Bedspace
                                                                </option>
                                                                @if ($student->checkIns->last() && $student->checkIns->last()->bedspace)
                                                                    <option
                                                                        value="{{ $student->checkIns->last()->bedspace->id }}"
                                                                        selected>
                                                                        {{ $student->checkIns->last()->bedspace->bedspace_no }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Clear-Out Guardian Dropdown -->

                                                    <div class="form-group col-md-12">
                                                        <label for="clearOut_person-{{ $student->id }}"
                                                            class="small">Clear-Out
                                                            Guardian</label>
                                                        <select class="form-control form-control-sm"
                                                            id="clearOut_person-{{ $student->id }}"
                                                            name="clearOut_person" required>
                                                            <option value="">--Select--</option>
                                                            <option value="parent">Parent</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>

                                                    <!-- Parent ID Selection -->
                                                    <div class="form-group" id="parent_id_wrapper-{{ $student->id }}">
                                                        <label for="parent_id" class="small">Select
                                                            Guardian</label>
                                                        <select name="parent_id" class="form-control form-control-sm">
                                                            <option value="">--Select a guardian--
                                                            </option>
                                                            @foreach ($student->guardians as $guardian)
                                                                <option value="{{ $guardian->id }}">
                                                                    {{ $guardian->name }}
                                                                    ({{ $guardian->contact_number }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Additional Guardian or Vehicle Details -->
                                                    <div id="other_clearOut_details-{{ $student->id }}" class="d-none">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="other_name" class="small">Name</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_name-{{ $student->id }}" name="other_name"
                                                                    placeholder="Full Name">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="other_nrc" class="small">NRC</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                                    placeholder="National Registration Card Number">
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="other_contact" class="small">Contact
                                                                    Number</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="other_contact-{{ $student->id }}"
                                                                    name="other_contact" placeholder="e.g., 097xxxxxxx">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="vehicle_reg" class="small">Vehicle
                                                                    Registration #</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="vehicle_reg-{{ $student->id }}"
                                                                    name="vehicle_reg"
                                                                    placeholder="Vehicle Registration Number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="pickup_by_relationship" class="small">Brought By
                                                                Relationship</label>
                                                            <select class="form-control form-control-sm"
                                                                id="pickup_by_relationship-{{ $student->id }}"
                                                                name="pickup_by_relationship">
                                                                <option value="">--Select--</option>
                                                                <option value="brother">Brother</option>
                                                                <option value="sister">Sister</option>
                                                                <option value="uncle">Uncle</option>
                                                                <option value="driver">Driver</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        form="clearOutForm-{{ $student->id }}">Clear-Out</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>





        {{-- Modal for admitting return day scholars students --}}
        <div class="modal fade" id="admitStudentModal" tabindex="-1" aria-labelledby="admitStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="admitStudentModalLabel">Admit Returning Students (Day-scholars)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- Admission Form --}}
                        <form action="{{ route('dayscholars.student.termly-report.store') }}" method="POST">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="academic_term">Select Term</label>
                                <select class="form-control form-control-sm" id="academic_term" name="academic_term"
                                    required>
                                    <option value="">-- Select a Term --</option>
                                    @foreach ($academicYears as $year)
                                        @foreach ($year->terms as $term)
                                            <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                {{ $year->academic_year }} - Term {{ $term->term_number }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="students">Select Students to Admit</label>
                                <select class="form-control select2" id="students" name="students[]"
                                    multiple="multiple" required>
                                    @foreach ($students->where('student_type', 'Day-Scholar') as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->firstname ?? 'N/A' }}
                                            {{ $student->lastname ?? '' }}
                                            - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                                            - Grade {{ $student->grade->gradeno ?? 'N/A' }}
                                            {{ $student->grade->class_name ?? 'N/A' }}
                                            - ({{ $student->student_type ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="report_status">Reporting Status</label>
                                <select class="form-control form-control-sm" id="report_status" name="report_status"
                                    required>
                                    <option value="">-- Select Status --</option>
                                    <option value="reported_in">Reported In</option>
                                    <option value="reported_out">Reported Out</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="reported_date">Date Reported for the Term</label>
                                <input type="date" class="form-control" id="reported_date" name="reported_date"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-success btn-sm col-md-12">Save Students</button>
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
            // $("select[id^='hostel_name-']").on("change", function() {
            //     var hostelId = $(this).val(); // Get selected hostel ID
            //     var studentId = $(this).attr('id').split('-')[
            //         1]; // Extract the student ID from the element ID
            //     var bedspaceSelect = $("#bedspaceSelect-" +
            //         studentId); // Target the corresponding bedspace select

            //     // Debug: Verify correct hostelId and studentId
            //     console.log("Hostel ID:", hostelId);
            //     console.log("Student ID:", studentId);

            //     if (hostelId) {
            //         $.ajax({
            //             url: "{{ route('fetch.bedspaces') }}", // Backend route
            //             type: "GET",
            //             data: {
            //                 hostel_id: hostelId
            //             },
            //             success: function(response) {
            //                 if (response.status === "success") {
            //                     bedspaceSelect.empty(); // Clear previous options
            //                     bedspaceSelect.append(
            //                         '<option value="">Select bedspace no</option>');

            //                     // Populate bedspaces dynamically
            //                     $.each(response.bedspaces, function(key, bedspace) {
            //                         bedspaceSelect.append(
            //                             '<option value="' +
            //                             bedspace.id +
            //                             '">' +
            //                             bedspace.bedspace_no +
            //                             "</option>"
            //                         );
            //                     });
            //                 } else {
            //                     console.log("Unexpected response:", response);
            //                 }
            //             },
            //             error: function(xhr) {
            //                 console.log("Error fetching bedspaces:", xhr.responseText);
            //             },
            //         });
            //     } else {
            //         // Clear the bedspace dropdown if no hostel is selected
            //         bedspaceSelect.empty();
            //         bedspaceSelect.append('<option value="">Select bedspace no</option>');
            //     }
            // });

            $("select[id^='hostel_name-']").on("change", function() {
                var hostelId = $(this).val(); // Get selected hostel ID
                var studentId = $(this).attr("id").split("-")[1]; // Extract the student ID
                var bedspaceSelect = $("#bedspaceSelect-" + studentId); // Target bedspace dropdown

                console.log("Hostel ID:", hostelId);
                console.log("Student ID:", studentId);

                if (hostelId) {
                    $.ajax({
                        url: "{{ route('fetch.bedspaces') }}", // Backend route for fetching bedspaces
                        type: "GET",
                        data: {
                            hostel_id: hostelId
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                bedspaceSelect.empty(); // Clear previous options
                                bedspaceSelect.append(
                                    '<option value="">Select Bedspace</option>');

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
                        }
                    });
                } else {
                    bedspaceSelect.empty();
                    bedspaceSelect.append('<option value="">Select Bedspace</option>');
                }
            });




            //hide and unhide inputs from the clear-out modal





            // Initialize select2 for student selection
            $('.select2').select2();

        });
    </script>
@endsection

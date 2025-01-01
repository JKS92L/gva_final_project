@extends('admin.admim-master')
@section('admin_content')
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Admissions Management</h2>
                    <p class="text-muted">Monitor and process applications from online and physical applicants.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">

                    <a href="{{ route('enrollment-process-register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Add New Enrollment
                    </a>
                    {{-- enrollment-process-register --}}
                </div>
            </div>
        </div>
    </div>
    {{-- render --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="content p-2">
        <div class="card shadow-sm p-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Admissions</h3>

            </div>
            <div class="card-body">
                <div class="table-responsive table-sm">
                    <div class="form-group mb-9" style="max-width: 300px;">
                        <label for="term" class="d-block">Filter By Year</label>
                        <select class="form-control form-control-sm" id="academic_term" name="academic_term" required>
                            <option value="">--Select a term--</option>
                            @foreach ($academicYears as $year)
                                @foreach ($year->terms as $term)
                                    <option value="{{ $year->id }}-{{ $term->term_number }}">
                                        {{ $year->academic_year }} - Term {{ $term->term_number }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <table id="enrollmentTable" class="table table-bordered table-hover text-nowrap table-sm">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>ECZ #</th>
                                <th>Applicant Name</th>
                                <th>Application ID</th>
                                <th>Application Type</th>
                                <th>Enrollment Year</th>
                                <th>Grade/Class</th>
                                <th>Parent(s) Name</th>
                                <th>Submission Date</th>
                                <th>Enrollment Status</th>
                                <th>Admission Response</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->ecz_no }}</td>
                                    <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                    <td>{{ $student->admissions->first()->admission_id ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($student->admissionAppType) ?? 'N/A' }}</td>
                                    <td>{{ $student->enrolled_year }} - {{ 'Term ' . $student->enrolled_term }}</td>
                                    <td>{{ optional($student->grade)->gradeno }}
                                        {{ optional($student->grade)->class_name }}
                                    </td>
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
                                    <td>{{ $student->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : ($student->active_status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($student->active_status) }}
                                        </span>
                                    </td>
                                    {{-- <td>{{ $student->application_status ?? 'N/A' }}</td> --}}
                                    <td>
                                        <!-- Badge for Application Status -->
                                        @php
                                            $badgeColor = 'secondary'; // Default value
                                            switch ($student->application_status) {
                                                case 'Accepted':
                                                    $badgeColor = 'success';
                                                    break;
                                                case 'Rejected':
                                                    $badgeColor = 'danger';
                                                    break;
                                                case 'Pending Review':
                                                    $badgeColor = 'warning';
                                                    break;
                                                default:
                                                    $badgeColor = 'secondary';
                                                    break;
                                            }
                                        @endphp

                                        <span class="badge badge-{{ $badgeColor }}">
                                            {{ ucfirst($student->application_status ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Approve Button -->
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#approveStudentModal{{ $student->id }}"
                                            @if ($student->application_status === 'Accepted') disabled @endif>
                                            {{-- decide the button output --}}
                                            @if ($student->application_status === 'Accepted')
                                                {{ 'Accepted' }}
                                            @else
                                                {{ 'Accept' }}
                                            @endif
                                        </button>

                                        <!-- Reject Button -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#rejectStudentModal{{ $student->id }}"
                                            @if ($student->application_status === 'Rejected') disabled @endif>
                                            {{-- decide the button output --}}
                                            @if ($student->application_status === 'Rejected')
                                                {{ 'Rejected' }}
                                            @else
                                                {{ 'Reject' }}
                                            @endif
                                        </button>
                                    </td>

                                </tr>

                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveStudentModal{{ $student->id }}" tabindex="-1"
                                    aria-labelledby="approveStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('studentsAdmission.approve', $student->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="approveStudentModalLabel{{ $student->id }}">Approve Enrollment
                                                        for {{ $student->firstname }} {{ $student->lastname }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to approve the enrollment of
                                                        <strong>{{ $student->firstname }}
                                                            {{ $student->lastname }}</strong> in grade
                                                        <strong>{{ optional($student->grade)->gradeno }}
                                                            {{ optional($student->grade)->class_name }}</strong>?
                                                    </p>
                                                    <div class="form-group">
                                                        <label for="aptitudeScore{{ $student->id }}">Aptitude
                                                            Score</label>
                                                        <input type="number" name="aptitude_score"
                                                            id="aptitudeScore{{ $student->id }}" class="form-control"
                                                            placeholder="Enter aptitude score" required min="0"
                                                            max="100">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectStudentModal{{ $student->id }}" tabindex="-1"
                                    aria-labelledby="rejectStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('studentsAdmission.reject', $student->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="rejectStudentModalLabel{{ $student->id }}">Reject Enrollment
                                                        for {{ $student->firstname }} {{ $student->lastname }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Please provide a reason for rejecting the enrollment of
                                                        <strong>{{ $student->firstname }}
                                                            {{ $student->lastname }}</strong>:
                                                    </p>
                                                    <div class="form-group">
                                                        <label for="aptitudeScore{{ $student->id }}">Aptitude
                                                            Score</label>
                                                        <input type="number" name="aptitude_score"
                                                            id="aptitudeScore{{ $student->id }}" class="form-control"
                                                            placeholder="Enter aptitude score" required min="0"
                                                            max="100">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="rejectionReason{{ $student->id }}">Rejection
                                                            Reason</label>
                                                        <textarea name="brief_comment" id="rejectionReason{{ $student->id }}" class="form-control" rows="3"
                                                            placeholder="Enter reason here" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No student records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    {{-- New Admission Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="register-applicant" tabindex="-1" aria-labelledby="registerApplicantLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="enrollmentProcess" action="{{ route('store.enrollment.record') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerApplicantLabel">Grandview Academy Application Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card mt-4">
                            <div class="card-header">

                                <h4 class="card-title">Student Form</h4>
                            </div>
                            <div class="card-body">
                                <!-- More rows here, keeping the structure consistent with form-control-sm -->
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="term">Select Term </label>
                                        <select class="form-control form-control-sm" id="academic_term"
                                            name="academic_term" required>
                                            <option value="">--Select a term--</option>
                                            @foreach ($academicYears as $year)
                                                @foreach ($year->terms as $term)
                                                    <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                        {{ $year->academic_year }} - Term {{ $term->term_number }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ecz_no" class="small">ECZ Exam Number</label> <small
                                                class="req">
                                                *</small>
                                            <input autofocus id="ecz_no" name="ecz_no" type="number"
                                                class="form-control form-control-sm" placeholder="">
                                            <span class="text-danger small"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="firstname" class="small">First Name</label> <small
                                                class="req">
                                                *</small>
                                            <input id="firstname" name="firstname" type="text"
                                                class="form-control form-control-sm" placeholder="">
                                            <span class="text-danger small"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lastname" class="small">Last Name</label>
                                            <input id="lastname" name="lastname" type="text"
                                                class="form-control form-control-sm" placeholder="">
                                            <span class="text-danger small"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="other_name" class="small">Other Name</label>
                                            <input id="other_name" name="other_name" type="text"
                                                class="form-control form-control-sm" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="gender" class="small">Gender</label> <small class="req">
                                                *</small>
                                            <select class="form-control form-control-sm" name="gender">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dob" class="small">Date of Birth</label> <small
                                                class="req">
                                                *</small>
                                            <input id="dob" name="dob" type="date"
                                                class="form-control form-control-sm date" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nrc_id_no" class="small">NRC Or PASSPORT CARD #</label>
                                            <input id="nrc_id_no" name="nrc_id_no" type="text"
                                                class="form-control form-control-sm" placeholder="">
                                        </div>
                                    </div>
                                    <!-- Religion -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="religion" class="small">Religion</label>
                                            <input id="religion" name="religion" type="text"
                                                class="form-control form-control-sm" placeholder="Religion">
                                        </div>
                                    </div>
                                    <!-- Date of Admission -->
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="admission_date" class="small">Date of Admission</label>
                                            <input id="admission_date" name="admission_date" type="date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div> --}}
                                    <!-- Medical Condition -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="medical_condition" class="small">Medical
                                                Condition</label>
                                            <textarea id="medical_condition" name="medical_condition" class="form-control form-control-sm"
                                                placeholder="Medical Condition"></textarea>
                                        </div>
                                    </div>
                                    <!-- Sibling Names -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sibling_name" class="small">Select Sibling</label>
                                            <select id="sibling_name" class="form-control select2" name="sibling_id"
                                                style="max-width: 100%">
                                                <option value="" selected disabled>Select a sibling</option>
                                                @foreach ($allStudents as $student)
                                                    <option value="{{ $student->id }}">
                                                        {{ ucwords($student->firstname) }}
                                                        {{ ucwords($student->lastname) }}
                                                        ({{ ucfirst($student->gender) }})
                                                        -
                                                        {{ $student->grade->gradeno . ' ' . $student->grade->class_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="roll_no" class="small">Grade</label>
                                            <select id="class_id" name="class_id" class="form-control form-control-sm">
                                                <option value="">Select</option>
                                                @foreach ($grades as $grade)
                                                    <option value="{{ $grade->id }}">
                                                        {{ $grade->gradeno . ' ' . $grade->class_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="student_type" class="small">Student type</label> <small
                                                class="req">
                                                *</small>
                                            <select id="student_type" name="student_type"
                                                class="form-control form-control-sm">
                                                <option value="">Select</option>
                                                <option value='Day-Scholar'>Day scholar</option>
                                                <option value='Boarder'>Boarder</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Student Photo -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="student_photo" class="small font-weight-bold">Student
                                                Photo</label>
                                            <!-- Styled file input for image upload -->
                                            <input type="file" class="form-control-file border p-2" id="student_photo"
                                                accept="image/*" style="border-radius: 4px; cursor: pointer;"
                                                name="student_photo">
                                        </div>

                                        <!-- Image preview container with improved styling -->
                                        <div id="image_preview" class="mt-3 text-center">
                                            <img id="preview_img" src="#" alt="Student Photo"
                                                style="display:none; max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);" />

                                            <!-- Reset button -->
                                            <button id="reset_btn" class="btn btn-warning btn-sm mt-3"
                                                style="display:none;">Reset Photo</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Guardian Details Card -->
                        <div id="guardianDetailsCard" class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Guardian Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="around10">
                                        <div class="row">
                                            <!-- Guardian 1 Details -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian1_name" class="small">Guardian 1 Name</label>
                                                    <input id="guardian1_name" name="guardian1_name" type="text"
                                                        class="form-control form-control-sm" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian1_phone" class="small">Guardian 1
                                                        Phone</label>
                                                    <input id="guardian1_phone" name="guardian1_phone" type="text"
                                                        class="form-control form-control-sm" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian1_occupation" class="small">Guardian 1
                                                        Occupation</label>
                                                    <input id="guardian1_occupation" name="guardian1_occupation"
                                                        type="text" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian1_email" class="small">Guardian 1
                                                        Email</label>
                                                    <input id="guardian1_email" name="guardian1_email" type="email"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian1_gender" class="small">Gender</label>
                                                    <select id="guardian1_gender" name="guardian1_gender"
                                                        class="form-control form-control-sm">
                                                        <option value="" disabled selected>Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian1_relationship"
                                                        class="small">Relationship</label>
                                                    <select id="guardian1_relationship" name="guardian1_relationship"
                                                        class="form-control form-control-sm" required>
                                                        <option value="" disabled selected>Select Relationship
                                                        </option>
                                                        <option value="mother">Mother</option>
                                                        <option value="father">Father</option>
                                                        <option value="uncle">Uncle</option>
                                                        <option value="aunt">Aunt</option>
                                                        <option value="brother">Brother</option>
                                                        <option value="sister">Sister</option>
                                                        <option value="guardian">Guardian</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="guardian1_address" class="small">Guardian 1
                                                    Address</label>
                                                <textarea id="guardian1_address" name="guardian1_address" class="form-control form-control-sm" rows="2"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <!-- Guardian 2 Details -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian2_name" class="small">Guardian 2 Name</label>
                                                    <input id="guardian2_name" name="guardian2_name" type="text"
                                                        class="form-control form-control-sm" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian2_phone" class="small">Guardian 2
                                                        Phone</label>
                                                    <input id="guardian2_phone" name="guardian2_phone" type="text"
                                                        class="form-control form-control-sm" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian2_occupation" class="small">Guardian 2
                                                        Occupation</label>
                                                    <input id="guardian2_occupation" name="guardian2_occupation"
                                                        type="text" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian2_email" class="small">Guardian 2
                                                        Email</label>
                                                    <input id="guardian2_email" name="guardian2_email" type="email"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian2_gender" class="small">Gender</label>
                                                    <select id="guardian2_gender" name="guardian2_gender"
                                                        class="form-control form-control-sm">
                                                        <option value="" disabled selected>Select Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="guardian2_relationship"
                                                        class="small">Relationship</label>
                                                    <select id="guardian2_relationship" name="guardian2_relationship"
                                                        class="form-control form-control-sm">
                                                        <option value="" selected>Select Relationship</option>
                                                        <option value="mother">Mother</option>
                                                        <option value="father">Father</option>
                                                        <option value="uncle">Uncle</option>
                                                        <option value="aunt">Aunt</option>
                                                        <option value="brother">Brother</option>
                                                        <option value="sister">Sister</option>
                                                        <option value="guardian">Guardian</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="guardian2_address" class="small">Guardian 2
                                                    Address</label>
                                                <textarea id="guardian2_address" name="guardian2_address" class="form-control form-control-sm" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fee Details Card -->
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 card-title">Fee Details</h4>
                                <div>
                                    <button id="select-all" class="btn btn-info btn-sm mr-2">Select
                                        All</button>
                                    <button id="deselect-all" class="btn btn-secondary btn-sm">Deselect
                                        All</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row col-md-12">
                                    <ul class="list-group col-md-12">
                                        <!-- Fees Header -->
                                        <li class="list-group-item d-flex">
                                            <span class="col-md-4 font-weight-bold">Fees Type</span>
                                            <span class="col-md-2 text-center font-weight-bold">Interval</span>
                                            <span class="col-md-2 text-center font-weight-bold">Amount (ZMK)</span>
                                            <span class="col-md-2 text-right font-weight-bold">Account No</span>
                                        </li>

                                        <!-- Fee Items from the database -->
                                        @foreach ($fees as $fee)
                                            <li class="list-group-item d-flex align-items-center">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <input class="mr-2 fee-checkbox" type="checkbox"
                                                        name="fee_session_group_id[]" value="{{ $fee->id }}"
                                                        autocomplete="off">
                                                    {{ $fee->fee_type }}
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <span>{{ ucfirst($fee->fee_interval) }}</span>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <span>{{ number_format($fee->amount, 2) }}</span>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <span>{{ $fee->account_no ?? 'N/A' }}</span>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>


                        <!-- Login  details-->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Student Login Details</h4>
                            </div>
                            <div class="card-body">
                                <!-- Additional Input Fields -->
                                <div class="row">
                                    <!-- Username -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="username" class="small">Username</label>
                                            <input id="username" name="username" type="text"
                                                class="form-control form-control-sm" autocomplete="off"
                                                placeholder="Enter Username" required>
                                        </div>
                                    </div>
                                    <!-- contact number -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone_number" class="small">Phone Number</label>
                                            <input id="phone_number" name="student_phone_number" type="text"
                                                class="form-control form-control-sm" autocomplete="off"
                                                placeholder="Enter Phone Number" required>
                                        </div>
                                    </div>
                                    <!-- contact email -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email" class="small">Email</label>
                                            <input id="email" name="student_email" type="email"
                                                class="form-control form-control-sm" autocomplete="off"
                                                placeholder="Enter Email" required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>




                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success bg-gradient-success btn-md ml-auto">
                                <i class="fas fa-user-plus"></i>
                                Save enrollment data
                            </button>
                        </div>

                    </div>
                </form>


            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {


            $('#enrollmentTable').DataTable();
            // Get the form and the submit button
            const form = document.querySelector(
                '#enrollmentProcess'); // Replace 'form' with your form's ID or class if needed
            const submitButton = document.querySelector('#registerButton');

            form.addEventListener('submit', function(e) {
                // Disable the submit button and change its text
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';
            });


            function fetchGuardianDetails(siblingId) {
                if (siblingId) {
                    $.ajax({
                        url: '/students/fetch-guardian-details', // Update with the correct backend route
                        method: 'POST',
                        data: {
                            sibling_id: siblingId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Guardian 1
                            console.log(response);
                            if (response.guardian1) {
                                $('#guardian1_name').val(response.guardian1.name).prop('disabled',
                                    true);
                                $('#guardian1_phone').val(response.guardian1.contact_number).prop(
                                    'disabled', true);
                                $('#guardian1_email').val(response.guardian1.email).prop('disabled',
                                    true);
                                $('#guardian1_gender').val(response.guardian1.guardian_gender).prop(
                                    'disabled',
                                    true);

                                $('#guardian1_occupation').val(response.guardian1.occupation).prop(
                                    'disabled', true);
                                $('#guardian1_address').val(response.guardian1.address).prop('disabled',
                                    true);
                            } else {
                                $('#guardian1_name, #guardian1_phone, #guardian1_email, #guardian1_occupation, #guardian1_address')
                                    .val('')
                                    .prop('disabled', false);
                            }

                            // Guardian 2
                            if (response.guardian2) {
                                $('#guardian2_name').val(response.guardian2.name).prop('disabled',
                                    true);
                                $('#guardian2_phone').val(response.guardian2.contact_number).prop(
                                    'disabled', true);
                                $('#guardian2_email').val(response.guardian2.email).prop('disabled',
                                    true);
                                $('#guardian2_gender').val(response.guardian2.guardian_gender).prop(
                                    'disabled',
                                    true);
                                $('#guardian2_occupation').val(response.guardian2.occupation).prop(
                                    'disabled', true);
                                $('#guardian2_address').val(response.guardian2.address).prop('disabled',
                                    true);
                            } else {
                                $('#guardian2_name, #guardian2_phone, #guardian2_email, #guardian2_occupation, #guardian2_address')
                                    .val('')
                                    .prop('disabled', false);
                            }

                            // Always enable the relationship fields
                            $('#guardian1_relationship, #guardian2_relationship').prop('disabled',
                                false);

                            // Show the guardian details card
                            $('#guardianDetailsCard').slideDown();
                        },
                        error: function(xhr) {
                            console.error('Failed to fetch guardian details:', xhr.responseText);
                        }
                    });
                } else {
                    // No sibling ID selected, enable all fields
                    $('#guardian1_name, #guardian1_phone, #guardian1_email, #guardian1_occupation, #guardian1_address, #guardian1_gender')
                        .val('')
                        .prop('disabled', false);
                    $('#guardian2_name, #guardian2_phone, #guardian2_email, #guardian2_occupation, #guardian2_address, #guardian2_gender')
                        .val('')
                        .prop('disabled', false);

                    // Relationship fields remain enabled
                    $('#guardian1_relationship, #guardian2_relationship').prop('disabled', false);

                    // Optionally hide the guardian details card
                    // $('#guardianDetailsCard').slideUp();
                }
            }

            $('#sibling_name').on('change', function() {
                const siblingId = $(this).val();
                fetchGuardianDetails(siblingId);
            });
            //SEARCH ENROLLMENT BY YEAR AND TERM 
            $('#academic_term').change(function() {
                const selectedValue = $(this).val();

                if (selectedValue) {
                    const [academicYearId, termNumber] = selectedValue.split('-');

                    // Show loader
                    // $('#loader').removeClass('d-none');

                    $.ajax({
                        url: "{{ route('students.filterEnrollmentByYear') }}", // Adjust this route as necessary
                        type: "GET",
                        data: {
                            academic_year_id: academicYearId,
                            term_number: termNumber,
                        },
                        beforeSend: function() {
                            // Optional: Clear table content before loading
                            $('#enrollmentTable tbody').html('');
                        },
                        success: function(response) {
                            $('#enrollmentTable tbody').empty();
                            console.log(response);

                            if (response.students.length > 0) {
                                response.students.forEach((student, index) => {
                                    // Determine badge color based on application status
                                    let badgeColor = 'secondary';
                                    if (student.admissions[0]?.application_status) {
                                        switch (student.admissions[0]
                                            .application_status) {
                                            case 'Accepted':
                                                badgeColor = 'success';
                                                break;
                                            case 'Rejected':
                                                badgeColor = 'danger';
                                                break;
                                            case 'Pending Review':
                                                badgeColor = 'warning';
                                                break;
                                            default:
                                                badgeColor = 'secondary';
                                                break;
                                        }
                                    }

                                    // Determine approve button state and text
                                    const approveDisabled = student.admissions[0]
                                        ?.application_status === 'Accepted' ?
                                        'disabled' : '';
                                    const approveText = student.admissions[0]
                                        ?.application_status === 'Accepted' ?
                                        'Accepted' : 'Accept';

                                    // Determine reject button state and text
                                    const rejectDisabled = student.admissions[0]
                                        ?.application_status === 'Rejected' ?
                                        'disabled' : '';
                                    const rejectText = student.admissions[0]
                                        ?.application_status === 'Rejected' ?
                                        'Rejected' : 'Reject';

                                    // Generate guardians list
                                    const guardians = student.guardians
                                        .map(guardian =>
                                            `<li>${guardian.name} (${guardian.contact_number || ''})</li>`
                                            )
                                        .join('');

                                    // Determine active status badge color and text
                                    const activeBadgeColor = student.active_status ===
                                        'enrolled' ?
                                        'success' :
                                        student.active_status === 'rejected' ?
                                        'danger' :
                                        'warning';
                                    const activeBadgeText = student.active_status ?
                                        student.active_status.charAt(0).toUpperCase() +
                                        student.active_status.slice(1) :
                                        'N/A';

                                    // Build the row HTML
                                    const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${student.ecz_no || 'N/A'}</td>
                    <td>${student.firstname} ${student.lastname}</td>
                    <td>${student.admissions[0]?.admission_id || 'N/A'}</td>
                    <td>${student.admissions[0]?.admissionAppType || 'N/A'}</td>
                    <td>${student.enrolled_year} - Term ${student.enrolled_term}</td>
                    <td>${student.grade?.gradeno || 'N/A'} ${student.grade?.class_name || ''}</td>
                    <td>
                        <ul style="list-style-type: disc; margin: 0; padding-left: 20px;">
                            ${guardians}
                        </ul>
                    </td>
                    <td>${new Date(student.created_at).toLocaleDateString()}</td>
                    <td>
                        <span class="badge badge-${activeBadgeColor}">
                            ${activeBadgeText}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-${badgeColor}">
                            ${student.admissions[0]?.application_status || 'N/A'}
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" 
                            data-target="#approveStudentModal${student.id}" ${approveDisabled}>
                            ${approveText}
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" 
                            data-target="#rejectStudentModal${student.id}" ${rejectDisabled}>
                            ${rejectText}
                        </button>
                    </td>
                </tr>
            `;

                                    // Append the row to the table
                                    $('#enrollmentTable tbody').append(row);
                                });
                            } else {
                                $('#enrollmentTable tbody').html(
                                    '<tr><td colspan="10" class="text-center">No students found for the selected term.</td></tr>'
                                );
                            }
                        },


                    });
                }
            });




        });
    </script>
@endsection

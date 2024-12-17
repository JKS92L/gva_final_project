@extends('admin.admim-master')
@section('admin_content')
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-lg-6 col-md-12">
                    <h4 class="m-0 text-danger">Edit Details for:
                        <span class="text-success font-weight-bold">
                            {{ $student->firstname . ' ' . $student->lastname.' (' . $student->gender. ')'.'-' . $student->grade->gradeno.''.$student->grade->class_name ?:'N/A';}}
                        </span>
                    </h4>
                </div>
                <div class="col-lg-6 col-md-12 text-md-end text-sm-start">
                    <a href="http://127.0.0.1:8000/students/details" class="btn btn-primary btn-sm">
                        View Student List
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="section-select" class="form-label fw-semibold">Select Section to Update</label>
                        <select id="section-select" class="form-select">
                            <option value="" disabled selected>Choose a section</option>
                            <option value="general-details">Student's General Details</option>
                            <option value="hostel-details">Student Hostel Details</option>
                            <option value="guardian-details">Guardian Details</option>
                            <option value="fee-details">Fee Details</option>
                            <option value="login-details">Login Details</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- content here --}}
    <div class="container mt-4">
        <!-- Brief Tags for Stats -->
        <div class="row">
            <div class="card-body">
                <!-- This is necessary to make it a PUT request -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- student details --}}
                <form method="POST" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="generalDetails">
                    <div id="general-details" class="card mt-4" style="display: none;">
                        <div class="card-header">
                            <h4 class="card-title">Student's General Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- ECZ Exam Number -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ecz_no" class="small">ECZ Exam Number</label> <small
                                            class="req">*</small>
                                        <input id="ecz_no" name="ecz_no" type="number"
                                            class="form-control form-control-sm"
                                            value="{{ old('ecz_no', $student->ecz_no) }}" placeholder="">
                                        <span class="text-danger small"></span>
                                    </div>
                                </div>
                                <!-- First Name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="firstname" class="small">First Name</label> <small
                                            class="req">*</small>
                                        <input id="firstname" name="firstname" type="text"
                                            class="form-control form-control-sm"
                                            value="{{ old('firstname', $student->firstname) }}" placeholder="">
                                        <span class="text-danger small"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="lastname" class="small">Last Name</label>
                                        <input id="lastname" name="lastname" type="text"
                                            value="{{ old('lastname', $student->lastname) }}"
                                            class="form-control form-control-sm" placeholder="">
                                        <span class="text-danger small"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="other_name" class="small">Other Name</label>
                                        <input id="other_name" name="other_name" type="text"
                                            class="form-control form-control-sm" placeholder=""
                                            value="{{ old('other_name', $student->other_name) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gender" class="small">Gender</label> <small class="req">
                                            *</small>
                                        <select class="form-control form-control-sm" name="gender">
                                            <option value="">Select</option>
                                            <option value="male"
                                                {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                        </select>

                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="dob" class="small">Date of Birth</label> <small
                                            class="req">*</small>
                                        <input id="dob" name="dob" type="date"
                                            class="form-control form-control-sm date"
                                            value="{{ old('dob', $student->dob->format('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nrc_id_no" class="small">NRC or Passport Card #</label>
                                        <input id="nrc_id_no" name="nrc_id_no" type="text"
                                            class="form-control form-control-sm"
                                            value="{{ old('nrc_id_no', $student->nrc_id_no ?? '') }}"
                                            placeholder="Enter NRC or Passport Card #">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="admission_date" class="small">Date of Admission</label>
                                        <input id="admission_date" name="admission_date" type="date"
                                            class="form-control form-control-sm"
                                            value="{{ old('admission_date', $student->admission_date ? $student->admission_date->format('Y-m-d') : '') }}">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="medical_condition" class="small">Medical Condition</label>
                                        <textarea id="medical_condition" name="medical_condition" class="form-control form-control-sm"
                                            placeholder="Medical Condition">{{ old('medical_condition', $student->medical_condition ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="religion" class="small">Religion</label>
                                        <input id="religion" name="religion" type="text"
                                            class="form-control form-control-sm" placeholder="Religion"
                                            value="{{ old('religion', $student->religion ?? '') }}">
                                    </div>
                                </div>
                                <!-- Siblings -->
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="sibling_names" class="small">Select Siblings<small
                                                class="text-danger"> (Input Disabled)</small></label>
                                        <select id="sibling_names" class="form-control small select2"
                                            name="sibling_ids[]" multiple="multiple" style="max-width: 100%" disabled>
                                            @foreach ($students as $studentOption)
                                                <option value="{{ $studentOption->id }}"
                                                    @if (in_array($studentOption->id, $siblings)) selected @endif>
                                                    {{ $studentOption->firstname }} {{ $studentOption->lastname }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>
                                <!-- Grade/Class -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="class_id" class="small">Grade/Class</label>
                                        <select id="class_id" name="class_id" class="form-control form-control-sm">
                                            <option value="">Select</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}"
                                                    {{ old('class_id', $student->class_id) == $grade->id ? 'selected' : '' }}>
                                                    {{ $grade->gradeno . ' ' . $grade->class_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="student_type" class="small">Student Type</label> <small
                                            class="req">*</small>
                                        <select id="student_type" name="student_type"
                                            class="form-control form-control-sm">
                                            <option value="">Select</option>
                                            <option value="day-scholar"
                                                {{ old('student_type', $student->student_type ?? '') == 'Day-Scholar' ? 'selected' : '' }}>
                                                Day scholar</option>
                                            <option value="boarder"
                                                {{ old('student_type', $student->student_type ?? '') == 'Boarder' ? 'selected' : '' }}>
                                                Boarder</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Student Photo -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="student_photo" class="small font-weight-bold">Student
                                            Photo</label>
                                        <input type="file" class="form-control-file border p-2" id="student_photo"
                                            accept="image/*" name="student_photo">
                                    </div>
                                    <!-- Image Preview -->
                                    <div id="image_preview" class="mt-3 text-center">
                                        <img id="preview_img" src="{{ asset('storage/photos/' . $student->photo) }}"
                                            alt="Student Photo"
                                            style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);" />
                                        <button id="reset_btn" class="btn btn-warning btn-sm mt-3">Reset
                                            Photo</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer col-md-12">
                                <button type="submit" class="btn btn-success bg-gradient-warning btn-md col-md-12">
                                    <i class="fas fa-user-plus"></i>
                                    Update
                                </button>
                            </div>
                        </div>

                    </div>


                </form>

                <!-- Student Hostel Details Card -->
                <form method="POST" action="{{ route('students.update', $student->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="studentHostels">
                    <div id="hostel-details" class="card mt-4" style="display: none;">
                        <div class="card-header">
                            <h5>Student Hostel Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Hostel Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hostel_name" class="small">Hostel Name</label>
                                        <select class="form-control form-control-sm" id="hostel_name" name="hostel_id">
                                            <option value="">Select Hostel</option>
                                            @foreach ($hostels as $hostel)
                                                <option value="{{ $hostel->id }}"
                                                    @if ($hostel->id == $student->hostel_id) selected @endif>
                                                    {{ $hostel->hostel_name . '( ' . $hostel->hostel_gender . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <!-- Bedspace Number -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bedspaceSelect" class="small">Bedspace Number</label>
                                        <select class="form-control form-control-sm" id="bedspaceSelect"
                                            name="bedspace_id">
                                            <option value="">Select Bedspace</option>
                                            @foreach ($bedspaces as $bedspace)
                                                <option value="{{ $bedspace->id }}"
                                                    {{ $student->bedspace_id == $bedspace->id ? 'selected' : '' }}>
                                                    {{ $bedspace->bedspace_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Hostel Supervisor -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hostel_supervisor" class="small">Hostel Teacher</label>
                                        <input id="hostel_supervisor" name="hostel_teacher_id" type="text"
                                            class="form-control form-control-sm" placeholder="Mr. SIR..."
                                            value="{{ $student->hostel->supervisor ?? '' }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer col-md-12">
                                <button type="submit" class="btn btn-success bg-gradient-warning btn-md col-md-12">
                                    <i class="fas fa-user-plus"></i>
                                    Update
                                </button>
                            </div>
                        </div>

                    </div>


                </form>
                <!-- Guardian Details Card -->
                <form method="POST" action="{{ route('students.update', $student->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="studentGuardian">
                    <div id="guardian-details" class="card mt-4" style="display: none;">
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
                                                    class="form-control form-control-sm" autocomplete="off"
                                                    value="{{ old('name', $guardian1['name'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian1_phone" class="small">Guardian 1 Phone</label>
                                                <input id="guardian1_phone" name="guardian1_phone" type="text"
                                                    class="form-control form-control-sm" autocomplete="off"
                                                    value="{{ old('guardian1_phone', $guardian1['contact_number'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian1_occupation" class="small">Guardian 1
                                                    Occupation</label>
                                                <input id="guardian1_occupation" name="guardian1_occupation"
                                                    type="text" class="form-control form-control-sm"
                                                    value="{{ old('guardian1_occupation', $guardian1['occupation'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian1_email" class="small">Guardian 1 Email</label>
                                                <input id="guardian1_email" name="guardian1_email" type="email"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('guardian1_email', $guardian1['email'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian1_gender" class="small">Guardian 1 Gender</label>
                                                <select id="guardian1_gender" name="guardian1_gender"
                                                    class="form-control form-control-sm">
                                                    <option value="" disabled selected>Select Gender</option>
                                                    <option value="male"
                                                        {{ old('guardian1_gender', $guardian1['guardian_gender'] ?? '') === 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('guardian1_gender', $guardian1['guardian_gender'] ?? '') === 'female' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian1_relationship" class="small">Relationship</label>
                                                <select id="guardian1_relationship" name="guardian1_relationship"
                                                    class="form-control form-control-sm">
                                                    <option value="" disabled selected>Select Relationship</option>
                                                    <option value="mother"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'mother' ? 'selected' : '' }}>
                                                        Mother</option>
                                                    <option value="father"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'father' ? 'selected' : '' }}>
                                                        Father</option>
                                                    <option value="uncle"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'uncle' ? 'selected' : '' }}>
                                                        Uncle</option>
                                                    <option value="aunt"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'aunt' ? 'selected' : '' }}>
                                                        Aunt</option>

                                                    <option value="brother"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'brother' ? 'selected' : '' }}>
                                                        Brother</option>
                                                    <option value="sister"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'sister' ? 'selected' : '' }}>
                                                        Sister</option>
                                                    <option value="guardian"
                                                        {{ old('guardian1_relationship', $guardian1['relationship'] ?? '') == 'guardian' ? 'selected' : '' }}>
                                                        Guardian</option>
                                                    <option value="other"
                                                        {{ old('guardian1_relationship', $guardian2['relationship'] ?? '') == 'other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="guardian1_address" class="small">Guardian 1 Address</label>
                                            <textarea id="guardian1_address" name="guardian1_address" class="form-control form-control-sm" rows="2">{{ old('guardian1_address', $guardian1['address'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <!-- Guardian 2 Details -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian2_name" class="small">Guardian 2 Name</label>
                                                <input id="guardian2_name" name="guardian2_name" type="text"
                                                    class="form-control form-control-sm" autocomplete="off"
                                                    value="{{ old('guardian2_name', $guardian2['name'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian2_phone" class="small">Guardian 2 Phone</label>
                                                <input id="guardian2_phone" name="guardian2_phone" type="text"
                                                    class="form-control form-control-sm" autocomplete="off"
                                                    value="{{ old('guardian2_phone', $guardian2['contact_number'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian2_occupation" class="small">Guardian 2
                                                    Occupation</label>
                                                <input id="guardian2_occupation" name="guardian2_occupation"
                                                    type="text" class="form-control form-control-sm"
                                                    value="{{ old('guardian2_occupation', $guardian2['occupation'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian2_email" class="small">Guardian 2 Email</label>
                                                <input id="guardian2_email" name="guardian2_email" type="email"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('guardian2_email', $guardian2['email'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="guardian2_gender" class="small">Guardian 1 Gender</label>
                                                <select id="guardian2_gender" name="guardian2_gender"
                                                    class="form-control form-control-sm">
                                                    <option value="" disabled selected>Select Gender</option>
                                                    <option value="male"
                                                        {{ old('guardian2_gender', $guardian1['guardian_gender'] ?? '') === 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('guardian2_gender', $guardian1['guardian_gender'] ?? '') === 'female' ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="guardian2_relationship" class="small">Relationship</label>
                                            <select id="guardian2_relationship" name="guardian2_relationship"
                                                class="form-control form-control-sm">
                                                <option value="" disabled selected>Select Relationship</option>
                                                <option value="mother"
                                                    {{ old('guardian2_relationship', $guardian2['relationship'] ?? '') == 'mother' ? 'selected' : '' }}>
                                                    Mother</option>
                                                <option value="father"
                                                    {{ old('guardian2_relationship', $guardian2['relationship'] ?? '') == 'father' ? 'selected' : '' }}>
                                                    Father</option>
                                                <option value="uncle"
                                                    {{ old('guardian2_relationship', $guardian2['relationship'] ?? '') == 'uncle' ? 'selected' : '' }}>
                                                    Uncle</option>
                                                <option value="aunt"
                                                    {{ old('guardian2_relationship', $guardian2['relationship'] ?? '') == 'aunt' ? 'selected' : '' }}>
                                                    Aunt</option>
                                                <option value="brother"
                                                    {{ old('guardian2_relationship', $guardian1['relationship'] ?? '') == 'brother' ? 'selected' : '' }}>
                                                    Brother</option>
                                                <option value="sister"
                                                    {{ old('guardian2_relationship', $guardian1['relationship'] ?? '') == 'sister' ? 'selected' : '' }}>
                                                    Sister</option>
                                                <option value="guardian"
                                                    {{ old('guardian2_relationship', $guardian2['relationship'] ?? '') == 'guardian' ? 'selected' : '' }}>
                                                    Guardian</option>
                                                <option value="other"
                                                    {{ old('guardian2_relationship', $guardian2['relationship'] ?? '') == 'other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <label for="guardian2_address" class="small">Guardian 2 Address</label>
                                        <textarea id="guardian2_address" name="guardian2_address" class="form-control form-control-sm" rows="2">{{ old('guardian2_address', $guardian2['address'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer col-md-12">
                            <button type="submit" class="btn btn-success bg-gradient-warning btn-md col-md-12">
                                <i class="fas fa-user-plus"></i>
                                Update
                            </button>
                        </div>

                    </div>
                </form>





                <!-- Fee Details Card -->
                <form method="POST" action="{{ route('students.update', $student->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="studentFees">
                    <div id="fee-details" class="card mt-4" style="display: none;">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 card-title">Fee Details</h4>

                        </div>

                        <div class="card-body">

                            <div class="row">
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
                                                <input type="checkbox" name="fee_session_group_id[]"
                                                    class="mr-2 fee-checkbox" value="{{ $fee->id }}"
                                                    autocomplete="off"
                                                    {{ $student->studentfee->contains('fee_id', $fee->id) ? 'checked' : '' }}>
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
                            <div class="card-footer col-md-12">
                                <button type="submit" class="btn btn-success bg-gradient-warning btn-md col-md-12">
                                    <i class="fas fa-user-plus"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>


                </form>
                <!-- Login Details -->
                <form method="POST" action="{{ route('students.update', $student->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="studentLoginDetails">
                    <div id="login-details" class="card mt-4" style="display: none;">
                        <div class="card-header">
                            <h5>Login Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username" class="small">Username</label>
                                        <input id="username" name="username" type="text"
                                            class="form-control form-control-sm" autocomplete="off"
                                            placeholder="Enter Username" required
                                            value="{{ old('username', $student->user->username ?? '') }}">
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone_number" class="small">Phone Number</label>
                                        <input id="phone_number" name="student_phone_number" type="text"
                                            class="form-control form-control-sm" autocomplete="off"
                                            placeholder="Enter Phone Number" required
                                            value="{{ old('student_phone_number', $student->user->contact_number ?? '') }}">
                                    </div>
                                </div>

                                <!-- Contact Email -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class="small">Email</label>
                                        <input id="email" name="student_email" type="email"
                                            class="form-control form-control-sm" autocomplete="off"
                                            placeholder="Enter Email" required
                                            value="{{ old('student_email', $student->user->email ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer col-md-12">
                                <button type="submit" class="btn btn-success bg-gradient-warning btn-md col-md-12">
                                    <i class="fas fa-user-plus"></i>
                                    Update
                                </button>
                            </div>

                        </div>
                    </div>


                </form>
            </div>




        </div>
    </div>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            //hide and uhide the sections
            $('#section-select').on('change', function() {
                const selectedSection = $(this).val(); // Get the selected value

                // Hide all cards
                $('.card').not(':first').slideUp();

                // Show the selected card with a smooth transition
                if (selectedSection) {
                    $(`#${selectedSection}`).slideDown();
                }
            });

            // Select All button functionality
            $('#select-all').on('click', function() {
                $('.card').not(':first').slideDown();
                $('#section-select').val(''); // Reset the dropdown
            });

            // Deselect All button functionality
            $('#deselect-all').on('click', function() {
                $('.card').not(':first').slideUp();
                $('#section-select').val(''); // Reset the dropdown
            });



            // alert('Jquery Loaded');
            $("#hostel_name").on("change", function() {
                // alert('Script running 2');
                var hostelId = $(this).val();

                if (hostelId) {
                    $.ajax({
                        url: "{{ route('fetch.bedspaces') }}", // Correct route for fetching bedspaces
                        type: "GET",
                        data: {
                            hostel_id: hostelId,
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                $("#bedspaceSelect").empty(); // Clear previous options
                                $("#bedspaceSelect").append(
                                    '<option value="">Select bedspace no</option>'
                                );

                                // Populate bedspaces dynamically
                                $.each(response.bedspaces, function(key, bedspace) {
                                    $("#bedspaceSelect").append(
                                        '<option value="' +
                                        bedspace.id +
                                        '">' +
                                        bedspace.bedspace_no +
                                        "</option>"
                                    );
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log("Error fetching bedspaces:", xhr.responseText);
                        },
                    });
                } else {
                    // If no hostel is selected, clear the bedspace dropdown
                    $("#bedspaceSelect").empty();
                    $("#bedspaceSelect").append(
                        '<option value="">Select bedspace no</option>'
                    );
                }
            });



            // Fees multi-selection
            const selectAllButton = document.getElementById('select-all');
            const deselectAllButton = document.getElementById('deselect-all');
            const checkboxes = document.querySelectorAll('.fee-checkbox');

            // Select all checkboxes
            selectAllButton.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
            });

            // Deselect all checkboxes
            deselectAllButton.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });


            // Set the input's value to the current date
            // document.getElementById('admission_date').value = new Date().toISOString().split('T')[0];


            // Handle image preview and reset functionality
            document.getElementById('student_photo').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const previewImg = document.getElementById('preview_img');
                const resetBtn = document.getElementById('reset_btn');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block'; // Show the preview
                        resetBtn.style.display = 'block'; // Show the reset button
                    };
                    reader.readAsDataURL(file); // Convert the file to a data URL for preview
                } else {
                    previewImg.style.display = 'none'; // Hide the preview if no file is selected
                    resetBtn.style.display = 'none'; // Hide the reset button
                }
            });

            // Reset button functionality
            document.getElementById('reset_btn').addEventListener('click', function() {
                const previewImg = document.getElementById('preview_img');
                const resetBtn = document.getElementById('reset_btn');
                const studentPhotoInput = document.getElementById('student_photo');

                studentPhotoInput.value = ''; // Clear the file input
                previewImg.style.display = 'none'; // Hide the preview
                resetBtn.style.display = 'none'; // Hide the reset button
            });






        });
    </script>
@endsection

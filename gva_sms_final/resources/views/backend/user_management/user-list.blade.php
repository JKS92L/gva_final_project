@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users List</h1>
                </div><!-- /.col -->
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div><!-- /.col --> --}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- The large modal -->
            <!-- Button to trigger modal -->


            <!-- Modal for adding a new teacher -->
            <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <!-- Personal Information -->
                                <h6 class="text-primary">Personal Information</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="firstName">First Name</label>
                                        <input type="text" class="form-control form-control-sm" id="firstName"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="middleName">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm" id="middleName"
                                            placeholder="Middle Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" id="lastName"
                                            placeholder="Last Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender</label>
                                        <select class="form-control form-control-sm" id="gender" required>
                                            <option selected disabled>Choose...</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" class="form-control form-control-sm" id="dob" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control form-control-sm" id="email"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="phoneNumber">Phone Number</label>
                                        <input type="tel" class="form-control form-control-sm" id="phoneNumber"
                                            placeholder="Phone Number" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control form-control-sm" id="address"
                                            placeholder="Address" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="province">Province</label>
                                        <input type="text" class="form-control form-control-sm" id="province"
                                            placeholder="province" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="town">Town</label>
                                        <input type="text" class="form-control form-control-sm" id="town"
                                            placeholder="town" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="country">Citizenship</label>
                                        <input type="text" class="form-control form-control-sm" id="country"
                                            placeholder="Country" required>
                                    </div>
                                </div>

                                <!-- Employment Information -->
                                <h6 class="text-primary">Employment Information</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="employeeId">Employee ID</label>
                                        <input type="text" class="form-control form-control-sm" id="employeeId"
                                            placeholder="Employee ID" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="hireDate">Date of Hire</label>
                                        <input type="date" class="form-control form-control-sm" id="hireDate"
                                            required>
                                    </div>
                                    {{-- <div class="form-group col-md-4">
                                        <label for="subject">Subject</label>
                                        <input type="text" class="form-control form-control-sm" id="subject"
                                            placeholder="Subject" required>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value="">Select a department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="form-group col-md-4">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control form-control-sm" id="position"
                                            placeholder="Position" required>
                                    </div> --}}
                                    <div class="form-group col-md-4">
                                        <label for="yearsExperience">Years of Experience</label>
                                        <input type="number" class="form-control form-control-sm" id="yearsExperience"
                                            placeholder="Years of Experience" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="qualifications">Qualifications</label>
                                        <input type="text" class="form-control form-control-sm" id="qualifications"
                                            placeholder="Qualifications" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="certifications">Certifications</label>
                                        <input type="text" class="form-control form-control-sm" id="certifications"
                                            placeholder="Certifications">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="classAssigned">Class Assigned</label>
                                        <input type="text" class="form-control form-control-sm" id="classAssigned"
                                            placeholder="Class Assigned">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="schoolBranch">School Branch</label>
                                        <input type="text" class="form-control form-control-sm" id="schoolBranch"
                                            placeholder="School Branch" required>
                                    </div>
                                </div>

                                <!-- System Information -->
                                <h6 class="text-primary">System Information</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control form-control-sm" id="username"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control form-control-sm" id="password"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="role">Role</label>
                                        <select class="form-control form-control-sm" id="role" required>
                                            <option selected disabled>Choose...</option>
                                            <option>Admin</option>
                                            <option>Teacher</option>
                                            <option>Class Teacher</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="status">Status</label>
                                        <select class="form-control form-control-sm" id="status" required>
                                            <option selected disabled>Choose...</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Emergency Contact Information -->
                                <h6 class="text-primary">Emergency Contact Information</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="emergencyContactName">Emergency Contact Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="emergencyContactName" placeholder="Contact Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="emergencyContactRelation">Relationship</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="emergencyContactRelation" placeholder="Relationship" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="emergencyContactPhone">Emergency Contact Phone</label>
                                        <input type="tel" class="form-control form-control-sm"
                                            id="emergencyContactPhone" placeholder="Phone Number" required>
                                    </div>
                                </div>

                                <!-- Other Information -->
                                <h6 class="text-primary">Other Information</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="nationalId">National ID</label>
                                        <input type="text" class="form-control form-control-sm" id="nationalId"
                                            placeholder="National ID" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="bankAccountNumber">Bank Account Number</label>
                                        <input type="text" class="form-control form-control-sm" id="bankAccountNumber"
                                            placeholder="Bank Account Number" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="workingDays">Working Days</label>
                                        <input type="text" class="form-control form-control-sm" id="workingDays"
                                            placeholder="e.g., Mon-Fri" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="workingHoursStart">Working Hours Start</label>
                                        <input type="time" class="form-control form-control-sm" id="workingHoursStart"
                                            required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="workingHoursEnd">Working Hours End</label>
                                        <input type="time" class="form-control form-control-sm" id="workingHoursEnd"
                                            required>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Save Teacher</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- add new student modal --}}
            <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog"
                aria-labelledby="addStudentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <div class="card">
                                    <div class="card-header">

                                        <h4 class="card-title">Student Form</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ecz_no" class="small">ECZ Exam Number</label> <small
                                                        class="req">
                                                        *</small>
                                                    <input autofocus id="ecz_no" name="ecz_no" type="number"
                                                        class="form-control form-control-sm" placeholder="">
                                                    <span class="text-danger small"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="roll_no" class="small">Grade/Class</label>
                                                    <select id="class_id" name="class_id"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        @foreach ($grades as $grade)
                                                            <option value="{{ $grade->id }}">
                                                                {{ $grade->gradeno . ' ' . $grade->class_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="class_id" class="small">Class</label> <small
                                                        class="req"> *</small>
                                                    <select id="class_id" name="class_id"
                                                        class="form-control form-control-sm">
                                                        <option value="">Class</option>
                                                        <option value="1">NS</option>
                                                        <option value="2">BS</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="section_id" class="small">Student type</label> <small
                                                        class="req"> *</small>
                                                    <select id="section_id" name="section_id"
                                                        class="form-control form-control-sm">
                                                        <option value="">Select</option>
                                                        <option value="">Day scholar</option>
                                                        <option value="">Boarder</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- More rows here, keeping the structure consistent with form-control-sm -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="firstname" class="small">First Name</label> <small
                                                        class="req"> *</small>
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
                                                    <label for="gender" class="small">Gender</label> <small
                                                        class="req"> *</small>
                                                    <select class="form-control form-control-sm" name="gender">
                                                        <option value="">Select</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="admission_date" class="small">Date of Admission</label>
                                                    <input id="admission_date" name="admission_date" type="date"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <!-- Medical Condition -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="medical_condition" class="small">Medical
                                                        Condition</label>
                                                    <textarea id="medical_condition" name="medical_condition" class="form-control form-control-sm"
                                                        placeholder="Medical Condition"></textarea>
                                                </div>
                                            </div>
                                            <!-- Student Photo -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="student_photo" class="small">Student Photo</label>
                                                    <form action="/upload" class="dropzone" id="studentPhotoDropzone">
                                                        <div class="dz-message">
                                                            <h5>Drag & Drop to Upload or Click</h5>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="image_preview" class="mt-2">
                                                    <!-- The reset button will appear here after upload -->
                                                    <button id="reset_btn" class="btn btn-warning btn-sm mt-2"
                                                        style="display:none;">Reset
                                                        Photo</button>
                                                </div>
                                            </div>


                                            <!-- Add Sibling Button -->

                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#addSiblingModal">
                                                    Add Sibling
                                                </button>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                                <!-- Student Hostel Details Card -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Student Hostel Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Hostel Name -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hostel_name" class="small">Hostel Name</label>
                                                    <select class="form-control form-control-sm" id="hostel_name"
                                                        name="hostel_name">
                                                        <option value="">Select Hostel</option>
                                                        @foreach ($hostels as $hostel)
                                                            <option value="{{ $hostel->hostel_id }}">
                                                                {{ $hostel->hostel_name . '( ' . $hostel->hostel_gender . ' )' }}
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
                                                        name="bedspaceSelect">
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Hostel Supervisor -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hostel_supervisor" class="small">Hostel Teacher</label>
                                                    <input id="hostel_supervisor" name="hostel_supervisor" type="text"
                                                        class="form-control form-control-sm" placeholder="Mr. SIR..."
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Guadian Details Card -->
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5>Parent/Guardin Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="around10">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="small">Father
                                                                Name</label>
                                                            <input id="father_name" name="father_name" placeholder=""
                                                                type="text" class="form-control form-control-sm"
                                                                autocomplete="off">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Father
                                                                Phone</label>
                                                            <input id="father_phone" name="father_phone" placeholder=""
                                                                type="text" class="form-control form-control-sm"
                                                                autocomplete="off">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Father
                                                                Occupation</label>
                                                            <input id="father_occupation" name="father_occupation"
                                                                placeholder="" type="text"
                                                                class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Father
                                                                Phone</label><small class="req">
                                                                *</small>
                                                            <input id="father_phone" name="father_phone" placeholder=""
                                                                type="number" class="form-control form-control-sm">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Father
                                                                Phone</label>
                                                            <input id="father_email" name="father_email" placeholder=""
                                                                type="text" class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label for="exampleInputEmail1"class="small">Father Address</label>
                                                        <textarea id="father_address" name="father_address" placeholder="" class="form-control form-control-sm"
                                                            rows="2"></textarea>

                                                    </div>
                                                    <br class="text-danger" style="width: 100%">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Mother
                                                                Name</label>
                                                            <input id="mother_name" name="mother_name" placeholder=""
                                                                type="text" class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Mother
                                                                Phone</label>
                                                            <input id="mother_phone" name="mother_phone" placeholder=""
                                                                type="text" class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Mother
                                                                Occupation</label>
                                                            <input id="mother_occupation" name="mother_occupation"
                                                                placeholder="" type="text"
                                                                class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Mother
                                                                Phone</label><small class="req">
                                                                *</small>
                                                            <input id="mother_phone" name="mother_phone" placeholder=""
                                                                type="number" class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1"class="small">Mother's
                                                                Email</label>
                                                            <input id="mother_email" name="mother_email" placeholder=""
                                                                type="text" class="form-control form-control-sm">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label for="exampleInputEmail1"class="small">Mother's
                                                            Address</label>
                                                        <textarea id="mather_address" name="mather_address" placeholder="" class="form-control form-control-sm"
                                                            rows="2"></textarea>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Fee Details Card -->
                                <div class="card mt-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Fee Details</h5>
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
                                        <h5>Login details</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Additional Input Fields -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email" class="small">Email</label>
                                                    <input id="email" name="email" type="email"
                                                        class="form-control form-control-sm" autocomplete="off"
                                                        placeholder="Enter Email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="phone_number" class="small">Phone Number</label>
                                                    <input id="phone_number" name="phone_number" type="text"
                                                        class="form-control form-control-sm" autocomplete="off"
                                                        placeholder="Enter Phone Number" required>
                                                </div>
                                            </div>
                                            <!-- Username -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="username" class="small">Username</label>
                                                    <input id="username" name="username" type="text"
                                                        class="form-control form-control-sm" autocomplete="off"
                                                        placeholder="Enter Username" required>
                                                </div>
                                            </div>
                                            <!-- Password -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="password" class="small">Password</label>
                                                    <input id="password" name="password" type="password"
                                                        class="form-control form-control-sm" autocomplete="off"
                                                        placeholder="Enter Password" required>
                                                </div>
                                            </div>
                                            <!-- Confirm Password -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="confirm_password" class="small">Confirm Password</label>
                                                    <input id="confirm_password" name="confirm_password" type="password"
                                                        class="form-control form-control-sm" autocomplete="off"
                                                        placeholder="Confirm Password" required>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="card-footer d-flex">
                                    <button type="submit" class="btn btn-success bg-gradient-success btn-md ml-auto">
                                        <i class="fas fa-user-plus"></i>
                                        Register
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-all-staff-tab" data-toggle="pill"
                                        href="#custom-tabs-all-staff" role="tab"
                                        aria-controls="custom-tabs-all-staff" aria-selected="true">Staff</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-all-parents-tab" data-toggle="pill"
                                        href="#custom-tabs-all-parents" role="tab"
                                        aria-controls="custom-tabs-all-parents" aria-selected="false">Parents</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-pupils-tab" data-toggle="pill"
                                        href="#custom-tabs-pupils" role="tab" aria-controls="custom-tabs-pupils"
                                        aria-selected="false">Pupils</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-all-system-users-tab" data-toggle="pill"
                                        href="#custom-tabs-all-system-users" role="tab"
                                        aria-controls="custom-tabs-all-system-users" aria-selected="false">System
                                        users</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">

                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="tab-pane fade show active" id="custom-tabs-all-staff" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-all-staff-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h1 class="card-title">Staff List</h1>
                                                {{-- <div class="row">
                                                    <div class="card-tools col-sm-12 text-right p-4">
                                                       
                                                    </div>
                                                </div> --}}
                                                <button type="button"
                                                    class="btn btn-primary btn-sm card-tools ext-right p-2"
                                                    data-toggle="modal" data-target="#addTeacherModal">
                                                    <i class="fas fa-user-plus"></i> Add New Teacher
                                                </button>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">

                                                <table class="table table-hover text-nowrap" id="allStaffTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID <i class="fas fa-sort"> </th>
                                                            <th>Name<i class="fas fa-sort"></th>
                                                            <th>Position<i class="fas fa-sort"></th>
                                                            <th>Department<i class="fas fa-sort"></th>
                                                            <th>Email<i class="fas fa-sort"></th>
                                                            <th>Phone<i class="fas fa-sort"></th>
                                                            <th>Status<i class="fas fa-sort"></th>
                                                            <th>Date Joined<i class="fas fa-sort"></th>
                                                            <th>Last Login<i class="fas fa-sort"></th>
                                                            <th>Actions<i class="fas fa-sort"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>101</td>
                                                            <td>Jane Smith</td>
                                                            <td>Teacher</td>
                                                            <td>Mathematics</td>
                                                            <td>jane.smith@example.com</td>
                                                            <td>(555) 987-6543</td>
                                                            <td>Active</td>
                                                            <td>2022-08-22</td>
                                                            <td>2023-09-01 07:30 AM</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                {{-- parents/guardian list --}}
                                <div class="tab-pane fade" id="custom-tabs-all-parents" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-all-parents-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <!-- /.card-header -->
                                            <div class="card-header">
                                                <h1 class="card-title">Parents List</h1>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm card-tools ext-right p-2"
                                                    data-toggle="modal" data-target="#addParentModal">
                                                    <i class="fas fa-user-plus"></i> Add new parent
                                                </button>
                                            </div>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap" id="allParentsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID<i class="fas fa-sort"> </th>
                                                            <th>Name<i class="fas fa-sort"> </th>
                                                            <th>Child's Name<i class="fas fa-sort"> </th>
                                                            <th>Phone<i class="fas fa-sort"> </th>
                                                            <th>Email<i class="fas fa-sort"> </th>
                                                            <th>Status<i class="fas fa-sort"> </th>
                                                            <th>Date Registered<i class="fas fa-sort"> </th>
                                                            <th>Actions<i class="fas fa-sort"> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>301</td>
                                                            <td>Michael Johnson</td>
                                                            <td>Emily Johnson</td>
                                                            <td>(555) 765-4321</td>
                                                            <td>michael.johnson@example.com</td>
                                                            <td>Active</td>
                                                            <td>2023-03-10</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-pupils" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-pupils-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h1 class="card-title">Students List</h1>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm card-tools ext-right p-2"
                                                    data-toggle="modal" data-target="#addStudentModal">
                                                    <i class="fas fa-user-plus"></i> Add new student
                                                </button>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <div id="allUsersTable_wrapper" class="dataTables_wrapper no-footer">
                                                    <!-- DataTable -->
                                                    <table class="table table-hover text-nowrap dataTable no-footer"
                                                        id="pupilsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>ID<i class="fas fa-sort"> </th>
                                                                <th>Exam #<i class="fas fa-sort"> </th>
                                                                <th>Name<i class="fas fa-sort"> </th>
                                                                <th>Gender<i class="fas fa-sort"> </th>
                                                                <th>Grade/Class<i class="fas fa-sort"> </th>
                                                                <th>Student type<i class="fas fa-sort"> </th>
                                                                <th>Parent/Guardian<i class="fas fa-sort"> </th>
                                                                <th>Date of Birth<i class="fas fa-sort"> </th>
                                                                <th>Status<i class="fas fa-sort"> </th>
                                                                <th>Date Enrolled<i class="fas fa-sort"> </th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>501</td>
                                                                <td>2345309788808</td>
                                                                <td>Emily Johnson</td>
                                                                <td>Girl</td>
                                                                <td>G12-A</td>
                                                                <td>Boarder</td>
                                                                <td>Michael Johnson</td>
                                                                <td>2013-05-17</td>
                                                                <td>Active</td>
                                                                <td>2023-01-05</td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary">View</button>
                                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>502</td>
                                                                <td>2345309788809</td>
                                                                <td>John Doe</td>
                                                                <td>Boy</td>
                                                                <td>G11-B</td>
                                                                <td>Day</td>
                                                                <td>Jane Doe</td>
                                                                <td>2014-06-22</td>
                                                                <td>Active</td>
                                                                <td>2022-09-01</td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary">View</button>
                                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>503</td>
                                                                <td>2345309788810</td>
                                                                <td>Mary Smith</td>
                                                                <td>Girl</td>
                                                                <td>G10-C</td>
                                                                <td>Boarder</td>
                                                                <td>Robert Smith</td>
                                                                <td>2015-07-30</td>
                                                                <td>Inactive</td>
                                                                <td>2021-11-15</td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary">View</button>
                                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>504</td>
                                                                <td>2345309788811</td>
                                                                <td>James Brown</td>
                                                                <td>Boy</td>
                                                                <td>G9-D</td>
                                                                <td>Day</td>
                                                                <td>Linda Brown</td>
                                                                <td>2016-08-15</td>
                                                                <td>Active</td>
                                                                <td>2022-03-25</td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary">View</button>
                                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                                </td>
                                                            </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-all-system-users" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-all-system-users-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">System list</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap" id="systemUsersTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Username</th>
                                                            <th>Role Name</th>
                                                            <th>Gender</th>
                                                            <th>Email</th>
                                                            <th>Contact</th>
                                                            <th>Date Assigned</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>john_doe</td>
                                                            <td>Administrator</td>
                                                            <td>Male</td>
                                                            <td>john.doe@example.com</td>
                                                            <td>(555) 123-4567</td>
                                                            <td>2024-09-01</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>jane_smith</td>
                                                            <td>Teacher</td>
                                                            <td>Female</td>
                                                            <td>jane.smith@example.com</td>
                                                            <td>(555) 987-6543</td>
                                                            <td>2024-09-02</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>alice_jones</td>
                                                            <td>Student</td>
                                                            <td>Female</td>
                                                            <td>alice.jones@example.com</td>
                                                            <td>(555) 321-7654</td>
                                                            <td>2024-09-03</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </div>



            {{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}
            {{-- <link rel="stylesheet" href="/css/custom_datatables.css"> --}}
        </div>
    </div>

    <script>
     
    </script>
@endsection

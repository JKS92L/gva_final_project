@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Teachers List</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('teachers.list') }}" type="button"
                            class="btn btn-success card-tools ext-right btn-sm">
                            <i class="fas fa-list"></i> View Teachers List
                        </a>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="container mt-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>

            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <!-- Personal Information -->
                <h6 class="text-primary">Personal Information</h6>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control form-control-sm" id="firstName" placeholder="First Name"
                            name="firstname" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="middleName">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" id="middleName" placeholder="Middle Name"
                            name="middleName">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control form-control-sm" id="lastName" placeholder="Last Name"
                            name="lastname" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="gender">Gender</label>
                        <select class="form-control form-control-sm" id="gender" name="gender" required>
                            <option selected disabled>Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control form-control-sm" id="dob" name="dob" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" placeholder="Email"
                            name="email" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="tel" class="form-control form-control-sm" id="phoneNumber"
                            placeholder="Phone Number" name="phoneNumber" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control form-control-sm" id="address" placeholder="Address"
                            name="address" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="province">Province</label>
                        <input type="text" class="form-control form-control-sm" id="province" placeholder="Province"
                            name="province" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="town">Town</label>
                        <input type="text" class="form-control form-control-sm" id="town" placeholder="Town"
                            name="town" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="country">Citizenship</label>
                        <input type="text" class="form-control form-control-sm" id="country" placeholder="Country"
                            name="country" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="nationalId">National ID</label>
                        <input type="text" class="form-control form-control-sm" id="national_id"
                            placeholder="N.R.C #" name="national_id" required>
                    </div>
                </div>

                <!-- Employment Information -->
                <h6 class="text-primary">Employment Information</h6>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="bankAccountNo">Bank Account #</label>
                        <input type="number" class="form-control form-control-sm" id="bankAccountNo"
                            name="bankAccountNo" placeholder="Bank Account" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="bankName">Bank Name</label>
                        <input type="text" class="form-control form-control-sm" id="bankName" name="bankName"
                            placeholder="Bank Name" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="employeeId">Employee ID</label>
                        <input type="text" class="form-control form-control-sm" id="employeeId"
                            placeholder="Employee ID" name="employeeId" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="hireDate">Date of Hire</label>
                        <input type="date" class="form-control form-control-sm" id="hireDate" name="hireDate"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="department">Department</label>
                        <select name="department" id="department" class="form-control form-control-sm">
                            <option value="">Select a department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="yearsExperience">Years of Experience</label>
                        <input type="number" class="form-control form-control-sm" id="yearsExperience"
                            name="yearsExperience" placeholder="Years of Experience" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="qualifications">Qualifications</label>
                        <input type="text" class="form-control form-control-sm" id="qualifications"
                            name="qualifications" placeholder="Qualifications" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="certifications">Certifications</label>
                        <input type="text" class="form-control form-control-sm" id="certifications"
                            name="certifications" placeholder="Certifications">
                    </div>

                    <!-- Grouped inputs for Major and Minor Subjects -->
                    <div class="form-group col-md-3">
                        <label for="major_subject" class="form-label">Major Subject(s)</label>
                        <select id="major_subject" name="major_subjects[]"
                            class="form-control form-control-sm subjectSelect" multiple="multiple">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->short_code.' ( CODE:'.$subject->subject_code.' )- '. ucfirst($subject->section) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="minor_subject" class="form-label">Minor Subject(s)</label>
                        <select id="minor_subject" name="minor_subjects[]"
                            class="form-control form-control-sm subjectSelect" multiple="multiple">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{$subject->short_code.' ( CODE:'.$subject->subject_code.' )- '. ucfirst($subject->section) }}</option>
                            @endforeach
                        </select>
                    </div>


                    
                    <div class="form-group col-md-3">
                        <label for="workingDaysCount">Number of Working Days</label>
                        <input type="number" id="workingDaysCount" name="working_days_count"
                            class="form-control form-control-sm " min="1" max="7"
                            placeholder="Enter number of working days">
                        <small class="form-text text-muted">Enter the number of working days (1-7).</small>
                    </div>

                    <!-- Working Time Start -->
                    <div class="form-group col-md-3">
                        <label for="workingStart ">Working Time Start</label>
                        <input type="time" id="workingStart" name="working_time_start"
                            class="form-control form-control-sm ">
                    </div>

                    <!-- Working Time End -->
                    <div class="form-group col-md-3">
                        <label for="workingEnd">Working Time End</label>
                        <input type="time" id="workingEnd" name="working_time_end"
                            class="form-control form-control-sm ">
                    </div>
                </div>

                <!-- System Information -->
                <h6 class="text-primary">System Information</h6>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="username">Username</label>
                        <input type="text" class="form-control form-control-sm" id="username" placeholder="Username"
                            name="username" required>
                    </div>
                    {{-- <div class="form-group col-md-4">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control form-control-sm" id="password"
                                                placeholder="Password" name="password" required>
                                        </div> --}}
                    <div class="form-group col-md-4">
                        <label for="role">Role</label>
                        <select class="form-control form-control-sm" id="role" name="role_id" required>
                            <option selected disabled>--Select roles--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="status">Status</label>
                        <select class="form-control form-control-sm" id="status" name="status" required>
                            <option selected disabled>Choose...</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Emergency Contact Information -->
                <h6 class="text-primary">Emergency Contact Information</h6>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="emergencyContactName">Emergency Contact Name</label>
                        <input type="text" class="form-control form-control-sm" id="emergencyContactName"
                            placeholder="Contact Name" name="emergencyContactName" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="emergencyContactRelation">Relationship</label>
                        <input type="text" class="form-control form-control-sm" id="emergencyContactRelation"
                            placeholder="Relationship" name="emergencyContactRelation" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="emergencyContactPhone">Emergency Contact Phone</label>
                        <input type="tel" class="form-control form-control-sm" id="emergencyContactPhone"
                            placeholder="Phone Number" name="emergencyContactPhone" required>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn  btn-success btn-sm w-50">Submit</button>
                </div>

            </form>



























        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#subjects_primary').select2({
                placeholder: "Select Primary Subjects"
            });

            $('#subjects_secondary').select2({
                placeholder: "Select Secondary Subjects"
            });
            $('.subjectSelect').select2({
                placeholder: "Select subjects",
                width: '100%'
            });
        });
    </script>
@endsection

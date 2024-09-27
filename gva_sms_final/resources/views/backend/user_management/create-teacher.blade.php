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
    <div class="content">
        <div class="container-fluid">
            <div class="row card">
                <div class="card-tools col-sm-12 text-right p-4 ">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTeacherModal">
                        <i class="fas fa-user-plus"></i>Add New Teacher
                    </button>
                </div>
            </div>



            <!-- The large modal -->
         <!-- Modal for adding a new teacher -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control form-control-sm" id="firstName" placeholder="First Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="middleName">Middle Name</label>
                            <input type="text" class="form-control form-control-sm" id="middleName" placeholder="Middle Name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="lastName" placeholder="Last Name" required>
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
                            <input type="email" class="form-control form-control-sm" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="tel" class="form-control form-control-sm" id="phoneNumber" placeholder="Phone Number" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="address">Address</label>
                            <input type="text" class="form-control form-control-sm" id="address" placeholder="Address" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">City</label>
                            <input type="text" class="form-control form-control-sm" id="city" placeholder="City" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">State</label>
                            <input type="text" class="form-control form-control-sm" id="state" placeholder="State" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="country">Country</label>
                            <input type="text" class="form-control form-control-sm" id="country" placeholder="Country" required>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <h6 class="text-primary">Employment Information</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="employeeId">Employee ID</label>
                            <input type="text" class="form-control form-control-sm" id="employeeId" placeholder="Employee ID" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="hireDate">Date of Hire</label>
                            <input type="date" class="form-control form-control-sm" id="hireDate" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control form-control-sm" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="department">Department</label>
                            <input type="text" class="form-control form-control-sm" id="department" placeholder="Department" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="position">Position</label>
                            <input type="text" class="form-control form-control-sm" id="position" placeholder="Position" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="yearsExperience">Years of Experience</label>
                            <input type="number" class="form-control form-control-sm" id="yearsExperience" placeholder="Years of Experience" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="qualifications">Qualifications</label>
                            <input type="text" class="form-control form-control-sm" id="qualifications" placeholder="Qualifications" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="certifications">Certifications</label>
                            <input type="text" class="form-control form-control-sm" id="certifications" placeholder="Certifications">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="classAssigned">Class Assigned</label>
                            <input type="text" class="form-control form-control-sm" id="classAssigned" placeholder="Class Assigned">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="schoolBranch">School Branch</label>
                            <input type="text" class="form-control form-control-sm" id="schoolBranch" placeholder="School Branch" required>
                        </div>
                    </div>

                    <!-- System Information -->
                    <h6 class="text-primary">System Information</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-sm" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" required>
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
                            <input type="text" class="form-control form-control-sm" id="emergencyContactName" placeholder="Contact Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="emergencyContactRelation">Relationship</label>
                            <input type="text" class="form-control form-control-sm" id="emergencyContactRelation" placeholder="Relationship" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="emergencyContactPhone">Emergency Contact Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="emergencyContactPhone" placeholder="Phone Number" required>
                        </div>
                    </div>

                    <!-- Other Information -->
                    <h6 class="text-primary">Other Information</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="nationalId">National ID</label>
                            <input type="text" class="form-control form-control-sm" id="nationalId" placeholder="National ID" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bankAccountNumber">Bank Account Number</label>
                            <input type="text" class="form-control form-control-sm" id="bankAccountNumber" placeholder="Bank Account Number" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="workingDays">Working Days</label>
                            <input type="text" class="form-control form-control-sm" id="workingDays" placeholder="e.g., Mon-Fri" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="workingHoursStart">Working Hours Start</label>
                            <input type="time" class="form-control form-control-sm" id="workingHoursStart" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="workingHoursEnd">Working Hours End</label>
                            <input type="time" class="form-control form-control-sm" id="workingHoursEnd" required>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save Teacher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>








            {{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}
            {{-- <link rel="stylesheet" href="/css/custom_datatables.css"> --}}
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // $('.select2').select2({
            //     placeholder: "Select a State", // Custom placeholder
            //     theme: "classic" // You can change theme here, e.g., 'default', 'bootstrap4'
            // });
            $('.select2').select2();
            $().DataTable()
        });
    </script>
@endsection

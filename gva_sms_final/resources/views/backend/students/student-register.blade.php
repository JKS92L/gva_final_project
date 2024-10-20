@extends('admin.admim-master')
@section('admin_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
               
                <!-- /.col -->
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="http://127.0.0.1:8000/admin/students/details" class="btn btn-primary btn-sm"
                                role="button">
                                View Student List
                            </a>
                        </li>
                    </ol>

                </div>
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Content Header (Page header) -->
    <style>
        /* Additional CSS for styling the components */
        .form-control-file {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-control-file:hover {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        #reset_btn {
            background-color: #ffc107;
            border: none;
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #reset_btn:hover {
            background-color: #e0a800;
        }
    </style>



    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="card-body">

            <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card mt-4">
                    <div class="card-header">

                        <h4 class="card-title">Student Form</h4>
                    </div>
                    <div class="card-body">
                        <!-- More rows here, keeping the structure consistent with form-control-sm -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ecz_no" class="small">ECZ Exam Number</label> <small class="req">
                                        *</small>
                                    <input autofocus id="ecz_no" name="ecz_no" type="number"
                                        class="form-control form-control-sm" placeholder="">
                                    <span class="text-danger small"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="firstname" class="small">First Name</label> <small class="req">
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
                                    <label for="gender" class="small">Gender</label> <small class="req"> *</small>
                                    <select class="form-control form-control-sm" name="gender">
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dob" class="small">Date of Birth</label> <small class="req">
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
                                    <label for="sibling_names" class="small">Select Siblings</label>
                                    <select id="sibling_names" class="form-control small select2" name="sibling_ids[]"
                                        multiple="multiple" style="max-width: 100%">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">
                                                {{ ucwords($student->firstname) }} {{ ucwords($student->lastname) }}
                                                ({{ ucfirst($student->gender) }})
                                                - {{ $student->grade->gradeno . ' ' . $student->grade->class_name }}
                                            </option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="roll_no" class="small">Grade/Class</label>
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
                                    <label for="student_type" class="small">Student type</label> <small class="req">
                                        *</small>
                                    <select id="student_type" name="student_type" class="form-control form-control-sm">
                                        <option value="">Select</option>
                                        <option value='Day scholar'>Day scholar</option>
                                        <option value='Boarder'>Boarder</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Student Photo -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="student_photo" class="small font-weight-bold">Student Photo</label>
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

                <!-- Student Hostel Details Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Student Hostel Details</h4>
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
                                    <select class="form-control form-control-sm" id="bedspaceSelect" name="bedspace_id">
                                        <option value="">Select Bedspace</option>

                                    </select>
                                </div>
                            </div>

                            <!-- Hostel Supervisor -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hostel_supervisor" class="small">Hostel Teacher</label>
                                    <input id="hostel_supervisor" name="hostel_teacher_id" type="text"
                                        class="form-control form-control-sm" placeholder="Mr. SIR..." disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Guadian Details Card -->
                {{-- <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Parent/Guardin Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="around10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="small">Father
                                                Name</label>
                                            <input id="father_name" name="father_name" placeholder="" type="text"
                                                class="form-control form-control-sm" autocomplete="off">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Father
                                                Phone</label>
                                            <input id="father_phone" name="father_phone" placeholder="" type="text"
                                                class="form-control form-control-sm" autocomplete="off">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Father
                                                Occupation</label>
                                            <input id="father_occupation" name="father_occupation" placeholder=""
                                                type="text" class="form-control form-control-sm">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Father's
                                                Email</label>
                                            <input id="father_email" name="father_email" placeholder="" type="text"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="exampleInputEmail1"class="small">Father Address</label>
                                        <textarea id="father_address" name="father_address" placeholder="" class="form-control form-control-sm"
                                            rows="2"></textarea>
                                    </div>
                                    <br class="text-danger" style="width: 100%">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Mother
                                                Name</label>
                                            <input id="mother_name" name="mother_name" placeholder="" type="text"
                                                class="form-control form-control-sm">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Mother
                                                Phone</label>
                                            <input id="mother_phone" name="mother_phone" placeholder="" type="number"
                                                class="form-control form-control-sm">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Mother
                                                Occupation</label>
                                            <input id="mother_occupation" name="mother_occupation" placeholder=""
                                                type="text" class="form-control form-control-sm">

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"class="small">Mother's
                                                Email</label>
                                            <input id="mother_email" name="mother_email" placeholder="" type="text"
                                                class="form-control form-control-sm">

                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="exampleInputEmail1"class="small">Mother's
                                            Address</label>
                                        <textarea id="mather_address" name="mather_address" placeholder="" class="form-control form-control-sm"
                                            rows="2"></textarea>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> --}}
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
                        <h4 class="card-title">Login details</h4>
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
                                        class="form-control form-control-sm" autocomplete="off" placeholder="Enter Email"
                                        required>
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
                                    <label for="password_confirmation" class="small">Confirm Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        class="form-control form-control-sm" autocomplete="off"
                                        placeholder="Confirm Password" required>
                                    <span id="password_match_error" style="color: red; display: none;">Passwords do not
                                        match</span>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
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
            document.getElementById('admission_date').value = new Date().toISOString().split('T')[0];


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



            // passowrd vaildation 
            document.getElementById('password_confirmation').addEventListener('input', function() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                if (password !== confirmPassword) {
                    document.getElementById('password_match_error').style.display = 'block';
                } else {
                    document.getElementById('password_match_error').style.display = 'none';
                }
            });





            // disable or clear parents input fields when a sibling is selected
            function toggleParentFields(disabled, clearFields = false) {
                const parentFields = $(
                    '#father_name, #father_phone, #father_occupation, #father_email, #father_address, ' +
                    '#mother_name, #mother_phone, #mother_occupation, #mother_email, #mother_address');

                parentFields.prop('disabled', disabled); // Disable or enable fields

                if (clearFields) {
                    // Clear the values in the fields
                    parentFields.val('');
                }
            }

            // Initially enable parent input fields
            toggleParentFields(false);

            // Event listener for sibling selection change
            $('#sibling_names').on('change', function() {
                // Check if any sibling is selected
                let selectedSiblings = $(this).val();

                if (selectedSiblings.length > 0) {
                    // If a sibling is selected, disable and clear parent input fields
                    toggleParentFields(true, true);
                } else {
                    // If no sibling is selected, enable parent input fields (without clearing)
                    toggleParentFields(false);
                }
            });




        });
    </script>

@endsection

@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Student Admission')
@section('content_header_title', 'Student')
@section('content_header_subtitle', 'Student Registration')

{{-- Content body: main page content --}}

@section('content_body')
    {{-- add sibling modal --}}


    <div class="container">
        <!-- Sibling Modal -->
        <div class="modal fade" id="addSiblingModal" tabindex="-1" role="dialog" aria-labelledby="siblingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="siblingModalLabel">Add Sibling</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <!-- Grade -->
                            <div class="form-group">
                                <label for="sibling_grade" class="small">Select Grade</label>
                                <select id="sibling_grade" class="form-control">
                                    <option selected>--Select Grade--</option>
                                    <option value="2">11</option>
                                    <option value="3">12</option>
                                    <!-- Add more options as necessary -->
                                </select>
                            </div>

                            <!-- Class -->
                            <div class="form-group">
                                <label for="sibling_class" class="small">Select Class</label>
                                <select id="sibling_class" class="form-control">
                                    <option selected>--Select Grade--</option>
                                    <option value="A">NS</option>
                                    <option value="B">BS</option>
                                    <option value="C">SS</option>
                                    <!-- Add more options as necessary -->
                                </select>
                            </div>

                            <!-- Sibling Names -->
                            <div class="form-group">
                                <label for="sibling_names" class="small">Select Siblings</label>
                                <select id="sibling_names" class="form-control select2" multiple="multiple"
                                    style="max-width: 100%">
                                    <option value="1">John Doe</option>
                                    <option value="2">Jane Doe</option>
                                    <option value="3">Jim Doe</option>
                                    <!-- Add more student names dynamically -->
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm">Add Sibling</button>
                    </div>
                </div>
            </div>

        </div>


        <form action="">
            <div class="card">
                <div class="card-header">

                    <h4 class="card-title">Student Form</h4>
                </div>
                <div class="card-body">
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
                                <label for="roll_no" class="small">Grade</label>
                                <select id="class_id" name="class_id" class="form-control form-control-sm">
                                    <option value="">Select</option>
                                    <option value="1">Class 1</option>
                                    <option value="2">Class 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="class_id" class="small">Class</label> <small class="req"> *</small>
                                <select id="class_id" name="class_id" class="form-control form-control-sm">
                                    <option value="">Class</option>
                                    <option value="1">NS</option>
                                    <option value="2">BS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="section_id" class="small">Student type</label> <small class="req"> *</small>
                                <select id="section_id" name="section_id" class="form-control form-control-sm">
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
                                <label for="firstname" class="small">First Name</label> <small class="req"> *</small>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medical_condition" class="small">Medical Condition</label>
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
                                <button id="reset_btn" class="btn btn-warning btn-sm mt-2" style="display:none;">Reset
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
                                <select class="form-control form-control-sm" name="hostel_name">
                                    <option value="">Select Hostel</option>
                                    <option value="Hostel_name">Hostel Name</option>
                                    <option value="Hostel_Name">Hostel Name</option>
                                </select>
                            </div>
                        </div>
                        <!-- Room Number -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="room_number" class="small">Room Number</label>
                                <select class="form-control form-control-sm" name="Room_no">
                                    <option value="">Select Room</option>
                                    <option value="room_no">RM 4</option>
                                    <option value="Hostel_Name">RM 5</option>
                                </select>
                            </div>
                        </div>
                        <!-- Hostel Supervisor -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hostel_supervisor" class="small">Hostel Supervisor</label>
                                <input id="hostel_supervisor" name="hostel_supervisor" type="text"
                                    class="form-control form-control-sm" placeholder="Mr. SIR..." disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Check-in Date -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="checkin_date" class="small">Check-in Date</label>
                                <input id="checkin_date" name="checkin_date" type="date"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <!-- Check-out Date -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="checkout_date" class="small">Check-out Date</label>
                                <input id="checkout_date" name="checkout_date" type="date"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <!-- Special Requirements -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="special_requirements" class="small">Special Requirements</label>
                                <textarea id="special_requirements" name="special_requirements" class="form-control form-control-sm"
                                    placeholder="Any special requirements..."></textarea>
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
                                        <label for="exampleInputEmail1" class="small">Father Name</label>
                                        <input id="father_name" name="father_name" placeholder="" type="text"
                                            class="form-control form-control-sm" autocomplete="off">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Father Phone</label>
                                        <input id="father_phone" name="father_phone" placeholder="" type="text"
                                            class="form-control form-control-sm" autocomplete="off">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Father Occupation</label>
                                        <input id="father_occupation" name="father_occupation" placeholder=""
                                            type="text" class="form-control form-control-sm">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Father Phone</label><small
                                            class="req">
                                            *</small>
                                        <input id="father_phone" name="father_phone" placeholder="" type="number"
                                            class="form-control form-control-sm">

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Father Phone</label>
                                        <input id="father_email" name="father_email" placeholder="" type="text"
                                            class="form-control form-control-sm">

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
                                        <label for="exampleInputEmail1"class="small">Mother Name</label>
                                        <input id="mother_name" name="mother_name" placeholder="" type="text"
                                            class="form-control form-control-sm">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Mother Phone</label>
                                        <input id="mother_phone" name="mother_phone" placeholder="" type="text"
                                            class="form-control form-control-sm">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Mother Occupation</label>
                                        <input id="mother_occupation" name="mother_occupation" placeholder=""
                                            type="text" class="form-control form-control-sm">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Mother Phone</label><small
                                            class="req">
                                            *</small>
                                        <input id="mother_phone" name="mother_phone" placeholder="" type="number"
                                            class="form-control form-control-sm">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"class="small">Mother's Email</label>
                                        <input id="mother_email" name="mother_email" placeholder="" type="text"
                                            class="form-control form-control-sm">

                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="exampleInputEmail1"class="small">Mother's Address</label>
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
                <div class="card-header">
                    <h5>Fee Details</h5>
                </div>
                <div class="card-body">
                    <div class="row col-md-12">

                        <ul class="list-group col-md-12">
                            <!-- Fees Header -->
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">Fees Type</span>
                                <span class="font-weight-bold">Interval</span>
                                <span class="font-weight-bold">Amount ($)</span>
                            </li>

                            <!-- Fee Items from the database-->
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <input class="mr-2" type="checkbox" name="fee_session_group_id[]"
                                        value="admission-fees" autocomplete="off">
                                    Admission Fees (admission-fees)
                                </div>
                                <small><i class="fa fa-calendar"></i> 04/10/2024</small>
                                <span>2,000.00</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <input class="mr-2" type="checkbox" name="fee_session_group_id[]"
                                        value="apr-month-fees" autocomplete="off">
                                    April Month Fees (apr-month-fees)
                                </div>
                                <small><i class="fa fa-calendar"></i> 04/10/2024</small>
                                <span>300.00</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <input class="mr-2" type="checkbox" name="fee_session_group_id[]"
                                        value="may-month-fees" autocomplete="off">
                                    May Month Fees (may-month-fees)
                                </div>
                                <small><i class="fa fa-calendar"></i> 05/10/2024</small>
                                <span>300.00</span>
                            </li>

                            <!-- Repeat for remaining months -->

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <input class="mr-2" type="checkbox" name="fee_session_group_id[]"
                                        value="feb-month-fees" autocomplete="off">
                                    February Month Fees (feb-month-fees)
                                </div>
                                <small><i class="fa fa-calendar"></i> 02/10/2025</small>
                                <span>300.00</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <input class="mr-2" type="checkbox" name="fee_session_group_id[]"
                                        value="mar-month-fees" autocomplete="off">
                                    March Fees (F02302)
                                </div>
                                <small><i class="fa fa-calendar"></i> 03/10/2025</small>
                                <span>300.00</span>
                            </li>
                        </ul>



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
    {{-- content here --}}

@stop

{{-- Push extra CSS --}}

@push('css')
    <style>
        #preview_img {
            border: 1px solid #de9307;
            padding: 5px;
            border-radius: 5px;
            margin-top: 10px;
            max-width: 100%;
            /* Ensure it fits inside the form container */
            height: auto;
            /* Maintain aspect ratio */
        }

        #reset_btn {
            background-color: #f39c12;
            border: none;
            padding: 8px 12px;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        #reset_btn:hover {
            background-color: #e67e22;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        // Dropzone configuration - must be outside the $(document).ready(function()
        Dropzone.options.studentPhotoDropzone = {
            paramName: "file",
            maxFilesize: 2,
            acceptedFiles: "image/*",
            maxFiles: 1,
            autoProcessQueue: true,
            thumbnailWidth: 150,
            thumbnailHeight: 150,
            dictDefaultMessage: "Drag & drop or click to upload",
            previewTemplate: `
        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail /></div>
            <div class="dz-details">
                <div class="dz-size"><span data-dz-size></span></div>
                <div class="dz-filename"><span data-dz-name></span></div>
            </div>
            <!-- Removed the default dz-remove button here -->
        </div>
    `,
            init: function() {
                var myDropzone = this;

                this.on("addedfile", function(file) {
                    document.getElementById('reset_btn').style.display = 'inline';
                });

                document.getElementById('reset_btn').addEventListener('click', function() {
                    myDropzone.removeAllFiles();
                });
            }
        };

        // js scrips here when the docment is ready
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 on sibling select inputs



        });
    </script>
@endpush

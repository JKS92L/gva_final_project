@extends('admin.admim-master')
@section('admin_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-success">Student Details</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('view.studentreg.form') }}">Register New Student</a>
                        </li>

                    </ol>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    {{-- content here --}}
    <div class="container col-md-12">

        <!-- Brief Tags for Stats -->
        <div class="row">
            <!-- Boarders Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none">
                    <span class="info-box-icon bg-info"><i class="fas fa-bed"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Boarders</span>
                        <span class="info-box-number">120</span> <!-- Replace with dynamic data -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- Day Scholars Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-success"><i class="fas fa-bus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Day Scholars</span>
                        <span class="info-box-number">80</span> <!-- Replace with dynamic data -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- Boys Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                    <span class="info-box-icon bg-warning"><i class="fas fa-male"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Boys</span>
                        <span class="info-box-number">100</span> <!-- Replace with dynamic data -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- Girls Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-lg">
                    <span class="info-box-icon bg-danger"><i class="fas fa-female"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Girls</span>
                        <span class="info-box-number">100</span> <!-- Replace with dynamic data -->
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>


        <!-- Table with Pupils List -->
        <div class="card">
            <div class="card-header">
                <h4>Student Details</h4>
            </div>
            <div class="card-body table-responsive p-2">
                <table class="table table-bordered table-hover text-nowrap" id="studentDetails">
                    <thead class="">
                        <tr>
                            <th>Exam Number</th>
                            <th>Pupil's Name</th>
                            <th>Grade</th>
                            <th>Student Type</th>
                            <th>D.O.B</th>
                            <th>Gender</th>
                            <th>Siblings</th>
                            <th>Hostel (Bedspace#)</th>
                            {{-- <th>Guardian Contact No.</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->ecz_no }}</td>
                                <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                <td>
                                    {{ $student->grade->gradeno ?? 'N/A' }} {{ $student->grade->class_name ?? '' }}
                                </td>
                                <td>{{ ucfirst($student->student_type) }}</td>
                                <td>{{ $student->dob ? $student->dob->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ ucfirst($student->gender) }}</td>
                                <td>
                                    <a href="#" data-toggle="tooltip"
                                        title="@foreach ($student->siblings as $sibling) {{ $sibling->firstname }} {{ $sibling->lastname }} @if (!$loop->last), @endif @endforeach">
                                        {{ $student->siblings->count() }}
                                    </a>
                                </td>
                                <td>
                                    {{ $student->hostel ? $student->hostel->hostel_name : 'N/A' }}
                                    @if ($student->bedspace)
                                        ({{ $student->bedspace->bedspace_no }})
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#viewModal-{{ $student->id }}">View</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteConfirmModal-{{ $student->id }}">Delete</button>
                                    <a href="{{ route('students.edit', $student->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>


                            <!-- View More Modal -->
                            <div class="modal fade" id="viewModal-{{ $student->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">Student Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Pupil's Photo ID -->
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ $student->student_photo ? asset('storage/students/' . $student->student_photo) : '/path/to/default-photo.jpg' }}"
                                                        id="modalPupilPhoto" class="img-fluid img-thumbnail"
                                                        alt="Pupil Photo" style="max-width: 150px;">
                                                    <h6 class="mt-2">Pupil's Photo</h6>
                                                </div>

                                                <!-- Pupil's Details -->
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Exam Number: <span
                                                                    id="modalExamNumber">{{ $student->ecz_no }}</span></h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Pupil's Name: <span
                                                                    id="modalPupilName">{{ $student->firstname }}
                                                                    {{ $student->lastname }}</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Grade: <span id="modalGrade">
                                                                    {{-- {{ $student->grade->gradeno }} --}}
                                                                    Work on the grade ids
                                                                </span></h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Class: <span
                                                                    id="modalClass">{{ $student->class_id }}</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Student Type: <span
                                                                    id="modalStudentType">{{ $student->student_type }}</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>D.O.B: <span
                                                                    id="modalDOB">{{ $student->dob->format('d/m/Y') }}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Gender: <span
                                                                    id="modalGender">{{ $student->gender }}</span></h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Siblings:
                                                                <span id="modalSiblings">
                                                                    @if ($student->siblings->count() > 0)
                                                                        @foreach ($student->siblings as $sibling)
                                                                            {{ $sibling->firstname }}
                                                                            {{ $sibling->lastname }}
                                                                            ({{ $sibling->grade->name }} - Class
                                                                            {{ $sibling->class_id }})
                                                                            @if (!$loop->last)
                                                                                ,
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        None
                                                                    @endif
                                                                </span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Guardian Name: <span
                                                                    id="modalGuardianName">{{ $student->father_name ?? $student->mother_name }}</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Guardian Contact: <span
                                                                    id="modalGuardianContact">{{ $student->father_phone ?? $student->mother_phone }}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Residential Address: <span
                                                                    id="modalResAddress">{{ $student->father_address ?? ($student->mother_address ?? 'N/A') }}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Hostel: <span
                                                                    id="modalHostel">{{ $student->hostel->hostel_name ?? 'N/A' }}</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Bedspace: <span
                                                                    id="modalBedspace">{{ $student->hostel->bedspace_no ?? 'N/A' }}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Medical Condition: <span
                                                                    id="modalMedical">{{ $student->medical_condition ?? 'None' }}</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Admission Date: <span
                                                                    id="modalAdmission">{{ $student->admission_date->format('d/m/Y') }}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- confirm delete modal --}}
                            <div class="modal fade" id="deleteConfirmModal-{{ $student->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="deleteStudentLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteStudentLabel">
                                                Confirm Deletion for {{ $student->firstname }} {{ $student->lastname }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this student?</p>
                                            <p><strong>Student Name:</strong> {{ $student->firstname }}
                                                {{ $student->lastname }}</p>
                                            <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                                            <p><strong>Grade:</strong>
                                                {{ $student->grade->gradeno . ' ' . $student->grade->class_name }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>





    {{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}


    <style>

    </style>

    <script>
        // js scrips here 

        $(document).ready(function() {

            // Define your variables
            var schoolAdress = `
        Off Kafue Road, Shimabala, P O Box 360398, Kafue
        Tel: 0956 480949
        Email: info@grandviewacademy.edu.zm
        Website: www.grandviewacademy.edu.zm
        VISION: To create a Grandview Academy School that will be highly regarded
        for its academic excellence and contribution in actively serving and improving the environment in which it operates
    `;
            var sch_title = 'GRANDVIEW ACADEMY';
            var current_Year = new Date().getFullYear();
            var schoolUrl = 'http://www.gvasms.com';

            // Function to get the table title dynamically based on the current active tab
            function getTableTitle(selector) {
                return $(selector).closest('.card').find('.card-title').text().trim() || 'Student List';
            }

            // Function to initialize DataTables with export buttons
            function initializeDataTable(selector, enableExportButtons = false, exportColumns = []) {

                var options = {
                    dom: 'Bfrtip',
                    buttons: []
                };

                if (enableExportButtons) {
                    var tableTitle = getTableTitle(selector); // Dynamically fetch the table title

                    options.buttons = [
                        // Excel Export Button
                        {
                            extend: 'excelHtml5',
                            text: 'Export to Excel',
                            title: tableTitle, // Use the dynamic table title here
                            className: 'btn btn-success',
                            exportOptions: {
                                columns: exportColumns // Dynamic columns
                            },
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                $('row c[r^="A1"]', sheet).attr('s', '2').text(sch_title);
                                $('row c[r^="A2"]', sheet).attr('s', '2').text(schoolAdress.trim().replace(
                                    /\n/g, ' '));
                                $('row c[r^="A3"]', sheet).attr('s', '2').text(current_Year);

                                var lastRowNumber = $('sheetData row', sheet).length + 1;
                                $('sheetData', sheet).append(
                                    '<row r="' + lastRowNumber + '">' +
                                    '<c t="inlineStr" r="A' + lastRowNumber +
                                    '"><is><t>Generated from: ' + schoolUrl + '</t></is></c>' +
                                    '</row>' +
                                    '<row r="' + (lastRowNumber + 1) + '">' +
                                    '<c t="inlineStr" r="A' + (lastRowNumber + 1) +
                                    '"><is><t>Generated on: ' + new Date().toLocaleString() +
                                    '</t></is></c>' +
                                    '</row>'
                                );
                            }
                        },
                        // CSV Export Button
                        {
                            extend: 'csvHtml5',
                            text: 'Export to CSV',
                            title: tableTitle, // Dynamic table title
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: exportColumns // Dynamic columns
                            }
                        },
                        // PDF Export Button
                        {
                            extend: 'pdfHtml5',
                            text: 'Export to PDF',
                            title: tableTitle, // Dynamic table title
                            className: 'btn btn-danger',
                            exportOptions: {
                                columns: exportColumns // Dynamic columns
                            },
                            customize: function(doc) {
                                doc.content.splice(0, 0, {
                                    alignment: 'center',
                                    text: sch_title,
                                    fontSize: 18,
                                    bold: true,
                                    margin: [0, 10]
                                });
                                doc.content.splice(1, 0, {
                                    alignment: 'center',
                                    text: schoolAdress,
                                    fontSize: 12,
                                    bold: true,
                                    margin: [0, 5]
                                });
                                doc.content.splice(2, 0, {
                                    alignment: 'center',
                                    text: current_Year,
                                    fontSize: 12,
                                    bold: true,
                                    margin: [0, 5]
                                });
                                doc.content.push({
                                    text: 'Generated from: ' + schoolUrl,
                                    alignment: 'center',
                                    margin: [0, 20],
                                    fontSize: 10
                                });
                                doc.content.push({
                                    text: 'Generated on: ' + new Date().toLocaleString(),
                                    alignment: 'center',
                                    margin: [0, 5],
                                    fontSize: 10
                                });
                            }
                        },
                        // Print Button
                        {
                            extend: 'print',
                            text: 'Print',
                            title: tableTitle, // Dynamic table title
                            className: 'btn btn-info',
                            exportOptions: {
                                columns: exportColumns // Dynamic columns
                            },
                            customize: function(win) {
                                $(win.document.body).prepend(
                                    '<div style="text-align: center; margin-bottom: 20px;">' +
                                    '<h1 style="font-weight: bold;">' + sch_title + '</h1>' +
                                    '<p style="font-weight: bold; white-space: pre-line;">' +
                                    schoolAdress + '</p>' +
                                    '<p style="font-weight: bold;">Year: ' + current_Year + '</p>' +
                                    '</div>'
                                );
                                $(win.document.body).append(
                                    '<div style="text-align: center; margin-top: 20px;">' +
                                    '<p>Generated from: <a href="' + schoolUrl + '">' + schoolUrl +
                                    '</a></p>' +
                                    '<p>Generated on: ' + new Date().toLocaleString() + '</p>' +
                                    '</div>'
                                );
                            }
                        },
                        // Copy Button
                        {
                            extend: 'copyHtml5',
                            text: 'Copy',
                            title: tableTitle, // Dynamic table title
                            className: 'btn btn-secondary',
                            exportOptions: {
                                columns: exportColumns // Dynamic columns
                            }
                        }
                    ];
                }

                $(selector).DataTable(options);
            }

            var tables = ['#studentDetails']; // Add other table IDs as needed
            tables.forEach(function(tableSelector) {
                // Check if the table is already initialized
                if ($.fn.DataTable.isDataTable($(
                        tableSelector))) { // Pass the jQuery object, not the string
                    // Destroy the existing DataTable instance
                    $(tableSelector).DataTable().destroy();
                }
            });

            // Trigger reinitialization when a tab is shown
            // $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
            //     initializeDataTable(); // Reinitialize tables when tabs are switched
            // });

            // Initialize the DataTable for the teacher grades table with dynamic columns
            initializeDataTable('#studentDetails', true, [0, 1, 2, 3, 4, 5, 6, 7, 8]);
            // initializeDataTable('#juniorExamTable', true, [0, 1, 2, 3, 4, 5, 6]);

            // Add search buttons ONLY for these tables


        });
    </script>
@endsection

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
                        <span class="info-box-number">{{ $stats['boarders'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Day Scholars Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-success"><i class="fas fa-bus"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Day Scholars</span>
                        <span class="info-box-number">{{ $stats['dayScholars'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Boys Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                    <span class="info-box-icon bg-warning"><i class="fas fa-male"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Boys</span>
                        <span class="info-box-number">{{ $stats['boys'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Girls Widget -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-lg">
                    <span class="info-box-icon bg-danger"><i class="fas fa-female"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Girls</span>
                        <span class="info-box-number">{{ $stats['girls'] }}</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Table with Pupils List -->
        <div class="card">
            <div class="card-header">
                <h5>Student Details</h5>
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
                            <th>Admitted date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->ecz_no ?? 'N/A' }}</td>
                                <td>{{ $student->firstname ?? 'N/A' }} {{ $student->lastname ?? '' }}</td>
                                <td>
                                    {{ $student->grade->gradeno ?? 'N/A' }} {{ $student->grade->class_name ?? '' }}
                                </td>
                                <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                                <td>{{ $student->dob ? $student->dob->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ ucfirst($student->gender ?? 'N/A') }}</td>
                                <td>
                                    <a href="#" data-toggle="tooltip"
                                        title="@foreach ($student->siblings as $sibling) {{ $sibling->firstname }} {{ $sibling->lastname }} @if (!$loop->last), @endif @endforeach">
                                        {{ $student->siblings->count() ?? 0 }}
                                    </a>
                                </td>
                                <td>
                                    {{ $student->hostel ? $student->hostel->hostel_name : 'N/A' }}
                                    @if ($student->bedspace)
                                        ({{ $student->bedspace->bedspace_no }})
                                    @endif
                                </td>
                                <td>
                                    {{ $student->admission_date ? $student->admission_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td>
                                    <span
                                        class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : 'warning' }}">
                                        {{ ucfirst($student->active_status) }}
                                    </span>
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
                                                            <h6>Exam Number: <strong
                                                                    id="modalExamNumber">{{ $student->ecz_no ?? 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Pupil's Name:
                                                                <strong
                                                                    id="modalPupilName">{{ $student->firstname ?? 'N/A' }}
                                                                    {{ $student->lastname ?? '' }}</strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Grade: <strong
                                                                    id="modalGrade">{{ $student->grade->gradeno ?? 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Class: <strong
                                                                    id="modalClass">{{ $student->grade->class_name ?? 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Student Type: <strong
                                                                    id="modalStudentType">{{ ucfirst($student->student_type ?? 'N/A') }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>D.O.B: <strong
                                                                    id="modalDOB">{{ $student->dob ? $student->dob->format('d/m/Y') : 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Gender: <strong
                                                                    id="modalGender">{{ ucfirst($student->gender ?? 'N/A') }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Siblings:
                                                                <strong id="modalSiblings">
                                                                    @if ($student->siblings && $student->siblings->count() > 0)
                                                                        @foreach ($student->siblings as $sibling)
                                                                            {{ $sibling->firstname ?? 'N/A' }}
                                                                            {{ $sibling->lastname ?? '' }}
                                                                            ({{ $sibling->grade->gradeno ?? 'N/A' }} -
                                                                            Class
                                                                            {{ $sibling->grade->class_name ?? 'N/A' }})
                                                                            @if (!$loop->last)
                                                                                ,
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        None
                                                                    @endif
                                                                </strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Hostel: <strong
                                                                    id="modalHostel">{{ $student->hostel->hostel_name ?? 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Bedspace: <strong
                                                                    id="modalBedspace">{{ $student->bedspace->bedspace_no ?? 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Medical Condition: <strong
                                                                    id="modalMedical">{{ $student->medical_condition ?? 'None' }}</strong>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Admission Date:
                                                                <strong
                                                                    id="modalAdmission">{{ $student->admission_date ? $student->admission_date->format('d/m/Y') : 'N/A' }}</strong>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Active Status:
                                                                <strong id="modalActiveStatus">
                                                                    <span
                                                                        class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : ($student->active_status === 'rejected' ? 'danger' : 'warning') }}">
                                                                        {{ ucfirst($student->active_status ?? 'N/A') }}
                                                                    </span>
                                                                </strong>
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
                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteConfirmModal-{{ $student->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="deleteConfirmModalLabel-{{ $student->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteConfirmModalLabel-{{ $student->id }}">
                                                Confirm Deletion
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete the record for
                                            <strong>{{ $student->firstname }} {{ $student->lastname }}</strong>?
                                            This action cannot be undone.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Confirm Delete</button>
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

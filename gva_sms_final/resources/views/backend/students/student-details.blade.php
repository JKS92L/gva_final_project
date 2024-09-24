@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Student Setails')
@section('content_header_title', 'Students')
@section('content_header_subtitle', 'Student List')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- content here --}}
    <div class="container mt-5">

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
                            <th>Guardian Name</th>
                            <th>Residential Address</th>
                            <th>Guardian Contact No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row -->
                        <tr>
                            <td>12345</td>
                            <td>John Doe</td>
                            <td>12-A</td>
                            <td>Boarder</td>
                            <td>15/06/2008</td>
                            <td>Male</td>
                            <td>
                                <a href="#" data-toggle="tooltip" title="Mike Doe (Grade 10 - Class B)">
                                    1
                                </a>
                            </td>
                            <td>Jane Doe</td>
                            <td>123 Residential Street</td>
                            <td>+260 956 123456</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal">
                                    View
                                </button>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>00123</td>
                            <td>Chomba Mwansa</td>
                            <td>12</td>
                            <td>Boarder</td>
                            <td>12/09/2008</td>
                            <td>Male</td>
                            <td><a href="#" data-toggle="tooltip" title="Mulenga Mwansa (Grade 10, Class A)">1</a>
                            </td>
                            <td>James Mwansa</td>
                            <td>Plot 45, Mufulira, Copperbelt</td>
                            <td>+260 972 567890</td>
                            <td>
                                <button class="btn btn-info btn-sm">View</button>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>

                        <!-- Pupil 2 -->
                        <tr>
                            <td>00456</td>
                            <td>Linda Chibale</td>
                            <td>11</td>
                            <td>Day Scholar</td>
                            <td>23/05/2009</td>
                            <td>Female</td>
                            <td><a href="#" data-toggle="tooltip" title="None">0</a></td>
                            <td>Angela Chibale</td>
                            <td>Chalala, Lusaka</td>
                            <td>+260 955 123456</td>
                            <td>
                                <button class="btn btn-info btn-sm">View</button>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>

                        <!-- Pupil 3 -->
                        <tr>
                            <td>00789</td>
                            <td>Kabwe Bwalya</td>
                            <td>10</td>
                            <td>Boarder</td>
                            <td>17/02/2010</td>
                            <td>Male</td>
                            <td><a href="#" data-toggle="tooltip" title="Lombe Bwalya (Grade 7, Class C)">1</a></td>
                            <td>Charles Bwalya</td>
                            <td>Kabwe Central, Central Province</td>
                            <td>+260 964 789012</td>
                            <td>
                                <button class="btn btn-info btn-sm">View</button>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows dynamically -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- View More Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
            aria-hidden="true">
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
                                <img src="/path/to/default-photo.jpg" id="modalPupilPhoto" class="img-fluid img-thumbnail"
                                    alt="Pupil Photo" style="max-width: 150px;">
                                <h6 class="mt-2">Pupil's Photo</h6>
                            </div>

                            <!-- Pupil's Details -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Exam Number: <span id="modalExamNumber">12345</span></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Pupil's Name: <span id="modalPupilName">John Doe</span></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Grade: <span id="modalGrade">12</span></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Class: <span id="modalClass">A</span></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Student Type: <span id="modalStudentType">Boarder</span></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>D.O.B: <span id="modalDOB">15/06/2008</span></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Gender: <span id="modalGender">Male</span></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Siblings: <span id="modalSiblings">Mike Doe (Grade 10, Class B)</span></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Guardian Name: <span id="modalGuardianName">Jane Doe</span></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Guardian Contact: <span id="modalGuardianContact">+260 956 123456</span></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Residential Address: <span id="modalResAddress">123 Residential Street</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>




@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}
    
    
    <style>

    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
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
@endpush

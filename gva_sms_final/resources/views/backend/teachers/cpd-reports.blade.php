@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'CPD Report')
@section('content_header_title', 'Teacher')
@section('content_header_subtitle', 'CPD Report')

{{-- Content body: main page content --}}
@section('content_body')

 
        <div class="row">
            <div class="col-12">
                {{-- Bootstrap Card --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Teachers Continuous Professional Development (CPD) Report</h3>
                        
                    </div>
                    <div class="card-body">
                        <table id="cpd-report-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>CPD Date</th>
                                    <th>Teacher's Name<i class="fas fa-sort"> </th>
                                    <th>Facilitator<i class="fas fa-sort"> </th>
                                    <th>Presenter<i class="fas fa-sort"> </th>
                                    <th>Teacher Role</th>
                                    <th>Comments</th>
                                    <th>Observations</th>
                                    <th>Recommendations</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example rows --}}
                                <tr>
                                    <td>2024-01-15</td>
                                    <td>Silillo</td>
                                    <td>Kawana</td>
                                    <td>Muyunda</td>
                                    <td>Facilitator</td>
                                    <td>Very interactive and productive session.</td>
                                    <td>Teachers showed high engagement.</td>
                                    <td>Encourage more hands-on activities.</td>
                                </tr>
                                <tr>
                                    <td>2024-02-10</td>
                                    <td>Bwalya</td>
                                    <td>Hamweene</td>
                                    <td>Chisabi</td>
                                    <td>Participant</td>
                                    <td>Well-organized meeting with clear objectives.</td>
                                    <td>Some teachers struggled with time management.</td>
                                    <td>Provide time management training.</td>
                                </tr>
                                <tr>
                                    <td>2024-03-05</td>
                                    <td>Kawana</td>
                                    <td>Muyunda</td>
                                    <td>Silillo</td>
                                    <td>Coordinator</td>
                                    <td>Great team collaboration.</td>
                                    <td>Discussions were insightful and progressive.</td>
                                    <td>Introduce peer reviews to enhance feedback.</td>
                                </tr>
                                {{-- Add more dummy rows as needed --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
 
@stop

{{-- Push extra CSS --}}
@push('css')
    <link rel="stylesheet" href="/css/custom_datatables.css">
    <style>
        /* Custom styles for the card */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: inline-flex;
            align-items: center;
        }

        /* Add spacing between the two elements */
        .dataTables_wrapper .dataTables_filter {
            margin-left: auto;
            /* Push the search box to the right */
        }

        /* Adjust the margin between the label and select */
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
        }

        .dataTables_wrapper .dataTables_length label select {
            margin-left: 5px;
        }
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTable for the CPD report
            $(document).ready(function() {
                // Initialize Select2 for all select elements
                $('.select2').select2({
                    width: '100%',
                    placeholder: '-- Select an option --',
                    allowClear: false
                });

                // Define your variables
                var schoolAddress = `
        Off Kafue Road, Shimabala, P O Box 360398, Kafue
        Tel: 0956 480949
        Email: info@grandviewacademy.edu.zm
        Website: www.grandviewacademy.edu.zm
        VISION: To create a Grandview Academy School that will be highly regarded
        for its academic excellence and contribution in actively serving and improving the environment in which it operates
    `;
                var schTitle = 'GRANDVIEW ACADEMY';
                var currentYear = new Date().getFullYear();
                var schoolUrl = 'http://www.gvasms.com';

                function initializeDataTable(selector, enableExportButtons = false) {
                    // Check if DataTable is already initialized and destroy it before re-initializing
                    if ($.fn.DataTable.isDataTable(selector)) {
                        $(selector).DataTable().destroy();
                    }

                    var options = {
                        dom: 'Bfrtip',
                        buttons: []
                    };

                    if (enableExportButtons) {
                        options.buttons = [{
                                extend: 'excelHtml5',
                                text: 'Export to Excel',
                                className: 'btn btn-success',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6,
                                        7
                                    ] // Adjust the columns according to your table
                                },
                                customize: function(xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                    // Add school name and address at the top
                                    $('row c[r^="A1"]', sheet).attr('s', '2').text(
                                        schTitle); // Bold style
                                    $('row c[r^="A2"]', sheet).attr('s', '2').text(schoolAddress
                                        .trim().replace(
                                            /\n/g, ' '));
                                    $('row c[r^="A3"]', sheet).attr('s', '2').text(currentYear);

                                    // Add URL, date, and time at the bottom
                                    var lastRowNumber = $('sheetData row', sheet).length + 1;
                                    $('sheetData', sheet).append(
                                        '<row r="' + lastRowNumber + '">' +
                                        '<c t="inlineStr" r="A' + lastRowNumber +
                                        '"><is><t>Generated from: ' + schoolUrl +
                                        '</t></is></c>' +
                                        '</row>' +
                                        '<row r="' + (lastRowNumber + 1) + '">' +
                                        '<c t="inlineStr" r="A' + (lastRowNumber + 1) +
                                        '"><is><t>Generated on: ' + new Date()
                                        .toLocaleString() +
                                        '</t></is></c>' +
                                        '</row>'
                                    );
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: 'Export to PDF',
                                className: 'btn btn-danger',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6,
                                        7
                                    ] // Adjust the columns according to your table
                                },
                                customize: function(doc) {
                                    doc.content.splice(0, 0, {
                                        alignment: 'center',
                                        text: schTitle,
                                        fontSize: 18,
                                        bold: true,
                                        margin: [0, 10]
                                    });
                                    doc.content.splice(1, 0, {
                                        alignment: 'center',
                                        text: schoolAddress,
                                        fontSize: 12,
                                        bold: true,
                                        margin: [0, 5]
                                    });
                                    doc.content.splice(2, 0, {
                                        alignment: 'center',
                                        text: currentYear,
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
                                        text: 'Generated on: ' + new Date()
                                            .toLocaleString(),
                                        alignment: 'center',
                                        margin: [0, 5],
                                        fontSize: 10
                                    });
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                className: 'btn btn-info',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6,
                                        7
                                    ] // Adjust the columns according to your table
                                },
                                customize: function(win) {
                                    $(win.document.body).prepend(
                                        '<div style="text-align: center; margin-bottom: 20px;">' +
                                        '<h1 style="font-weight: bold;">' + schTitle + '</h1>' +
                                        '<p style="font-weight: bold; white-space: pre-line;">' +
                                        schoolAddress + '</p>' +
                                        '<p style="font-weight: bold;">Year: ' + currentYear +
                                        '</p>' +
                                        '</div>'
                                    );
                                    $(win.document.body).append(
                                        '<div style="text-align: center; margin-top: 20px;">' +
                                        '<p>Generated from: <a href="' + schoolUrl + '">' +
                                        schoolUrl +
                                        '</a></p>' +
                                        '<p>Generated on: ' + new Date().toLocaleString() +
                                        '</p>' +
                                        '</div>'
                                    );
                                }
                            }
                        ];
                    }

                    // Initialize the DataTable with options
                    $(selector).DataTable(options);
                }

                // Initialize the DataTable for the assignedRoleTable with export buttons enabled
                initializeDataTable('#cpd-report-table', true);

            });
        });
    </script>
@endpush

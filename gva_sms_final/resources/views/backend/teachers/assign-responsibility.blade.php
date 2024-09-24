@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Responsibilities')
@section('content_header_title', 'Teacher')
@section('content_header_subtitle', 'Assign Responsibilities')

{{-- Content body: main page content --}}
@section('content_body')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <!-- Table card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Teachers and Assigned Responsibilities</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#assignRoleModal">
                                <i class="fa fa-user-tag"></i> Assign Responsibilities to Teacher
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover" id="assignedRoleTable">
                            <thead>
                                <tr>
                                    <th>Teacher Name <i class="fas fa-sort"></i></th>
                                    <th>Current Responbilities<i class="fas fa-sort"></i></th>
                                    <th>Actions <i class="fas fa-sort"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>Class Teacher</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#assignRoleModal">
                                            Edit Role
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>Head of Department</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#assignRoleModal">
                                            Edit Role
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Michael Johnson</td>
                                    <td>Teacher</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#assignRoleModal">
                                            Edit Role
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal for assigning role -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1" role="dialog" aria-labelledby="assignRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignRoleModalLabel">Assign Responsibility to Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <!-- Teacher Selection -->
                        <div class="form-group">
                            <label for="teacher">Select Teacher</label>
                            <select id="teacher" name="teacher_id" class="form-control">
                                <option value="">-- Select Teacher --</option>
                                <option value="1">John Doe</option>
                                <option value="2">Jane Smith</option>
                                <option value="3">Michael Johnson</option>
                            </select>
                        </div>

                        <!-- Role Selection -->
                        <div id="role-container">
                            <div class="form-group permissions-group">
                                <label for="permissions">Select Position</label>
                                <div class="input-group">
                                    <select id="role" name="permissions_id[]" class="form-control select2"
                                        id="permissions" multiple="multiple" style="width: 100%;">
                                        <option value="1">Manage Users</option>
                                        <option value="2">Edit Content</option>
                                        <option value="3">View Reports</option>
                                        <option value="4">Manage Finances</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">Assign Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.2/css/buttons.dataTables.min.css"> --}}
  
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
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
                                columns: [0, 1, 2] // Adjust the columns according to your table
                            },
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                // Add school name and address at the top
                                $('row c[r^="A1"]', sheet).attr('s', '2').text(schTitle); // Bold style
                                $('row c[r^="A2"]', sheet).attr('s', '2').text(schoolAddress.trim().replace(
                                    /\n/g, ' '));
                                $('row c[r^="A3"]', sheet).attr('s', '2').text(currentYear);

                                // Add URL, date, and time at the bottom
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
                        {
                            extend: 'pdfHtml5',
                            text: 'Export to PDF',
                            className: 'btn btn-danger',
                            exportOptions: {
                                columns: [0, 1, 2] // Adjust the columns according to your table
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
                                    text: 'Generated on: ' + new Date().toLocaleString(),
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
                                columns: [0, 1, 2] // Adjust the columns according to your table
                            },
                            customize: function(win) {
                                $(win.document.body).prepend(
                                    '<div style="text-align: center; margin-bottom: 20px;">' +
                                    '<h1 style="font-weight: bold;">' + schTitle + '</h1>' +
                                    '<p style="font-weight: bold; white-space: pre-line;">' +
                                    schoolAddress + '</p>' +
                                    '<p style="font-weight: bold;">Year: ' + currentYear + '</p>' +
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
                        }
                    ];
                }

                // Initialize the DataTable with options
                $(selector).DataTable(options);
            }

            // Initialize the DataTable for the assignedRoleTable with export buttons enabled
            initializeDataTable('#assignedRoleTable', true);

        });
    </script>
@endpush

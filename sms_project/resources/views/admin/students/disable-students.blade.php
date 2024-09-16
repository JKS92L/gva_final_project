@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Disable Students')
@section('content_header_title', 'Admin')
@section('content_header_subtitle', 'Disable Students')

{{-- Content body: main page content --}}
@section('content_body')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="justify-content-left">
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#disableStudentModal">
                        Disable Student
                    </button>
                </div>
                <h5 class="mb-0 text-left">Currently Disabled Students</h5>

            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Exam Number</th>
                                <th>Full Name</th>
                                <th>Grade-Class</th>
                                <th>Date Disabled</th>
                                <th>Reason</th>
                                <th>Disabled By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dummy Data for Illustration --}}
                            <tr>
                                <td>20230123</td>
                                <td>John Banda</td>
                                <td>Grade 10 - A</td>
                                <td>2024-09-09</td>
                                <td>Outstanding Fees</td>
                                <td>Admin User</td>
                                <td>
                                    <button class="btn btn-info btn-sm">Enable</button>
                                    <button class="btn btn-danger btn-sm">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>20230124</td>
                                <td>Grace Mwansa</td>
                                <td>Grade 12 - C</td>
                                <td>2024-09-08</td>
                                <td>Academic Probation</td>
                                <td>Admin User</td>
                                <td>
                                    <button class="btn btn-info btn-sm">Enable</button>
                                    <button class="btn btn-danger btn-sm">Remove</button>
                                </td>
                            </tr>
                            {{-- Add more rows as needed --}}
                        </tbody>
                    </table>
                </div>
            </div>


        </div>



        <!-- Modal for Disabling Student -->
        <div class="modal fade" id="disableStudentModal" tabindex="-1" role="dialog"
            aria-labelledby="disableStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="disableStudentModalLabel">Disable a Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="disableStudentForm">
                            {{-- Select2 for Student --}}
                            <div class="form-group">
                                <label for="studentSelect" class="form-label">Select Student:</label>
                                <select class="form-control select2" multiple="multiple" id="studentSelect"
                                    name="student_id" style="width: 100%" required>
                                    {{-- Dummy Active Students Data --}}
                                    <option value="" disabled>Select a student</option>
                                    <option value="1">Lilian Banda (STU-2023003)</option>
                                    <option value="2">Samuel Phiri (STU-2023004)</option>
                                    <option value="3">Grace Mwansa (STU-2023005)</option>
                                    {{-- Add more dummy options as needed --}}
                                </select>
                            </div>

                            {{-- Select2 for Reason --}}
                            <div class="form-group">
                                <label for="disableReason" class="form-label">Reason for Disabling:</label>
                                <select class="form-control select2" multiple="multiple" id="disableReason" name="reason"
                                    style="width: 100%" required>
                                    <option value="" disabled>Select a reason</option>
                                    <option value="fees">Outstanding Fees</option>
                                    <option value="academic">Academic Probation</option>
                                    <option value="misconduct">Misconduct</option>
                                    {{-- Add more reasons as needed --}}
                                </select>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="checkboxPrimary3">
                                <label for="checkboxPrimary3">
                                    Disable and Send SMS notification
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="disableStudentButton">Disable
                            Student</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    {{-- Include Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        // Initialize Select2 on both fields
        $('.select2').select2();

        // Modal form submission (dummy action)
        $('#disableStudentButton').on('click', function() {
            const student = $('#studentSelect').val();
            const reason = $('#disableReason').val();

            if (!student || !reason) {
                alert('Please select both a student and a reason.');
                return;
            }

            // Simulate disabling student
            alert(`Student disabled: ${student}, Reason: ${reason}`);

            // Close modal (in a real scenario, submit form to backend)
            $('#disableStudentModal').modal('hide');
        });
    </script>
@endpush

@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Student Admission')
@section('content_header_title', 'Students')
@section('content_header_subtitle', 'Admit Students')

{{-- Content body: main page content --}}
@section('content_body')

    {{-- Button to trigger the admission modal --}}
    <div class="card-header row">
        <div class="col-md-9 d-flex align-items-center">
            <h1 class="card-title mb-0">Admit Students</h1>
        </div>

        <div class="col-md-3 d-flex justify-content-end">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#admitStudentModal">
                Admit New Students
            </button>
        </div>
    </div>


    {{-- Table showing admitted students --}}
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Exam Number</th>
                    <th>Student Name</th>
                    <th>Grade</th>
                    <th>Class</th>
                    <th>Admitted Term</th>
                    <th>Admitted Year</th>
                    <th>Admitted By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dummy Data --}}
                <tr>
                    <td>123456</td>
                    <td>John Doe</td>
                    <td>10</td>
                    <td>A</td>
                    <td>Term 1</td>
                    <td>2024</td>
                    <td>Admin</td>
                    <td>
                        <button class="btn btn-sm btn-danger">Remove</button>
                    </td>
                </tr>
                <tr>
                    <td>654321</td>
                    <td>Jane Smith</td>
                    <td>12</td>
                    <td>B</td>
                    <td>Term 2</td>
                    <td>2024</td>
                    <td>Admin</td>
                    <td>
                        <button class="btn btn-sm btn-danger">Remove</button>
                    </td>
                </tr>
                {{-- Add more rows as needed --}}
            </tbody>
        </table>
    </div>

    {{-- Modal for admitting students --}}
    <div class="modal fade" id="admitStudentModal" tabindex="-1" aria-labelledby="admitStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="admitStudentModalLabel">Admit New Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Admission Form --}}
                    <form action="" method="POST">
                        @csrf
                        {{-- Academic Year --}}
                        <div class="form-group">
                            <label for="academic_year">Academic Year</label>
                            <select class="form-control" id="academic_year" name="academic_year" required>
                                <option value="" selected disabled>Select Academic Year</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>

                        {{-- Term --}}
                        <div class="form-group">
                            <label for="term">Term</label>
                            <select class="form-control" id="term" name="term" required>
                                <option value="" selected disabled>Select Term</option>
                                <option value="1">Term 1</option>
                                <option value="2">Term 2</option>
                                <option value="3">Term 3</option>
                            </select>
                        </div>

                        {{-- Students List --}}
                        <div class="form-group">
                            <label for="students">Select Students to Admit</label>
                            <select class="form-control select2" id="students" name="students[]" multiple="multiple"
                                required>
                                <option value="1">John Doe - Grade 10</option>
                                <option value="2">Jane Smith - Grade 12</option>
                                <option value="3">Albert Banda - Grade 9</option>
                                <option value="4">Linda Mwansa - Grade 8</option>
                                {{-- Dynamically generated student list --}}
                            </select>
                        </div>

                        {{-- Admission Date --}}
                        <div class="form-group">
                            <label for="admission_date">Admission Date</label>
                            <input type="date" class="form-control" id="admission_date" name="admission_date" required>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-success">Admit Students</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- <link rel="stylesheet" href="/css/custom_datatables.css"> --}}
    <style>
        /* Custom styles for the admission page */
        /* .modal-header {
                    background-color: #007bff;
                    color: white;
                } */
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(document).ready(function() {
            // Initialize select2 for student selection
            $('.select2').select2();
        });
    </script>
@endpush

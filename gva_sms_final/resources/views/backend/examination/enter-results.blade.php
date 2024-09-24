@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Results Sheet')
@section('content_header_title', 'Examination')
@section('content_header_subtitle', 'Enter Results')

{{-- Content body: main page content --}}
@section('content_body')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Enter Results</h5>
    </div>

    <div class="card-body">
        {{-- Form for selecting academic year, term, grade, class, and subject --}}
        <form id="resultsForm">
            <div class="form-row">
                <div class="form-group col-md-3  ">
                    <label for="academicYear">Academic Year</label>
                    <select id="academicYear" class="form-control">
                        <option selected disabled>Select Academic Year</option>
                        <option>2023/2024</option>
                        <option>2024/2025</option>
                        <option>2025/2026</option>
                        {{-- Add more years as needed --}}
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="term">Term</label>
                    <select id="term" class="form-control">
                        <option selected disabled>Select Term</option>
                        <option>Term 1</option>
                        <option>Term 2</option>
                        <option>Term 3</option>
                        {{-- Add more terms as needed --}}
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="grade">Grade</label>
                    <select id="grade" class="form-control">
                        <option selected disabled>Select Grade</option>
                        <option>Grade 10</option>
                        <option>Grade 11</option>
                        <option>Grade 12</option>
                        {{-- Add more grades as needed --}}
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="class">Class</label>
                    <select id="class" class="form-control">
                        <option selected disabled>Select Class</option>
                        <option>Class A</option>
                        <option>Class B</option>
                        <option>Class C</option>
                        {{-- Add more classes as needed --}}
                    </select>
                </div>
                <div class="form-group col-md-3 mt-3">
                    <label for="subject">Subject</label>
                    <select id="subject" class="form-control">
                        <option selected disabled>Select Subject</option>
                        <option>Mathematics</option>
                        <option>English</option>
                        <option>Science</option>
                        {{-- Add more subjects as needed --}}
                    </select>
                </div>
                <div class="form-group col-md-3 mt-3">
                    <button type="button" id="showRegister" class="btn btn-primary">Show Class Register</button>
                </div>
            </div>

            <div id="classRegister" class="mt-4" style="display: none;">
                {{-- Table for entering results --}}
                <h5 class="mb-3">Class Register</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Results</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dummy Data --}}
                            <tr>
                                <td>STU-001</td>
                                <td>John Doe</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Enter result here" />
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm mark-absent" type="button">Absent</button>
                                    <button class="btn btn-success btn-sm mark-present" type="button" style="display: none;">Enter</button>
                                </td>
                            </tr>
                            <tr>
                                <td>STU-002</td>
                                <td>Jane Smith</td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Enter result here" />
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm mark-absent" type="button">Absent</button>
                                    <button class="btn btn-success btn-sm mark-present" type="button" style="display: none;">Enter</button>
                                </td>
                            </tr>
                            {{-- Add more students as needed --}}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Save Results</button>
            </div>
        </form>
    </div>
</div>

@stop

{{-- Push extra CSS --}}
@push('css')
<link rel="stylesheet" href="/css/custom_datatables.css">
<style>
    .table th, .table td {
        text-align: center;
    }
    .mark-absent {
        cursor: pointer;
    }
    .mark-present {
        cursor: pointer;
    }
    .form-control[disabled] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
@endpush

{{-- Push extra scripts --}}
@push('js')
<script>
    // JavaScript to handle showing class register
    document.getElementById('showRegister').addEventListener('click', function() {
        document.getElementById('classRegister').style.display = 'block';
    });

    // JavaScript to handle marking as absent
    document.querySelectorAll('.mark-absent').forEach(button => {
        button.addEventListener('click', function() {
            const inputField = this.closest('tr').querySelector('input.form-control');
            const enterButton = this.closest('tr').querySelector('.mark-present');
            inputField.value = 'ABSENT';
            inputField.setAttribute('disabled', true);
            this.style.display = 'none';
            enterButton.style.display = 'inline-block';
        });
    });

    // JavaScript to handle marking as present
    document.querySelectorAll('.mark-present').forEach(button => {
        button.addEventListener('click', function() {
            const inputField = this.closest('tr').querySelector('input.form-control');
            inputField.removeAttribute('disabled');
            inputField.focus();
            this.style.display = 'none';
            this.closest('tr').querySelector('.mark-absent').style.display = 'inline-block';
        });
    });

    // JavaScript to handle form submission
    document.getElementById('resultsForm').addEventListener('submit', function(event) {
        event.preventDefault();
        // Add logic to handle form submission
        alert('Results have been saved.');
    });
</script>
@endpush

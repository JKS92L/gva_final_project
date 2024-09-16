@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'View Results')
@section('content_header_title', 'Pupil/Parent Portal')
@section('content_header_subtitle', 'View and Query Results')

{{-- Content body: main page content --}}
@section('content_body')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Select Student, Year, and Term</h5>
        </div>

        <div class="card-body">
            {{-- Form to select pupil, academic year, and term --}}
            <form id="filterResultsForm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="studentName">Student Name</label>
                            <select class="form-control" id="studentName" required>
                                <option value="" disabled selected>Select Student</option>
                                <option value="John Doe">John Doe</option>
                                <option value="Jane Smith">Jane Smith</option>
                                {{-- Add more students as needed --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="academicYear">Academic Year</label>
                            <select class="form-control" id="academicYear" required>
                                <option value="" disabled selected>Select Year</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                {{-- Add more years as needed --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="term">Term</label>
                            <select class="form-control" id="term" required>
                                <option value="" disabled selected>Select Term</option>
                                <option value="Term 1">Term 1</option>
                                <option value="Term 2">Term 2</option>
                                <option value="Term 3">Term 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Show Results</button>
            </form>

            {{-- Results Section --}}
            <div id="resultsSection" class="mt-5" style="display:none;">
                <h5 class="mb-4">Results for <span id="studentNameDisplay"></span> - <span
                        id="academicYearDisplay"></span>, <span id="termDisplay"></span></h5>

                {{-- Student Info --}}
                <div class="mb-3">
                    <p><strong>Grade:</strong> <span id="studentGrade">10</span></p>
                    <p><strong>Class:</strong> <span id="studentClass">A</span></p>
                    <p><strong>Class Teacher:</strong> <span id="classTeacher">Mr. John Mwansa</span></p>
                    <p><strong>Student Type:</strong> <span id="studentType">Boarder</span></p>
                </div>

                {{-- Results Table --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Marks (%)</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dummy Data --}}
                            <tr>
                                <td>Mathematics</td>
                                <td>Mr. John Mwansa</td>
                                <td>85%</td>
                                <td>A</td>
                                <td>Excellent</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#queryModal"
                                        data-subject="Mathematics">Send Query</button>
                                </td>
                            </tr>
                            <tr>
                                <td>English</td>
                                <td>Ms. Alice Mulenga</td>
                                <td>65%</td>
                                <td>B</td>
                                <td>Good</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#queryModal"
                                        data-subject="English">Send Query</button>
                                </td>
                            </tr>
                            {{-- Add more rows as needed --}}
                        </tbody>
                    </table>
                </div>

                {{-- View Report Card Button --}}
                <button class="btn btn-primary mt-4" data-toggle="modal" data-target="#reportCardModal">View & Print Report
                    Card</button>
            </div>

            {{-- Query Modal for Sending Message --}}
            <div class="modal fade" id="queryModal" tabindex="-1" role="dialog" aria-labelledby="queryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="queryModalLabel">Send Query</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="queryForm">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="queryType">Query Type</label>
                                    <select class="form-control" id="queryType" required>
                                        <option value="" disabled selected>Select Query Type</option>
                                        <option value="Poor Results">Poor Results</option>
                                        <option value="Incorrect Results">Incorrect Results</option>
                                        <option value="Missing Results">Missing Results</option>
                                        <option value="Clarification Needed">Clarification Needed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="queryMessage">Message</label>
                                    <textarea class="form-control" id="queryMessage" rows="4" placeholder="Write your message here..." required></textarea>
                                </div>
                                <input type="hidden" id="teacherEmail" value="headteacher@example.com">
                                {{-- Placeholder for teacher's email --}}
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitQuery">Send Query</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Report Card Modal --}}
            <div class="modal fade" id="reportCardModal" tabindex="-1" role="dialog"
                aria-labelledby="reportCardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportCardModalLabel">Report Card</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- Report Card --}}
                            <div id="reportCardContent">
                                <h3 class="text-center">Secondary School Report Card</h3>
                                <p><strong>Student Name:</strong> <span id="reportCardStudentName">John Sitwala</span></p>
                                <p><strong>Grade:</strong> <span id="reportCardGrade">10</span></p>
                                <p><strong>Term:</strong> <span id="reportCardTerm">2</span></p>
                                <p><strong>Academic Year:</strong> <span id="reportCardYear">2023</span></p>
                                <p><strong>Class:</strong> <span id="reportCardClass">A</span></p>
                                <p><strong>Class Teacher:</strong> <span id="reportCardClassTeacher">Mr. Kabinga
                                        Mwansa</span></p>
                                <p><strong>Student Type:</strong> <span id="reportCardStudentType">Boarder</span></p>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Marks (%)</th>
                                            <th>Grade</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportCardTableBody">
                                        <tr>
                                            <td>Mathematics</td>
                                            <td>85%</td>
                                            <td>A</td>
                                            <td>Excellent</td>
                                        </tr>
                                        <tr>
                                            <td>English</td>
                                            <td>75%</td>
                                            <td>B</td>
                                            <td>Good</td>
                                        </tr>
                                        {{-- Add more subjects as needed --}}
                                    </tbody>
                                </table>
                                <p><strong>Overall Remarks:</strong> Excellent performance overall.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="printReportCard()">Print Report
                                Card</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Push extra CSS --}}
@push('css')
    <link rel="stylesheet" href="/css/custom_datatables.css">
    <style>
        .table th,
        .table td {
            text-align: center;
        }
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        // JavaScript to handle showing results based on selected filters
        document.getElementById('filterResultsForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const studentName = document.getElementById('studentName').value;
            const academicYear = document.getElementById('academicYear').value;
            const term = document.getElementById('term').value;

            if (studentName && academicYear && term) {
                document.getElementById('studentNameDisplay').textContent = studentName;
                document.getElementById('academicYearDisplay').textContent = academicYear;
                document.getElementById('termDisplay').textContent = term;
                document.getElementById('resultsSection').style.display = 'block';
            }
        });

        // JavaScript to handle sending queries
        $('#queryModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const subject = button.data('subject');
            const modal = $(this);
            modal.find('.modal-body #subject').val(subject);
        });

        // Print report card
        function printReportCard() {
            const printContent = document.getElementById('reportCardContent').innerHTML;
            const newWindow = window.open('', '', 'width=800,height=600');
            newWindow.document.write('<html><head><title>Print Report Card</title></head><body>');
            newWindow.document.write(printContent);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
        }
    </script>
@endpush

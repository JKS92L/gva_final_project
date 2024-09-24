@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Teachers Repor')
@section('content_header_title', 'Teachers')
@section('content_header_subtitle', 'Reports')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- content here --}}
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-teacher-observation-tab" data-toggle="pill"
                                href="#custom-tabs-teacher-observation" role="tab"
                                aria-controls="custom-tabs-teacher-observation" aria-selected="true">Lesson Observation
                                Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-file-observation-tab" data-toggle="pill"
                                href="#custom-tabs-file-observation" role="tab"
                                aria-controls="custom-tabs-file-observation" aria-selected="false">File Observation
                                Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-senior-performance-tab" data-toggle="pill"
                                href="#custom-tabs-senior-performance" role="tab"
                                aria-controls="custom-tabs-senior-performance" aria-selected="false">Teachers' Exam Report
                                (SENIOR)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-junior-exam-tab" data-toggle="pill"
                                href="#custom-tabs-junior-exam" role="tab" aria-controls="custom-tabs-junior-exam"
                                aria-selected="false">Teachers' Exam Performance (Junior)</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">

                        <!-- Teacher's Observation Report Tab -->
                        <div class="tab-pane fade show active" id="custom-tabs-teacher-observation" role="tabpanel"
                            aria-labelledby="custom-tabs-teacher-observation-tab">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Lesson Observation Report</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">

                                        {{-- <table class="table table-hover text-nowrap" id="teacherObservationTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Teacher</th>
                                                    <th>Subject</th>
                                                    <th>Grade</th>
                                                    <th>Observation Date</th>
                                                    <th>Comments</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Jane Smith</td>
                                                    <td>Mathematics</td>
                                                    <td>Grade 12</td>
                                                    <td>2023-08-25</td>
                                                    <td>Excellent teaching methods</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> --}}

                                        <table class="table table-hover text-nowrap" id="teacherObservationTable">
                                            <thead>
                                                <tr>
                                                    <th>Observation Date<i class="fas fa-sort"></th>
                                                    <th>Teacher's Name<i class="fas fa-sort"></th>
                                                    <th>Observer's Name<i class="fas fa-sort"></th>
                                                    <th>Subject<i class="fas fa-sort"></th>
                                                    <th>Class<i class="fas fa-sort"></th>
                                                    <th>Topic<i class="fas fa-sort"></th>
                                                    <th>Time Observed<i class="fas fa-sort"></th>
                                                    <th>Observation Type<i class="fas fa-sort"></th>
                                                    <th>Performance Rating<i class="fas fa-sort"></th>
                                                    <th>Notes/Comments</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>01/09/2024</td>
                                                    <td>Mutinta Mwape</td>
                                                    <td>Chanda Nsofwa</td>
                                                    <td>Mathematics</td>
                                                    <td>Grade 11B</td>
                                                    <td>Linear Equations</td>
                                                    <td>09:00 AM - 10:00 AM</td>
                                                    <td>Unannounced</td>
                                                    <td>Excellent</td>
                                                    <td>Engaged students with clear explanations.</td>
                                                    <td>
                                                        <button class="btn btn-info" data-toggle="modal"
                                                            data-target="#viewObservationModal">View More</button>
                                                        <button class="btn btn-warning">Edit</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>02/09/2024</td>
                                                    <td>Henry Banda</td>
                                                    <td>Florence Zulu</td>
                                                    <td>English</td>
                                                    <td>Grade 9A</td>
                                                    <td>Writing Skills</td>
                                                    <td>10:00 AM - 11:00 AM</td>
                                                    <td>Announced</td>
                                                    <td>Good</td>
                                                    <td>Good student participation, needs more visuals.</td>
                                                    <td>
                                                        <button class="btn btn-info" data-toggle="modal"
                                                            data-target="#viewObservationModal">View More</button>
                                                        <button class="btn btn-warning">Edit</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>03/09/2024</td>
                                                    <td>Chileshe Lungu</td>
                                                    <td>Emmanuel Mwila</td>
                                                    <td>Science</td>
                                                    <td>Grade 8C</td>
                                                    <td>Human Digestive System</td>
                                                    <td>08:00 AM - 09:00 AM</td>
                                                    <td>Unannounced</td>
                                                    <td>Fair</td>
                                                    <td>Struggled with student engagement.</td>
                                                    <td>
                                                        <button class="btn btn-info" data-toggle="modal"
                                                            data-target="#viewObservationModal">View More</button>
                                                        <button class="btn btn-warning">Edit</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>04/09/2024</td>
                                                    <td>Margaret Phiri</td>
                                                    <td>Beatrice Mwansa</td>
                                                    <td>History</td>
                                                    <td>Grade 12A</td>
                                                    <td>Colonialism in Africa</td>
                                                    <td>11:00 AM - 12:00 PM</td>
                                                    <td>Announced</td>
                                                    <td>Excellent</td>
                                                    <td>Lesson was well-structured and interactive.</td>
                                                    <td>
                                                        <button class="btn btn-info" data-toggle="modal"
                                                            data-target="#viewObservationModal">View More</button>
                                                        <button class="btn btn-warning">Edit</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>05/09/2024</td>
                                                    <td>Brighton Mulenga</td>
                                                    <td>Josephine Chikonde</td>
                                                    <td>Geography</td>
                                                    <td>Grade 10C</td>
                                                    <td>Weather and Climate</td>
                                                    <td>12:00 PM - 01:00 PM</td>
                                                    <td>Unannounced</td>
                                                    <td>Good</td>
                                                    <td>Clear instructions, but students lacked participation.</td>
                                                    <td>
                                                        <button class="btn btn-info" data-toggle="modal"
                                                            data-target="#viewObservationModal">View More</button>
                                                        <button class="btn btn-warning">Edit</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- teacher lesson observation modal --}}
                        <!-- View More Modal -->
                        <div class="modal fade" id="viewObservationModal" tabindex="-1" role="dialog"
                            aria-labelledby="viewObservationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewObservationModalLabel">Teacher's Observation Report
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Teacher and Observer Information -->
                                        <h6>Teacher Information</h6>
                                        <p><strong>Name:</strong> John Doe</p>
                                        <p><strong>Teacher ID:</strong> T12345</p>
                                        <p><strong>Subject:</strong> Mathematics</p>
                                        <p><strong>Class:</strong> Grade 10A</p>
                                        <p><strong>Topic:</strong> Quadratic Equations</p>
                                        <p><strong>Time Observed:</strong> 08:00 AM - 09:00 AM</p>
                                        <p><strong>Date:</strong> 5th September 2024</p>

                                        <!-- Observer Information -->
                                        <h6>Observer Information</h6>
                                        <p><strong>Observer Name:</strong> Jane Smith</p>
                                        <p><strong>Position:</strong> Head of Department</p>

                                        <!-- Observation Details -->
                                        <h6>Observation Details</h6>
                                        <p><strong>Lesson Objectives:</strong> Clear</p>
                                        <p><strong>Lesson Delivery:</strong> Engaging, with good use of examples</p>
                                        <p><strong>Classroom Management:</strong> Excellent control of student behavior</p>
                                        <p><strong>Resources Used:</strong> Textbook, interactive whiteboard</p>
                                        <p><strong>Student Participation:</strong> Very active, with frequent student
                                            engagement</p>

                                        <!-- Performance Ratings -->
                                        <h6>Performance Ratings</h6>
                                        <ul>
                                            <li><strong>Lesson Planning:</strong> 5/5</li>
                                            <li><strong>Instruction Delivery:</strong> 4/5</li>
                                            <li><strong>Student Engagement:</strong> 4/5</li>
                                            <li><strong>Classroom Management:</strong> 5/5</li>
                                            <li><strong>Use of Teaching Aids:</strong> 4/5</li>
                                            <li><strong>Feedback to Students:</strong> 5/5</li>
                                        </ul>

                                        <!-- Final Comments -->
                                        <h6>Observer's Final Comments</h6>
                                        <p>Excellent lesson delivery with strong classroom management skills.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            onclick="printObservation()">Print</button>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="editObservation()">Edit</button>
                                        <button type="button" class="btn btn-success" onclick="exportToPDF()">Export to
                                            PDF</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- File Observation Report Tab -->
                        <div class="tab-pane fade" id="custom-tabs-file-observation" role="tabpanel"
                            aria-labelledby="custom-tabs-file-observation-tab">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">File Observation Report</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap" id="fileObservationTable">
                                            <thead>
                                                <tr>
                                                    <th>TCZ #</th>
                                                    <th>Teacher's Name</th>
                                                    <th>Observer/Monitor</th>
                                                    <th>Monitor's Position</th>
                                                    <th>Rating</th>
                                                    <th>Comments</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>TCZ12345</td>
                                                    <td>Mutinta Mwape</td>
                                                    <td>Chanda Nsofwa</td>
                                                    <td>Head Teacher</td>
                                                    <td>Excellent</td>
                                                    <td>Well-prepared lesson plan.</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#viewFileObservationModal">View More</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TCZ67890</td>
                                                    <td>Henry Banda</td>
                                                    <td>Florence Zulu</td>
                                                    <td>Deputy Head</td>
                                                    <td>Good</td>
                                                    <td>Detailed but needs more student engagement.</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#viewFileObservationModal">View More</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TCZ54321</td>
                                                    <td>Margaret Phiri</td>
                                                    <td>Emmanuel Mwila</td>
                                                    <td>Senior Teacher</td>
                                                    <td>Fair</td>
                                                    <td>Missing details in marking scheme.</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#viewFileObservationModal">View More</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal - File Observation Report -->
                        <div class="modal fade" id="viewFileObservationModal" tabindex="-1" role="dialog"
                            aria-labelledby="viewFileObservationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewFileObservationModalLabel">Observation Details
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- File Observation Details Here -->
                                        <p><strong>TCZ #:</strong> TCZ12345</p>
                                        <p><strong>Teacher's Name:</strong> Mutinta Mwape</p>
                                        <p><strong>Observer/Monitor:</strong> Chanda Nsofwa</p>
                                        <p><strong>Monitor's Position:</strong> Head Teacher</p>
                                        <p><strong>Rating:</strong> Excellent</p>
                                        <p><strong>Comments:</strong> Well-prepared lesson plan.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-sm btn-primary" onclick="window.print()">Print</button>
                                        <button class="btn btn-sm btn-success">Export to PDF</button>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ECZ Performance Report Tab -->
                        <div class="tab-pane fade" id="custom-tabs-senior-performance" role="tabpanel"
                            aria-labelledby="custom-tabs-senior-performance-tab">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Teachers' Exam Performance Report(Senior)</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">

                                        <table class="table table-hover text-nowrap" id="teacherGradesTable">
                                            <thead>
                                                <tr>
                                                    <th>TCZ # <i class="fas fa-sort"> </th>
                                                    <th>Teacher's Name<i class="fas fa-sort"> </th>
                                                    <th>Exam Year<i class="fas fa-sort"> </th>
                                                    <th>Exam Type<i class="fas fa-sort"> </th>
                                                    <th>Subject<i class="fas fa-sort"> </th>
                                                    <th>Grade<i class="fas fa-sort"> </th>
                                                    <th>Distinction One<i class="fas fa-sort"> </th>
                                                    <th>Distinction Two<i class="fas fa-sort"> </th>
                                                    <th>Merit Three<i class="fas fa-sort"> </th>
                                                    <th>Merit Four<i class="fas fa-sort"> </th>
                                                    <th>Credit Five<i class="fas fa-sort"> </th>
                                                    <th>Credit Six<i class="fas fa-sort"> </th>
                                                    <th>Satisfactory Seven<i class="fas fa-sort"> </th>
                                                    <th>Satisfactory Eight<i class="fas fa-sort"> </th>
                                                    <th>Unsatisfactory Nine<i class="fas fa-sort"> </th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>TCZ12345</td>
                                                    <td>Mutinta Mwape</td>
                                                    <td>2023</td>
                                                    <td>ECZ</td>
                                                    <td>Mathematics</td>
                                                    <td>Grade 12</td>
                                                    <td>10</td>
                                                    <td>3</td>
                                                    <td>9</td>
                                                    <td>4</td>
                                                    <td>20</td>
                                                    <td>12</td>
                                                    <td>30</td>
                                                    <td>02</td>
                                                    <td>37</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TCZ67845</td>
                                                    <td>Zindaba Mwape</td>
                                                    <td>2023</td>
                                                    <td>Midterm</td>
                                                    <td>English</td>
                                                    <td>Grade 12</td>
                                                    <td>5</td>
                                                    <td>3</td>
                                                    <td>7</td>
                                                    <td>4</td>
                                                    <td>10</td>
                                                    <td>12</td>
                                                    <td>6</td>
                                                    <td>3</td>
                                                    <td>2</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TCZ678095</td>
                                                    <td>Phiri Mwape</td>
                                                    <td>2024</td>
                                                    <td>Term I- Midterm</td>
                                                    <td>History</td>
                                                    <td>Grade 10-BS</td>
                                                    <td>08</td>
                                                    <td>34</td>
                                                    <td>2</td>
                                                    <td>5</td>
                                                    <td>1</td>
                                                    <td>5</td>
                                                    <td>34</td>
                                                    <td>32</td>
                                                    <td>12</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TCZ67845</td>
                                                    <td>Banda Mwape</td>
                                                    <td>2024</td>
                                                    <td>Term III - EOT</td>
                                                    <td>Maths</td>
                                                    <td>Grade 11-NS</td>
                                                    <td>00</td>
                                                    <td>00</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                    <td>10</td>
                                                    <td>03</td>
                                                    <td>02</td>
                                                    <td>12</td>
                                                    <td>11</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <!-- Add more rows as necessary -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Junir Exam Report Tab -->
                        <div class="tab-pane fade" id="custom-tabs-junior-exam" role="tabpanel"
                            aria-labelledby="custom-tabs-junior-exam-tab">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Teachers' Exam Performance (Junior)</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap" id="juniorExamTable">
                                            <thead>
                                                <tr>
                                                    <th>TCZ # <i class="fas fa-sort"> </th>
                                                    <th>Teacher's Name<i class="fas fa-sort"> </th>
                                                    <th>Exam Year<i class="fas fa-sort"> </th>
                                                    <th>Grade<i class="fas fa-sort"> </th>
                                                    <th>Distinction One<i class="fas fa-sort"> </th>
                                                    <th>Distinction Two<i class="fas fa-sort"> </th>
                                                    <th>Merit Three<i class="fas fa-sort"> </th>
                                                    <th>Merit Four<i class="fas fa-sort"> </th>
                                                    <th>Credit Five<i class="fas fa-sort"> </th>
                                                    <th>Credit Six<i class="fas fa-sort"> </th>
                                                    <th>Satisfactory Seven<i class="fas fa-sort"> </th>
                                                    <th>Satisfactory Eight<i class="fas fa-sort"> </th>
                                                    <th>Unsatisfactory Nine<i class="fas fa-sort"> </th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>TCZ12345</td>
                                                    <td>Mutinta Mwape</td>
                                                    <td>2023</td>
                                                    <td>Grade 8C</td>
                                                    <td>5</td>
                                                    <td>3</td>
                                                    <td>7</td>
                                                    <td>4</td>
                                                    <td>10</td>
                                                    <td>12</td>
                                                    <td>6</td>
                                                    <td>3</td>
                                                    <td>2</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TCZ67890</td>
                                                    <td>Henry Banda</td>
                                                    <td>2022</td>
                                                    <td>Grade 9</td>
                                                    <td>8</td>
                                                    <td>6</td>
                                                    <td>5</td>
                                                    <td>7</td>
                                                    <td>9</td>
                                                    <td>8</td>
                                                    <td>5</td>
                                                    <td>4</td>
                                                    <td>3</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary">View</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                                <!-- Add more rows as necessary -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>














@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}
    <link rel="stylesheet" href="/css/custom_datatables.css">
    <style>

    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
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
                return $(selector).closest('.card').find('.card-title').text().trim() || 'Table Export';
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

            var tables = ['#teacherGradesTable', '#juniorExamTable']; // Add other table IDs as needed
            tables.forEach(function(tableSelector) {
                // Check if the table is already initialized
                if ($.fn.DataTable.isDataTable($(
                    tableSelector))) { // Pass the jQuery object, not the string
                    // Destroy the existing DataTable instance
                    $(tableSelector).DataTable().destroy();
                }
            });

            // Trigger reinitialization when a tab is shown
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                initializeDataTable(); // Reinitialize tables when tabs are switched
            });

            // Initialize the DataTable for the teacher grades table with dynamic columns
            initializeDataTable('#teacherGradesTable', true, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]);
            initializeDataTable('#juniorExamTable', true, [0, 1, 2, 3, 4, 5, 6]);

            // Add search buttons ONLY for these tables
            $('#teacherObservationTable').DataTable();
            $('#fileObservationTable').DataTable();

        });
    </script>
@endpush

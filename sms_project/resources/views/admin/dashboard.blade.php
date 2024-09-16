@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Dashboard')
@section('content_header_title', 'Admin')
@section('content_header_subtitle', 'Dashboard')

{{-- Content body: main page content --}}
@section('content_body')



    <div class="row">
        <!-- Pupils Reported -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pupils Reported</span>
                    <span class="info-box-number">
                        450
                        <small>of</small> 500
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- Bedspaces Remaining -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-bed"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Bedspaces Remaining</span>
                    <span class="info-box-number">25</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- Fees Collected vs Uncollected -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wallet"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Fees Collected</span>
                    <span class="info-box-number">
                        K150,000 <small>of</small> K200,000
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- Teachers on Leave -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Teachers on Leave</span>
                    <span class="info-box-number">
                        3 <small>of</small> 40
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <!-- Total Students Chart -->
        <div class="col-lg-6 admin_charts">
            <div id="students_chart" style="width: 100%; height: 400px;"></div>
        </div>

        <!-- Attendance Rate Chart -->
        <div class="col-lg-6 admin_charts">
            <div id="attendance_chart" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <div class="row">
        <!-- Teacher Workload Chart -->
        <div class="col-lg-6 admin_charts">
            <div id="teacher_workload_chart" style="width: 100%; height: 400px;"></div>
        </div>

        <!-- Financial Overview Chart -->
        <div class="col-lg-6 admin_charts">
            <div id="finance_chart" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

    <div class="row">
        <!-- TO DO List -->
        <div class="card col-md-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    To Do List
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm">
                        <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                    </ul>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                    <li>
                        <!-- drag handle -->
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <!-- checkbox -->
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo1" id="todoCheck1">
                            <label for="todoCheck1"></label>
                        </div>
                        <!-- todo text -->
                        <span class="text">Design a nice theme</span>
                        <!-- Emphasis label -->
                        <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                            <label for="todoCheck2"></label>
                        </div>
                        <span class="text">Make the theme responsive</span>
                        <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo3" id="todoCheck3">
                            <label for="todoCheck3"></label>
                        </div>
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo4" id="todoCheck4">
                            <label for="todoCheck4"></label>
                        </div>
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo5" id="todoCheck5">
                            <label for="todoCheck5"></label>
                        </div>
                        <span class="text">Check your messages and notifications</span>
                        <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo6" id="todoCheck6">
                            <label for="todoCheck6"></label>
                        </div>
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
            </div>
        </div>
        {{-- 
        calendar --}}
        {{-- <div class="card bg-gradient-success col-md-6">
            <div class="card-header border-0">

                <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                            data-offset="-52">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a href="#" class="dropdown-item">Add new event</a>
                            <a href="#" class="dropdown-item">Clear events</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">View calendar</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.card-body -->
        </div> --}}
        <div class="card shadow col-md-6">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-question-circle"></i> Exam Queries Summary</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="examQueriesTab" role="tablist">
                    <li class="nav-item text-sm">
                        <a class="nav-link active text-sm" id="incoming-tab" data-toggle="tab" href="#incoming"
                            role="tab" aria-controls="incoming" aria-selected="true">
                            <i class="fas fa-envelope"></i> Incoming Queries
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                            aria-controls="pending" aria-selected="false">
                            <i class="fas fa-hourglass-half"></i> Pending Queries
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved" role="tab"
                            aria-controls="resolved" aria-selected="false">
                            <i class="fas fa-check-circle"></i> Resolved Queries
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="examQueriesTabContent">
                    <!-- Incoming Tab Content -->
                    <div class="tab-pane fade show active" id="incoming" role="tabpanel"
                        aria-labelledby="incoming-tab">
                        <!-- Collapsible Button with Query Subject Title -->
                        <div class="accordion" id="incomingQueriesAccordion">
                            <!-- Query 1 -->
                            <div class="card">
                                <div class="card-header" id="query1Heading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link d-flex justify-content-between align-items-center"
                                            type="button" data-toggle="collapse" data-target="#query1"
                                            aria-expanded="true" aria-controls="query1">
                                            Mathematics Query - Algebra
                                            <i class="fas fa-plus ml-auto"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div id="query1" class="collapse" aria-labelledby="query1Heading"
                                    data-parent="#incomingQueriesAccordion">
                                    <div class="card-body">
                                        <p><strong>Sender:</strong> John Doe</p>
                                        <p><strong>Title:</strong> Difficulty with Algebra</p>
                                        <p><strong>Subject:</strong> Mathematics</p>
                                        <p><strong>Grade & Class:</strong> Grade 10, Class A</p>
                                        <p><strong>Teacher:</strong> Mr. Smith</p>
                                        <p><strong>Message:</strong> The pupil is struggling with factoring polynomials.
                                            Please provide additional resources.</p>
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#messageTeacherModal" data-teacher="Mr. Smith">Message the
                                            Teacher</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Repeat for other queries -->

                        </div>
                    </div>

                    <!-- Pending Tab Content -->
                    <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="accordion" id="pendingQueriesAccordion">
                            <div class="card">
                                <div class="card-header" id="pendingQuery1Heading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link d-flex justify-content-between align-items-center"
                                            type="button" data-toggle="collapse" data-target="#pendingQuery1"
                                            aria-expanded="false" aria-controls="pendingQuery1">
                                            Science Query - Physics
                                            <i class="fas fa-plus ml-auto"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div id="pendingQuery1" class="collapse" aria-labelledby="pendingQuery1Heading"
                                    data-parent="#pendingQueriesAccordion">
                                    <div class="card-body">
                                        <p><strong>Sender:</strong> Mark Johnson</p>
                                        <p><strong>Title:</strong> Understanding Force and Motion</p>
                                        <p><strong>Subject:</strong> Science</p>
                                        <p><strong>Grade & Class:</strong> Grade 9, Class B</p>
                                        <p><strong>Teacher:</strong> Ms. Jackson</p>
                                        <p><strong>Message:</strong> The pupil is struggling with Newton's laws of motion.
                                        </p>
                                        <button class="btn btn-warning" data-toggle="modal"
                                            data-target="#remindTeacherModal" data-teacher="Ms. Jackson">Remind the
                                            Teacher</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Repeat for other pending queries -->

                        </div>
                    </div>

                    <!-- Resolved Tab Content -->
                    <div class="tab-pane fade" id="resolved" role="tabpanel" aria-labelledby="resolved-tab">
                        <div class="accordion" id="resolvedQueriesAccordion">
                            <div class="card">
                                <div class="card-header" id="resolvedQuery1Heading">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link d-flex justify-content-between align-items-center"
                                            type="button" data-toggle="collapse" data-target="#resolvedQuery1"
                                            aria-expanded="false" aria-controls="resolvedQuery1">
                                            English Query - Grammar
                                            <i class="fas fa-plus ml-auto"></i>
                                        </button>
                                    </h5>
                                </div>

                                <div id="resolvedQuery1" class="collapse" aria-labelledby="resolvedQuery1Heading"
                                    data-parent="#resolvedQueriesAccordion">
                                    <div class="card-body">
                                        <p><strong>Sender:</strong> Jane Doe</p>
                                        <p><strong>Title:</strong> Grammar Help</p>
                                        <p><strong>Subject:</strong> English</p>
                                        <p><strong>Grade & Class:</strong> Grade 8, Class C</p>
                                        <p><strong>Teacher:</strong> Mr. James</p>
                                        <p><strong>Message:</strong> The issue has been resolved successfully, and the pupil
                                            is now confident with the rules of subject-verb agreement.</p>
                                        <button class="btn btn-success" data-toggle="modal"
                                            data-target="#congratulateTeacherModal" data-teacher="Mr. James">Congratulate
                                            the Teacher</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Repeat for other resolved queries -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to Message the Teacher -->
        <div class="modal fade" id="messageTeacherModal" tabindex="-1" aria-labelledby="messageTeacherModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageTeacherModalLabel">Message the Teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="teacherName">Teacher:</label>
                                <input type="text" class="form-control" id="teacherName" readonly>
                            </div>
                            <div class="form-group">
                                <label for="messageContent">Message:</label>
                                <textarea class="form-control" id="messageContent" rows="3" placeholder="Type your message here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to Remind the Teacher -->
        <div class="modal fade" id="remindTeacherModal" tabindex="-1" aria-labelledby="remindTeacherModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="remindTeacherModalLabel">Remind the Teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="remindTeacherName">Teacher:</label>
                                <input type="text" class="form-control" id="remindTeacherName" readonly>
                            </div>
                            <div class="form-group">
                                <label for="remindMessageContent">Message:</label>
                                <textarea class="form-control" id="remindMessageContent" rows="3" placeholder="Type your reminder here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">Send Reminder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to Congratulate the Teacher -->
        <div class="modal fade" id="congratulateTeacherModal" tabindex="-1"
            aria-labelledby="congratulateTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="congratulateTeacherModalLabel">Congratulate the Teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="congratulateTeacherName">Teacher:</label>
                                <input type="text" class="form-control" id="congratulateTeacherName" readonly>
                            </div>
                            <div class="form-group">
                                <label for="congratulateMessageContent">Message:</label>
                                <textarea class="form-control" id="congratulateMessageContent" rows="3"
                                    placeholder="Congratulate the teacher here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Send Congratulations</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>








@stop

{{-- Push extra CSS --}}
@push('css')
    <style>
        /* Add any custom styles here */

        .info-box {
            transition: all 0.3s ease;
            /* Smooth transition for all properties */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            /* Initial subtle shadow */
        }

        .info-box:hover {
            transform: translateY(-5px);
            /* Move the box slightly up on hover */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            /* Enhanced shadow on hover */
        }

        .info-box .info-box-icon {
            transition: all 0.3s ease;
            /* Smooth transition for the icon background */
        }

        .info-box:hover .info-box-icon {
            background-color: #d9534f;
            /* Change background color of the icon on hover */
        }

        .info-box .info-box-text,
        .info-box .info-box-number {
            transition: color 0.3s ease;
            /* Smooth transition for text color */
        }

        .info-box:hover .info-box-text,
        .info-box:hover .info-box-number {
            color: #333;
            /* Change text color on hover */
        }

        /* Card body styling */
        .card-body {
            padding: 1rem;
        }

        /* Tabs header style */
        .nav-tabs .nav-link {
            font-size: 0.9rem;
            /* Slightly smaller font */
            padding: 0.5rem 1rem;
            /* Adjust padding for a cleaner look */
        }

        /* To make the table content scrollable */
        .tab-content {
            max-height: 300px;
            /* Adjust height as needed */
            overflow-y: auto;
            /* Enable vertical scrolling */
            padding: 0.5rem;
        }

        /* Fix header of tabs */
        .nav-tabs {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #ffffff;
            /* Keep the background white when scrolling */
            padding: 0.5rem 0;
            border-bottom: 1px solid #dee2e6;
        }

        /* Accordion button style */
        .card-header button {
            font-size: 0.85rem;
            /* Slightly smaller text */
            text-align: left;
            width: 100%;
            padding: 0.5rem;
            font-weight: 500;
        }

        .card-body {
            font-size: 0.85rem;
            /* Slightly smaller content text */
        }

        .btn-link {
            color: #007bff;
        }

        .btn-link:hover {
            color: #0056b3;
            text-decoration: none;
        }

        /* Make the card shadow subtle */
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    {{-- <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js"></script> --}}
    <script>
        // $('#calendar').datetimepicker({
        //     format: 'L', // Format of the date
        //     inline: true, // Display the calendar inline
        //     sideBySide: true // Show date and time side by side
        // });
        // $(document).ready(function() {

        // });

        // Set teacher name in the message modal
        $('#messageTeacherModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var teacherName = button.data('teacher'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('.modal-body #teacherName').val(teacherName);
        });

        // Set teacher name in the remind modal
        $('#remindTeacherModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var teacherName = button.data('teacher');
            var modal = $(this);
            modal.find('.modal-body #remindTeacherName').val(teacherName);
        });

        // Set teacher name in the congratulate modal
        $('#congratulateTeacherModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var teacherName = button.data('teacher');
            var modal = $(this);
            modal.find('.modal-body #congratulateTeacherName').val(teacherName);
        });



        // Total Students by Grade Chart
        anychart.onDocumentReady(function() {
            var data = [{
                    x: "Grade 1",
                    value: 120
                },
                {
                    x: "Grade 2",
                    value: 150
                },
                {
                    x: "Grade 3",
                    value: 130
                },
                {
                    x: "Grade 4",
                    value: 170
                },
                {
                    x: "Grade 5",
                    value: 200
                }
            ];

            var chart = anychart.pie(data);
            chart.title("Total Students by Grade");
            chart.container("students_chart");
            chart.draw();
        });

        // Attendance Rate Over Time Chart
        anychart.onDocumentReady(function() {
            var data = [
                ['January', 96],
                ['February', 92],
                ['March', 89],
                ['April', 95],
                ['May', 98],
                ['June', 93]
            ];

            var chart = anychart.line();
            chart.title("Attendance Rate Over Time");
            var series = chart.line(data);
            series.name('Attendance Rate (%)');
            chart.container("attendance_chart");
            chart.draw();
        });

        // Teacher Workload Distribution Chart
        anychart.onDocumentReady(function() {
            var data = [{
                    x: "Teacher A",
                    value: 25
                },
                {
                    x: "Teacher B",
                    value: 20
                },
                {
                    x: "Teacher C",
                    value: 30
                },
                {
                    x: "Teacher D",
                    value: 35
                },
                {
                    x: "Teacher E",
                    value: 28
                }
            ];

            var chart = anychart.bar();
            chart.title("Teacher Workload Distribution");
            chart.data(data);
            chart.container("teacher_workload_chart");
            chart.draw();
        });

        // Financial Overview Chart (Income vs Expenses)
        anychart.onDocumentReady(function() {
            var data = [{
                    x: "Income",
                    value: 50000
                },
                {
                    x: "Expenses",
                    value: 30000
                }
            ];

            var chart = anychart.column();
            chart.title("Financial Overview: Income vs Expenses");
            chart.data(data);
            chart.container("finance_chart");
            chart.draw();
        });

        // Performance by Subject Chart
        anychart.onDocumentReady(function() {
            var data = [{
                    x: "Math",
                    value: 80
                },
                {
                    x: "Science",
                    value: 75
                },
                {
                    x: "English",
                    value: 85
                },
                {
                    x: "History",
                    value: 90
                },
                {
                    x: "Geography",
                    value: 70
                }
            ];

            var chart = anychart.radar();
            chart.title("Student Performance by Subject");
            chart.data(data);
            chart.container("performance_chart");
            chart.draw();
        });
    </script>
@endpush

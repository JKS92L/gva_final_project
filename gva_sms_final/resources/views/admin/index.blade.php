@extends('admin.admim-master')
@section('admin_content')
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
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
                            <span class="info-box-icon bg-warning elevation-1"><i
                                    class="fas fa-chalkboard-teacher"></i></span>

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
                    {{-- <div class="col-lg-6 admin_charts">
                        <div id="students_chart" style="width: 100%; height: 400px;"></div>
                    </div>

                    <!-- Attendance Rate Chart -->
                    <div class="col-lg-6 admin_charts">
                        <div id="attendance_chart" style="width: 100%; height: 400px;"></div>
                    </div> --}}
                </div>

                <div class="row">
                    <!-- Teacher Workload Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Sales</h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">$18,230.00</span>
                                        <span>Sales Over Time</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> 33.1%
                                        </span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                    <canvas id="sales-chart" height="200"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> This year
                                    </span>

                                    <span>
                                        <i class="fas fa-square text-gray"></i> Last year
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card -->

                    <!-- To do list -->
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
                            <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add
                                item</button>
                        </div>
                    </div>


                </div>


                {{-- modals  --}}
                <div class="row">
                    <!-- Modal to Message the Teacher -->
                    <div class="modal fade" id="messageTeacherModal" tabindex="-1"
                        aria-labelledby="messageTeacherModalLabel" aria-hidden="true">
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
                    <div class="modal fade" id="remindTeacherModal" tabindex="-1"
                        aria-labelledby="remindTeacherModalLabel" aria-hidden="true">
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
                                    <h5 class="modal-title" id="congratulateTeacherModalLabel">Congratulate the Teacher
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="congratulateTeacherName">Teacher:</label>
                                            <input type="text" class="form-control" id="congratulateTeacherName"
                                                readonly>
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
                <div class="div col-md-12">
                    <div class="card">
                        <div class="card-header bg-gray text-white">
                            <h3 class="card-title"><i class="fas fa-question-circle"></i> Exam Queries Summary</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="examQueriesTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="incoming-tab" data-toggle="tab" href="#incoming"
                                        role="tab" aria-controls="incoming" aria-selected="true">
                                        <i class="fas fa-envelope"></i> Incoming Queries
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending"
                                        role="tab" aria-controls="pending" aria-selected="false">
                                        <i class="fas fa-hourglass-half"></i> Pending Queries
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved"
                                        role="tab" aria-controls="resolved" aria-selected="false">
                                        <i class="fas fa-check-circle"></i> Resolved Queries
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-4 mt-0" id="examQueriesTabContent">
                                <!-- Incoming Tab Content -->
                                <div class="tab-pane fade show active" id="incoming" role="tabpanel"
                                    aria-labelledby="incoming-tab">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Query ID</th>
                                                    <th>Sender</th>
                                                    <th>Subject</th>
                                                    <th>Title</th>
                                                    <th>Grade & Class</th>
                                                    <th>Teacher</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Query Row -->
                                                <tr>
                                                    <td>Q12345</td>
                                                    <td>John Doe</td>
                                                    <td>Mathematics</td>
                                                    <td>Difficulty with Algebra</td>
                                                    <td>Grade 10, Class A</td>
                                                    <td>Mr. Smith</td>
                                                    <td><span class="badge badge-primary">Incoming</span></td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#viewDetailsModal" data-query-id="Q12345">View
                                                            Details</button>
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#messageTeacherModal"
                                                            data-teacher="Mr. Smith">Message Teacher</button>
                                                    </td>
                                                </tr>
                                                <!-- Repeat for other incoming queries -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Pending Tab Content -->
                                <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Query ID</th>
                                                    <th>Sender</th>
                                                    <th>Subject</th>
                                                    <th>Title</th>
                                                    <th>Grade & Class</th>
                                                    <th>Teacher</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Query Row -->
                                                <tr>
                                                    <td>Q67890</td>
                                                    <td>Mark Johnson</td>
                                                    <td>Science</td>
                                                    <td>Understanding Force and Motion</td>
                                                    <td>Grade 9, Class B</td>
                                                    <td>Ms. Jackson</td>
                                                    <td><span class="badge badge-warning">Pending</span></td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#viewDetailsModal" data-query-id="Q67890">View
                                                            Details</button>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#messageTeacherModal"
                                                            data-teacher="Ms. Jackson">Message Teacher</button>
                                                    </td>
                                                </tr>
                                                <!-- Repeat for other pending queries -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Resolved Tab Content -->
                                <div class="tab-pane fade" id="resolved" role="tabpanel"
                                    aria-labelledby="resolved-tab">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Query ID</th>
                                                    <th>Sender</th>
                                                    <th>Subject</th>
                                                    <th>Title</th>
                                                    <th>Grade & Class</th>
                                                    <th>Teacher</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Example Query Row -->
                                                <tr>
                                                    <td>Q54321</td>
                                                    <td>Jane Doe</td>
                                                    <td>English</td>
                                                    <td>Grammar Help</td>
                                                    <td>Grade 8, Class C</td>
                                                    <td>Mr. James</td>
                                                    <td><span class="badge badge-success">Resolved</span></td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#viewDetailsModal" data-query-id="Q54321">View
                                                            Details</button>
                                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                                            data-target="#messageTeacherModal"
                                                            data-teacher="Mr. James">Congratulate Teacher</button>
                                                    </td>
                                                </tr>
                                                <!-- Repeat for other resolved queries -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
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
    </script>
@endsection

@extends('admin.admim-master')
@section('admin_content')
    <div class="container mt-7">
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <h1>Attendance Management</h1>
                <p class="text-muted">Manage attendance records for daily and session registers with detailed status options.
                </p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily"
                    aria-selected="true">Daily Attendance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="period-tab" data-toggle="tab" href="#period" role="tab" aria-controls="period"
                    aria-selected="false">Session Register</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Daily Attendance -->
            <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
                <div class="card">
                    <div class="card-header">
                        <h5>Daily Attendance Register</h5>
                    </div>
                    <div class="card-body">
                        <form id="dailyAttendanceForm">
                            <div class="mb-3">
                                <label for="classSelect" class="form-label">Select Class</label>
                                <select id="classSelect" class="form-control">
                                    <option value="">Select a class...</option>
                                    <option value="1">Grade 1</option>
                                    <option value="2">Grade 2</option>
                                    <option value="3">Grade 3</option>
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dummy Rows -->
                                        <tr>
                                            <td>John Doe</td>
                                            <td>
                                                <select name="attendance[1][status]" class="form-control">
                                                    <option value="present">Present</option>
                                                    <option value="absent_without_permission">Absent Without Permission
                                                    </option>
                                                    <option value="absent_with_permission">Absent With Permission</option>
                                                    <option value="late_with_permission">Late With Permission</option>
                                                    <option value="late_without_permission">Late Without Permission</option>
                                                    <option value="sick">Sick</option>
                                                    <option value="on_leave">On Leave</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm">View Attendance</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>
                                                <select name="attendance[2][status]" class="form-control">
                                                    <option value="present">Present</option>
                                                    <option value="absent_without_permission">Absent Without Permission
                                                    </option>
                                                    <option value="absent_with_permission">Absent With Permission</option>
                                                    <option value="late_with_permission">Late With Permission</option>
                                                    <option value="late_without_permission">Late Without Permission</option>
                                                    <option value="sick">Sick</option>
                                                    <option value="on_leave">On Leave</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm">View Attendance</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Attendance</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Session Attendance -->
            <div class="tab-pane fade" id="period" role="tabpanel" aria-labelledby="period-tab">
                <div class="card">
                    <div class="card-header">
                        <h5>Session Register</h5>
                    </div>
                    <div class="card-body">
                        <form id="sessionAttendanceForm">
                            <div class="mb-3">
                                <label for="subjectSelect" class="form-label">Select Subject</label>
                                <select id="subjectSelect" class="form-control">
                                    <option value="">Select a subject...</option>
                                    <option value="math">Mathematics</option>
                                    <option value="sci">Science</option>
                                    <option value="eng">English</option>
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dummy Rows -->
                                        <tr>
                                            <td>John Doe</td>
                                            <td>
                                                <select name="sessionAttendance[1][status]" class="form-control">
                                                    <option value="present">Present</option>
                                                    <option value="absent_without_permission">Absent Without Permission
                                                    </option>
                                                    <option value="absent_with_permission">Absent With Permission</option>
                                                    <option value="late_with_permission">Late With Permission</option>
                                                    <option value="late_without_permission">Late Without Permission</option>
                                                    <option value="sick">Sick</option>
                                                    <option value="on_leave">On Leave</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm">View Attendance</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jane Smith</td>
                                            <td>
                                                <select name="sessionAttendance[2][status]" class="form-control">
                                                    <option value="present">Present</option>
                                                    <option value="absent_without_permission">Absent Without Permission
                                                    </option>
                                                    <option value="absent_with_permission">Absent With Permission</option>
                                                    <option value="late_with_permission">Late With Permission</option>
                                                    <option value="late_without_permission">Late Without Permission
                                                    </option>
                                                    <option value="sick">Sick</option>
                                                    <option value="on_leave">On Leave</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm">View
                                                    Attendance</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Session Attendance</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

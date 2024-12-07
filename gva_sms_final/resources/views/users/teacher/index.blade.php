@extends('admin.admim-master')
@section('admin_content')
    <div class="content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-0">Dashboard</h2>
                    <p class="text-muted">Welcome back, {{ Auth::user()->name }}</p>
                </div>
            </div>
            <!-- Row 1: Summary Widgets -->
            <div class="row">

                <!-- CPD Attendance -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-chalkboard-teacher"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">CPD Attendance</span>
                            <span class="info-box-number">8/10 Meetings</span>
                            <span class="progress-description">80% Attendance</span>
                        </div>
                    </div>
                </div>

                <!-- Evaluations -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Evaluations</span>
                            <span class="info-box-number">4.5/5 Rating</span>
                            <span class="progress-description">Based on 15 Evaluations</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Assignments -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-tasks"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending Tasks</span>
                            <span class="info-box-number">3</span>
                            <span class="progress-description">Assignments Due</span>
                        </div>
                    </div>
                </div>

                <!-- Upcoming CPD -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Next CPD Meeting</span>
                            <span class="info-box-number">March 15, 2024</span>
                            <span class="progress-description">10:00 AM</span>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Low Performing Students Section -->
            <div class="col-lg-12">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">Students Needing Attention</h5>
                        <small class="text-light">Based on recent performance</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Grade/Class</th>
                                        <th>Subject</th>
                                        <th>Score (%)</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Dummy Data - Replace with dynamic content --}}
                                    <tr>
                                        <td>John Doe</td>
                                        <td>Grade 5 A</td>
                                        <td>Mathematics</td>
                                        <td class="text-danger">32</td>
                                        <td><span class="badge badge-warning">Below Average</span></td>
                                    </tr>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td>Grade 4 B</td>
                                        <td>English</td>
                                        <td class="text-danger">25</td>
                                        <td><span class="badge badge-danger">Critical</span></td>
                                    </tr>
                                    <tr>
                                        <td>Mark Taylor</td>
                                        <td>Grade 6 C</td>
                                        <td>Science</td>
                                        <td class="text-warning">45</td>
                                        <td><span class="badge badge-warning">Needs Improvement</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Detailed Tables -->
            <div class="row">
                <!-- Recent Evaluation Comments -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Recent Teacher Evaluation Comments</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">"Excellent teaching methods!" - Principal</li>
                                <li class="list-group-item">"Great classroom management." - HOD</li>
                                <li class="list-group-item">"Highly effective communicator." - Parent</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- CPD Meeting History -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">CPD Meeting History</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Topic</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jan 15, 2024</td>
                                        <td>Student Engagement Strategies</td>
                                        <td><span class="badge badge-success">Attended</span></td>
                                    </tr>
                                    <tr>
                                        <td>Feb 20, 2024</td>
                                        <td>Effective Lesson Planning</td>
                                        <td><span class="badge badge-success">Attended</span></td>
                                    </tr>
                                    <tr>
                                        <td>March 15, 2024</td>
                                        <td>Inclusive Classroom Techniques</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Attendance Chart
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Attended', 'Missed'],
                datasets: [{
                    data: [80, 20],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            }
        });

        // Evaluation Chart
        const evaluationCtx = document.getElementById('evaluationChart').getContext('2d');
        new Chart(evaluationCtx, {
            type: 'bar',
            data: {
                labels: ['Principal', 'HOD', 'Parents'],
                datasets: [{
                    label: 'Rating',
                    data: [4.8, 4.5, 4.3],
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });
    </script>
@endsection

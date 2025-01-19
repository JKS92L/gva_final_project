@extends('admin.admim-master')
@section('admin_content')
    <style>
        .chart-container {
            width: 100%;
            max-height: 250px;
        }
    </style>
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Class Register Dashboard</h2>
                    <p class="text-muted">Select term and year to view statistics</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#admitStudentModal">
                        <i class="fas fa-user-plus"></i> Checkin Dayscholars
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="content p-4 row container-fluid">

        <div class="col-md-5">
            <div class="card-header small">
                <h5 class="modal-title" id="admitStudentModalLabel">Termly Statistics Dashboard</h5>
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <label for="term" class="form-label">Term</label>
                    <select class="form-control form-control-sm" id="term" name="term">
                        <option value="">Select Term</option>
                        <option value="1">Term 1</option>
                        <option value="2">Term 2</option>
                        <option value="3">Term 3</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-control form-control-sm" id="year" name="year">
                        <option value="">Select Year</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex align-items-end p-4">
                    <button class="btn btn-primary btn-sm w-100" id="fetchStats">View Statistics</button>
                </div>

                {{-- dashboard canvas --}}
                <div class="col-md-12">
                    <div class="chart-container" style="position: relative; height:250px;">
                        <canvas id="statisticsChart"></canvas>
                    </div>
                </div>

            </div>
        </div>


        <div class="card p-10 col-md-7">
            <!-- /.card-header -->
            <div class="card-header small">
                <h1 class="card-title">Class Termly Lists</h1>
            </div>
            <div class="card-body">
                <!-- Term and Year Selection -->
                <div class="row">
                    <div class="col-md-4">
                        <label for="academic_year_id">Academic Year</label>
                        <select id="academic_year_id" name="academic_year_id" class="form-control form-control-sm">
                            <option value="">--Select year--
                            </option>
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->academic_year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="term">Term</label>
                        <select id="term" name="term" class="form-control form-control-sm">
                            <option value="">--Select Term--</option>
                            <option value="1">Term 1</option>
                            <option value="2">Term 2</option>
                            <option value="3">Term 3</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="roll_no" class="small">Grade/Class</label>
                            <select id="class_id" name="class_id" class="form-control form-control-sm">
                                <option value="">Select</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">
                                        {{ $grade->gradeno . ' ' . $grade->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm w-100" id="searchRegisters">Search</button>
                    </div>

                </div>
                <div class="col-md-12 p-2 table-responsive">
                    <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Student Exam Number</th>
                                <th>Student Name</th>
                                <th>Gender</th>
                                <th>Report Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic content will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('statisticsChart').getContext('2d');
        const statisticsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Reported', 'Expelled','Suspensions','Home Permissions', 'New Students', 'Transfers Out'],
                datasets: [{
                        label: 'Current Term',
                        data: [120, 10, 5, 30, 8, 4], // Replace with dynamic data
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: 'Previous Term',
                        data: [95, 15, 3, 25, 10, 6], // Replace with dynamic data
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Categories',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Students',
                        },
                    },
                },
            },
        });

        document.getElementById('fetchStats').addEventListener('click', () => {
            alert('Fetching data for the chart... Replace this with API integration.');
        });



        $(document).ready(function() {

            // dataTables('#studentsTable');
            // Fetch termly class register
            $('#searchRegisters').click(function() {
                const academicYearId = $('#academic_year_id').val();
                const term = $('#term').val();
                const classId = $('#class_id').val();

                $.ajax({
                    url: "{{ route('students.termly.register.search') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        academic_year_id: academicYearId,
                        term: term,
                        class_id: classId
                    },
                    success: function(response) {
                        let students = response.students;
                        let tableContent = '';

                        if (students.length > 0) {
                            students.forEach(student => {
                                // Get the latest termly report (assuming the array is ordered by `created_at`)
                                let latestReport = student.termly_reports && student
                                    .termly_reports.length > 0 ?
                                    student.termly_reports[student.termly_reports
                                        .length - 1] :
                                    null;

                                let reportStatus = latestReport ? latestReport
                                    .report_status : 'No Reports';
                                let reportedDate = latestReport && latestReport
                                    .reported_date ?
                                    new Date(latestReport.reported_date)
                                    .toLocaleDateString() :
                                    'N/A';

                                tableContent += `
                        <tr>
                            <td>${student.ecz_no || 'N/A'}</td>
                            <td>${student.firstname || 'N/A'} ${student.lastname || ''}</td>
                            <td>${student.gender ? student.gender.charAt(0).toUpperCase() + student.gender.slice(1) : 'N/A'}</td>
                            <td>${reportStatus}</td>
                            <td>${reportedDate}</td>
                        </tr>
                    `;
                            });
                        } else {
                            tableContent = '<tr><td colspan="5">No records found</td></tr>';
                        }

                        $('#studentsTable tbody').html(tableContent);
                    },
                    error: function(error) {
                        console.error('Error fetching students:', error);
                    }
                });
            });



        });
    </script>
@endsection

@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-2 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Student Fees Collection</h2>
                    <p class="text-muted">Collect student fees from here.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    {{-- <a href="{{ route('student.disciplinaryForm.view') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add Disciplinary Record
                    </a> --}}

                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4  p-3">
        <div class="card-title">
            <h4>Student Register</h4>
        </div>

        <div class="table-responsive">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Students Fee Collection</h3>
                </div>
                <div class="card-body">
                    <table id="feesTable" class="table table-bordered table-hover text-nowrap table-sm dataTable no-footer">
                        <thead>
                            <tr>
                                <th>Exam Number</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Grade-Class</th>
                                <th>Enrollment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allStudents as $student)
                                <tr>
                                    <td>{{ $student->ecz_no }}</td>
                                    <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                    <td>{{ ucfirst($student->gender) }}</td>
                                    <td>
                                        Grade {{ $student->grade->gradeno ?? 'N/A' }} -
                                        {{ $student->grade->class_name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($student->active_status)
                                            <span class="badge bg-success">Enrolled</span>
                                        @else
                                            <span class="badge bg-danger">Not Enrolled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('fees.pay.view', ['student_id' => $student->id]) }}"
                                            class="btn btn-success btn-sm">
                                            Submit Payment
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Initialize DataTable
            var table = $('#feesTable').DataTable({
                responsive: false,
                paging: true,
                searching: true,
                order: [
                    [1, 'asc']
                ]
            });


        });
    </script>
@endsection

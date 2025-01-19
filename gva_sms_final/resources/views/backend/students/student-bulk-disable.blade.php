@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-2 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Bulk Disable Student Accounts</h2>
                    <p class="text-muted">Disable student accounts from here </p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    {{-- <a href="{{ route('student.disciplinaryForm.view') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add Disciplinary Record
                    </a> --}}

                </div>
            </div>
        </div>
    </div>


    <section class="content p-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Student Accounts</h3>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <select id="statusFilter" class="form-control form-control-sm">
                                <option value="">Filter by Status</option>
                                <option value="Outstanding Balance">Outstanding Balances</option>
                                <option value="Suspended">Suspended</option>
                                <option value="Expelled">Expelled</option>
                                <option value="Transferred">Transferred</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="academicYearFilter" class="form-control form-control-sm">
                                <option value="">Filter by Academic Year</option>
                                @foreach ($academicYearsWithTerms as $year)
                                    <option value="{{ $year->id }}">{{ $year->academic_year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="termFilter" class="form-control form-control-sm">
                                <option value="">Filter by Term</option>
                                <option value="1">Term 1</option>
                                <option value="2">Term 2</option>
                                <option value="3">Term 3</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="filterButton" class="btn btn-primary btn-sm">Apply Filters</button>
                        </div>
                        <div class="col-md-3 text-right">
                            <button id="bulkDisableButton" class="btn btn-danger btn-sm"><i class="fas fa-user-slash"></i> Bulk
                                Disable</button>
                            <button id="bulkEnableButton" class="btn btn-success btn-sm"><i class="fas fa-user-check"></i> Bulk
                                Enable</button>
                        </div>
                    </div>

                    <!-- Student Table -->
                    <table id="studentTable" class="table table-bordered table-hover text-nowrap no-footer table-sm">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" />
                                </th>
                                <th>Exam ECZ #</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTable will populate dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#studentTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                order: [
                    [1, 'asc']
                ]
            });

            // Filter Functionality
            $('#filterButton').on('click', function() {
                var filterValue = $('#statusFilter').val();
                table.column(4).search(filterValue).draw(); // Filter by Status column
            });

            // Select All Checkbox
            $('#selectAll').on('change', function() {
                $('.student-checkbox').prop('checked', $(this).is(':checked'));
            });

            // Bulk Disable
            $('#bulkDisableButton').on('click', function() {
                var selectedIds = $('.student-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) {
                    alert('No students selected!');
                    return;
                }

                $.ajax({
                    url: '{{ route('students.bulk.disable') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    }
                });
            });

            // Bulk Enable
            $('#bulkEnableButton').on('click', function() {
                var selectedIds = $('.student-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) {
                    alert('No students selected!');
                    return;
                }

                $.ajax({
                    url: '{{ route('students.bulk.enable') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    }
                });
            });

            // Single Disable
            $('.disable-button').on('click', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('students.disable') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    }
                });
            });

            // Single Enable
            $('.enable-button').on('click', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('students.enable') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection

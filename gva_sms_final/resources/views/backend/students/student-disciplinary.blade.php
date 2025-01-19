@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Disciplinary List Action</h2>
                    <p class="text-muted">Manage disciplinary cases and records here.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    <a href="{{ route('student.disciplinaryForm.view') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add Disciplinary Record
                    </a>

                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content p-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-fluid row">

            <div class="card card-outline card-outline-success col-md-12">
                <div class="card">
                    <div class="card-header p-3">
                        <h1 class="card-title">Students Disciplinary List</h1>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-3">
                        <div id="allUsersTable_wrapper" class="dataTables_wrapper no-footer">
                            <!-- DataTable -->
                            <table class="table table-hover text-nowrap dataTable no-footer p-3" id="disciplinaryTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Exam No</th>
                                        <th>Student Name(gender)</th>
                                        <th>Grade/class</th>
                                        <th>Student Type</th>
                                        <th>Incident Date</th>
                                         <th>Incident Time</th>
                                        <th>Incident Year-Term</th>
                                        <th>Location</th>
                                        <th>Reported By</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                        <th>Action Date</th>
                                        <th>Approved By</th>
                                        <th>Approval Date</th>
                                        <th>Comments</th>
                                        <th>Attachments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        @foreach ($student->disciplinaries as $disciplinary)
                                            <tr>
                                                <td>{{ $student->ecz_no }}</td>
                                                <td>
                                                    {{ $student->firstname }} {{ $student->lastname }}
                                                    ({{ ucfirst($student->gender) }})
                                                </td>
                                                <td>
                                                    Grade {{ $student->grade->gradeno ?? 'N/A' }} -
                                                    {{ $student->grade->class_name ?? 'N/A' }}
                                                </td>
                                                <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                                                <td>{{ $disciplinary->incident_date }}</td>
                                                <td>{{ $disciplinary->incident_time }}</td>
                                                <td>{{ $disciplinary->academicYear->academic_year ?? 'N/A' }} -
                                                    {{ 'Term ' . $disciplinary->term_no }}</< /td>
                                                <td>{{ $disciplinary->incident_location }}</td>
                                                <td>{{ $disciplinary->reported_by }}</td>
                                                <td>{{ $disciplinary->disciplinary_action }}</td>
                                                <td>{{ ucfirst($disciplinary->status) }}</td>
                                                <td>{{ $disciplinary->action_date }}</td>
                                                <td>{{ $disciplinary->approved_by ?? 'N/A' }}</td>
                                                <td>{{ $disciplinary->approval_date ?? 'N/A' }}</td>
                                                <td>{{ $disciplinary->comments ?? 'No comments' }}</td>
                                                <td>
                                                    @if (!empty($disciplinary->attachments) && count($disciplinary->attachments) > 0)
                                                        <a href="{{ route('disciplinary.attachments.view', $disciplinary->id) }}"
                                                            target="_blank" class="btn btn-primary btn-sm">
                                                            View Attachments
                                                        </a>
                                                    @else
                                                        <span>No Attachments</span>
                                                    @endif
                                                </td>


                                                <td>
                                                    @if ($disciplinary->status === 'Approved')
                                                        <span class="text-success">Approved</span>
                                                    @elseif ($disciplinary->status === 'Rejected')
                                                        <span class="text-danger">Rejected</span>
                                                    @elseif ($disciplinary->status === 'Withdrawn')
                                                        <span class="text-warning">Withdrawn</span>
                                                    @else
                                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                                            data-target="#approveModal-{{ $disciplinary->id }}">Approve</button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                            data-target="#rejectModal-{{ $disciplinary->id }}">Reject</button>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#withdrawModal-{{ $disciplinary->id }}">Withdraw</button>
                                                    @endif
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal-{{ $disciplinary->id }}">Delete</button>
                                                </td>


                                            </tr>

                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approveModal-{{ $disciplinary->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="approveModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('disciplinary.approve', $disciplinary->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="approveModalLabel">Approve
                                                                    Disciplinary Action</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label for="comments" class="form-label">Comments</label>
                                                                <textarea name="comments" id="comments" class="form-control" rows="3" required></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Approve</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal-{{ $disciplinary->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('disciplinary.reject', $disciplinary->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rejectModalLabel">Reject
                                                                    Disciplinary Action</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label for="comments" class="form-label">Comments</label>
                                                                <textarea name="comments" id="comments" class="form-control" rows="3" required></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Reject</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Withdraw Modal -->
                                            <div class="modal fade" id="withdrawModal-{{ $disciplinary->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('disciplinary.withdraw', $disciplinary->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="withdrawModalLabel">Withdraw
                                                                    Disciplinary Action</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label for="comments" class="form-label">Comments</label>
                                                                <textarea name="comments" id="comments" class="form-control" rows="3" required></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-warning">Withdraw</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="deleteModal-{{ $disciplinary->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('disciplinary.delete', $disciplinary->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                    Disciplinary Record</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this disciplinary record?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>


            </div>
        </div>





    </div>


    </div>


    <script>
        function toggleDateFields() {
            const actionSelect = document.getElementById('disciplinary_action');
            const dateFields = document.getElementById('date_fields');

            if (actionSelect.value === 'Suspension' || actionSelect.value === 'Punishment') {
                dateFields.style.display = 'block';
            } else {
                dateFields.style.display = 'none';
            }
        }


        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Student',
                width: '100%'
            });


            $('#disciplinaryTable').DataTable({
                responsive: true,
                paging: true,
                searching: true
            });


        });
    </script>
@endsection

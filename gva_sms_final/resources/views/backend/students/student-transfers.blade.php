@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Student Transfers</h2>
                    <p class="text-muted">Manage student transfers from here.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    {{-- <a href="{{ route('student.disciplinaryForm.view') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add Disciplinary Record
                    </a> --}}

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
        <div class="container-fluid">
            <div class="row">
                <!-- Add New Transfer Form -->
                <div class="card col-md-5">
                    <div class="card-header small">
                        <h5>Add New Transfer</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('students.transfer.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="term">Select Term </label>
                                    <select class="form-control form-control-sm" id="academic_term" name="academic_term"
                                        required>
                                        <option value="">--Select a term--</option>
                                        @foreach ($academicYears as $year)
                                            @foreach ($year->terms as $term)
                                                <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                    {{ $year->academic_year }} - Term {{ $term->term_number }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="student_name" class="small">Student Name</label>
                                    <select name="student_id" id="student_id" class="form-control form-control-sm select2">
                                        <option value="">--Select student--</option>
                                        @foreach ($allStudents as $student)
                                            <option value="{{ $student->id }}">
                                                {{ ucwords($student->firstname) }}
                                                {{ ucwords($student->lastname) }}
                                                ({{ ucfirst($student->gender) }})
                                                -
                                                {{ $student->grade->gradeno . ' ' . $student->grade->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="new_school" class="small">New School</label>
                                    <input type="text" class="form-control form-control-sm" id="new_school"
                                        name="new_school" placeholder="Enter New School Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="transfer_date" class="small">Transfer Date</label>
                                    <input type="date" class="form-control form-control-sm" id="transfer_date"
                                        name="transfer_date">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="status" class="small">Status</label>
                                    <select class="form-control form-control-sm" id="status" name="status">
                                        <option>Pending</option>
                                        <option>Approved</option>
                                        <option>Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm col-md-12">Save Transfer</button>
                        </form>
                    </div>
                </div>

                <!-- Transfer Records Table -->
                <div class="card col-md-7">
                    <div class="card-header small">
                        <h5>Student Transfer Records</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="transferTable" class="table table-hover text-nowrap dataTable no-footer">
                            <thead class="thead-light">
                                <tr>
                                    <th>ECZ No</th>
                                    <th>Student Name</th>
                                    <th>Grade - Class</th>
                                    <th>New School</th>
                                    <th>Transfer Date</th>
                                    <th>Term/Year</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Approval Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allStudents as $student)
                                    @foreach ($student->transfers as $transfer)
                                        <tr>
                                            <!-- ECZ No -->
                                            <td>{{ $student->ecz_no }}</td>

                                            <!-- Student Name -->
                                            <td>{{ $student->firstname }} {{ $student->lastname }}
                                                {{ $student->other_name ?? '' }}</td>

                                            <!-- Grade - Class -->
                                            <td>
                                                {{ $student->grade->gradeno ?? 'N/A' }}
                                                {{ $student->grade->class_name ?? '' }}
                                            </td>

                                            <!-- New School -->
                                            <td>{{ $transfer->new_school }}</td>

                                            <!-- Transfer Date -->
                                            <td>{{ $transfer->transfer_date }}</td>

                                            <!-- Term/Year -->
                                            <td>
                                                Term {{ $transfer->term_no }},
                                                {{ $transfer->academicYear->academic_year ?? '-' }}
                                            </td>

                                            <!-- Status -->
                                            <td>{{ $transfer->status }}</td>

                                            <!-- Approved By -->
                                            <td>
                                                {{ $transfer->approvedBy->name ?? 'No record' }}
                                            </td>

                                            <!-- Approval Date -->
                                            <td>
                                                {{ $transfer->approval_date ?? 'No record' }}
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                @if ($transfer->status !== 'Approved')
                                                    <!-- Approve Button -->
                                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                                        data-target="#approveModal-{{ $transfer->id }}">Approve</button>
                                                @endif

                                                <!-- Edit Button -->
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editModal-{{ $transfer->id }}">Edit</button>

                                                <!-- Delete Button -->
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteModal-{{ $transfer->id }}">Delete</button>
                                            </td>


                                        </tr>

                                        <!-- Approve Modal -->
                                        <div class="modal fade" id="approveModal-{{ $transfer->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="approveModalLabel-{{ $transfer->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="approveModalLabel-{{ $transfer->id }}">
                                                            Approve Transfer</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to approve the transfer for
                                                        {{ $student->firstname }} {{ $student->lastname }} to
                                                        {{ $transfer->new_school }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form
                                                            action="{{ route('students.transfer.approve', $transfer->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-success">Approve</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal-{{ $transfer->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel-{{ $transfer->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel-{{ $transfer->id }}">
                                                            Edit Transfer</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('students.transfer.update', $transfer->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-group">
                                                                <label for="new_school-{{ $transfer->id }}">New
                                                                    School</label>
                                                                <input type="text" class="form-control"
                                                                    id="new_school-{{ $transfer->id }}" name="new_school"
                                                                    value="{{ $transfer->new_school }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="transfer_date-{{ $transfer->id }}">Transfer
                                                                    Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="transfer_date-{{ $transfer->id }}"
                                                                    name="transfer_date"
                                                                    value="{{ $transfer->transfer_date }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="status-{{ $transfer->id }}">Status</label>
                                                                <select class="form-control"
                                                                    id="status-{{ $transfer->id }}" name="status">
                                                                    <option value="Pending"
                                                                        {{ $transfer->status == 'Pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="Approved"
                                                                        {{ $transfer->status == 'Approved' ? 'selected' : '' }}>
                                                                        Approved</option>
                                                                    <option value="Rejected"
                                                                        {{ $transfer->status == 'Rejected' ? 'selected' : '' }}>
                                                                        Rejected</option>
                                                                </select>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $transfer->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel-{{ $transfer->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteModalLabel-{{ $transfer->id }}">Delete Transfer</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this transfer for
                                                        {{ $student->firstname }} {{ $student->lastname }} to
                                                        {{ $transfer->new_school }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form
                                                            action="{{ route('students.transfer.destroy', $transfer->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>


    </div>


    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Student',
                width: '100%'
            });


            $('#transferTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
            });
        });
    </script>
@endsection

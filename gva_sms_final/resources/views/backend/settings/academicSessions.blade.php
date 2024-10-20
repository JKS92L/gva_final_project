@extends('admin.admim-master')
@section('admin_content')
    <style>

    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#addAcademicYearModal">
                            Add Academic Year Session
                        </button>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="container mt-3">
                {{-- @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif --}}

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>

            <div class="row">
                <!-- Academic Year Form -->
                <div class="modal fade" id="addAcademicYearModal" tabindex="-1" role="dialog"
                    aria-labelledby="addAcademicYearModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAcademicYearModalLabel">New Academic Session</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('academic-session.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group  col-md-12">
                                            <label for="academic_year">Academic Year</label>
                                            <input type="text" name="academic_year" class="form-control form-control-sm"
                                                id="academic_year" placeholder="Enter Academic Year">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="term1_start">Term 1 Start Date</label>
                                            <input type="date" name="term1_start" class="form-control form-control-sm"
                                                id="term1_start">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="term1_end">Term 1 End Date</label>
                                            <input type="date" name="term1_end" class="form-control form-control-sm"
                                                id="term1_end">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="term2_start">Term 2 Start Date</label>
                                            <input type="date" name="term2_start" class="form-control form-control-sm"
                                                id="term2_start">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="term2_end">Term 2 End Date</label>
                                            <input type="date" name="term2_end" class="form-control form-control-sm"
                                                id="term2_end">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="term3_start">Term 3 Start Date</label>
                                            <input type="date" name="term3_start" class="form-control form-control-sm"
                                                id="term3_start">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="term3_end">Term 3 End Date</label>
                                            <input type="date" name="term3_end" class="form-control form-control-sm"
                                                id="term3_end">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm col-md-12">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Academic Year Table -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Academic Year Sessions</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="academicSession" class="display nowrap table table-hover text-nowrap dataTable">
                                    <thead>
                                        <tr>
                                            <th>Academic Year</th>
                                            <th>Term 1 (Start - End)</th>
                                            <th>Term 2 (Start - End)</th>
                                            <th>Term 3 (Start - End)</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($academicSessions as $session)
                                            <tr>
                                                <td>{{ $session->academic_year }}</td>
                                                <td>{{ $session->term1_start }} - {{ $session->term1_end }}</td>
                                                <td>{{ $session->term2_start }} - {{ $session->term2_end }}</td>
                                                <td>{{ $session->term3_start }} - {{ $session->term3_end }}</td>
                                                <td>{{ ucfirst($session->status) }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                        data-target="#editAcademicYearModal{{ $session->id }}">
                                                        Edit
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#deleteAcademicYearModal{{ $session->id }}">
                                                        Delete
                                                    </button>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editAcademicYearModal{{ $session->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editAcademicYearModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-md" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editAcademicYearModalLabel">
                                                                        Edit Academic Year Session</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('academic-session.update', $session->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">


                                                                            <div class="form-group col-md-12">
                                                                                <label for="academic_year">Academic
                                                                                    Year</label>
                                                                                <input type="text" name="academic_year"
                                                                                    class="form-control"
                                                                                    id="academic_year"
                                                                                    value="{{ $session->academic_year }}">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="term1_start">Term 1
                                                                                    Start</label>
                                                                                <input type="date" name="term1_start"
                                                                                    class="form-control" id="term1_start"
                                                                                    value="{{ $session->term1_start }}">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="term1_end">Term 1 End</label>
                                                                                <input type="date" name="term1_end"
                                                                                    class="form-control" id="term1_end"
                                                                                    value="{{ $session->term1_end }}">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="term2_start">Term 2
                                                                                    Start</label>
                                                                                <input type="date" name="term2_start"
                                                                                    class="form-control" id="term2_start"
                                                                                    value="{{ $session->term2_start }}">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="term2_end">Term 2 End</label>
                                                                                <input type="date" name="term2_end"
                                                                                    class="form-control" id="term2_end"
                                                                                    value="{{ $session->term2_end }}">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="term3_start">Term 3
                                                                                    Start</label>
                                                                                <input type="date" name="term3_start"
                                                                                    class="form-control" id="term3_start"
                                                                                    value="{{ $session->term3_start }}">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="term3_end">Term 3 End</label>
                                                                                <input type="date" name="term3_end"
                                                                                    class="form-control" id="term3_end"
                                                                                    value="{{ $session->term3_end }}">
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label for="status">Status</label>
                                                                                <select name="status"
                                                                                    class="form-control" id="status">
                                                                                    <option value="active"
                                                                                        {{ $session->status == 'active' ? 'selected' : '' }}>
                                                                                        Active</option>
                                                                                    <option value="inactive"
                                                                                        {{ $session->status == 'inactive' ? 'selected' : '' }}>
                                                                                        Inactive</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm col-md-12">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade"
                                                        id="deleteAcademicYearModal{{ $session->id }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="deleteAcademicYearModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteAcademicYearModalLabel">
                                                                        Confirm Delete</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to delete the session for
                                                                        <strong>{{ $session->academic_year }}</strong>?
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('academic-session.destroy', $session->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center">
                                {{ $academicSessions->links() }}
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
        </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection

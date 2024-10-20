@extends('admin.admim-master')
@section('admin_content')
    {{-- Customize layout sections --}}
@section('content_header_title', 'Teachers')
@section('content_header_subtitle', 'Manage User Roles')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h4 class="m-0">Assign Subject Teachers</h4> --}}
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#assignSubjectModal">
                        <i class="fa fa-sitemap"></i> Assign Subject
                    </button>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<!-- Custom CSS to make the form inline and responsive -->

<!-- Modal -->
<div class="modal fade" id="assignSubjectModal" tabindex="-1" role="dialog" aria-labelledby="assignSubjectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignSubjectModalLabel">Assign Subjects to Teachers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="container">
                        <form action="#" method="POST">

                            <div class="form-row">
                                <!-- Subject Selection -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="subject" class="small-label">Select Class</label>
                                    <select id="class" name="class" class="form-control form-control-sm" required>
                                        <option value="">-- Select Class --</option>
                                        <option value="1">12 A</option>
                                        <option value="2">12 B</option>
                                        <option value="3">12 C</option>
                                    </select>
                                </div>
                                <!-- Subject Selection -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="subject" class="small-label">Select Subject</label>
                                    <select id="subject" name="subject_id[]" class="form-control form-control-sm"
                                        multiple="multiple" required>
                                        <option value="1">Mathematics</option>
                                        <option value="2">Science</option>
                                        <option value="3">English</option>
                                        <option value="4">History</option>
                                        <option value="5">Geography</option>
                                    </select>
                                </div>
                                <!-- Teacher Selection -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="teacher" class="small-label">Select Teacher</label>
                                    <select id="teacher" name="teacher_id" class="form-control form-control-sm" required>
                                        <option value="">-- Select Teacher --</option>
                                        <option value="1">Teacher 1</option>
                                        <option value="2">Teacher 2</option>
                                        <option value="3">Teacher 3</option>
                                    </select>
                                </div>

                                <!-- Academic Year -->
                                <div class="form-group col-md-6 mb-3">
                                    <label for="academic_year" class="small-label">Academic Year</label>
                                    <select id="academic_year" name="academic_year"
                                        class="form-control form-control-sm" required>
                                        <option value="">-- Select Academic Year --</option>
                                        <option value="2024 Term 1">2024 Term 1</option>
                                        <option value="2024 Term 2">2024 Term 2</option>
                                        <option value="2024 Term 3">2024 Term 3</option>
                                    </select>
                                </div>



                                <!-- Submit Button -->
                                <div class="form-group card-footer col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Assign Subject</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </form>

        </div>
    </div>
</div>

<div class="container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assigned Subject Teachers</h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body table-responsive p-4">

                <div id="allUsersTable_wrapper" class="dataTables_wrapper no-footer">
                    <table class="table table-hover text-nowrap" id="assignSubjectTable">
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Academic Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dummy data for display -->
                            <tr>
                                <td>John Doe</td>
                                <td>Class A</td>
                                <td>Mathematics</td>
                                <td>2024</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>Class B</td>
                                <td>Science</td>
                                <td>2024</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Michael Johnson</td>
                                <td>Class C</td>
                                <td>English</td>
                                <td>2024</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script> --}}
<!-- DataTables JS -->
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
<script>
    $(document).ready(function() {
        // $(selector).DataTable(options);
        // Initialize Select2
        $('.select2').select2();
        $('#subject').select2({
            placeholder: "-- Select Subject --",
            allowClear: true
        });

        // Initialize DataTables with sorting functionality
        $('#assignSubjectTable').DataTable();
    });
</script>

@endsection

@extends('admin.admim-master')
@section('admin_content')
{{-- Customize layout sections --}}
@section('content_header_title', 'Teachers')
@section('content_header_subtitle', 'Manage User Roles')

 <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Assign Subject Teachers</h1>
                </div><!-- /.col -->
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div><!-- /.col --> --}}
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

                <div class="modal-body">
                    <form action="#" method="POST" class="form-inline">
                        <!-- Teacher Selection -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="teacher">Select Teacher</label>
                            <select id="teacher" name="teacher_id" class="form-control">
                                <option value="">-- Select Teacher --</option>
                                <option value="1">Teacher 1</option>
                                <option value="2">Teacher 2</option>
                                <option value="3">Teacher 3</option>
                            </select>
                        </div>

                        <!-- Class Selection -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="class">Select Class</label>
                            <select id="class" name="class_id" class="form-control">
                                <option value="">-- Select Class --</option>
                                <option value="1">Class A</option>
                                <option value="2">Class B</option>
                                <option value="3">Class C</option>
                            </select>
                        </div>

                        <!-- Subject Selection -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="subject">Select Subject</label>
                            <select id="subject" name="subject_id" class="form-control">
                                <option value="">-- Select Subject --</option>
                                <option value="1">Mathematics</option>
                                <option value="2">Science</option>
                                <option value="3">English</option>
                            </select>
                        </div>

                        <!-- Academic Year (Optional) -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="academic_year">Academic Year</label>
                            <input type="text" id="academic_year" name="academic_year" class="form-control"
                                placeholder="E.g., Term I - 2024">
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn-primary ">Assign Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assigned Subject Teachers</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success " data-toggle="modal"
                            data-target="#assignSubjectModal">
                            <i class="fa fa-sitemap"></i> Assign Subject
                        </button>
                    </div>
                </div>
                
                <!-- /.card-header -->
                <div class="card-body table-responsive p-4">

                    <div id="allUsersTable_wrapper" class="dataTables_wrapper no-footer">
                        <table class="table table-hover text-nowrap" id="assignSubjectTable">
                            <thead>
                                <tr>
                                    <th>Teacher<i class="fas fa-sort"></th>
                                    <th>Class <i class="fas fa-sort"></th>
                                    <th>Subject <i class="fas fa-sort"></th>
                                    <th>Academic Year <i class="fas fa-sort"></th>
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

            // Initialize DataTables with sorting functionality
            $('#assignSubjectTable').DataTable();
        });
    </script>

@endsection
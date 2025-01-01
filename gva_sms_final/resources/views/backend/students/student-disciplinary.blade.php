@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Termly Student Admissions Management</h2>
                    <p class="text-muted">Clear-in/out, give permissions and disciplinary actions from here</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#admitStudentModal">
                        <i class="fas fa-user-plus"></i> Add New Enrollment
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content p-2">
        <div class="container-fluid">
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


            <div class="card card-outline card-outline-success">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Students Disciplinary List</h1>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <div id="allUsersTable_wrapper" class="dataTables_wrapper no-footer">
                            <!-- DataTable -->
                            <table class="table table-hover text-nowrap dataTable no-footer" id="pupilsTable">
                                <thead>
                                    <tr>
                                        <th>ID<i class="fas fa-sort"> </i></th>
                                        <th>Exam #<i class="fas fa-sort"> </i></th>
                                        <th>Name<i class="fas fa-sort"> </i></th>
                                        <th>Gender<i class="fas fa-sort"> </i></th>
                                        <th>Grade/Class<i class="fas fa-sort"> </i></th>
                                        <th>Student type<i class="fas fa-sort"> </i></th>
                                        <th>Parent/Guardian<i class="fas fa-sort"> </i></th>
                                        <th>Date of Birth<i class="fas fa-sort"> </i></th>
                                        <th>Status<i class="fas fa-sort"> </i></th>
                                        <th>Date Enrolled<i class="fas fa-sort"> </i></th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>501</td>
                                        <td>2345309788808</td>
                                        <td>Emily Johnson</td>
                                        <td>Girl</td>
                                        <td>G12-A</td>
                                        <td>Boarder</td>
                                        <td>Michael Johnson</td>
                                        <td>2013-05-17</td>
                                        <td>Active</td>
                                        <td>2023-01-05</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>502</td>
                                        <td>2345309788809</td>
                                        <td>John Doe</td>
                                        <td>Boy</td>
                                        <td>G11-B</td>
                                        <td>Day</td>
                                        <td>Jane Doe</td>
                                        <td>2014-06-22</td>
                                        <td>Active</td>
                                        <td>2022-09-01</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>503</td>
                                        <td>2345309788810</td>
                                        <td>Mary Smith</td>
                                        <td>Girl</td>
                                        <td>G10-C</td>
                                        <td>Boarder</td>
                                        <td>Robert Smith</td>
                                        <td>2015-07-30</td>
                                        <td>Inactive</td>
                                        <td>2021-11-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>504</td>
                                        <td>2345309788811</td>
                                        <td>James Brown</td>
                                        <td>Boy</td>
                                        <td>G9-D</td>
                                        <td>Day</td>
                                        <td>Linda Brown</td>
                                        <td>2016-08-15</td>
                                        <td>Active</td>
                                        <td>2022-03-25</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">View</button>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- /.card-body -->
                </div>


            </div>
        </div>
    </div>

@endsection

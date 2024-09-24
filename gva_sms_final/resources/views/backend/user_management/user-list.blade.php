@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users List</h1>
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card-tools col-sm-12 text-right p-4">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                        <i class="fas fa-user-plus"></i>Add New User
                    </button>
                </div>
            </div>



            <!-- The large modal -->
            <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="modal-lgLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-lgLabel">Large Modal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                        placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Example select</label>
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Example textarea</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-all-staff-tab" data-toggle="pill"
                                        href="#custom-tabs-all-staff" role="tab" aria-controls="custom-tabs-all-staff"
                                        aria-selected="true">Staff</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-all-parents-tab" data-toggle="pill"
                                        href="#custom-tabs-all-parents" role="tab"
                                        aria-controls="custom-tabs-all-parents" aria-selected="false">Parents</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-pupils-tab" data-toggle="pill"
                                        href="#custom-tabs-pupils" role="tab" aria-controls="custom-tabs-pupils"
                                        aria-selected="false">Pupils</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-all-system-users-tab" data-toggle="pill"
                                        href="#custom-tabs-all-system-users" role="tab"
                                        aria-controls="custom-tabs-all-system-users" aria-selected="false">System users</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">

                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="tab-pane fade show active" id="custom-tabs-all-staff" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-all-staff-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Staff List</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">

                                                <table class="table table-hover text-nowrap" id="allStaffTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID <i class="fas fa-sort"> </th>
                                                            <th>Name<i class="fas fa-sort"></th>
                                                            <th>Position<i class="fas fa-sort"></th>
                                                            <th>Department<i class="fas fa-sort"></th>
                                                            <th>Email<i class="fas fa-sort"></th>
                                                            <th>Phone<i class="fas fa-sort"></th>
                                                            <th>Status<i class="fas fa-sort"></th>
                                                            <th>Date Joined<i class="fas fa-sort"></th>
                                                            <th>Last Login<i class="fas fa-sort"></th>
                                                            <th>Actions<i class="fas fa-sort"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>101</td>
                                                            <td>Jane Smith</td>
                                                            <td>Teacher</td>
                                                            <td>Mathematics</td>
                                                            <td>jane.smith@example.com</td>
                                                            <td>(555) 987-6543</td>
                                                            <td>Active</td>
                                                            <td>2022-08-22</td>
                                                            <td>2023-09-01 07:30 AM</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                {{-- parents/guardian list --}}
                                <div class="tab-pane fade" id="custom-tabs-all-parents" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-all-parents-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <!-- /.card-header -->
                                            <div class="card-header">
                                                <h3 class="card-title">Parents List</h3>
                                            </div>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap" id="allParentsTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID<i class="fas fa-sort"> </th>
                                                            <th>Name<i class="fas fa-sort"> </th>
                                                            <th>Child's Name<i class="fas fa-sort"> </th>
                                                            <th>Phone<i class="fas fa-sort"> </th>
                                                            <th>Email<i class="fas fa-sort"> </th>
                                                            <th>Status<i class="fas fa-sort"> </th>
                                                            <th>Date Registered<i class="fas fa-sort"> </th>
                                                            <th>Actions<i class="fas fa-sort"> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>301</td>
                                                            <td>Michael Johnson</td>
                                                            <td>Emily Johnson</td>
                                                            <td>(555) 765-4321</td>
                                                            <td>michael.johnson@example.com</td>
                                                            <td>Active</td>
                                                            <td>2023-03-10</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-pupils" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-pupils-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">All pupils list</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <div id="allUsersTable_wrapper" class="dataTables_wrapper no-footer">
                                                    <!-- DataTable -->
                                                    <table class="table table-hover text-nowrap dataTable no-footer"
                                                        id="pupilsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>ID<i class="fas fa-sort"> </th>
                                                                <th>Exam #<i class="fas fa-sort"> </th>
                                                                <th>Name<i class="fas fa-sort"> </th>
                                                                <th>Gender<i class="fas fa-sort"> </th>
                                                                <th>Grade/Class<i class="fas fa-sort"> </th>
                                                                <th>Student type<i class="fas fa-sort"> </th>
                                                                <th>Parent/Guardian<i class="fas fa-sort"> </th>
                                                                <th>Date of Birth<i class="fas fa-sort"> </th>
                                                                <th>Status<i class="fas fa-sort"> </th>
                                                                <th>Date Enrolled<i class="fas fa-sort"> </th>
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
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-all-system-users" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-all-system-users-tab">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">System list</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap" id="systemUsersTable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Username</th>
                                                            <th>Role Name</th>
                                                            <th>Gender</th>
                                                            <th>Email</th>
                                                            <th>Contact</th>
                                                            <th>Date Assigned</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>john_doe</td>
                                                            <td>Administrator</td>
                                                            <td>Male</td>
                                                            <td>john.doe@example.com</td>
                                                            <td>(555) 123-4567</td>
                                                            <td>2024-09-01</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>jane_smith</td>
                                                            <td>Teacher</td>
                                                            <td>Female</td>
                                                            <td>jane.smith@example.com</td>
                                                            <td>(555) 987-6543</td>
                                                            <td>2024-09-02</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>alice_jones</td>
                                                            <td>Student</td>
                                                            <td>Female</td>
                                                            <td>alice.jones@example.com</td>
                                                            <td>(555) 321-7654</td>
                                                            <td>2024-09-03</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary">View</button>
                                                                <button class="btn btn-sm btn-warning">Edit</button>
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </div>



            {{-- Add here extra stylesheets sms_project/public/css/custom_datatables.css --}}
            {{-- <link rel="stylesheet" href="/css/custom_datatables.css"> --}}
        </div>
    </div>
@endsection
<script>
    $().DataTable()
</script>

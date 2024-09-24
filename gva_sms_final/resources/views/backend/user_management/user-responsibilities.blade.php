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
                <!-- Form for adding new roles -->
                <div class="col-md-4">
                    <div class="form-wrapper">
                        {{-- <h4 class="mb-4 text-s">Add New Responsibility</h4> --}}
                        <form id="roleForm">
                            <div class="form-group">
                                <label for="roleName">Responsibility Name</label>
                                <input type="text" class="form-control" id="roleName" placeholder="Enter role name"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label for="roleDescription">Description</label>
                                <textarea class="form-control" id="roleDescription" rows="3" placeholder="Enter role description" required=""></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Responsibility</button>
                        </form>
                    </div>
                </div>

                <!-- Table of existing roles -->
                <div class="col-md-8">
                    <div class="table-wrapper">
                        <h4 class="mb-4">Existing Roles</h4>
                        <table class="table table-bordered table-hover role-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Responsibily Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example data rows, replace with dynamic content -->
                                <tr>
                                    <td>1</td>
                                    <td>Class Teacher</td>
                                    <td>Manages the class room activies for the assigned class</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Hostel Teacher</td>
                                    <td>Handles issues in the assigned hostel</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

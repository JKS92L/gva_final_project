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
                <div class="col-md-12">
                    {{-- Add User Role Button --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Roles</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#addRoleModal">
                                    <i class="fas fa-plus-circle"></i> Add New Role
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- User Role Table --}}
                            <table id="rolesTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th># <i class="fas fa-sort"></i></th>
                                        <th>Role Name <i class="fas fa-sort"></i></th>
                                        <th>Description <i class="fas fa-sort"></i></th>
                                        <th>Permissions <i class="fas fa-sort"></i></th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Table rows go here --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Administrator</td>
                                        <td>Full access to the system</td>
                                        <td>Manage Users, Edit Content, View Reports</td>
                                        <td>
                                            {{-- Edit Button --}}
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editRoleModal-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            {{-- Delete Button --}}
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteRoleModal-1">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Editor</td>
                                        <td>Can edit and manage content</td>
                                        <td>Edit Content, View Reports</td>
                                        <td>
                                            {{-- Edit Button --}}
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editRoleModal-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            {{-- Delete Button --}}
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteRoleModal-2">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Viewer</td>
                                        <td>Can only view content</td>
                                        <td>View Reports</td>
                                        <td>
                                            {{-- Edit Button --}}
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editRoleModal-3">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            {{-- Delete Button --}}
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteRoleModal-3">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add Role Modal --}}
            {{-- Add Role Modal --}}
            <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- Role Name --}}
                                <div class="form-group">
                                    <label for="roleName">Role Name</label>
                                    <input type="text" class="form-control" id="roleName" name="name"
                                        placeholder="Enter role name" required>
                                </div>
                                {{-- Role Description --}}
                                <div class="form-group">
                                    <label for="roleDescription">Description</label>
                                    <textarea class="form-control" id="roleDescription" name="description" placeholder="Enter role description" required></textarea>
                                </div>
                                {{-- Role Permissions --}}
                                <div class="form-group">
                                    <label for="rolePermissions">Permissions</label>
                                    <select class="form-control select2" id="rolePermissions" name="permissions[]"
                                        multiple="multiple" style="width: 100%;">
                                        <option value="1">Manage Users</option>
                                        <option value="2">Edit Content</option>
                                        <option value="3">View Reports</option>
                                        <option value="4">Manage Finances</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Include Edit and Delete Modals --}}
            {{-- Example Edit Modal --}}
            <div class="modal fade" id="editRoleModal-1" tabindex="-1" role="dialog"
                aria-labelledby="editRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- Role Name --}}
                                <div class="form-group">
                                    <label for="editRoleName">Role Name</label>
                                    <input type="text" class="form-control" id="editRoleName" name="name"
                                        value="Administrator" required>
                                </div>
                                {{-- Role Description --}}
                                <div class="form-group">
                                    <label for="editRoleDescription">Description</label>
                                    <textarea class="form-control" id="editRoleDescription" name="description" required>Full access to the system</textarea>
                                </div>
                                {{-- Role Permissions --}}
                                <div class="form-group">
                                    <label for="editRolePermissions">Permissions</label>
                                    <select class="form-control select2 text-bg-success accent-danger"
                                        id="editRolePermissions" name="permissions[]" multiple="multiple"
                                        style="width: 100%;">
                                        <option value="1" selected>Manage Users</option>
                                        <option value="2" selected>Edit Content</option>
                                        <option value="3" selected>View Reports</option>
                                        <option value="4">Manage Finances</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Example Delete Modal --}}
            <div class="modal fade" id="deleteRoleModal-1" tabindex="-1" role="dialog"
                aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete the "Administrator" role?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // Initialize DataTables with sorting functionality
            $('#rolesTable').DataTable();
        });
    </script>
@endsection

@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                {{-- Add User Role Button --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Roles</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addRoleModal">
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
                                    {{-- <th>Permissions <i class="fas fa-sort"></i></th> --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Dynamically render roles --}}
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->role_name }}</td>
                                        <td>{{ $role->description }}</td>
                                        {{-- <td> --}}
                                        {{-- Assuming you have a relationship between roles and permissions --}}
                                        {{-- @foreach ($role->permissions as $permission)
                                                {{ $permission->name }},
                                            @endforeach --}}
                                        {{-- </td> --}}
                                        <td>
                                            {{-- Edit Button --}}

                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#editRoleModal-{{ $role->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            {{-- Delete Button --}}
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteRoleModal-{{ $role->id }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                            <a href="{{route('edit.user.roles', $role->id)}}" class="btn btn-success btn-sm">
                                               <i class='fas fa-user-edit'></i>
                                                Edit Permissions
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- Edit Role Modal --}}
                                    <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Role: {{ $role->role_name }}</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="roleName">Role Name</label>
                                                            <input type="text" name="role_name" class="form-control"
                                                                value="{{ $role->role_name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="roleDescription">Description</label>
                                                            <textarea name="description" class="form-control">{{ $role->description }}</textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Delete Role Modal --}}
                                    <div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Role: {{ $role->role_name }}</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this role?</p>
                                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Role Modal --}}
        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Role</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="roleName">Role Name</label>
                                <input type="text" name="role_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="roleDescription">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Role</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script></script>
@endsection

@extends('admin.admim-master')
@section('admin_content')
    <style>
        .table-responsive {
            max-height: 400px;
            /* Adjust this height as needed */
            overflow-y: auto;
        }

        .table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: #13b1c0;
            border-bottom: 2px solid #dee2e6;
            /* Adds a subtle border between header and rows */
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a class="btn btn-sm btn-success" href="{{ route('view-roles') }}"><i
                                    class='fas fa-id-card-alt'></i> View Roles List</a>
                        </li>
                        {{-- <li class="breadcrumb-item active">List</li> --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Edit: <span
                            class=" text-bold text-success">{{ Str::ucfirst($role->role_name) }}</span> Permissions
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('save.UserRolePermissions', $role->id) }}" method="POST">
                        @csrf
                        <div class="table-responsive bg-white text-sm" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead class="table-header"
                                    style="position: sticky; top: 0; z-index: 1; background-color: white;">
                                    <tr class="text-sm text-white">
                                        <th>Menu</th>
                                        <th>Submenu</th>
                                        <th>View</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td class="text-bold">{{ $menu->menu_name }}</td>
                                            <td></td>
                                            <td>
                                                <input type="checkbox" name="permissions[{{ $menu->id }}][can_view]"
                                                    value="1"
                                                    {{ isset($rolePermissions[$menu->id][null]) && $rolePermissions[$menu->id][null]->first()->can_view ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                {{-- <input type="checkbox" name="permissions[{{ $menu->id }}][can_add]"
                                                    value="1"
                                                    {{ isset($rolePermissions[$menu->id][null]) && $rolePermissions[$menu->id][null]->first()->can_add ? 'checked' : '' }}> --}}
                                            </td>
                                            <td>
                                                {{-- <input type="checkbox" name="permissions[{{ $menu->id }}][can_edit]"
                                                    value="1"
                                                    {{ isset($rolePermissions[$menu->id][null]) && $rolePermissions[$menu->id][null]->first()->can_add ? 'checked' : '' }}> --}}
                                            </td>
                                            <!-- Repeat for edit and delete -->
                                            <td>
                                                {{-- <input type="checkbox" name="permissions[{{ $menu->id }}][can_edit]"
                                                    value="1"
                                                    {{ isset($rolePermissions[$menu->id][null]) && $rolePermissions[$menu->id][null]->first()->can_add ? 'checked' : '' }}> --}}
                                            </td>

                                        </tr>

                                        @foreach ($menu->submenus as $submenu)
                                            <tr>
                                                <td></td>
                                                <td>{{ $submenu->submenu_name }}</td>
                                                <td>
                                                    <input type="checkbox"
                                                        name="permissions[{{ $menu->id }}][submenus][{{ $submenu->id }}][can_view]"
                                                        value="1"
                                                        {{ isset($rolePermissions[$menu->id][$submenu->id]) && $rolePermissions[$menu->id][$submenu->id]->first()->can_view ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="checkbox"
                                                        name="permissions[{{ $menu->id }}][submenus][{{ $submenu->id }}][can_add]"
                                                        value="1"
                                                        {{ isset($rolePermissions[$menu->id][$submenu->id]) && $rolePermissions[$menu->id][$submenu->id]->first()->can_add ? 'checked' : '' }}>
                                                </td>
                                                <!-- Repeat for edit and delete -->
                                                <td>
                                                    <input type="checkbox"
                                                        name="permissions[{{ $menu->id }}][submenus][{{ $submenu->id }}][can_edit]"
                                                        value="1"
                                                        {{ isset($rolePermissions[$menu->id][$submenu->id]) && $rolePermissions[$menu->id][$submenu->id]->first()->can_add ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="checkbox"
                                                        name="permissions[{{ $menu->id }}][submenus][{{ $submenu->id }}][can_delete]"
                                                        value="1"
                                                        {{ isset($rolePermissions[$menu->id][$submenu->id]) && $rolePermissions[$menu->id][$submenu->id]->first()->can_add ? 'checked' : '' }}>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer text-center text-md">
                            <button type="submit" class="btn  btn-info btn-sm w-50">Save Permissions</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
   
    <!-- Check if there's a success message in the session -->
    @if (session('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3400,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif
    </script>
@endsection

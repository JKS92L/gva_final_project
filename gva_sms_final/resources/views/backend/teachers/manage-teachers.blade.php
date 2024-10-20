@extends('admin.admim-master')
@section('admin_content')
    <style>
        /* Teacher Modal Custom Styles */
        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .modal-header.bg-primary {
            background-color: #007bff;
            color: white;
        }

        .teacher-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .modal-body h4 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .modal-body p {
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Teachers List</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('teacher.regForm') }}" class="btn btn-success btn-sm card-tools ext-right p-2">
                            <i class="fas fa-user-plus"></i> Add New Teacher
                        </a>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="container mt-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Staff List</h1>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="allStaffTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Major Subjects</th>
                                    <th>Minor Subjects</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Date Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->id }}</td>
                                        <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->gender }}</td>
                                        <td>{{ $teacher->user->role->role_name ?? 'N/A' }}</td>
                                        <td>{{ $teacher->department->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($teacher->majorSubjects->isNotEmpty())
                                                {{ $teacher->majorSubjects->pluck('short_code')->join(', ') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($teacher->minorSubjects->isNotEmpty())
                                                {{ $teacher->minorSubjects->pluck('name')->join(', ') }}
                                            @endif
                                        </td>
                                        <td>{{ $teacher->user->email }}</td>
                                        <td>{{ $teacher->user->contact_number }}</td>
                                        <td>{{ $teacher->user->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $teacher->date_of_hire }}</td>
                                        <td>
                                            <!-- Trigger for View Modal -->
                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#viewTeacherModal{{ $teacher->id }}">View</button>
                                            <!-- Edit and Delete buttons -->
                                           <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#deleteTeacherModal{{ $teacher->id }}">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- View Teacher Modal -->
                                    <div class="modal fade" id="viewTeacherModal{{ $teacher->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="viewTeacherModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="viewTeacherModalLabel">Teacher Details</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <!-- ID Card Design -->
                                                    <div class="row">
                                                        <!-- Teacher's Photo -->
                                                        <div class="col-md-4 text-center">
                                                            <img src="{{ $teacher->photo ? asset('storage/' . $teacher->photo) : asset('assets/images/gva_logo/gva_default.png') }}"
                                                                alt="Profile Picture"
                                                                class="img-fluid rounded-circle teacher-photo">
                                                        </div>
                                                        <!-- Teacher's Information -->
                                                        <div class="col-md-8">
                                                            <h4 class="font-weight-bold">{{ $teacher->first_name }}
                                                                {{ $teacher->last_name }}</h4>
                                                            <p><strong>Username:</strong> {{ $teacher->user->username }}
                                                            </p>
                                                            <p><strong>Email:</strong> {{ $teacher->user->email }}</p>
                                                            <p><strong>Contact:</strong>
                                                                {{ $teacher->user->contact_number }}</p>
                                                            <p><strong>Gender:</strong> {{ $teacher->gender }}</p>
                                                            <p><strong>Position:</strong>
                                                                {{ $teacher->user->role->role_name ?? 'N/A' }}</p>
                                                            <p><strong>Department:</strong>
                                                                {{ $teacher->department->name ?? 'N/A' }}</p>
                                                            <p><strong>Major Subjects:</strong>
                                                                {{ $teacher->majorSubjects->pluck('short_code')->join(', ') ?? 'N/A' }}
                                                            </p>
                                                            <p><strong>Minor Subjects:</strong>
                                                                {{ $teacher->minorSubjects->pluck('name')->join(', ') ?? 'N/A' }}
                                                            </p>
                                                            <p><strong>Date of Birth:</strong>
                                                                {{ $teacher->date_of_birth }}</p>
                                                            <p><strong>Date Joined:</strong> {{ $teacher->date_of_hire }}
                                                            </p>
                                                            <p><strong>Years of Experience:</strong>
                                                                {{ $teacher->years_of_experience }}</p>
                                                            <p><strong>Qualifications:</strong>
                                                                {{ $teacher->qualifications ?? 'N/A' }}</p>
                                                            <p><strong>Bank Account No:</strong>
                                                                {{ $teacher->bank_account_no }}</p>
                                                            <p><strong>Bank Name:</strong> {{ $teacher->bank_name }}</p>
                                                            <p><strong>Emergency Contact:</strong>
                                                                {{ $teacher->emergency_contact_name }}</p>
                                                            <p><strong>Emergency Contact Relation:</strong>
                                                                {{ $teacher->emergency_contact_relation }}</p>
                                                            <p><strong>Emergency Contact Phone:</strong>
                                                                {{ $teacher->emergency_contact_phone }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary col-md-12 btn-sm"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteTeacherModal{{ $teacher->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="deleteTeacherModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteTeacherModalLabel">Delete Confirmation
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete {{ $teacher->first_name }}
                                                        {{ $teacher->last_name }}?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form method="POST"
                                                        action="{{ route('teachers.destroy', $teacher->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>

                        </table>





                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#subjects_primary').select2({
                placeholder: "Select Primary Subjects"
            });

            $('#subjects_secondary').select2({
                placeholder: "Select Secondary Subjects"
            });
            $('.subjectSelect').select2({
                placeholder: "Select subjects",
                width: '100%'
            });
        });
    </script>
@endsection

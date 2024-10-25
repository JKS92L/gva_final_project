@extends('admin.admim-master')
@section('admin_content')
    <style>
        .assignedSubjectTable {
            max-height: 400px;
            /* Set your desired maximum height */
            overflow-y: auto;
            /* Enable vertical scrolling if the content exceeds the maximum height */
            overflow-x: hidden;
            /* Prevent horizontal scrolling */
            border: 1px solid #ddd;
            /* Optional: Add a border */
            border-radius: 5px;
            /* Optional: Add rounded corners */
            padding: 15px;
            /* Optional: Add padding inside the card */
        }

        .assignedSubjectTable {
            max-height: 400px;
            /* Set the maximum height for the table */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        .assignedSubjectTable thead {
            position: sticky;
            /* Make the header sticky */
            top: 0;
            /* Set the position of the sticky header */
            background-color: #f8f9fa;
            /* Match Bootstrap light background */
            z-index: 1020;
            /* Ensure the header is on top of the other content */
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Left side: Assign Subjects Form -->
            <div class="col-md-4">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Assign New Subject to Grade</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('academics.assign.classSubjects') }}" method="POST">
                            @csrf

                            <!-- Select Grade (Class) -->
                            <div class="form-group col-md-12">
                                <label for="grade">Grade (with Class)</label>
                                <select id="grade" class="form-control form-control-sm" name="grade">
                                    <option selected disabled>Select Grade & Class</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->gradeno }} - {{ $grade->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- Error display for grade -->
                                @error('grade')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Subjects -->
                            <div class="form-group col-md-12">
                                <label for="subjects">Subjects</label>
                                <select id="subjectsIds" class="form-control form-control-sm" multiple="multiple"
                                    name="subjects[]">
                                    @foreach ($allSubjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->short_code . ' ( ' . ucfirst($subject->section) . ' )' }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- Error display for subjects -->
                                @error('subjects')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Select Academic Session -->
                            <div class="form-group col-md-12">
                                <label for="academic_session">Academic Session</label>
                                <select id="academic_session" class="form-control form-control-sm" name="academic_session">
                                    <option selected disabled>Select Academic Session</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year->id }}">{{ $year->academic_year }}</option>
                                    @endforeach
                                </select>
                                <!-- Error display for academic session -->
                                @error('academic_session')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success btn-sm">Assign Subject</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Right side: Table of Assigned Subjects -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Assigned Subjects to Grades</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive assignedSubjectTable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Grade (Class)</th>
                                        <th>Academic Session</th>
                                        <th>Subjects Assigned</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignments as $grade)
                                        @php
                                            // Group subjects by academic session for this grade
                                            $groupedBySession = $grade->subjects->groupBy('pivot.academic_session_id');
                                        @endphp

                                        @foreach ($groupedBySession as $academicSessionId => $subjects)
                                            <tr>
                                                <td>{{ $grade->gradeno . $grade->class_name }}</td>
                                                <td>
                                                    @php
                                                        $session = $academicYears->firstWhere('id', $academicSessionId); // Find the session by ID
                                                    @endphp
                                                    {{ $session ? $session->academic_year : 'Unknown' }}
                                                </td>
                                                <td>{{ $subjects->pluck('name')->join(', ') }}</td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                        data-target="#editModal-{{ $grade->id }}-{{ $academicSessionId }}">
                                                        Edit
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#deleteModal-{{ $grade->id }}-{{ $academicSessionId }}">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- edit the modal --}}
                                            <div class="modal fade"
                                                id="editModal-{{ $grade->id }}-{{ $academicSessionId }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form method="POST"
                                                            action="{{ route('academics.update.class.subjects') }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel">Edit Subjects
                                                                    for Grade {{ $grade->gradeno . $grade->class_name }}
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Hidden Inputs for Grade ID and Academic Session ID -->
                                                                <input type="hidden" name="grade_id"
                                                                    value="{{ $grade->id }}">
                                                                <input type="hidden" name="academic_session_id"
                                                                    value="{{ $academicSessionId }}">

                                                                <!-- Academic Year Selection -->
                                                                <div class="form-group col-md-12">
                                                                    <label for="academic_session">Academic Year</label>
                                                                    <select name="academic_session_id"
                                                                        class="form-control form-control-sm" required>
                                                                        @foreach ($academicYears as $year)
                                                                            <option value="{{ $year->id }}"
                                                                                {{ $year->id == $academicSessionId ? 'selected' : '' }}>
                                                                                {{ $year->academic_year }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <!-- Subjects Selection -->
                                                                <div class="form-group col-md-12">
                                                                    <label for="subjects">Subjects</label>
                                                                    <select
                                                                        id="subjectsIds-{{ $grade->id }}-{{ $academicSessionId }}"
                                                                        class="form-control form-control-sm subjectsEdit"
                                                                        multiple="multiple" name="subjects[]">
                                                                        @foreach ($allSubjects as $subject)
                                                                            <option value="{{ $subject->id }}"
                                                                                {{ $grade->subjects->where('pivot.academic_session_id', $academicSessionId)->pluck('id')->contains($subject->id)? 'selected': '' }}>
                                                                                {{ $subject->short_code . ' ( ' . ucfirst($subject->section) . ' )' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <!-- Error display for subjects -->
                                                                    @error('subjects')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>




                                            <!-- Delete Modal -->
                                            <div class="modal fade"
                                                id="deleteModal-{{ $grade->id }}-{{ $academicSessionId }}"
                                                tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form method="POST"
                                                            action="{{ route('academics.delete.class.subjects') }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                    Assignment for Grade
                                                                    {{ $grade->gradeno . $grade->class_name }}</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="grade_id"
                                                                    value="{{ $grade->id }}">
                                                                <input type="hidden" name="academic_session_id"
                                                                    value="{{ $academicSessionId }}">
                                                                Are you sure you want to delete the subjects assignment for
                                                                this grade and academic session?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <!-- Pagination Links -->

                            </table>
                            {{-- <div class="pagination-wrapper text-sm">
                                {{ $assignments->links() }} <!-- This will generate pagination links -->
                            </div> --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Initialize Select2 for Subjects
        $(document).ready(function() {

            // SweetAlert2 for Success Message
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            // SweetAlert2 for Error Message
            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            // Initialize select2 for the form inputs outside modals
            $('#subjectsIds').select2({
                width: '100%',
                placeholder: 'Select Subjects'
            });
            $('.subjectsEdit').select2({
                width: '100%',
                placeholder: 'Select Subjects'
            });


        });
    </script>
@endsection

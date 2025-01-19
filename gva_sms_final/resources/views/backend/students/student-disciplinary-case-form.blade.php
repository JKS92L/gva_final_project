@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Disciplinary Form</h2>
                    <p class="text-muted">Add a disciplinary record</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    <!-- Trigger Button for Modal -->
                    <a href="{{ route('student.disciplinaryList.view') }}" class="btn btn-success">
                        <i class="fas fa-list-ul"></i> View Disciplinary List
                    </a>

                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content p-2">
        <div class="container-fluid row">
            <div class="col-md-12">
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
            </div>


            <div class="card col-md-12">
                <div class="card-header small">
                    <h5 class="card-title" id="disciplinaryModalLabel">Student Disciplinary Action Form</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('student.disciplinary.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Student Details -->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="term">Select Term </label>
                                <select class="form-control form-control-sm" id="academic_term" name="academic_term"
                                    required>
                                    <option value="">--Select a term--</option>
                                    @foreach ($academicYears as $year)
                                        @foreach ($year->terms as $term)
                                            <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                {{ $year->academic_year }} - Term {{ $term->term_number }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="student_name" class="form-label">Student Name</label>
                                <select class="form-control form-control-sm select2" id="student_name" name="student_name"
                                    required>
                                    <option value="">Select a Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->firstname ?? 'N/A' }}
                                            {{ $student->lastname ?? '' }}
                                            - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                                            - Grade {{ $student->grade->gradeno ?? 'N/A' }}
                                            {{ $student->grade->class_name ?? 'N/A' }}
                                            - ({{ $student->student_type ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="incident_date" class="form-label">Date of Incident</label>
                                <input type="date" class="form-control form-control-sm" id="incident_date"
                                    name="incident_date" required>
                            </div>
                             <div class="col-md-3">
                                <label for="incident_time" class="form-label">Time of Incident</label>
                                <input type="time" class="form-control form-control-sm" id="incident_time"
                                    name="incident_time" required>
                            </div>
                            <div class="col-md-3">
                                <label for="incident_location" class="form-label">Location of Incident</label>
                                <input type="text" class="form-control form-control-sm" id="incident_location"
                                    name="incident_location" required>
                            </div>
                            <div class="col-md-4">
                                <label for="reported_by" class="form-label">Reported By</label>
                                <input type="text" class="form-control form-control-sm" id="reported_by"
                                    name="reported_by" required>
                            </div>
                            <div class="col-md-4">
                                <label for="incident_description" class="form-label">Incident Description</label>
                                <textarea class="form-control form-control-sm" id="incident_description" name="incident_description" rows="3"
                                    required></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="disciplinary_action" class="form-label">Disciplinary Action</label>
                                <select class="form-select form-control form-control-sm" id="disciplinary_action"
                                    name="disciplinary_action" required>
                                    <option value="" disabled selected>Select Action</option>
                                    <option value="Warning">Warning</option>
                                    <option value="Suspension">Suspension</option>
                                    <option value="Expulsion">Expulsion</option>
                                    <option value="Punishment">Severe Punishment</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Details -->
                        <div class="form-row d-none" id="date_fields">
                            <div class="col-md-6">
                                <label for="suspension_start_date" class="form-label">Suspension/Punishment Start
                                    Date</label>
                                <input type="date" class="form-control form-control-sm" id="suspension_start_date"
                                    name="suspension_start_date">
                            </div>
                            <div class="col-md-6">
                                <label for="suspension_end_date" class="form-label">Suspension/Punishment End Date</label>
                                <input type="date" class="form-control form-control-sm" id="suspension_end_date"
                                    name="suspension_end_date">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3">
                                <label for="action_date" class="form-label">Date of Action</label>
                                <input type="date" class="form-control form-control-sm" id="action_date"
                                    name="action_date" required>
                            </div>
                            <div class="col-md-3">
                                <label for="action_taken_by" class="form-label">Action Taken By</label>
                                <input type="text" class="form-control form-control-sm" id="action_taken_by"
                                    name="action_taken_by" required>
                            </div>
                            <div class="col-md-3">
                                <label for="action_description" class="form-label">Action Description</label>
                                <textarea class="form-control form-control-sm" id="action_description" name="action_description" rows="2"
                                    required></textarea>
                            </div>
                            <div class="col-md-3">
                                <label for="attachments" class="form-label">Upload Attachments</label>
                                <input type="file" class="form-control form-control-sm" id="attachments"
                                    name="attachments[]" multiple>
                            </div>
                        </div>

                        <!-- Approval Details -->
                        <div class="form-row ">
                            {{-- <div class="col-md-3">
                                <label for="approved_by" class="form-label">Approved By</label>
                                <input type="text" class="form-control form-control-sm" id="approved_by"
                                    name="approved_by">
                            </div> --}}
                            {{-- <div class="col-md-3">
                                <label for="approval_date" class="form-label">Approval Date</label>
                                <input type="date" class="form-control form-control-sm" id="approval_date"
                                    name="approval_date">
                            </div>
                            <div class="col-md-9">
                                <label for="comments" class="form-label">Comments/Remarks</label>
                                <textarea class="form-control form-control-sm" id="comments" name="comments" rows="4"></textarea>
                            </div> --}}
                        </div>

                        <!-- Status -->
                        {{-- <div class="form-row mb-3">
                            <div class="col">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="status_resolved" name="status"
                                        value="Resolved" required>
                                    <label class="form-check-label" for="status_resolved">Resolved</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="status_pending" name="status"
                                        value="Pending">
                                    <label class="form-check-label" for="status_pending">Pending</label>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Submit Button -->
                        <div class="text-center col-md-12 p-3">
                            <button type="submit" class="btn btn-primary btn-sm">Submit for Review & Approval</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>





    </div>


    </div>
    <script>
        function toggleDateFields() {
            const actionSelect = document.getElementById('disciplinary_action');
            const dateFields = document.getElementById('date_fields');

            if (actionSelect.value === 'Suspension' || actionSelect.value === 'Punishment') {
                dateFields.style.display = 'block';
            } else {
                dateFields.style.display = 'none';
            }
        }


        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Student',
                width: '100%'
            });

            $('#disciplinary_action').on('change', function() {
                var selectedAction = $(this).val();
                if (selectedAction === 'Suspension' || selectedAction === 'Punishment') {
                    $('#date_fields').removeClass('d-none');
                } else {
                    $('#date_fields').addClass('d-none');
                }
            });
        });
    </script>
@endsection

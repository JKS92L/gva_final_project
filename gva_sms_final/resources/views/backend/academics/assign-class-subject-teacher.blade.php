@extends('admin.admim-master')
@section('admin_content')
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
            <!-- Right Column: Assignment Form -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Assign Teacher to Class Subject
                    </div>
                    <div class="card-body">
                        <form id="fetchsubjectTeachers">
                            @csrf
                            <!-- Class ID Input -->
                            <div class="form-group col-md-12">
                                <label for="grade">Grade/Class (with assigned Subjects)</label>
                                <select id="grade" class="form-control form-control-sm" name="grade">
                                    <option selected disabled>Select Grade & Class</option>
                                    @foreach ($gradesWithSubjects as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->gradeno }} - {{ $grade->class_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Error display for grade -->
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success btn-block btn-sm">
                                <i class="fas fa-search"></i> Search Subjects
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 id="class-name" class="text-info">Select Class</h4>
                    </div>
                    <div class="card-body">
                        <form id="assignTeachersForm" method="POST">
                            @csrf
                            <input type="hidden" id="class_id" name="class_id" value="">

                            <input type="hidden" id="session_id" name="session_id" value="">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject List</th>
                                        <th>Teachers List</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic content will be injected here by AJAX -->
                                </tbody>
                            </table>
                            <button id="updateAssignedTeachers" type="button"
                                class="btn btn-success btn-sm float-right">Update Assigned Teachers</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {


            $('#fetchsubjectTeachers').on('submit', function(e) {
                e.preventDefault();

                let gradeId = $('#grade').val();
                let selectedGradeName = $('#grade option:selected').text(); // Get selected class name

                $.ajax({
                    url: '/admin/academics/fetch-subjects-teachers/' + gradeId,
                    type: 'GET',
                    success: function(response) {
                        // Assign fetched values to hidden inputs
                        $('#class_id').val(gradeId);
                        console.log(response);

                        // Update the card header with the selected class name
                        $('#class-name').removeClass('text-info').text(selectedGradeName);

                        let tableBody = $('table tbody');
                        tableBody.empty();

                        response.classSubjects.forEach((classSubject, index) => {
                            $('#session_id').val(classSubject.academic_session_id);

                            // Build each row with subject and teacher information
                            let row = `<tr>
                    <td>${index + 1}</td>
                    <td>${classSubject.subjects.name}</td>
                    
                    <!-- Hidden input to store subject ID for each row -->
                    <input type="hidden" name="subject_id[]" value="${classSubject.subject_id}" />

                    <td>
                        <select name="teacher_id[]" class="form-control">`;

                            // Get assigned teacher ID if available
                            let assignedTeacherId = classSubject.assigned_teachers
                                .length > 0 ?
                                classSubject.assigned_teachers[0].teacher_id :
                                null;

                            // Add major teachers with conditional selection
                            classSubject.subjects.major_teachers.forEach(teacher => {
                                let prefix = teacher.gender === 'Male' ? 'Mr.' :
                                    'Ms.';
                                let fullName =
                                    `${prefix} ${teacher.first_name} ${teacher.last_name}`;
                                let selected = teacher.id ===
                                    assignedTeacherId ? 'selected' : '';
                                row +=
                                    `<option value="${teacher.id}" ${selected}>${fullName} (Major)</option>`;
                            });

                            // Add minor teachers with conditional selection
                            classSubject.subjects.minor_teachers.forEach(teacher => {
                                let prefix = teacher.gender === 'Male' ? 'Mr.' :
                                    'Ms.';
                                let fullName =
                                    `${prefix} ${teacher.first_name} ${teacher.last_name}`;
                                let selected = teacher.id ===
                                    assignedTeacherId ? 'selected' : '';
                                row +=
                                    `<option value="${teacher.id}" ${selected}>${fullName} (Minor)</option>`;
                            });

                            row += `</select></td></tr>`;
                            tableBody.append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        // Revert to default message if error occurs
                        $('#class-name').addClass('text-info').text('Select Class');
                    }
                });
            });



            // update the assigned teachers lesson

            // Event listener for updating assigned teachers
            $('#updateAssignedTeachers').on('click', function(e) {
                e.preventDefault();

                let assignments = [];

                // Iterate over each table row to get subject and teacher IDs
                $('table tbody tr').each(function() {
                    let subjectId = $(this).find('input[name="subject_id[]"]')
                .val(); // Fetch subject ID from hidden input
                    let teacherId = $(this).find('select[name="teacher_id[]"]')
                .val(); // Fetch selected teacher ID

                    assignments.push({
                        subject_id: subjectId,
                        teacher_id: teacherId
                    });
                });

                // AJAX request to update the assignments
                $.ajax({
                    url: '/admin/academics/assign-subject-teachers',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        session_id: $('#session_id').val(),
                        class_id: $('#class_id').val(),
                        subjects: assignments, // Send subject-teacher assignments array
                    },
                    success: function(response) {
                        alert(response.message); // Display success message
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText); // Log error for debugging
                    }
                });
            });

        });
    </script>
@endsection

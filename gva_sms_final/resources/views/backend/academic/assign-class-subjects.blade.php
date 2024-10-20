@extends('admin.admim-master')
@section('admin_content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#assignSubjectModal">
                            Assign New Subject
                        </button>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid mt-5">
        <!-- Page Header -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Assign Subjects to Grades</h3>
            </div>
            <!-- Table of Assigned Subjects -->
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive table-hover">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Grade (Class)</th>
                                    <th>Subjects Assigned</th>
                                    <th>Class/Grade Teacher</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Grade 10 - Class A</td>
                                    <td>Mathematics, English, Science</td>
                                    <td>Mr. John Doe</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-toggle="modal"
                                            data-target="#viewDetailsModal"
                                            onclick="showDetails('Grade 10 - Class A', 45, 'Mathematics - Mrs. Jane Smith, English - Mr. Robert Brown, Science - Dr. Emily White')">
                                            View More
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#editModal">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <!-- You can add more rows here -->
                            </tbody>
                            <!-- Modal for Editing -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Class Assignment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <!-- Select Grade (includes Class) -->
                                                    <div class="form-group col-md-12">
                                                        <label for="editGrade">Grade (with Class)</label>
                                                        <select id="editGrade" class="form-control form-control-sm">
                                                            <option selected disabled>Select Grade & Class</option>
                                                            <option>Grade 8 - Class A</option>
                                                            <option>Grade 9 - Class B</option>
                                                            <option>Grade 10 - Class C</option>
                                                            <option>Grade 11 - Class A</option>
                                                            <option>Grade 12 - Class B</option>
                                                        </select>
                                                    </div>

                                                    <!-- Multi-Select for Subjects (using Select2) -->
                                                    <div class="form-group col-md-12">
                                                        <label for="editSubjects">Subjects</label>
                                                        <select id="editSubjects" class="form-control form-control-sm"
                                                            multiple="multiple">
                                                            <option>Mathematics</option>
                                                            <option>English</option>
                                                            <option>Science</option>
                                                            <option>History</option>
                                                            <option>Geography</option>
                                                        </select>
                                                    </div>

                                                    <!-- Input for Class/Grade Teacher -->
                                                    <div class="form-group col-md-12">
                                                        <label for="editTeacher">Class/Grade Teacher</label>
                                                        <select id="editTeacher" class="form-control form-control-sm"
                                                            name="editTeacher">
                                                            <option selected disabled>Select Class Teacher</option>
                                                            <option>Teacher A</option>
                                                            <option>Teacher A</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning btn-sm">Update
                                                    Assignment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal to view more details -->
                            <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog"
                                aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewDetailsModalLabel">Class Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 id="modal-grade">Grade/Class: </h5>
                                            <p><strong>Total Pupils in Class: </strong><span id="modal-total-pupils"></span>
                                            </p>
                                            <p><strong>Subject Teachers:</strong></p>
                                            <ul id="modal-subject-teachers"></ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </table>





                    </div>

                </div>
            </div>
        </div>

        <!-- Assign New Subject Modal -->
        <div class="modal fade" id="assignSubjectModal" tabindex="-1" role="dialog"
            aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignSubjectModalLabel">Assign New Subject to Grade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-row">
                                <!-- Select Grade (includes Class) -->
                                <div class="form-group col-md-12">
                                    <label for="grade">Grade (with Class)</label>
                                    <select id="grade" class="form-control form-control-sm">
                                        <option selected disabled>Select Grade & Class</option>
                                        <option>Grade 8 - Class A</option>
                                        <option>Grade 9 - Class B</option>
                                        <option>Grade 10 - Class C</option>
                                        <option>Grade 11 - Class A</option>
                                        <option>Grade 12 - Class B</option>
                                    </select>
                                </div>

                                <!-- Multi-Select for Subjects (using Select2) -->
                                <div class="form-group col-md-12">
                                    <label for="subjects">Subjects</label>
                                    <select id="subjects" class="form-control form-control-sm" multiple="multiple"
                                        name="subjects[]">
                                        <option>Mathematics</option>
                                        <option>English</option>
                                        <option>Science</option>
                                        <option>History</option>
                                        <option>Geography</option>
                                    </select>
                                </div>

                                <!-- Input for Class/Grade Teacher -->
                                <div class="form-group col-md-12">
                                    <label for="teacher">Class/Grade Teacher</label>
                                    <select id="teacher" class="form-control form-control-sm" name="teacher">
                                        <option selected disabled>Select Class Teacher</option>
                                        <option>Teacher A</option>
                                        <option>Teacher A</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm">Assign Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Select2 for Subjects
        $(document).ready(function() {
            // Initialize select2 for the form inputs outside modals (if any)
            $('#subjects').select2({
                width: '100%',
                placeholder: 'Select Subjects'
            });

            // Re-initialize select2 when the modal is opened
            $('#editModal').on('shown.bs.modal', function() {
                $('#editSubjects').select2({
                    width: '100%',
                    placeholder: 'Select Subjects'
                });
            });

            // Close data table rows (if you have that logic)
            // Example code for expandable table row toggle can go here
        });
    </script>
@endsection

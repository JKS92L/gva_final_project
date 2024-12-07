@extends('admin.admim-master')
@section('admin_content')
    <style>
        .table th,
        .table td {
            text-align: center;
        }

        .form-control[disabled] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .mark-absent, .mark-present {
            cursor: pointer;
        }

        .info-message {
            display: none;
            margin-top: 10px;
        }
    </style>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Enter Results</h5>
                </div>

                <div class="card-body">
                    {{-- Form for selecting academic year, term, grade/class, and subject --}}
                    <form id="resultsForm" action="{{ route('save.results') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <!-- Academic Term -->
                            <div class="form-group col-md-3">
                                <label for="academic_term">Academic Term</label>
                                <select class="form-control form-control-sm" id="academic_term" name="academic_term" required>
                                    <option value="">--Select a term--</option>
                                    @foreach ($terms as $term)
                                        <option value="{{ $term['id'] }}">{{ $term['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Grade -->
                            <div class="form-group col-md-3">
                                <label for="class_id">Grade/Class</label>
                                <select id="class_id" name="class_id" class="form-control form-control-sm" required>
                                    <option value="">Select Grade/Class</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">
                                            {{ $grade->gradeno . ' ' . $grade->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subject -->
                            <div class="form-group col-md-3">
                                <label for="subject">Subject</label>
                                <select id="subject" class="form-control form-control-sm" name="subject" required>
                                    <option value="" disabled selected>Select Subject</option>
                                    <option>Mathematics</option>
                                    <option>English</option>
                                    <option>Science</option>
                                    <!-- Add more subjects dynamically -->
                                </select>
                            </div>

                            <!-- Exam Type -->
                            <div class="form-group col-md-3">
                                <label for="examtype">Exam Type</label>
                                <select id="examtype" class="form-control form-control-sm" name="examtype" required>
                                    <option value="" disabled selected>Select Exam Type</option>
                                    <option>Midterm</option>
                                    <option>End of Term</option>
                                </select>
                            </div>

                            <!-- Show Register Button -->
                            <div class="form-group col-md-12 mt-3">
                                <button type="button" id="showRegister" class="btn btn-primary btn-sm">Show Class Register</button>
                            </div>
                        </div>

                        <div id="classRegister" class="mt-4" style="display: none;">
                            {{-- Table for entering results --}}
                            <h5 class="mb-3">Class Register</h5>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Marks (%)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Dynamically populated using JavaScript --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success btn-sm">Save Results</button>
                                <button type="button" class="btn btn-secondary btn-sm" id="clearRegister">Clear All</button>
                            </div>
                        </div>
                    </form>

                    {{-- Information Messages --}}
                    <div id="infoMessage" class="alert alert-success info-message" role="alert">
                        Results saved successfully!
                    </div>
                    <div id="errorMessage" class="alert alert-danger info-message" role="alert">
                        An error occurred while saving results.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('showRegister').addEventListener('click', function () {
            const classId = document.getElementById('class_id').value;
            const subject = document.getElementById('subject').value;

            if (!classId || !subject) {
                alert('Please select a grade/class and subject before proceeding.');
                return;
            }

            document.getElementById('classRegister').style.display = 'block';

            // Mock: Dynamically populate class register table
            const tableBody = document.querySelector('#classRegister tbody');
            tableBody.innerHTML = `
                <tr>
                    <td>STU-001</td>
                    <td>John Doe</td>
                    <td><input type="text" name="marks[]" class="form-control form-control-sm" placeholder="Enter marks" required></td>
                    <td><button type="button" class="btn btn-warning btn-sm mark-absent">Absent</button></td>
                </tr>
                <tr>
                    <td>STU-002</td>
                    <td>Jane Smith</td>
                    <td><input type="text" name="marks[]" class="form-control form-control-sm" placeholder="Enter marks" required></td>
                    <td><button type="button" class="btn btn-warning btn-sm mark-absent">Absent</button></td>
                </tr>
            `;
        });

        // Clear all inputs
        document.getElementById('clearRegister').addEventListener('click', function () {
            document.getElementById('resultsForm').reset();
            document.getElementById('classRegister').style.display = 'none';
        });
    </script>
@endsection

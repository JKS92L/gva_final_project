@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'File Monitoring')
@section('content_header_title', 'Supervisor')
@section('content_header_subtitle', 'File Monitoring Form')

{{-- Content body: main page content --}}
@section('content_body')

    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h3>File Monitoring Form</h3>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST"> {{-- Dummy action, replace later --}}
                            {{-- Add CSRF token for security if using Laravel --}}
                            {{-- @csrf --}}
                            {{-- Teacher selection --}}
                            <div class="form-group">
                                <label for="teacher_select">Select Teacher</label>
                                <select name="teacher" id="teacher_select" class="form-control" required>
                                    <option value="">-- Select Teacher --</option>
                                    <option value="John Doe">Michael Sata(Mr)</option>
                                    <option value="Jane Smith">Jane Smith (Mrs)</option>
                                    <option value="Michael Johnson">Funga Bwalya(Ms)</option>
                                </select>
                            </div>

                            <h5>Documents Review (Rate out of 10)</h5>

                            {{-- PERSONAL DETAILS --}}
                            {{-- <div class="form-group">
                                <label for="personal_details">Personal Details</label>
                                <input type="number" name="personal_details_score" id="personal_details"
                                    class="form-control" min="0" max="10" required>
                                <label for="personal_details_comment" class="mt-2">Comments</label>
                                <textarea name="personal_details_comment" id="personal_details_comment" class="form-control" rows="2"></textarea>
                            </div> --}}

                            {{-- TIME TABLE --}}
                            <div class="form-group">
                                <label for="time_table">Time Table</label>
                                <input type="number" name="time_table_score" id="time_table" class="form-control"
                                    min="0" max="10" required>
                                <label for="time_table_comment" class="mt-2">Comments</label>
                                <textarea name="time_table_comment" id="time_table_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- INDIVIDUAL WORK PLAN --}}
                            <div class="form-group">
                                <label for="work_plan">Individual Work Plan</label>
                                <input type="number" name="work_plan_score" id="work_plan" class="form-control"
                                    min="0" max="10" required>
                                <label for="work_plan_comment" class="mt-2">Comments</label>
                                <textarea name="work_plan_comment" id="work_plan_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- CLASS LIST/ REGISTERS --}}
                            <div class="form-group">
                                <label for="class_list">Class List / Registers</label>
                                <input type="number" name="class_list_score" id="class_list" class="form-control"
                                    min="0" max="10" required>
                                <label for="class_list_comment" class="mt-2">Comments</label>
                                <textarea name="class_list_comment" id="class_list_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- SYLLABUS --}}
                            <div class="form-group">
                                <label for="syllabus">Syllabus</label>
                                <input type="number" name="syllabus_score" id="syllabus" class="form-control"
                                    min="0" max="10" required>
                                <label for="syllabus_comment" class="mt-2">Comments</label>
                                <textarea name="syllabus_comment" id="syllabus_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- SCHEMES OF WORK --}}
                            <div class="form-group">
                                <label for="schemes_of_work">Schemes of Work</label>
                                <input type="number" name="schemes_of_work_score" id="schemes_of_work" class="form-control"
                                    min="0" max="10" required>
                                <label for="schemes_of_work_comment" class="mt-2">Comments</label>
                                <textarea name="schemes_of_work_comment" id="schemes_of_work_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- LESSON PLANS --}}
                            <div class="form-group">
                                <label for="lesson_plans">Lesson Plans</label>
                                <input type="number" name="lesson_plans_score" id="lesson_plans" class="form-control"
                                    min="0" max="10" required>
                                <label for="lesson_plans_comment" class="mt-2">Comments</label>
                                <textarea name="lesson_plans_comment" id="lesson_plans_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- RECORDS OF WORK --}}
                            <div class="form-group">
                                <label for="records_of_work">Records of Work</label>
                                <input type="number" name="records_of_work_score" id="records_of_work"
                                    class="form-control" min="0" max="10" required>
                                <label for="records_of_work_comment" class="mt-2">Comments</label>
                                <textarea name="records_of_work_comment" id="records_of_work_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- HOME WORK POLICY/ RECORDS --}}
                            <div class="form-group">
                                <label for="homework_policy">Homework Policy / Records</label>
                                <input type="number" name="homework_policy_score" id="homework_policy"
                                    class="form-control" min="0" max="10" required>
                                <label for="homework_policy_comment" class="mt-2">Comments</label>
                                <textarea name="homework_policy_comment" id="homework_policy_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- TEST PAPERS MARKING KEYS --}}
                            <div class="form-group">
                                <label for="marking_keys">Test Papers Marking Keys</label>
                                <input type="number" name="marking_keys_score" id="marking_keys" class="form-control"
                                    min="0" max="10" required>
                                <label for="marking_keys_comment" class="mt-2">Comments</label>
                                <textarea name="marking_keys_comment" id="marking_keys_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- TEST SAMPLES --}}
                            <div class="form-group">
                                <label for="test_samples">Test Samples</label>
                                <input type="number" name="test_samples_score" id="test_samples" class="form-control"
                                    min="0" max="10" required>
                                <label for="test_samples_comment" class="mt-2">Comments</label>
                                <textarea name="test_samples_comment" id="test_samples_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- MARK SCHEDULES/ PROGRESS SHEETS --}}
                            <div class="form-group">
                                <label for="mark_schedules">Mark Schedules / Progress Sheets</label>
                                <input type="number" name="mark_schedules_score" id="mark_schedules"
                                    class="form-control" min="0" max="10" required>
                                <label for="mark_schedules_comment" class="mt-2">Comments</label>
                                <textarea name="mark_schedules_comment" id="mark_schedules_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- EXAM RESULT ANALYSIS --}}
                            <div class="form-group">
                                <label for="exam_analysis">Exam Result Analysis</label>
                                <input type="number" name="exam_analysis_score" id="exam_analysis" class="form-control"
                                    min="0" max="10" required>
                                <label for="exam_analysis_comment" class="mt-2">Comments</label>
                                <textarea name="exam_analysis_comment" id="exam_analysis_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- CPD MINUTES/REPORTS --}}
                            <div class="form-group">
                                <label for="cpd_minutes">CPD Minutes / Reports</label>
                                <input type="number" name="cpd_minutes_score" id="cpd_minutes" class="form-control"
                                    min="0" max="10" required>
                                <label for="cpd_minutes_comment" class="mt-2">Comments</label>
                                <textarea name="cpd_minutes_comment" id="cpd_minutes_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- CO-CURRICULAR ACTIVITIES --}}
                            <div class="form-group">
                                <label for="co_curricular">Co-curricular Activities</label>
                                <input type="number" name="co_curricular_score" id="co_curricular" class="form-control"
                                    min="0" max="10" required>
                                <label for="co_curricular_comment" class="mt-2">Comments</label>
                                <textarea name="co_curricular_comment" id="co_curricular_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- MONITORING RECORD --}}
                            <div class="form-group">
                                <label for="monitoring_record">Monitoring Record</label>
                                <input type="number" name="monitoring_record_score" id="monitoring_record"
                                    class="form-control" min="0" max="10" required>
                                <label for="monitoring_record_comment" class="mt-2">Comments</label>
                                <textarea name="monitoring_record_comment" id="monitoring_record_comment" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- MISCELLANEOUS --}}
                            <div class="form-group">
                                <label for="miscellaneous">Miscellaneous</label>
                                <input type="number" name="miscellaneous_score" id="miscellaneous" class="form-control"
                                    min="0" max="10" required>
                                <label for="miscellaneous_comment" class="mt-2">Comments</label>
                                <textarea name="miscellaneous_comment" id="miscellaneous_comment" class="form-control" rows="2"></textarea>
                            </div>
                            {{-- GENERAL COMMENTS --}}
                            <div class="form-group mt-4">
                                <label for="general_comment">General Comments</label>
                                <textarea name="general_comment" id="general_comment" class="form-control" rows="3"
                                    placeholder="Type your general comments here..."></textarea>
                            </div>

                            {{-- OBSERVER INFO (Disabled input fields) --}}
                            <div class="form-group mt-4">
                                <label for="observer_name">Observer Name</label>
                                <input type="text" id="observer_name" class="form-control" value="Observer Name"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label for="observer_position">Observer Position</label>
                                <input type="text" id="observer_position" class="form-control" value="Supervisor"
                                    disabled>
                            </div>
                            {{-- Submit button --}}
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

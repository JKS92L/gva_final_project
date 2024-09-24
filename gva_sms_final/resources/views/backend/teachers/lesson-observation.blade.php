@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Teachers')
@section('content_header_title', 'Teachers')
@section('content_header_subtitle', 'Lesson Observation Form')

{{-- Content body: main page content --}}
@section('content_body')

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Lesson Observation Form</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="POST"> {{-- Dummy action, replace later --}}
                        {{-- Add CSRF token for security if using Laravel --}}
                        {{-- @csrf --}}

                        {{-- Select Teacher --}}
                        <div class="form-group">
                            <label for="teacher">Teacher Name</label>
                            <select name="teacher_id" id="teacher" class="form-control" required>
                                <option value="" selected disabled>Select Teacher</option>
                                {{-- Dynamically populate this list with teachers from the database --}}
                                <option value="1">Teacher 1</option>
                                <option value="2">Teacher 2</option>
                                <option value="3">Teacher 3</option>
                                {{-- More teacher options can go here --}}
                            </select>
                        </div>

                        {{-- Date of Observation --}}
                        <div class="form-group">
                            <label for="date">Date of Observation</label>
                            <input type="date" name="observation_date" id="date" class="form-control" required>
                        </div>

                        {{-- Time of Observation --}}
                        <div class="form-group">
                            <label for="time">Time of Observation</label>
                            <input type="time" name="observation_time" id="time" class="form-control" required>
                        </div>

                        {{-- Lesson Subject --}}
                        <div class="form-group">
                            <label for="subject">Lesson Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter the subject taught" required>
                        </div>

                        {{-- Lesson Objectives --}}
                        <div class="form-group">
                            <label for="objectives">Lesson Objectives</label>
                            <textarea name="objectives" id="objectives" class="form-control" placeholder="State the lesson objectives" rows="3" required></textarea>
                        </div>

                        {{-- Scoring Fields --}}
                        <h5>Scoring Criteria (Rate out of 10)</h5>
                        
                        {{-- Lesson Planning --}}
                        <div class="form-group">
                            <label for="planning">Lesson Planning</label>
                            <input type="number" name="score_planning" id="planning" class="form-control" min="0" max="10" required>
                        </div>

                        {{-- Classroom Management --}}
                        <div class="form-group">
                            <label for="management">Classroom Management</label>
                            <input type="number" name="score_management" id="management" class="form-control" min="0" max="10" required>
                        </div>

                        {{-- Lesson Delivery --}}
                        <div class="form-group">
                            <label for="delivery">Lesson Delivery</label>
                            <input type="number" name="score_delivery" id="delivery" class="form-control" min="0" max="10" required>
                        </div>

                        {{-- Learner Engagement --}}
                        <div class="form-group">
                            <label for="engagement">Learner Engagement</label>
                            <input type="number" name="score_engagement" id="engagement" class="form-control" min="0" max="10" required>
                        </div>

                        {{-- Use of Resources --}}
                        <div class="form-group">
                            <label for="resources">Use of Teaching Aids/Resources</label>
                            <input type="number" name="score_resources" id="resources" class="form-control" min="0" max="10" required>
                        </div>

                        {{-- Assessment of Learners --}}
                        <div class="form-group">
                            <label for="assessment">Assessment of Learners</label>
                            <input type="number" name="score_assessment" id="assessment" class="form-control" min="0" max="10" required>
                        </div>

                        {{-- Comment Section --}}
                        <div class="form-group">
                            <label for="comments">General Comments</label>
                            <textarea name="comments" id="comments" class="form-control" placeholder="Provide any additional feedback" rows="4"></textarea>
                        </div>

                        {{-- Supervisor's Name --}}
                        <div class="form-group">
                            <label for="supervisor">Supervisor Name</label>
                            <input type="text" name="supervisor" id="supervisor" class="form-control" value="Supervisor Name" readonly>
                        </div>

                        {{-- Submit Button --}}
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit Observation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

{{-- Push extra CSS --}}
@push('css')
<link rel="stylesheet" href="/css/custom_datatables.css">
<style>
    /* Custom styles */
    .form-group label {
        font-weight: bold;
    }
</style>
@endpush

{{-- Push extra scripts --}}
@push('js')
<script>
    // You can add custom JS validation or interactivity here
</script>
@endpush

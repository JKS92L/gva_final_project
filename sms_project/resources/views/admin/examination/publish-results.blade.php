@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Result Validation and Publishing')
@section('content_header_title', 'Examination')
@section('content_header_subtitle', 'Validate and Publish Results')

{{-- Content body: main page content --}}
@section('content_body')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Result Validation</h5>
        <button class="btn btn-secondary btn-sm" onclick="">Back to Results List</button>
    </div>

    <div class="card-body">
        {{-- Filter Section --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <select class="form-control" id="filterGrade">
                    <option selected disabled>Filter by Grade</option>
                    <option value="8">Grade 8</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="filterClass">
                    <option selected disabled>Filter by Class</option>
                    <option value="A">Class A</option>
                    <option value="B">Class B</option>
                    <option value="C">Class C</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="filterSubject">
                    <option selected disabled>Filter by Subject</option>
                    <option value="Math">Mathematics</option>
                    <option value="English">English</option>
                    <option value="Science">Science</option>
                    <!-- Add more subjects as needed -->
                </select>
            </div>
        </div>

        {{-- Progress Bar for Validation Status --}}
        <div class="progress mb-3">
            <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70% Validated</div>
        </div>

        {{-- Results Validation Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Grade</th>
                        <th>Class</th>
                        <th>Validation Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy Data --}}
                    <tr>
                        <td>Mathematics</td>
                        <td>Mr. John Mwansa</td>
                        <td>Grade 10</td>
                        <td>Class A</td>
                        <td><span class="badge badge-danger">Missing Results</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#sendMessageModal">Notify Teacher</button>
                        </td>
                    </tr>
                    <tr>
                        <td>English</td>
                        <td>Ms. Alice Mulenga</td>
                        <td>Grade 9</td>
                        <td>Class B</td>
                        <td><span class="badge badge-success">Validated</span></td>
                        <td>
                            <button class="btn btn-secondary btn-sm disabled">No Action Needed</button>
                        </td>
                    </tr>
                    {{-- Additional rows with dynamically loaded data from the database --}}
                </tbody>
            </table>
        </div>

        {{-- Publish Results Button --}}
        <button class="btn btn-success mt-3 float-right" id="publishResults" disabled>Publish All Results</button>
    </div>
</div>

{{-- Modal for Sending Message to Teachers --}}
<div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMessageModalLabel">Notify Teacher About Missing Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="teacherName">Teacher Name</label>
                        <input type="text" class="form-control" id="teacherName" value="Mr. John Mwansa" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Your results for Mathematics (Grade 10, Class A) have missing entries. Please update them as soon as possible."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </div>
</div>

@stop

{{-- Push extra CSS --}}
@push('css')
<link rel="stylesheet" href="/css/custom_datatables.css">
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    .btn-warning {
        margin-right: 0.5rem;
    }
    .badge {
        font-size: 0.9rem;
    }
</style>
@endpush

{{-- Push extra scripts --}}
@push('js')
<script>
    $(document).ready(function() {
        // Example logic to enable/disable publish button
        let isAllValidated = false; // Dummy flag; in real implementation, calculate from results

        if (isAllValidated) {
            $('#publishResults').removeAttr('disabled');
        }

        // Modal functionality for sending message to teacher
        $('#sendMessageModal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let teacher = button.closest('tr').find('td:nth-child(2)').text();
            let subject = button.closest('tr').find('td:first-child').text();
            let modal = $(this);
            modal.find('#teacherName').val(teacher);
            modal.find('#message').val(`Your results for ${subject} have missing entries. Please update them.`);
        });
    });
</script>
@endpush

@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Manage Queries')
@section('content_header_title', 'Query Management Portal')
@section('content_header_subtitle', 'View and Manage Queries')

{{-- Content body: main page content --}}
@section('content_body')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Incoming, Resolved, and Pending Queries</h5>
    </div>

    <div class="card-body">
        {{-- Tabs for navigating between Incoming, Resolved, and Pending queries --}}
        <ul class="nav nav-tabs" id="queryTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="incoming-tab" data-toggle="tab" href="#incoming" role="tab" aria-controls="incoming" aria-selected="true">Incoming Queries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved" role="tab" aria-controls="resolved" aria-selected="false">Resolved Queries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending Queries</a>
            </li>
        </ul>

        <div class="tab-content mt-4" id="queryTabContent">
            {{-- Incoming Queries Section --}}
            <div class="tab-pane fade show active" id="incoming" role="tabpanel" aria-labelledby="incoming-tab">
                <h5 class="mb-3">Incoming Queries</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Query ID</th>
                                <th>Subject</th>
                                <th>Student Name</th>
                                <th>Query Type</th>
                                <th>Date Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dummy Data --}}
                            <tr>
                                <td>Q-001</td>
                                <td>Mathematics</td>
                                <td>John Doe</td>
                                <td>Incorrect Results</td>
                                <td>2024-08-01</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewQueryModal" data-query-id="Q-001">View & Respond</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Q-002</td>
                                <td>English</td>
                                <td>Jane Smith</td>
                                <td>Poor Results</td>
                                <td>2024-08-02</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewQueryModal" data-query-id="Q-002">View & Respond</button>
                                </td>
                            </tr>
                            {{-- Add more queries as needed --}}
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Resolved Queries Section --}}
            <div class="tab-pane fade" id="resolved" role="tabpanel" aria-labelledby="resolved-tab">
                <h5 class="mb-3">Resolved Queries</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Query ID</th>
                                <th>Subject</th>
                                <th>Student Name</th>
                                <th>Query Type</th>
                                <th>Date Resolved</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dummy Data --}}
                            <tr>
                                <td>Q-003</td>
                                <td>Science</td>
                                <td>Mary Johnson</td>
                                <td>Clarification Needed</td>
                                <td>2024-08-03</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#feedbackModal" data-query-id="Q-003">Submit Feedback</button>
                                </td>
                            </tr>
                            {{-- Add more queries as needed --}}
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pending Queries Section --}}
            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <h5 class="mb-3">Pending Queries</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Query ID</th>
                                <th>Subject</th>
                                <th>Student Name</th>
                                <th>Query Type</th>
                                <th>Date Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Dummy Data --}}
                            <tr>
                                <td>Q-004</td>
                                <td>History</td>
                                <td>Michael Brown</td>
                                <td>Missing Results</td>
                                <td>2024-08-05</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewQueryModal" data-query-id="Q-004">View & Respond</button>
                                </td>
                            </tr>
                            {{-- Add more queries as needed --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- View & Respond to Query Modal --}}
        <div class="modal fade" id="viewQueryModal" tabindex="-1" role="dialog" aria-labelledby="viewQueryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewQueryModalLabel">Query Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Query ID:</strong> <span id="queryIdDisplay">Q-001</span></p>
                        <p><strong>Subject:</strong> <span id="querySubjectDisplay">Mathematics</span></p>
                        <p><strong>Student Name:</strong> <span id="studentNameDisplay">John Doe</span></p>
                        <p><strong>Query Type:</strong> <span id="queryTypeDisplay">Incorrect Results</span></p>
                        <p><strong>Date Submitted:</strong> <span id="queryDateDisplay">2024-08-01</span></p>
                        <p><strong>Message:</strong> <span id="queryMessageDisplay">"The results are incorrect. I received 70%, but I was expecting 85%."</span></p>

                        <div class="form-group">
                            <label for="responseMessage">Response</label>
                            <textarea class="form-control" id="responseMessage" rows="4" placeholder="Write your response here..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitResponse">Submit Response</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Feedback Modal --}}
        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Submit Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Query ID:</strong> <span id="feedbackQueryIdDisplay">Q-003</span></p>
                        <p><strong>Subject:</strong> <span id="feedbackSubjectDisplay">Science</span></p>
                        <p><strong>Student Name:</strong> <span id="feedbackStudentNameDisplay">Mary Johnson</span></p>
                        <p><strong>Query Type:</strong> <span id="feedbackQueryTypeDisplay">Clarification Needed</span></p>
                        <p><strong>Date Resolved:</strong> <span id="feedbackDateResolvedDisplay">2024-08-03</span></p>

                        <div class="form-group">
                            <label for="feedbackMessage">Feedback</label>
                            <textarea class="form-control" id="feedbackMessage" rows="4" placeholder="Write your feedback here..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitFeedback">Submit Feedback</button>
                    </div>
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
    .table th, .table td {
        text-align: center;
    }
    .modal-body p {
        margin-bottom: 15px;
    }
    .modal-body textarea {
        resize: none;
    }
</style>
@endpush

{{-- Push extra scripts --}}
@push('js')
<script>
    // JavaScript to handle viewing and responding to queries
    $('#viewQueryModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const queryId = button.data('query-id');
        const modal = $(this);
        // Fetch and display query details based on queryId
        modal.find('#queryIdDisplay').text(queryId);
        // Add logic to fetch and display query details (dummy data for now)
    });

    $('#feedbackModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const queryId = button.data('query-id');
        const modal = $(this);
        // Fetch and display feedback details based on queryId
        modal.find('#feedbackQueryIdDisplay').text(queryId);
        // Add logic to fetch and display feedback details (dummy data for now)
    });

    // JavaScript to handle submitting responses and feedback
    document.getElementById('submitResponse').addEventListener('click', function() {
        const responseMessage = document.getElementById('responseMessage').value;
        if (responseMessage.trim() === '') {
            alert('Please enter a response message.');
            return;
        }
        // Add logic to handle the response submission
        alert('Response submitted: ' + responseMessage);
        $('#viewQueryModal').modal('hide');
    });

    document.getElementById('submitFeedback').addEventListener('click', function() {
        const feedbackMessage = document.getElementById('feedbackMessage').value;
        if (feedbackMessage.trim() === '') {
            alert('Please enter a feedback message.');
            return;
        }
        // Add logic to handle the feedback submission
        alert('Feedback submitted: ' + feedbackMessage);
        $('#feedbackModal').modal('hide');
    });
</script>
@endpush

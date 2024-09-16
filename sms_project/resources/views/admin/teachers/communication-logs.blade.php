@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Teacher Communication Logs')
@section('content_header_title', 'Communication Logs')
@section('content_header_subtitle', 'Teacher Communication Logs')

{{-- Content body: main page content --}}
@section('content_body')

<div class="container">
    <div class="row">
        <div class="col-12">
            {{-- Bootstrap Card --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Teacher Communication Logs</h3>
                </div>
                <div class="card-body">
                    <table id="communication-logs-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Teacher's Name</th>
                                <th>Recipient(Role)</th>
                                 <th>Communication Type</th>
                                <th>Message Title</th>
                                <th>Message Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Example rows --}}
                            <tr>
                                <td>2024-01-15</td>
                                <td>Silillo</td>
                                <td>Email</td>
                                <td>School events and projects.</td>
                                <td>Discussed upcoming ....</td>
                                <td>Discussed upcoming ....</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewLogModal">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-02-10</td>
                                <td>Kawana</td>
                                 <td>Phone Call</td>
                                <td>Davis(Parent)</td>
                                <td>School events and projects.</td>
                                <td>Discussed upcoming ....</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewLogModal">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2024-03-05</td>
                                <td>Bwalya</td>
                                <td>In-Person Meeting</td>
                                   <td>Mwanza(Teacher)</td>
                                <td>School events and projects.</td>
                                <td>Discussed upcoming ....</td>
                               
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewLogModal">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                            {{-- Add more dummy rows as needed --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- View Log Modal --}}
<div class="modal fade" id="viewLogModal" tabindex="-1" role="dialog" aria-labelledby="viewLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLogModalLabel">View Communication Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> <span id="log-date">2024-01-15</span></p>
                <p><strong>Teacher's Name:</strong> <span id="log-teacher">Silillo</span></p>
                <p><strong>Communication Type:</strong> <span id="log-type">Email</span></p>
                <p><strong>Details:</strong></p>
                <p id="log-details">Discussed upcoming school events and projects.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop

{{-- Push extra CSS --}}
@push('css')


<style>
    /* Custom styles for the card */
    /* Make the container for 'Show entries' and 'Search' align horizontally */
.dataTables_wrapper .dataTables_length, 
.dataTables_wrapper .dataTables_filter {
    display: inline-flex;
    align-items: center;
}

/* Add spacing between the two elements */
.dataTables_wrapper .dataTables_filter {
    margin-left: auto; /* Push the search box to the right */
}

/* Adjust the margin between the label and select */
.dataTables_wrapper .dataTables_length label, 
.dataTables_wrapper .dataTables_filter label {
    display: flex;
    align-items: center;
}

.dataTables_wrapper .dataTables_length label select {
    margin-left: 5px;
}

   
</style>
@endpush

{{-- Push extra scripts --}}
@push('js')
<script>
    $(document).ready(function() {
        // Initialize DataTable for communication logs
        $('#communication-logs-table').DataTable();

        // Example of setting log details in the modal
        $('#viewLogModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var date = button.closest('tr').find('td').eq(0).text();
            var teacher = button.closest('tr').find('td').eq(1).text();
            var type = button.closest('tr').find('td').eq(2).text();
            var details = button.closest('tr').find('td').eq(3).text();
            
            var modal = $(this);
            modal.find('#log-date').text(date);
            modal.find('#log-teacher').text(teacher);
            modal.find('#log-type').text(type);
            modal.find('#log-details').text(details);
        });
    });
</script>
@endpush

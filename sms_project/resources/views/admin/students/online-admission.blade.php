@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Online Admissions')
@section('content_header_title', 'Admissions')
@section('content_header_subtitle', 'Manage Applications')

{{-- Content body: main page content --}}
@section('content_body')


    {{-- Modal for Physical Admission --}}
    <div class="modal fade" id="physicalAdmissionModal" tabindex="-1" aria-labelledby="physicalAdmissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="physicalAdmissionModalLabel">Add Physical Admission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="physicalAdmissionForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="applicantName">Applicant Name</label>
                                <input type="text" class="form-control" id="applicantName"
                                    placeholder="Enter applicant's name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="applicationId">Application ID</label>
                                <input type="text" class="form-control" id="applicationId"
                                    placeholder="Enter application ID" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="admissionType">Admission Type</label>
                                <select id="admissionType" class="form-control" required>
                                     <option>--Select--</option>
                                    <option>Physical</option>
                                    <option>Online</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="applicationYear">Application Year</label>
                                <input type="number" class="form-control" id="applicationYear" value="{{ date('Y') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="submissionDate">Submission Date</label>
                                <input type="date" class="form-control" id="submissionDate" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" required>
                                    <option selected>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Admission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- View Applicant Modal -->
    <div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewApplicantModalLabel">Applicant Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Applicant Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Applicant Name:</strong> <span id="applicantName">Chileshe Mwansa</span></h6>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Application ID:</strong> <span id="applicationId">ADM004</span></h6>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <h6><strong>Admission Type:</strong> <span id="admissionType">Physical</span></h6>
                        </div>
                        <div class="col-md-4">
                            <h6><strong>Grade:</strong> <span id="grade">8</span></h6>
                        </div>
                        <div class="col-md-4">
                            <h6><strong>Citizenship:</strong> <span id="citizenship">Zambian</span></h6>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <h6><strong>District:</strong> <span id="district">Lusaka</span></h6>
                        </div>
                        <div class="col-md-4">
                            <h6><strong>Application Year:</strong> <span id="applicationYear">2024</span></h6>
                        </div>
                        <div class="col-md-4">
                            <h6><strong>Submission Date:</strong> <span id="submissionDate">05 Jan, 2024</span></h6>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6><strong>Application Status:</strong> <span id="applicationStatus"
                                    class="badge badge-warning">Pending</span></h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- admission container  --}}
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3>Online Admissions</h3>
                    <p>Manage and track applications from both physical and online applicants.</p>
                </div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#physicalAdmissionModal">
                    Add New Admission
                </button>
            </div>
            <div class="card-body table-responsive p-2">

                <table id="admissionsTable" class="table table-bordered table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Applicant Name</th>
                            <th>Application ID</th>
                            <th>Admission Type</th>
                            <th>Grade</th>
                            <th>District</th>
                            <th>Citizenship</th>
                            <th>Application Year</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Chileshe Mwansa</td>
                            <td>ADM004</td>
                            <td>Physical</td>
                            <td>8</td>
                            <td>Lusaka</td>
                            <td>Zambian</td>
                            <td>2024</td>
                            <td>05 Jan, 2024</td>
                            <td>
                                <span class="badge badge-warning">Pending</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#viewApplicantModal">View</button>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" class="btn btn-success btn-sm">Approve</a>
                                <a href="#" class="btn btn-danger btn-sm">Reject</a>
                            </td>


                        </tr>
                        <tr>
                            <td>Mutale Mulenga</td>
                            <td>ADM005</td>
                            <td>Online</td>
                            <td>10</td>
                            <td>Ndola</td>
                            <td>Zambian</td>
                            <td>2024</td>
                            <td>10 Feb, 2024</td>
                            <td>
                                <span class="badge badge-success">Approved</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#viewApplicantModal">View</button>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" class="btn btn-success btn-sm">Approve</a>
                                <a href="#" class="btn btn-danger btn-sm">Reject</a>
                            </td>

                        </tr>
                        <tr>
                            <td>Katongo Bwalya</td>
                            <td>ADM006</td>
                            <td>Physical</td>
                            <td>8</td>
                            <td>Kitwe</td>
                            <td>Zambian</td>
                            <td>2024</td>
                            <td>12 Mar, 2024</td>
                            <td>
                                <span class="badge badge-danger">Rejected</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#viewApplicantModal">View</button>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" class="btn btn-success btn-sm">Approve</a>
                                <a href="#" class="btn btn-danger btn-sm">Reject</a>
                            </td>

                        </tr>
                        <tr>
                            <td>Mbita Lungu</td>
                            <td>ADM007</td>
                            <td>Online</td>
                            <td>9</td>
                            <td>Livingstone</td>
                            <td>Zambian</td>
                            <td>2024</td>
                            <td>18 Apr, 2024</td>
                            <td>
                                <span class="badge badge-warning">Pending</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#viewApplicantModal">View</button>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" class="btn btn-success btn-sm">Approve</a>
                                <a href="#" class="btn btn-danger btn-sm">Reject</a>
                            </td>

                        </tr>
                        <tr>
                            <td>Nchimunya Banda</td>
                            <td>ADM008</td>
                            <td>Physical</td>
                            <td>11</td>
                            <td>Choma</td>
                            <td>Zambian</td>
                            <td>2024</td>
                            <td>25 May, 2024</td>
                            <td>
                                <span class="badge badge-success">Approved</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#viewApplicantModal">View</button>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="#" class="btn btn-success btn-sm">Approve</a>
                                <a href="#" class="btn btn-danger btn-sm">Reject</a>
                            </td>

                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>




@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- <link rel="stylesheet" href="/css/custom_datatables.css"> --}}
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(document).ready(function() {
            $('#admissionsTable').DataTable();

            // Modal form submission
            $('#physicalAdmissionForm').on('submit', function(e) {
                e.preventDefault();
                // Perform AJAX request to save physical admission data
                alert('Physical admission saved successfully!');
                $('#physicalAdmissionModal').modal('hide');
            });


            $(document).ready(function() {
                $('#admissionsTable').on('click', '.btn-info', function() {
                    // Get the table row where the button was clicked
                    let row = $(this).closest('tr');

                    // Fetch data from the clicked row
                    let applicantName = row.find('td:nth-child(1)').text();
                    let applicationId = row.find('td:nth-child(2)').text();
                    let admissionType = row.find('td:nth-child(3)').text();
                    let grade = row.find('td:nth-child(4)').text();
                    let district = row.find('td:nth-child(5)').text();
                    let citizenship = row.find('td:nth-child(6)').text();
                    let applicationYear = row.find('td:nth-child(7)').text();
                    let submissionDate = row.find('td:nth-child(8)').text();
                    let status = row.find('td:nth-child(9) span').text();

                    // Populate the modal fields with data
                    $('#applicantName').text(applicantName);
                    $('#applicationId').text(applicationId);
                    $('#admissionType').text(admissionType);
                    $('#grade').text(grade);
                    $('#district').text(district);
                    $('#citizenship').text(citizenship);
                    $('#applicationYear').text(applicationYear);
                    $('#submissionDate').text(submissionDate);
                    $('#applicationStatus').text(status);
                    $('#applicationStatus').removeClass().addClass('badge badge-' + getStatusClass(
                        status));
                });

                // Function to assign a class to the status badge
                function getStatusClass(status) {
                    switch (status.toLowerCase()) {
                        case 'approved':
                            return 'success';
                        case 'rejected':
                            return 'danger';
                        case 'pending':
                            return 'warning';
                        default:
                            return 'secondary';
                    }
                }
            });

        });
    </script>
@endpush

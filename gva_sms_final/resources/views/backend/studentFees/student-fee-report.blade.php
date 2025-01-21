@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Fee Reports</h2>
                    <p class="text-muted">Analyze and manage fee-related reports from here.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid mt-3 shadow-lg">
          @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- Summary Widgets -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <!-- Total Outstanding -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4 class="text-bold">ZMK {{ number_format($totalOutstanding, 2) }}</h4>
                        <p>Total Outstanding Balances</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- Total Payments -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4 class="text-bold">ZMK {{ number_format($totalPayments, 2) }}</h4>
                        <p>Total Approved Payments</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- Pending Requests -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h4 class="text-bold">{{ $totalPending }}</h4>
                        <p>Pending Payment Requests</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- Rejected Payments -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4 class="text-bold">{{ $totalRejected }}</h4>
                        <p>Rejected Payments</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ban"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Tabs for Navigation -->
        <ul class="nav nav-tabs" id="reportTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="outstanding-tab" data-toggle="tab" href="#outstanding" role="tab"
                    aria-controls="outstanding" aria-selected="true">Outstanding Balances</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="payment-requests-tab" data-toggle="tab" href="#payment-requests"
                    role="tab" aria-controls="payment-requests" aria-selected="false">Payment Requests</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4">
            <!-- Outstanding Balances -->
            <div class="tab-pane fade " id="outstanding" role="tabpanel" aria-labelledby="outstanding-tab">
                <h5>Outstanding Balances</h5>
                <p>Select a term, year, or fee category to view details of outstanding balances.</p>
                <form id="filterForm">
                    <div class="row">
                        <!-- Academic Year -->
                        <div class="col-md-4">
                            <label for="filter_academic_year" class="form-label small">Academic Year</label>
                            <select id="filter_academic_year" name="academic_year_id" class="form-control form-control-sm">
                                <option value="" disabled selected>Select Academic Year</option>
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year['id'] }}">{{ $year['academic_year'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Term -->
                        <div class="col-md-4">
                            <label for="filter_term" class="form-label small">Term</label>
                            <select id="filter_term" name="term_no" class="form-control form-control-sm">
                                <option value="" disabled selected>Select Term</option>
                                <option value="1">Term 1</option>
                                <option value="2">Term 2</option>
                                <option value="3">Term 3</option>
                            </select>
                        </div>

                        <!-- Fee Category -->
                        <div class="col-md-4">
                            <label for="filter_fee_category" class="form-label small">Fee Category</label>
                            <select id="filter_fee_category" name="fee_category_id" class="form-control form-control-sm">
                                <option value="" disabled selected>Select Fee Category</option>
                                @foreach ($feeCategories as $feeCategory)
                                    <option value="{{ $feeCategory->id }}">
                                        {{ $feeCategory->fee_type }}-{{ $feeCategory->amount }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" id="filterButton" class="btn btn-primary mt-3 btn-sm col-md-6">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>


                </form>

                <div class="card my-2">
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered table-hover table-sm px-2 py-2" id="studentBalances">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Year-Term</th>
                                        <th>Fee Category</th>
                                        <th>Amount (ZMK)</th>
                                        <th>Paid (ZMK)</th>
                                        <th>Outstanding Balance (ZMK)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="studentBalancesTbBody">
                                    <!-- Dynamic Data -->
                                    <tr>
                                        <td colspan="7" class="text-center">No outstanding balances found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- send reminder modal --}}
                <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog"
                    aria-labelledby="reminderModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reminderModalLabel">Send Reminder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="reminderDescription"></p>
                                <form id="reminderForm">
                                    <div class="form-group">
                                        <label for="reminderMethod">Select Reminder Method:</label>
                                        <select class="form-control" id="reminderMethod" name="reminderMethod" required>
                                            <option value="email">Email</option>
                                            <option value="mailbox">Mailbox</option>
                                            <option value="whatsapp">WhatsApp</option>
                                            <option value="sms">SMS</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="reminderMessage">Message:</label>
                                        <textarea class="form-control" id="reminderMessage" name="reminderMessage" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success">Send Reminder</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Payment Requests -->
            <div class="tab-pane fade show active" id="payment-requests" role="tabpanel"
                aria-labelledby="payment-requests-tab">
                <div class="card-body table-responsive my-1">
                    <h5>Manage Fee Payment Requests</h5>
                    <table class="table table-bordered table-hover table-sm mb-0 text-nowrap manageFeePaymentRequestTable"
                        id="">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Student Name</th>
                                <th>Fee Category</th>
                                <th>Amount</th>
                                <th>Year - Term</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pendingRequests->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No pending payment requests found.</td>
                                </tr>
                            @else
                                @foreach ($pendingRequests as $group => $requests)
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ $request->student->firstname }} {{ $request->student->lastname }}</td>
                                            <td>{{ $request->feeCategory->fee_type }}</td>
                                            <td>ZMK {{ number_format($request->amount_paid, 2) }}</td>
                                            <td>{{ $request->academicSession->academic_year }} -
                                                {{ 'Term ' . $request->term_no }}</td>
                                            <td>{{ ucfirst($request->payment_status) }}</td>
                                            <td>
                                                <!-- Approve Button -->
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#approveModal{{ $request->id }}">
                                                    Approve
                                                </button>

                                                <!-- Reject Button -->
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#rejectModal{{ $request->id }}">
                                                    Reject
                                                </button>

                                                <!-- Preview Button -->
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#previewModal{{ $request->id }}">
                                                    Preview
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Approve Modal -->
                                        <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="approveModalLabel{{ $request->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="approveModalLabel{{ $request->id }}">
                                                            Approve Fee Payment of 
                                                            <span class="text-white mt-4"> {{ $request->feeCategory->fee_type }} Amount: ZMK {{ number_format($request->amount_paid, 2) }}</span> </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('approve.payment') }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="payment_id"
                                                                value="{{ $request->id }}">
                                                            <textarea name="action_comment" class="form-control" rows="4" placeholder="Add an action comment (optional)"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-success">Approve</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="rejectModalLabel{{ $request->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel{{ $request->id }}">
                                                            Reject Fee Payment for <span class="text-white">  {{ $request->feeCategory->fee_type }}, Amount: ZMK {{ number_format($request->amount_paid, 2) }}</span> </h5>
                                                            
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('reject.payment') }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" name="payment_id"
                                                                value="{{ $request->id }}">
                                                            <textarea name="reject_comment" class="form-control" rows="4" placeholder="Add a reason for rejection"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Modal -->
                                        <div class="modal fade" id="previewModal{{ $request->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="previewModalLabel{{ $request->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="previewModalLabel{{ $request->id }}">
                                                            Attachment Preview for - <span class="text-white">  {{ $request->feeCategory->fee_type }}, Amount: ZMK {{ number_format($request->amount_paid, 2) }}</span></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($request->attachment_url)
                                                            <!-- Dynamically render the attachment based on file type -->
                                                            @php
                                                                $fileExtension = pathinfo(
                                                                    $request->attachment_url,
                                                                    PATHINFO_EXTENSION,
                                                                );
                                                                $fileUrl = asset('storage/' . $request->attachment_url); // Use storage path if needed
                                                            @endphp

                                                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                <!-- Display image attachments -->
                                                                <img src="{{ $fileUrl }}" alt="Attachment"
                                                                    class="img-fluid">
                                                            @elseif (in_array($fileExtension, ['pdf']))
                                                                <!-- Embed PDF files -->
                                                                <embed src="{{ $fileUrl }}" type="application/pdf"
                                                                    width="100%" height="500px">
                                                            @else
                                                                <!-- Provide download link for unsupported file types -->
                                                                <p>Preview not available for this file type. <a
                                                                        href="{{ $fileUrl }}"
                                                                        target="_blank">Download
                                                                        File</a></p>
                                                            @endif
                                                        @else
                                                            <p>No attachment found.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>


                </div>

            </div>

        </div>
    </div>
   
    <script>
        //   $('.manageFeePaymentRequestTable').DataTable();
        $(document).ready(function() {
            
          
            $('#filterButton').on('click', function() {
                const academicYearId = $('#filter_academic_year').val();
                const termNo = $('#filter_term').val();
                const feeCategoryId = $('#filter_fee_category').val();

                if (!academicYearId || !termNo || !feeCategoryId) {
                    alert('Please select all filters.');
                    return;
                }

                $.ajax({
                    url: '{{ route('fee.fetchOutstandingBalances') }}',
                    method: 'POST',
                    data: {
                        academic_year_id: academicYearId,
                        term_no: termNo,
                        fee_category_id: feeCategoryId,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        console.log(response); // Debugging: Log the response

                        if (response.success && Array.isArray(response.data)) {
                            const balances = response.data; // Access the data array
                            const tableBody = $(
                                '#studentBalancesTbBody'); // Target the table body

                            // Destroy the existing DataTable instance
                            if ($.fn.DataTable.isDataTable('#studentBalances')) {
                                $('#studentBalances').DataTable().destroy();
                            }

                            tableBody.empty(); // Clear existing rows

                            if (balances.length === 0) {
                                tableBody.append(
                                    '<tr><td colspan="7" class="text-center">No outstanding balances found.</td></tr>'
                                );
                            } else {
                                balances.forEach((balance) => {
                                    tableBody.append(`
        <tr>
            <td>${balance.student_id || 'N/A'}</td>
            <td>${balance.student_name || 'N/A'}</td>
            <td>${balance.academic_year || 'N/A'} - Term ${balance.term_no || 'N/A'}</td>
            <td>${balance.fee_category || 'N/A'}</td>
            <td>${balance.total_fee || 'N/A'}</td>
            <td>${balance.amount_paid || '0.00'}</td>
            <td>${balance.balance_due || 'N/A'}</td>
            <td>
                ${
                    parseFloat(balance.balance_due) > 0
                        ? `<button class="btn btn-primary btn-sm send-reminder-btn" 
                                                                                            data-student-name="${balance.student_name}" 
                                                                                            data-fee-category="${balance.fee_category}" disabled>
                                                                                            Send Reminder
                                                                                       </button>`
                        : ''
                                            }
                                        </td>
                                    </tr>
                                `);
                                });

                            }

                            // Reinitialize DataTable after populating the data
                            $('#studentBalances').DataTable({
                                destroy: true, // Ensure any existing instance is destroyed
                                searching: true, // Enable the search bar
                                paging: true, // Enable pagination
                                ordering: true, // Enable column sorting
                                info: true, // Show table info
                                responsive: true, // Make the table responsive 
                            });


                        } else {
                            console.error('Unexpected response format:', response);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred.');
                    },
                });
            });



            //Modal data

            // Use event delegation for dynamically added elements
            $(document).on('click', '.send-reminder-btn', function() {
                const studentName = $(this).data('student-name');
                const feeCategory = $(this).data('fee-category');

                // Update modal content
                $('#reminderDescription').text(`Remind parents of ${studentName} to pay ${feeCategory}?`);
                $('#reminderMessage').val(''); // Clear any previous message
                $('#reminderMethod').val('email'); // Default to email

                // Show modal
                $('#reminderModal').modal('show');
            });



            // Send reminder data
            $('#reminderForm').on('submit', function(e) {
                e.preventDefault();

                const reminderData = {
                    method: $('#reminderMethod').val(),
                    message: $('#reminderMessage').val(),
                    _token: $('meta[name="csrf-token"]').attr('content'),
                };

                $.ajax({
                    url: '{{ route('fee.sendReminder') }}', // Update with your reminder endpoint
                    method: 'POST',
                    data: reminderData,
                    success: function(response) {
                        if (response.success) {
                            alert('Reminder sent successfully!');
                            $('#reminderModal').modal('hide'); // Hide the modal
                        } else {
                            alert('Failed to send the reminder. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred while sending the reminder.');
                    },
                });
            });

        });
    </script>
@endsection

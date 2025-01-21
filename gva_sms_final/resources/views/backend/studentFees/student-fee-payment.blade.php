@extends('admin.admim-master')
@section('admin_content')
    <style>
        .img-thumbnail {
            width: 115px;
            height: 115px;
            object-fit: cover;
            margin: auto;
        }

        .table th {
            width: 25%;
            white-space: nowrap;
            font-weight: bold;
        }

        .table td {
            width: 25%;
        }

        .border {
            border-color: #dee2e6 !important;
        }

        .rounded {
            border-radius: 10px !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Content Header (Page header) -->
    <div class="content-header py- bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Student Fee Collections</h2>
                    <p class="text-muted">Manage student fees from here.</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#submitPaymentModal">
                        <i class="fas fa-plus-circle"></i> Submit Payment
                    </button>
                </div>

            </div>
        </div>
    </div>
    @if (session('success') || $errors->any())
        <div class="mt-3">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn btn-link text-decoration-none collapsed" data-toggle="collapse"
                        data-target="#successDetails" aria-expanded="false" aria-controls="successDetails">
                        Details
                    </button>
                    <div id="successDetails" class="collapse mt-2">
                        <p class="mb-0">Your payment has been successfully processed. You can view more details in your
                            transaction history.</p>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Something went wrong.
                    <button type="button" class="btn btn-link text-decoration-none collapsed" data-toggle="collapse"
                        data-target="#errorDetails" aria-expanded="false" aria-controls="errorDetails">
                        View Errors
                    </button>
                    <div id="errorDetails" class="collapse mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif
    {{-- payment modal --}}
    <div class="modal fade" id="submitPaymentModal" tabindex="-1" role="dialog" aria-labelledby="submitPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('feePayments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Hidden Student ID -->
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="submitPaymentModalLabel">Submit Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <!-- Fee Category -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fee_category_id" class="small">Fee Category</label>
                                        <select name="fee_category_id" class="form-control form-control-sm" required>
                                            <option value="" disabled selected>Select Fee Category</option>
                                            @foreach ($student->feeCategories as $feeCategory)
                                                <option value="{{ $feeCategory->id }}">
                                                    {{ $feeCategory->fee_type }}-{{ $feeCategory->amount }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Academic Year -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="academic_year_id" class="small">Academic Year</label>
                                        <select name="academic_year_id" class="form-control form-control-sm" required>
                                            <option value="" disabled selected>Select Academic Year</option>
                                            @foreach ($academicYears as $year)
                                                <option value="{{ $year['id'] }}">{{ $year['academic_year'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Term -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="term_no" class="small">Term</label>
                                        <select name="term_no" class="form-control form-control-sm" required>
                                            <option value="" disabled selected>Select Term</option>
                                            <option value="1">Term 1</option>
                                            <option value="2">Term 2</option>
                                            <option value="3">Term 3</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Amount Paid -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_paid" class="small">Amount Paid (ZMK)</label>
                                        <input type="number" name="amount_paid" class="form-control form-control-sm"
                                            step="0.01" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Payment Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_date" class="small">Payment Date</label>
                                        <input type="date" name="payment_date" class="form-control form-control-sm"
                                            required>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_method" class="small">Payment Method</label>
                                        <select name="payment_method" class="form-control form-control-sm" required>
                                            <option value="Cash">Cash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Mobile Money">Mobile Money</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Reference Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference_no" class="small">Reference Number</label>
                                        <input type="text" name="reference_no" class="form-control form-control-sm">
                                    </div>
                                </div>

                                <!-- Attachment -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attachment" class="small">Upload Attachment (Required)</label>
                                        <input type="file" name="attachment" class="form-control form-control-sm"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Submit Payment</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="content row mt-3 p-2">
        <div class="row align-items-center border rounded p-0 shadow-sm bg-gradient-white col-md-12 ">
            <div class="card card-widget widget-user-2 col-md-12">
                <div class="widget-user-header bg-warning">
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2"
                            src="{{ $student->student_photo ? asset('path/to/uploads/' . $student->student_photo) : asset('path/to/default_female.jpg') }}"
                            alt="No Image" class="img-fluid img-thumbnail rounded-circle">
                    </div>
                    <h3 class="widget-user-username">
                        {{ $student->firstname }} {{ $student->other_name ?? '' }} {{ $student->lastname }}
                        <span class="small text-muted">({{ $student->student_type }})</span>
                    </h3>
                    <h5 class="widget-user-desc">
                        {{ $latestAcademicYear['academic_year'] ?? 'Year Not Found' }}
                        TERM {{ $latestAcademicYear['term_number'] ?? 'Term Not Found' }} INVOICE
                    </h5>


                </div>
                <div class="card-footer p-2">
                    <h5 class="text-center font-weight-bold">Invoice Details</h5>
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fee Description</th>
                                <th>Amount</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Student Fees -->
                            @foreach ($student->studentFee as $index => $fee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $fee->feeCategory->fee_type }}</td>
                                    <td>{{ number_format($fee->feeCategory->amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('fee.payment.transactions', ['student_id' => $student->id, 'fee_category_id' => $fee->feeCategory->id]) }}"
                                            class="btn btn-info btn-sm">
                                            View Transactions
                                        </a>

                                    </td>
                                </tr>
                            @endforeach

                            <!-- Class Fees -->
                            @foreach ($classFeeAdjustments as $index => $classFeeAdjustment)
                                <tr>
                                    <td>{{ $loop->index + count($student->studentFee) + 1 }}</td>
                                    <td>Class Fee - {{ $classFeeAdjustment->reason }}</td>
                                    <td>{{ number_format($classFeeAdjustment->amount, 2) }}</td>
                                </tr>
                            @endforeach

                            <!-- Fee Adjustments -->
                            @foreach ($feeAdjustments as $index => $adjustment)
                                <tr>
                                    <td>{{ $loop->index + count($student->studentFee) + count($classFeeAdjustments) + 1 }}
                                    </td>
                                    <td>{{ ucfirst($adjustment->adjustment_type) }} Adjustment - {{ $adjustment->reason }}
                                    </td>

                                    <td>
                                        @if ($adjustment->adjustment_type === 'waiver')
                                            <span
                                                class="badge badge-success">-{{ number_format($adjustment->amount, 2) }}</span>
                                        @elseif ($adjustment->adjustment_type === 'penalty')
                                            <span
                                                class="badge badge-danger">+{{ number_format($adjustment->amount, 2) }}</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">Total:</th>
                                <th>
                                    {{ number_format(
                                        $student->studentFee->sum('feeCategory.amount') +
                                            $classFeeAdjustments->sum('amount') +
                                            $feeAdjustments->sum(function ($adjustment) {
                                                return $adjustment->adjustment_type === 'waiver' ? -$adjustment->amount : $adjustment->amount;
                                            }),
                                        2,
                                    ) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>





        <!-- Fees Details Section -->
        <div class="card shadow mt-2 col-md-12 ">

            <div class="card-body">
                <!-- Filters -->
                <div class="mb-3">
                    <form id="filterForm">
                        <div class="row">
                            <!-- Academic Year -->
                            <div class="col-md-4">
                                <label for="filter_academic_year" class="form-label small">Academic Year</label>
                                <select id="filter_academic_year" name="academic_year_id"
                                    class="form-control form-control-sm">
                                    <option value="" disabled selected>Select Academic Year</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year['id'] }}">{{ $year['academic_year'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" class="hidden" value="{{ $student->id }}" name="student_id"
                                id="student_id">

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
                                <select id="filter_fee_category" name="fee_category_id"
                                    class="form-control form-control-sm">
                                    <option value="" disabled selected>Select Fee Category</option>
                                    @foreach ($student->feeCategories as $feeCategory)
                                        <option value="{{ $feeCategory->id }}">
                                            {{ $feeCategory->fee_type }}-{{ $feeCategory->amount }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" id="filterButton" class="btn btn-primary mt-3 btn-sm col-md-6">Check
                                Balanace</button>
                        </div>


                    </form>
                </div>


                <!-- Table -->
                <div class="table-responsive">
                    <table id="feesTable"
                        class="table table-bordered table-hover text-nowrap table-sm dataTable no-footer">
                        <thead>
                            <tr>
                                <th>Fee Category</th>
                                <th>Fee Interval</th>
                                <th>Status</th>
                                <th>Amount (ZMK)</th>
                                <th>Paid (ZMK)</th>
                                <th>Outstanding Balance (ZMK)</th>
                                <th>Approval Status</th>
                            </tr>
                        </thead>
                        <tbody id="pupils_data_body">
                            <!-- Data will be populated by AJAX -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            //search for fees 
            // Trigger filter button click
            // $('#filterButton').click(function() {
            //     const academicYearId = $('#filter_academic_year').val();
            //       const student_id = $('#student_id').val();
            //     const termNo = $('#filter_term').val();
            //     const feeCategoryId = $('#filter_fee_category').val();

            //     // Validate inputs
            //     if (!academicYearId || !termNo) {
            //         alert('Please select both Academic Year and Term.');
            //         return;
            //     }

            //     // Fetch filtered data via AJAX
            //     $.ajax({
            //         url: '{{ route('fee.checkStudentBalance') }}',
            //         type: 'GET',
            //         data: {
            //             academic_year_id: academicYearId,
            //             term_no: termNo,
            //             fee_category_id: feeCategoryId,
            //             student_id: '{{ $student->id }}',
            //         },
            //         success: function(response) {
            //             console.log(response);
            //             // Clear the table body
            //             $('#pupils_data_body').empty();

            //             // Populate the table with the filtered data
            //             if (response.data.length > 0) {
            //                 response.data.forEach(function(feeCategory) {
            //                     const amount = parseFloat(feeCategory.amount) || 0;
            //                     const totalPaid = parseFloat(feeCategory.total_paid) ||
            //                         0;
            //                     const balance = parseFloat(feeCategory.balance) || 0;

            //                     const recentTransaction = feeCategory
            //                         .recent_transaction ?
            //                         `ZMK ${feeCategory.recent_transaction.amount_paid.toFixed(2)} on ${feeCategory.recent_transaction.payment_date}` :
            //                         'No Recent Transaction';

            //                     const paymentStatus = feeCategory.recent_transaction
            //                         ?.payment_status ?? 'N/A';

            //                     // Dynamic badge class based on payment status
            //                     const badgeClass = paymentStatus === 'approved' ?
            //                         'badge bg-success' :
            //                         paymentStatus === 'rejected' ?
            //                         'badge bg-danger' :
            //                         paymentStatus === 'pending' ?
            //                         'badge bg-warning' :
            //                         'badge bg-secondary';

            //                     const paymentHistoryId = feeCategory.recent_transaction
            //                         ?.id ?? '';

            //                     // Determine if the "View Transactions" button or "No Payment Record" badge should be displayed
            //                     const transactionAction = paymentHistoryId ?
            //                         `<button class="btn btn-info btn-sm payment-history" 
        //                 data-id="${paymentHistoryId}" 
        //                 onclick="window.location.href='/fees/payment-history/' + ${paymentHistoryId} + '/receipt'">
        //                 View Transactions
        //             </button>` :
            //                         `<span class="badge bg-secondary">No Payment Record</span>`;

            //                     // Append the row to the table
            //                     $('#pupils_data_body').append(`
        //             <tr>
        //                 <td>${feeCategory.fee_type ?? 'N/A'}</td>
        //                 <td>${feeCategory.fee_interval ?? 'N/A'}</td>
        //                 <td><span class="badge ${feeCategory.status_class}">${feeCategory.status}</span></td>
        //                 <td>ZMK ${amount.toFixed(2)}</td>
        //                 <td>ZMK ${totalPaid.toFixed(2)}</td>
        //                 <td>ZMK ${balance.toFixed(2)}</td>
        //                 <td><span class="${badgeClass}">${paymentStatus}</span></td>
        //                 <td>${transactionAction}</td>
        //             </tr>
        //         `);
            //                 });
            //             } else {
            //                 $('#pupils_data_body').append(`
        //         <tr>
        //             <td colspan="9" class="text-center">No fee data available.</td>
        //         </tr>
        //     `);
            //             }
            //         },
            //         error: function(xhr) {
            //             console.error(xhr.responseText);
            //             alert('An error occurred while fetching data.');
            //         }
            //     });
            // });



            $('#filterButton').click(function() {
                const academicYearId = $('#filter_academic_year').val();
                const termNo = $('#filter_term').val();
                const feeCategoryId = $('#filter_fee_category').val();
                const studentId = $('#student_id').val();

                // Validate inputs
                if (!academicYearId || !termNo || !studentId || !feeCategoryId) {
                    alert('Please select all required fields.');
                    return;
                }

                // Fetch filtered data via AJAX
                $.ajax({
                    url: '{{ route('fee.checkStudentBalance') }}', // Replace with your route
                    type: 'GET',
                    data: {
                        academic_year_id: academicYearId,
                        term_no: termNo,
                        fee_category_id: feeCategoryId,
                        student_id: studentId,
                    },

                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Clear the table body
                            const tbody = $('#pupils_data_body');
                            tbody.empty();

                            // Extract the data
                            const data = response.data;

                            // Convert to numbers where necessary
                            const totalFee = parseFloat(data.total_fee) || 0;
                            const amountPaid = parseFloat(data.amount_paid) || 0;
                            const balanceDue = parseFloat(data.balance_due) || 0;

                            // Determine the badge class for payment status
                            const badgeClass =
                                data.payment_status === 'approved' ?
                                'badge bg-success' :
                                data.payment_status === 'rejected' ?
                                'badge bg-danger' :
                                data.payment_status === 'pending' ?
                                'badge bg-warning' :
                                'badge bg-secondary';

                            // Check if there is a recent transaction ID
                            const paymentHistoryId = data.amountPaid?.id || '';

                            
                            // Append the row to the table
                            const row = `
                                            <tr>
                                                <td>${data.fee_category ?? 'N/A'}</td>
                                                <td>${data.fee_interval ?? 'N/A'}</td>
                                                <td><span class="${badgeClass}">${data.payment_status}</span></td>
                                                <td>ZMK ${totalFee.toFixed(2)}</td>
                                                <td>ZMK ${amountPaid.toFixed(2)}</td>
                                                <td>ZMK ${balanceDue.toFixed(2)}</td>
                                                <td><span class="${badgeClass}">${data.payment_status}</span></td>
                                            </tr>
                                        `;

                            tbody.append(row);
                        } else {
                            alert(response.message || 'Error fetching data.');
                        }
                    },




                    error: function(xhr) {
                        alert('An error occurred while fetching data.');
                    },
                });
            });


        });
    </script>
@endsection

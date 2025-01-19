@extends('admin.admim-master')
@section('admin_content')
    <style>
        /* Hide elements during printing */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header py- bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="text-primary">Payment Report</h2>
                    <p class="text-muted">Detailed information about the selected payment and related records.</p>
                </div>
                {{-- <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#submitPaymentModal">
                        <i class="fas fa-plus-circle"></i> Add Payment Record
                    </button>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="container mt-4">

        <!-- Fee Details Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Fee Category Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <p><strong>Fee Type:</strong> {{ $transaction->feeCategory->fee_type }}</p>
                        <p><strong>Fee Interval:</strong> {{ $transaction->feeCategory->fee_interval }}</p>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <p><strong>Academic Year:</strong> {{ $transaction->academicSession->academic_year ?? 'N/A' }} -
                            Term {{ $transaction->term_no ?? 'N/A' }}</p>

                        <p><strong>Amount:</strong> ZMK {{ number_format($transaction->feeCategory->amount, 2) }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Total Paid and Balance -->
                    <div class="col-md-6">
                        <p><strong>Total Paid:</strong>
                            ZMK {{ number_format($transaction->feeCategory->payments->sum('amount_paid'), 2) }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Outstanding Balance:</strong>
                            ZMK
                            {{ number_format($transaction->feeCategory->amount - $transaction->feeCategory->payments->sum('amount_paid'), 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Related Payments Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Other Payments for {{ $transaction->feeCategory->fee_type }}</h5>
            </div>
            <div class="card-body">
                @if ($relatedPayments->isEmpty())
                    <p class="text-center text-muted">No other payments found for this fee category.</p>
                @else
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary btn-sm" id="printAll">
                            <i class="fas fa-print"></i> Print All
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="summaryTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Date of Payment</th>
                                    <th>Amount Paid (ZMK)</th>
                                    <th>Payment Method</th>
                                    <th>Reference No</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($relatedPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                        <td>ZMK {{ number_format($payment->amount_paid, 2) }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->reference_no ?? 'N/A' }}</td>
                                        <td class="no-print">
                                            <button class="btn btn-outline-primary btn-sm print-row"
                                                data-row-id="{{ $payment->id }}" title="Print Row">
                                                <i class="fas fa-print"></i> Print
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            $('#summaryTable').DataTable({
                paging: true, // Enable pagination
                searching: true, // Enable the search bar
                ordering: true, // Enable column sorting
                info: true, // Show table information
                responsive: true, // Make table responsive
                lengthMenu: [10, 25, 50, 65, 85], // Page length options
                language: {
                    search: "Search:", // Customize the search bar placeholder
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });


            // Print All Rows
            $('#printAll').click(function() {
                const tableContent = document.getElementById('summaryTable').outerHTML;

                // Add a custom header with the school details and logo
                const printContent = `
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="School Logo" style="height: 100px;">
            <h3>School Name</h3>
            <p>Address: School Address, City</p>
            <p>Contact: +260 123 456 789</p>
        </div>
        ${tableContent}
    `;

                // Use Print.js to print the content
                printJS({
                    printable: printContent,
                    type: 'raw-html',
                    css: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
                });
            });

            // Print Individual Row
            $('.print-row').click(function() {
                const rowId = $(this).data('row-id'); // Get the data-row-id
                const tableRow = $(this).closest('tr').html(); // Get the HTML content of the row

                // Add a custom header with the school details and logo
                const printContent = `
                        <div style="text-align: center; margin-bottom: 20px;">
                            <img src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="School Logo" style="height: 100px;">
                            <h3>School Name</h3>
                            <p>Address: School Address, City</p>
                            <p>Contact: +260 123 456 789</p>
                        </div>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date of Payment</th>
                                    <th>Amount Paid (ZMK)</th>
                                    <th>Payment Method</th>
                                    <th>Reference No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>${tableRow}</tr>
                            </tbody>
                        </table>
                    `;

                // Print the row using Print.js
                printJS({
                    printable: printContent,
                    type: 'raw-html',
                    css: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
                });
            });


        });
    </script>
@endsection

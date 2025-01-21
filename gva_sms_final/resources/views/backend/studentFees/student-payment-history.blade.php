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
        <!-- Related Payments Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4>Fee Payment History</h4>
            </div>
            <div class="card-body">


                <div class="container mt-4">

                    <table class="table table-sm table-bordered table-striped mt-4 table-hover" id="historyTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaction->student->firstname }} {{ $transaction->student->lastname }}</td> 
                                    <td>{{ number_format($transaction->amount_paid, 2) }}</td>
                                    <td>{{ $transaction->payment_date->format('d M Y') }}</td>
                                    <td>{{ ucfirst($transaction->payment_method) }}</td>
                                    <td>{{ ucfirst($transaction->payment_status) }}</td>
                                    <td>{{ $transaction->reference_no }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            $('#historyTable').DataTable({
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

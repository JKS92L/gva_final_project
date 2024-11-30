@extends('admin.admim-master')
@section('admin_content')
    <div class="container-fluid">
        <h2 class="my-4">Balance Report</h2>

        <!-- Summary Section -->
        <div class="row">
            <!-- Total Deposits -->
            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Deposits</span>
                        <span class="info-box-number">ZMW {{ number_format($totalDeposits, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Spent at Tuckshop</span>
                        <span class="info-box-number">ZMW {{ number_format($totalSpent, 2) }}</span>
                    </div>
                </div>
            </div>
            <!-- Total Cash Withdrawals -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Cash Withdrawals</span>
                        <span class="info-box-number">ZMW {{ number_format($totalCashWithdraws, 2) }}</span>
                    </div>
                </div>
            </div>
            <!-- Total Net Balance -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Net Balance</span>
                        <span class="info-box-number">ZMW {{ number_format($netBalance, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Pupils Deposits -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-graduate"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pupils Deposits</span>
                        <span class="info-box-number">{{ $pupilCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance Report Table -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-table"></i> Detailed Balances</h6>
            </div>
            <div class="card-body table-responsive p-2">
                <table class="table table-bordered table-hover text-nowrap no-footer table-sm">
                    <thead>
                        <tr>
                        <tr>
                            <th>#</th>
                            <th>Pupil</th>
                            <th>Grade/Class</th>
                            <th>Initial Total Balance (ZMK)</th>
                            <th>Current Balance (ZMK)</th>
                            <th>Tuck Shop Expenses (ZMK)</th>
                            <th>Total Cash Withdrawal (ZMK)</th>
                            <th>Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($balances as $index => $balance)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $balance['student']->firstname }} {{ $balance['student']->lastname }}</td>
                                <td>{{ $balance['grade_class'] }}</td>
                                <td>{{ $balance['initial_balance'] }}</td>
                                <td>{{ $balance['current_balance'] }}</td>
                                <td>{{ $balance['tuckshop_expenses'] }}</td>
                                <td>{{ $balance['total_withdrawn'] }}</td>
                                <td>
                                    <!-- Action Buttons (e.g., View Details, Edit, etc.) -->
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#viewDetailsModal{{ $balance['student']->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            <!-- View Details Modal -->
                            <div class="modal fade" id="viewDetailsModal{{ $balance['student']->id }}" tabindex="-1"
                                aria-labelledby="viewDetailsModalLabel{{ $balance['student']->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="viewDetailsModalLabel{{ $balance['student']->id }}">Details for
                                                {{ $balance['student']->firstname }} {{ $balance['student']->lastname }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Grade/Class:</strong> {{ $balance['grade_class'] }}</p>
                                            <p><strong>Initial Total Balance:</strong> ZMK
                                                {{ $balance['initial_balance'] }}</p>
                                            <p><strong>Current Balance:</strong> ZMK {{ $balance['current_balance'] }}</p>
                                            <p><strong>Tuck Shop Expenses:</strong> ZMK {{ $balance['tuckshop_expenses'] }}
                                            </p>
                                            <p><strong>Total Cash Withdrawal:</strong> ZMK
                                                {{ $balance['total_withdrawn'] }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <!-- Additional actions can be added here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No balance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Initialize Select2 for pupil selection
            $('.select2').select2({
                placeholder: 'Select a pupil',
                allowClear: true,
                width: '100%' // Ensures Select2 takes the full width of the form control
            });

        });
    </script>
@endsection

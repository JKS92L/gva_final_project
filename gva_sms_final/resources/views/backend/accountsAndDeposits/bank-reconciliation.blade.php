@extends('admin.admim-master')
@section('admin_content')
    <div class="content pt-3">
        <div class="container-fluid ">
            <div class="container mt-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center my-3">
                    <h4><i class="fas fa-file-invoice-dollar"></i> Bank Deposit Reconciliation</h4>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addReconciliationModal">
                        <i class="fas fa-plus-circle"></i> Add New Reconciliation
                    </button>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-filter"></i> Filters</h6>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="form-inline">
                            <!-- Date Range -->
                            <div class="form-group mr-3">
                                <label for="from_date" class="mr-2">From:</label>
                                <input type="date" class="form-control form-control-sm" id="from_date" name="from_date">
                            </div>
                            <div class="form-group mr-3">
                                <label for="to_date" class="mr-2">To:</label>
                                <input type="date" class="form-control form-control-sm" id="to_date" name="to_date">
                            </div>
                            <button type="submit" class="btn btn-sm bg-gradient-success ">Apply Filters</button>
                        </form>
                    </div>
                </div>

                <!-- Reconciliation Table -->
                <div class="card mb-6">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-list-alt"></i> Reconciliation Records</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-sm  table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction Date</th>
                                    <th>Pupil</th>
                                    <th>Amount</th>
                                    <th>Bank Account</th>
                                    <th>Receipt No.</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="reconciliationTableBody">
                                @forelse($bankDeposits as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $record->student->firstname . ' ' . $record->student->lastname }}</td>
                                        <td>{{ number_format($record->deposit_amount, 2) }}</td>
                                        <td>{{ $record->bank_account }}</td>
                                        <td>{{ $record->receipt_number }}</td>
                                        <td>{{ $record->deposit_description }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                                data-target="#editReconciliationModal-{{ $record->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                                data-target="#deleteReconciliationModal-{{ $record->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>

                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade editReconciliationModal"
                                        id="editReconciliationModal-{{ $record->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="editReconciliationModalLabel-{{ $record->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('accounts.expenses.bank-reconciliation.update', $record->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editReconciliationModalLabel-{{ $record->id }}">Edit Bank
                                                            Reconciliation</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Pupil Selection -->
                                                        <div class="form-group">
                                                            <label for="student_id-{{ $record->id }}">Pupil</label>
                                                            <select class="form-control select2"
                                                                id="student_id-{{ $record->id }}" name="student_id"
                                                                required>
                                                                <option value="">Select a pupil</option>
                                                                @foreach ($students as $student)
                                                                    <option value="{{ $student->id }}"
                                                                        {{ $record->student_id == $student->id ? 'selected' : '' }}>
                                                                        {{ $student->firstname . ' ' . $student->lastname }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Deposit Amount -->
                                                        <div class="form-group">
                                                            <label for="deposit_amount-{{ $record->id }}">Amount</label>
                                                            <input type="number" class="form-control"
                                                                id="deposit_amount-{{ $record->id }}"
                                                                name="deposit_amount" value="{{ $record->deposit_amount }}"
                                                                step="0.01" required>
                                                        </div>
                                                        <!-- Bank Account -->
                                                        <div class="form-group">
                                                            <label for="bank_account-{{ $record->id }}">Bank
                                                                Account</label>
                                                            <input type="text" class="form-control"
                                                                id="bank_account-{{ $record->id }}" name="bank_account"
                                                                value="{{ $record->bank_account }}">
                                                        </div>
                                                        <!-- Receipt Number -->
                                                        <div class="form-group">
                                                            <label for="receipt_number-{{ $record->id }}">Receipt
                                                                No.</label>
                                                            <input type="text" class="form-control"
                                                                id="receipt_number-{{ $record->id }}"
                                                                name="receipt_number"
                                                                value="{{ $record->receipt_number }}">
                                                        </div>
                                                        <!-- Description -->
                                                        <div class="form-group">
                                                            <label
                                                                for="deposit_description-{{ $record->id }}">Description</label>
                                                            <textarea class="form-control" id="deposit_description-{{ $record->id }}" name="deposit_description">{{ $record->deposit_description }}</textarea>
                                                        </div>
                                                        <!-- Deposit Date -->
                                                        <div class="form-group">
                                                            <label for="deposit_date-{{ $record->id }}">Transaction
                                                                Date</label>
                                                            <input type="date" class="form-control"
                                                                id="deposit_date-{{ $record->id }}" name="deposit_date"
                                                                value="{{ $record->deposit_date->format('Y-m-d') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteReconciliationModal-{{ $record->id }}"
                                        tabindex="-1" aria-labelledby="deleteReconciliationModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteReconciliationModalLabel">Confirm
                                                        Delete
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this record for
                                                    <strong>{{ $record->student->firstname . ' ' . $record->student->lastname }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form
                                                        action="{{ route('accounts.expenses.bank-reconciliation.destroy', $record->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No reconciliation records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add Reconciliation Modal -->
            <div class="modal fade" id="addReconciliationModal" tabindex="-1" role="dialog"
                aria-labelledby="addReconciliationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('accounts.expenses.bank-reconciliation.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addReconciliationModalLabel">Add New Reconciliation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="transaction_date">Transaction Date</label>
                                    <input type="date" class="form-control" id="transaction_date"
                                        name="transaction_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="pupil_id">Pupil</label>
                                    <select class="form-control select2" id="pupil_id" name="pupil_id" required>
                                        <option value="">Select a pupil</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">
                                                {{ $student->firstname . ' ' . $student->lastname . ' (' . $student->grade->gradeno . $student->grade->class_name . ')' ?? 'No pupils found..' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </div>
                                <div class="form-group">
                                    <label for="bank_account">Bank Account</label>
                                    <input type="text" class="form-control" id="bank_account" name="bank_account">
                                </div>
                                <div class="form-group">
                                    <label for="receipt_number">Receipt Number</label>
                                    <input type="text" class="form-control" id="receipt_number"
                                        name="receipt_number">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
            // Re-initialize Select2 when the modal is shown
            $('#addReconciliationModal').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $(
                        '#addReconciliationModal'
                    ) // Attach the dropdown to the modal to prevent z-index issues
                });
            });
            //editReconciliationModal
            // Re-initialize Select2 when the modal is shown
            $('.editReconciliationModal').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $(
                        '.editReconciliationModal'
                    ) // Attach the dropdown to the modal to prevent z-index issues
                });
            });

            //filter data 
            $('#filterForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission

                // Fetch date range values
                let fromDate = $('#from_date').val();
                let toDate = $('#to_date').val();

                $.ajax({
                    url: "{{ route('accounts.expenses.bank-reconciliation.filter') }}",
                    method: "GET",
                    data: {
                        from_date: fromDate,
                        to_date: toDate
                    },
                    success: function(response) {
                        // Assuming you render the filtered data in a specific table
                        $('#reconciliationTableBody').html(response);
                        console.log(response);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong. Please try again later.',
                        });
                    }
                });
            });
            //.......
        });
    </script>

@endsection

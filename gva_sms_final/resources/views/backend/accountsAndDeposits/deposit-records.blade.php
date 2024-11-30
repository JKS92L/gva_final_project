@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addDepositModal">
                                <i class="fas fa-plus"></i> <!-- Font Awesome "plus" icon -->
                                Add New Deposit
                            </button>
                        </li>
                        {{-- <li class="breadcrumb-item active">List</li> --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Modal for Adding a New Deposit -->
    <div class="modal fade" id="addDepositModal" tabindex="-1" role="dialog" aria-labelledby="addDepositModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('deposit-record.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepositModalLabel">Add New Deposit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="academic_term">Academic Term</label>
                            <select class="form-control" id="academic_term" name="academic_term" required>
                                <option value="">--Select a term--</option>
                                @foreach ($terms as $term)
                                    <option value="{{ $term['id'] }}">{{ $term['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Pupil Selection -->
                        <div class="form-group">
                            <label for="student_id">Pupil</label>
                            <select class="form-control select2" id="student_id" name="student_id" required>
                                <option value="">--Select a pupil--</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->firstname . ' ' . $student->lastname . ' (' . $student->grade->gradeno . $student->grade->class_name . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Deposit Amount -->
                        <div class="form-group">
                            <label for="deposit_amount">Deposit Amount</label>
                            <input type="number" class="form-control" id="deposit_amount" name="deposit_amount" required>
                        </div>

                        <!-- Deposit Method -->
                        <div class="form-group">
                            <label for="method">Method</label>
                            <select class="form-control" id="deposit_method" name="deposit_method" required>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>

                        <!-- Receipt Number (Optional) -->
                        <div class="form-group">
                            <label for="receipt_number">Receipt Number (Optional)</label>
                            <input type="text" class="form-control" id="receipt_number" name="receipt_number">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Deposit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="container mt-4">
                <h4 class="mb-4">Student Deposit Records</h4>

                <!-- Deposit Records Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Pupil Name</th>
                                <th>Current Amount</th>
                                <th>Deposit Amount</th>
                                <th>Method</th>
                                <th>Receipt Number</th>
                                <th>Withdraw Code</th>
                                {{-- <th>Deposit Date</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $index => $deposit)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $deposit->student->firstname . ' ' . $deposit->student->lastname . ' (' . $deposit->student->grade->gradeno . $deposit->student->grade->class_name . ')' ?? 'Unknown' }}
                                    </td>
                                    <td>{{ number_format($deposit->current_amount, 2) }}</td>
                                    <td>{{ number_format($deposit->initial_deposit, 2) }}</td>
                                    <td>{{ ucfirst($deposit->deposit_method) }}</td>
                                    <td>{{ $deposit->receipt_number ?? 'N/A' }}</td>
                                    <td>{{ $deposit->withdraw_code }}</td>
                                    {{-- <td>{{ $deposit->deposit_date->format('d M Y') }}</td> --}}
                                    <td>
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editDepositModal{{ $deposit->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteDepositModal{{ $deposit->id }}">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>

                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#withDrawCashModal{{ $deposit->id }}">
                                            <i class="fas fa-money-bill-wave"></i> Withdraw
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editDepositModal{{ $deposit->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="editDepositModalLabel{{ $deposit->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editDepositModalLabel{{ $deposit->id }}">
                                                    Edit Deposit For: <span class="text-white">
                                                        {{ $deposit->student->firstname . ' ' . $deposit->student->lastname . ' (' . $deposit->student->grade->gradeno . $deposit->student->grade->class_name . ')' ?? 'Unknown' }}</span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('deposits.update', $deposit->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="deposit_amount">Deposit Amount</label>
                                                        <input type="number" class="form-control" name="deposit_amount"
                                                            value="{{ $deposit->initial_deposit }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="method">Method</label>
                                                        <select class="form-control" name="deposit_method" required>
                                                            <option value="bank"
                                                                {{ $deposit->deposit_method == 'bank' ? 'selected' : '' }}>
                                                                Bank</option>
                                                            <option value="cash"
                                                                {{ $deposit->deposit_method == 'cash' ? 'selected' : '' }}>
                                                                Cash</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="receipt_number">Receipt Number</label>
                                                        <input type="text" class="form-control" name="receipt_number"
                                                            value="{{ $deposit->receipt_number }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deposit_date">Deposit Date</label>
                                                        {{-- <input type="date" class="form-control" name="deposit_date"
                                                            value="{{ $deposit->deposit_date->format('Y-m-d') }}"
                                                            required> --}}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteDepositModal{{ $deposit->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteDepositModalLabel{{ $deposit->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteDepositModalLabel{{ $deposit->id }}">
                                                    Confirm Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this deposit record for
                                                <strong>{{ $deposit->student->firstname . ' ' . $deposit->student->lastname }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('deposits.destroy', $deposit->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Withdraw Modal -->
                                <div class="modal fade" id="withDrawCashModal{{ $deposit->id }}" tabindex="-1"
                                    aria-labelledby="withdrawModalLabel{{ $deposit->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('pocket-money.withdraw') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="withdrawModalLabel{{ $deposit->id }}">
                                                        Withdraw Pocket Money for:
                                                        <span
                                                            class="text-primary">{{ $deposit->student->firstname . ' ' . $deposit->student->lastname }}</span>
                                                        ({{ $deposit->student->grade->gradeno . $deposit->student->grade->class_name }})
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Current Balance -->
                                                    <div class="mb-3">
                                                        <p>
                                                            Current Balance:
                                                            <span class="text-success fw-bold">ZMK
                                                                {{ number_format($deposit->current_amount, 2) }}</span>
                                                        </p>
                                                    </div>

                                                    <!-- Hidden Field for Deposit ID -->
                                                    <input type="hidden" name="transaction_id" value="{{ $deposit->id }}">

                                                    <!-- Withdrawal Amount -->
                                                    <div class="mb-3">
                                                        <label for="withdraw_amount_{{ $deposit->id }}"
                                                            class="form-label">Withdrawal Amount</label>
                                                        <input type="number" class="form-control"
                                                            id="withdraw_amount_{{ $deposit->id }}"
                                                            name="withdraw_amount" min="1"
                                                            max="{{ $deposit->current_amount }}"
                                                            placeholder="Enter withdrawal amount" required>
                                                    </div>

                                                    <!-- Withdrawal Description -->
                                                    <div class="mb-3">
                                                        <label for="withdraw_description_{{ $deposit->id }}"
                                                            class="form-label">Description (Optional)</label>
                                                        <textarea class="form-control" id="withdraw_description_{{ $deposit->id }}" name="withdraw_description"
                                                            rows="3" placeholder="Enter description (optional)"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Confirm
                                                        Withdrawal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No deposit records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Initialize Select2 for pupil selection
            $('#student_id').select2({
                placeholder: 'Select a pupil',
                allowClear: true,
                width: '100%' // Ensures Select2 takes the full width of the form control
            });

            // Re-initialize Select2 when the modal is shown
            $('#addDepositModal').on('shown.bs.modal', function() {
                $('#student_id').select2({
                    dropdownParent: $(
                        '#addDepositModal'
                    ) // Attach the dropdown to the modal to prevent z-index issues
                });
            });
        });
    </script>
@endsection

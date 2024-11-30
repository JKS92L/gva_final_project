@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Tuckshop Sales</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#studentListModal">
                            View Student Balances
                        </button>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Student List -->
    <div class="modal fade" id="studentListModal" tabindex="-1" role="dialog" aria-labelledby="studentListModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentListModalLabel">All Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="studentTable" class="table table-bordered table-hover text-nowrap no-footer table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Gender</th>
                                <th>Grade</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $student)
                                @php
                                    $balance = \App\Models\PocketMoneyAccount::where('student_id', $student->id)->sum(
                                        'current_amount',
                                    );
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                                    <td>{{ ucfirst($student->gender) ?? 'N/A' }}</td>
                                    <td>{{ $student->grade->gradeno ?? 'N/A' }} - {{ $student->grade->class_name ?? 'N/A' }}
                                    </td>
                                    <td>{{ number_format($balance, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Item Selection -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Select Items</h3>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('tuckshop.processTransaction') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="academic_term">Academic Term</label>
                                        <select class="form-control form-control-sm" id="academic_term" name="academic_term" required>
                                            <option value="">--Select a term--</option>
                                            @foreach ($terms as $term)
                                                <option value="{{ $term['id'] }}">{{ $term['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="studentName">Student Name</label>
                                        <select name="student_id" id="studentName"
                                            class="form-control form-control-sm select2" required>
                                            <option value="">Search and Select Student</option>
                                            @foreach ($students as $student)
                                                @php
                                                    $balance = \App\Models\PocketMoneyAccount::where(
                                                        'student_id',
                                                        $student->id,
                                                    )->sum('current_amount');
                                                @endphp
                                                @if ($balance > 0)
                                                    <option value="{{ $student->id }}">
                                                        {{ $student->firstname }} {{ $student->lastname }} -
                                                        ({{ $student->grade->gradeno ?? 'N/A' }} -
                                                        {{ $student->grade->class_name ?? 'N/A' }})
                                                        - Bal: {{ number_format($balance, 2) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div id="itemsContainer">
                                    <div class="row item-row">
                                        <div class="form-group col-md-6">
                                            <label for="itemName">Item</label>
                                            <select name="item_id[]" class="form-control form-control-sm select2" required>
                                                <option value="">Search and Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-price="{{ number_format($item->price, 2) }}">
                                                        {{ $item->name }} - ZMK {{ number_format($item->price, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" name="quantity[]"
                                                class="form-control form-control-sm quantity" min="1"
                                                placeholder="Enter Quantity" value="1" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="addItemButton" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add More
                                </button>

                                <div class="form-group mt-3">
                                    <label for="totalCost">Total Cost (ZMK)</label>
                                    <input type="text" name="total_cost" id="totalCost"
                                        class="form-control form-control-sm" readonly value="0.00">
                                </div>

                                <div class="form-group">
                                    <label for="withdrawCode">Withdraw Code</label>
                                    <input type="password" name="withdraw_code" id="withdrawCode"
                                        class="form-control form-control-sm" placeholder="Enter Withdraw Code" required>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm">Process Transaction</button>
                            </form>


                        </div>
                    </div>
                </div>

                <!-- Transaction Summary -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Transaction Summary</h3>
                        </div>
                        <div class="card-body">
                            <h5>Recent Sales</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Total Cost</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->tuckshop_item->name ?? 'N/A' }}</td>
                                            <td>{{ $transaction->quantity }}</td>
                                            <td>ZMK {{ number_format($transaction->total_cost, 2) }}</td>
                                            <td>{{ $transaction->transaction_date->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No transactions found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Render pagination links -->
                            <div class="d-flex justify-content-center">
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>
    </div>

    <script>
        const items = @json($items);

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 for existing elements
            $('.select2').select2({
                placeholder: "Search and Select",
                allowClear: true,
            });

            const itemsContainer = document.getElementById('itemsContainer');
            const addItemButton = document.getElementById('addItemButton');
            const totalCostInput = document.getElementById('totalCost');

            // Function to calculate the total cost dynamically
            function calculateTotal() {
                let totalCost = 0;

                itemsContainer.querySelectorAll('.item-row').forEach(row => {
                    const itemSelect = row.querySelector('select[name="item_id[]"]');
                    const quantityInput = row.querySelector('input[name="quantity[]"]');

                    const price = parseFloat(itemSelect.options[itemSelect.selectedIndex]?.dataset.price ||
                        0);
                    const quantity = parseInt(quantityInput.value) || 0;

                    totalCost += price * quantity;
                });

                // Update the total cost field
                totalCostInput.value = ` ${totalCost.toFixed(2)}`;
            }

            // Function to add a new item row
            function addItemRow() {
                const row = document.createElement('div');
                row.classList.add('row', 'item-row', 'mt-2');

                // Create item select dropdown
                const itemGroup = document.createElement('div');
                itemGroup.classList.add('form-group', 'col-md-6');
                const itemSelect = document.createElement('select');
                itemSelect.name = 'item_id[]';
                itemSelect.classList.add('form-control', 'form-control-sm', 'select2');
                itemSelect.required = true;
                itemSelect.innerHTML = `<option value="">Search and Select Item</option>`;
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.dataset.price = item.price.toFixed(2);
                    option.textContent = `${item.name} - ${item.price.toFixed(2)}`;
                    itemSelect.appendChild(option);
                });
                itemGroup.appendChild(itemSelect);

                // Create quantity input
                const quantityGroup = document.createElement('div');
                quantityGroup.classList.add('form-group', 'col-md-4');
                const quantityInput = document.createElement('input');
                quantityInput.type = 'number';
                quantityInput.name = 'quantity[]';
                quantityInput.classList.add('form-control', 'form-control-sm', 'quantity');
                quantityInput.min = 1;
                quantityInput.placeholder = 'Enter Quantity';
                quantityInput.value = 1;
                quantityInput.required = true;
                quantityGroup.appendChild(quantityInput);

                // Create remove button
                const removeGroup = document.createElement('div');
                removeGroup.classList.add('form-group', 'col-md-2');
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'btn-remove-item');
                removeButton.innerHTML = '<i class="fas fa-trash"></i>';
                removeGroup.appendChild(removeButton);

                // Append all to the row
                row.appendChild(itemGroup);
                row.appendChild(quantityGroup);
                row.appendChild(removeGroup);

                // Add row to the container
                itemsContainer.appendChild(row);

                // Reinitialize Select2 for the new dropdown
                $(itemSelect).select2({
                    placeholder: "Search and Select",
                    allowClear: true,
                });

                // Attach event listeners for dynamic calculation
                itemSelect.addEventListener('change', calculateTotal);
                quantityInput.addEventListener('input', calculateTotal);
            }

            // Function to remove an item row
            function removeItemRow(event) {
                if (event.target.closest('.btn-remove-item')) {
                    const row = event.target.closest('.item-row');
                    row.remove();
                    calculateTotal();

                    // Show warning if no items remain
                    if (!itemsContainer.querySelector('.item-row')) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Items Left',
                            text: 'You need at least one item to proceed.',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                }
            }

            // Attach event listeners
            addItemButton.addEventListener('click', addItemRow);
            itemsContainer.addEventListener('click', removeItemRow);

            // Update total when item or quantity changes
            itemsContainer.addEventListener('change', calculateTotal);
            itemsContainer.addEventListener('input', calculateTotal);
        });
    </script>
@endsection

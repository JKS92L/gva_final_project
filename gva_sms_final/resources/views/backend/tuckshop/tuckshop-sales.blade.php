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
                                        'deposit_amount',
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
                            <form id="salesForm" method="POST" action="#">

                                <div class="form-group col-md-12">
                                    <label for="studentName">Student Name</label>
                                    <select name="student_id" id="studentName" class="form-control form-control-sm select2"
                                        required>
                                        <option value="">Search and Select Student</option>
                                        @foreach ($students as $student)
                                            @php
                                                $balance = \App\Models\PocketMoneyAccount::where(
                                                    'student_id',
                                                    $student->id,
                                                )->sum('deposit_amount');
                                            @endphp
                                            @if ($balance > 0)
                                                <option value="{{ $student->id }}">
                                                    {{ $student->firstname }} {{ $student->lastname }} -
                                                    ({{ $student->grade->gradeno ?? 'N/A' }} -
                                                    {{ $student->grade->class_name ?? 'N/A' }})
                                                    -
                                                    Bal: {{ number_format($balance, 2) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

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
                                    <label for="totalCost">Total Cost</label>
                                    <input type="text" name="total_cost" id="totalCost"
                                        class="form-control form-control-sm" readonly value="ZMK 0.00">
                                </div>

                                <button type="button" id="processSaleButton"
                                    class="btn btn-success btn-block btn-sm">Process Sale</button>
                            </form>

                            <!-- Modal for Purchase Code -->
                            <div class="modal fade" id="purchaseCodeModal" tabindex="-1" role="dialog"
                                aria-labelledby="purchaseCodeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="purchaseCodeModalLabel">Enter Purchase Code</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="purchaseCode">Purchase Code</label>
                                                <input type="text" id="purchaseCode" class="form-control"
                                                    placeholder="Enter Purchase Code" required>
                                            </div>
                                            <div class="form-group">
                                                <p>Total Amount: <strong id="modalTotalDisplay">ZMK 0.00</strong></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="button" id="confirmPurchaseButton"
                                                class="btn btn-success">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <tr>
                                        <td>Apple</td>
                                        <td>2</td>
                                        <td>$5.00</td>
                                        <td>16-11-2024 10:30</td>
                                    </tr>
                                    <tr>
                                        <td>Banana</td>
                                        <td>3</td>
                                        <td>$3.00</td>
                                        <td>16-11-2024 11:00</td>
                                    </tr>
                                    <tr>
                                        <td>Orange</td>
                                        <td>1</td>
                                        <td>$3.00</td>
                                        <td>16-11-2024 11:15</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <script>
         const items = @json($items);
    </script>
    <script>
        $(document).ready(function() {
            $('#studentTable').DataTable({
                "paging": true, // Enables pagination
                "searching": true, // Enables search box
                "ordering": true, // Enables column sorting
                "info": true, // Shows table info (e.g., "Showing 1-10 of 20")
                "lengthChange": true, // Allows changing number of rows shown
                "pageLength": 8, // Default number of rows shown per page
                "language": {
                    "search": "Search Students:",
                    "lengthMenu": "Show _MENU_ entries"
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 plugin
            $('.select2').select2({
                placeholder: "Search and Select",
                allowClear: true
            });

            const itemsContainer = document.getElementById('itemsContainer');
            const addItemButton = document.getElementById('addItemButton');
            const processSaleButton = document.getElementById('processSaleButton');
            const totalCostInput = document.getElementById('totalCost');
            const purchaseCodeModal = new bootstrap.Modal(document.getElementById('purchaseCodeModal'), {});
            const modalTotalDisplay = document.getElementById('modalTotalDisplay'); // Total display in modal

            // Calculate the total cost dynamically
            function calculateTotal() {
                let totalCost = 0;
                itemsContainer.querySelectorAll('.item-row').forEach(row => {
                    const itemSelect = row.querySelector('.select2');
                    const quantityInput = row.querySelector('.quantity');
                    const price = parseFloat(itemSelect.options[itemSelect.selectedIndex]?.getAttribute(
                        'data-price')) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    totalCost += price * quantity;
                });
                totalCostInput.value = `ZMK ${totalCost.toFixed(2)}`;
                modalTotalDisplay.textContent = `ZMK ${totalCost.toFixed(2)}`;
            }

            // Add a new item row

           
            // Add a new item row
            function addItemRow() {
                const row = document.createElement('div');
                row.classList.add('row', 'item-row', 'mt-2');

                // Generate the options dynamically
                let options = '<option value="">Search and Select Item</option>';
                items.forEach(item => {
                    options += `<option value="${item.id}" data-price="${item.price.toFixed(2)}">
                        ${item.name} - ZMK ${item.price.toFixed(2)}
                    </option>`;
                });

                row.innerHTML = `
        <div class="form-group col-md-6">
            <select name="item_id[]" class="form-control form-control-sm select2" required>
                ${options}
            </select>
        </div>
        <div class="form-group col-md-4">
            <input type="number" name="quantity[]" class="form-control form-control-sm quantity" min="1"
                   placeholder="Enter Quantity" value="1" required>
        </div>
        <div class="form-group col-md-2">
            <button type="button" class="btn btn-danger btn-sm btn-remove-item"><i class="fas fa-trash"></i></button>
        </div>
    `;

                itemsContainer.appendChild(row);

                // Reinitialize Select2 for the new row
                $(row).find('.select2').select2({
                    placeholder: "Search and Select",
                    allowClear: true
                });

                // Attach dynamic calculation to the new row
                row.querySelector('.quantity').addEventListener('input', calculateTotal);
                row.querySelector('.select2').addEventListener('change', calculateTotal);
            }





            // Remove an item row
            function removeItemRow(event) {
                if (event.target.classList.contains('btn-remove-item')) {
                    event.target.closest('.item-row').remove();
                    calculateTotal();
                }
            }

            // Attach event listeners
            addItemButton.addEventListener('click', function() {
                addItemRow();
            });

            itemsContainer.addEventListener('click', removeItemRow);

            // Update total when item or quantity changes
            itemsContainer.addEventListener('change', calculateTotal);
            itemsContainer.addEventListener('input', calculateTotal);

            // Show the modal and update the total in the modal
            processSaleButton.addEventListener('click', function() {
                calculateTotal(); // Ensure the total is up-to-date
                purchaseCodeModal.show();
            });

            // Confirm purchase (form submission logic can go here)
            document.getElementById('confirmPurchaseButton').addEventListener('click', function() {
                const purchaseCode = document.getElementById('purchaseCode').value.trim();
                if (purchaseCode) {
                    alert(`Processing payment with purchase code: ${purchaseCode}`);
                    document.getElementById('salesForm').submit(); // Submit the form
                } else {
                    alert('Please enter a valid purchase code.');
                }
            });
        });
    </script>
@endsection

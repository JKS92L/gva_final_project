@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0">Inventory Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addItemModal">
                            <i class="fas fa-plus"></i> Add New Item
                        </button>
                        {{-- <button type="button" class="btn btn-warning btn-sm" id="exportButton">
                            <i class="fas fa-file-export"></i> Export Data
                        </button> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Inventory List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="inventoryTable"
                                    class="table table-bordered table-hover table-striped text-nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Name</th>
                                            <th>Price (ZMK)</th>
                                            <th>Stock Quantity</th>
                                            <th>Restock Level</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventory as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>ZMK {{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->stock_quantity }}</td>
                                                <td>{{ $item->restock_level }}</td>
                                                <td>
                                                    @if ($item->stock_quantity < $item->restock_level)
                                                        <span class="badge badge-warning">Low Stock</span>
                                                    @else
                                                        <span class="badge badge-success">In Stock</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-info" data-toggle="modal"
                                                        data-target="#editItemModal-{{ $item->id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#confirmDeleteModal-{{ $item->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editItemModal-{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="POST"
                                                            action="{{ route('tuckshop.inventory.edit', $item->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="name">Item Name</label>
                                                                    <input type="text" name="name"
                                                                        value="{{ $item->name }}" class="form-control"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="price">Price (ZMK)</label>
                                                                    <input type="number" name="price"
                                                                        value="{{ $item->price }}" class="form-control"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stock_quantity">Stock Quantity</label>
                                                                    <input type="number" name="stock_quantity"
                                                                        value="{{ $item->stock_quantity }}"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="restock_level">Restock Level</label>
                                                                    <input type="number" name="restock_level"
                                                                        value="{{ $item->restock_level }}"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="confirmDeleteModal-{{ $item->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm
                                                                Deletion</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete the item
                                                            <strong>{{ $item->name }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST"
                                                                action="{{ route('tuckshop.inventory.delete', $item->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tuckshop.inventory.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="itemName">Item Name</label>
                            <input type="text" name="name" id="itemName" class="form-control"
                                placeholder="Enter Item Name" required>
                        </div>
                        <div class="form-group">
                            <label for="itemPrice">Price (ZMK)</label>
                            <input type="number" name="price" id="itemPrice" class="form-control"
                                placeholder="Enter Item Price" required>
                        </div>
                        <div class="form-group">
                            <label for="stockQuantity">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stockQuantity" class="form-control"
                                placeholder="Enter Stock Quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="restockLevel">Restock Level</label>
                            <input type="number" name="restock_level" id="restockLevel" class="form-control"
                                placeholder="Enter Restock Level" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editItemForm">
                    <div class="modal-body">
                        <input type="hidden" id="editItemId">
                        <div class="form-group">
                            <label for="editItemName">Item Name</label>
                            <input type="text" id="editItemName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editItemPrice">Price (ZMK)</label>
                            <input type="number" id="editItemPrice" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editStockQuantity">Stock Quantity</label>
                            <input type="number" id="editStockQuantity" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editRestockLevel">Restock Level</label>
                            <input type="number" id="editRestockLevel" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable();


            // add stock
            // document.addEventListener('DOMContentLoaded', function() {
            //     $('#addItemForm').on('submit', function(e) {
            //         e.preventDefault(); // Prevent default form submission

            //         // Collect form data
            //         const itemData = {
            //             name: $('#itemName').val(),
            //             price: $('#itemPrice').val(),
            //             stock_quantity: $('#stockQuantity').val(),
            //             restock_level: $('#restockLevel').val(),
            //             _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            //         };

            //         // AJAX request to add new stock
            //         $.ajax({
            //             url: '/admin/tuckshop/inventory/add',
            //             type: 'POST',
            //             data: itemData,
            //             success: function(response) {
            //                 if (response.success) {
            //                     alert('Item added successfully!');
            //                     $('#addItemModal').modal('hide'); // Close the modal
            //                     $('#inventoryTable').DataTable().ajax
            //                         .reload(); // Reload DataTable
            //                 } else {
            //                     alert('Failed to add item: ' + response.message);
            //                 }
            //             },
            //             error: function(xhr) {
            //                 const errorMessage = xhr.responseJSON?.message ||
            //                     'An error occurred';
            //                 alert('Error: ' + errorMessage);
            //             }
            //         });
            //     });
            // });

            //fetch stock
            // const table = $('#inventoryTable').DataTable({
            //     ajax: {
            //         url: '/admin/tuckshop/inventory/view', // Endpoint to fetch data
            //         type: 'GET',
            //         dataSrc: '', // JSON array is returned directly
            //     },
            //     columns: [{
            //             data: 'id',
            //             render: (data, type, row, meta) => meta.row + 1
            //         }, // Auto-number rows
            //         {
            //             data: 'name'
            //         },
            //         {
            //             data: 'price',
            //             render: data => `ZMK ${parseFloat(data).toFixed(2)}`
            //         },
            //         {
            //             data: 'stock_quantity'
            //         },
            //         {
            //             data: 'restock_level'
            //         },
            //         {
            //             data: 'stock_quantity',
            //             render: (data, type, row) => {
            //                 return data < row.restock_level ?
            //                     '<span class="badge badge-warning">Low Stock</span>' :
            //                     '<span class="badge badge-success">In Stock</span>';
            //             }
            //         },
            //         {
            //             data: 'id',
            //             render: data => `
        //         <button class="btn btn-sm btn-info edit-item" data-id="${data}" data-toggle="modal" data-target="#editItemModal">
        //             <i class="fas fa-edit"></i> Edit
        //         </button>
        //         <button class="btn btn-sm btn-danger delete-item" data-id="${data}">
        //             <i class="fas fa-trash"></i> Delete
        //         </button>
        //     `
            //         }
            //     ],

            // });

            // // Reload table after any actions
            // $(document).on('click', '.delete-item, .edit-item', function() {
            //     table.ajax.reload();
            // });
        });
    </script>
@endsection

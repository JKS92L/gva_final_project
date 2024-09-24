@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Bulk Delete')
@section('content_header_title', 'students')
@section('content_header_subtitle', 'Bulk Delete Pupils')

{{-- Content body: main page content --}}
@section('content_body')

    {{-- Bulk Delete Actions --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between row">


            <div class="col-md-9">
                <h5 class="mb-0">Bulk Delete Pupils</h5>
            </div>
            <div class="md-col-3 mr-0 ">
                <button class="btn btn-danger btn-sm" id="deleteSelected">Delete Selected Pupils</button>
            </div>


        </div>
        <div class="card-body">
            {{-- Search Bar for quick pupil search --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    {{-- <input type="text" class="form-control" id="searchPupil" placeholder="Search pupils..."> --}}
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-warning btn-sm" id="selectAll">Select All</button>
                    <button class="btn btn-secondary btn-sm" id="deselectAll">Deselect All</button>
                </div>
            </div>

            {{-- Table for listing pupils with checkboxes --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="pupilsTable">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" id="selectAllCheckbox">
                            </th>
                            <th scope="col"> Exam Number <i class="fa fa-sort"></i> </th>
                            <th scope="col">Full Name <i class="fa fa-sort"></i></th>
                            <th scope="col">Grade-Class <i class="fa fa-sort"></i></th>
                            <th scope="col">Date Registered <i class="fa fa-sort"></i></th>
                            <th scope="col">Actions<i class="fa fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Dummy Data Rows - Replace with actual dynamic content later --}}
                        <tr>
                            <td><input type="checkbox" class="selectCheckbox"></td>
                            <td>1001</td>
                            <td>John Banda</td>
                            <td>Grade 12-A</td>
                            <td>2024-01-15</td>
                            <td>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="selectCheckbox"></td>
                            <td>1002</td>
                            <td>Jane Phiri</td>
                            <td>Grade 11-B</td>
                            <td>2024-01-20</td>
                            <td>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Confirmation Modal for bulk delete --}}
            <div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bulkDeleteModalLabel">Confirm Bulk Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the selected pupils? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmBulkDelete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Push extra CSS --}}
@push('css')
    <link rel="stylesheet" href="/css/custom_datatables.css">
    <style>
        #pupilsTable tbody tr {
            cursor: pointer;
        }
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(document).ready(function() {
            // add search functionality 
            $('#pupilsTable').DataTable();
            // Handle the Select All / Deselect All functionality
            $('#selectAll').click(function() {
                $('.selectCheckbox').prop('checked', true);
            });
            $('#deselectAll').click(function() {
                $('.selectCheckbox').prop('checked', false);
            });

            // Handle Select All checkbox in table header
            $('#selectAllCheckbox').change(function() {
                $('.selectCheckbox').prop('checked', this.checked);
            });

            // Handle Delete Selected button click
            $('#deleteSelected').click(function() {
                var selectedCount = $('.selectCheckbox:checked').length;
                if (selectedCount > 0) {
                    $('#bulkDeleteModal').modal('show');
                } else {
                    alert('Please select at least one pupil to delete.');
                }
            });

            // Confirm bulk delete action
            $('#confirmBulkDelete').click(function() {
                // Logic to delete selected pupils
                alert('Selected pupils will be deleted!');
                $('#bulkDeleteModal').modal('hide');
            });
        });
    </script>
@endpush

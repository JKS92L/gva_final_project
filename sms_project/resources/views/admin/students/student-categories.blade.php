@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Manage Student Categories')
@section('content_header_title', 'Students')
@section('content_header_subtitle', 'Student Categories')

{{-- Content body: main page content --}}
@section('content_body')

    {{-- Categories Management Card --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="col-md-10">
                <h5 class="mb-0">Manage Student Categories</h5>
            </div>
            <div class="col-md-2 ml-0">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCategoryModal">
                    Add New Category
                </button>
            </div>

        </div>
        <div class="card-body">
            {{-- Table for Category Management --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-nowrap" id="categoriesTable">
                    <thead>
                        <tr>
                            <th scope="col">Category Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Number of Students</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Dummy Data Rows - Replace with dynamic content you can add more
                         Full Scholarship, Partial Scholarship, Self-Financed. --}}
                        <tr>
                            <td>Boarders</td>
                            <td>Students who stay on the school campus</td>
                            <td>150</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#editCategoryModal">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteCategoryModal">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Day Scholars</td>
                            <td>Students who commute daily to school</td>
                            <td>300</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#editCategoryModal">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteCategoryModal">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Athletes</td>
                            <td>Students participating in school sports</td>
                            <td>50</td>
                            <td>
                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#editCategoryModal">Edit</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteCategoryModal">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals for Category Management --}}

    {{-- Add Category Modal --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Student Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter category name">
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Description</label>
                            <textarea class="form-control" id="categoryDescription" placeholder="Enter description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Student Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <div class="form-group">
                            <label for="editCategoryName">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName"
                                placeholder="Enter new category name">
                        </div>
                        <div class="form-group">
                            <label for="editCategoryDescription">Description</label>
                            <textarea class="form-control" id="editCategoryDescription" placeholder="Enter new description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Category Modal --}}
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Push extra CSS --}}
@push('css')
    <style>
        #categoriesTable tbody tr {
            cursor: pointer;
        }
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable();
            // Handle Add Category form submission
            $('#addCategoryForm').submit(function(e) {
                e.preventDefault();
                alert('New category added!');
                $('#addCategoryModal').modal('hide');
            });

            // Handle Edit Category form submission
            $('#editCategoryForm').submit(function(e) {
                e.preventDefault();
                alert('Category edited successfully!');
                $('#editCategoryModal').modal('hide');
            });
        });
    </script>
@endpush

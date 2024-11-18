@extends('admin.admim-master')
@section('admin_content')
    <div class="container-fluid">
        <h2 class="my-4">Balance Report</h2>
        <!-- Summary Section -->
        <div class="row">
            <!-- Total Deposits -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Deposits</span>
                        <span class="info-box-number">ZMW 10,410</span>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Money Spent</span>
                        <span class="info-box-number">ZMW 41,410</span>
                    </div>
                </div>
            </div>


            <!-- Total Net Balance -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Net Balance</span>
                        <span class="info-box-number">ZMW 760</span>
                    </div>
                </div>
            </div>

            <!-- Total Pupils Deposits -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-graduate"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pupils Deposits</span>
                        <span class="info-box-number">2,000</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Balance Report Table -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-table"></i> Detailed Transactions</h6>
            </div>
            <div class="card-body table-responsive p-2">
                <div class="row">
                    {{-- search by name --}}
                    <form id="searchByName" class="col-md-4">
                        <div class="form-group mr-3">
                            <label for="student_id" class="mr-2">Search by name</label>
                            {{-- <input type="date" class="form-control form-control-sm" id="from_date" name="from_date"> --}}
                            <select class="form-control select2 form-control-sm" id="student_id" name="student_id">
                                <option value="">--Select--</option>
                            </select>

                        </div>
                        {{-- <button type="submit" class="btn btn-sm bg-gradient-success">Search</button> --}}
                    </form>
                </div>
                <table class="table table-bordered table-hover text-nowrap no-footer table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pupil</th>
                            <th>Grade/Class</th>
                            <th>Total Deposit Amount</th>
                            <th>Total Spent</th>
                            <th>Net Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dummy Data Rows -->
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>12-A</td>
                            <td>5,000.00</td>
                            <td>1,000.00</td>
                            <td>4,000.00</td>
                            {{-- action buttons  --}}
                            <td>
                                <!-- View Button -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewModal-10">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Print Button -->
                                <a href="#"  class="btn btn-danger btn-sm">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>


                        </tr>
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

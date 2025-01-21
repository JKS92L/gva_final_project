@extends('admin.admim-master')


@section('admin_content')
    <div class="content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-0">Parent Dashboard</h2>
                    <p class="text-muted">Welcome back, {{ Auth::user()->name }}</p>
                </div>
            </div>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Reminder!</h5>
                Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my
                entire
                soul, like these sweet mornings of spring which I enjoy with my whole heart.
            </div>

            <!-- Info Boxes -->
            <div class="row">
                <!-- Total Amount Owed -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>$1,200</h3>
                            <p>Total Outstanding Payments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            View Details <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Number of Students -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>3</h3>
                            <p>Number of Students</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            View Students <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Total Disciplinary Cases -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>2</h3>
                            <p>Total Disciplinary Cases</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            View Details <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- Health Reports -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>4</h3>
                            <p>Health Reports</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            View Reports <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table for Students' Lowest Scores -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Students' Lowest Scores</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Subject</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Jane Doe</td>
                                        <td>Mathematics</td>
                                        <td>45%</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning">
                                                Contact Teacher
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>John Smith</td>
                                        <td>Science</td>
                                        <td>50%</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning">
                                                Contact Teacher
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-alt"></i>
                                Upcoming School Events
                            </h3>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            <div class="callout callout-info">
                                <h5>Science Fair</h5>
                                <p>Date: February 10, 2025</p>
                            </div>
                            <div class="callout callout-warning">
                                <h5>Sports Day</h5>
                                <p>Date: February 15, 2025</p>
                            </div>
                            <div class="callout callout-success">
                                <h5>Parent-Teacher Meeting</h5>
                                <p>Date: February 20, 2025</p>
                            </div>
                            <div class="callout callout-danger">
                                <h5>Art Exhibition</h5>
                                <p>Date: March 5, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 table-responsive">
                  
                        <h4 class="card-title text-bold">Pocket Money Log</h4>
                     
                  <table class="table table-striped table-sm table-borderless">
                    <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Transaction Type</th>
                      <th>Amount</th>
                       <th>Balance</th>
                      <th>Narration</th>
                      <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>1</td>
                      <td>Deposit</td>
                      <td>400</td>
                      <td>Bought (items *2) or for a trip/ or nl</td>
                      <td>$64.50</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Need for Speed IV</td>
                      <td>247-925-726</td>
                      <td>Wes Anderson umami biodiesel</td>
                      <td>$50.00</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Monsters DVD</td>
                      <td>735-845-642</td>
                      <td>Terry Richardson helvetica tousled street art master</td>
                      <td>$10.70</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Grown Ups Blue Ray</td>
                      <td>422-568-642</td>
                      <td>Tousled lomo letterpress</td>
                      <td>$25.99</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
@endsection

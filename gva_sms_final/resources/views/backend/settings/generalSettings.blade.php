@extends('admin.admim-master')
@section('admin_content')
    <style>
        /* Active Tab Background */
        .nav-link.active {
            background: linear-gradient(339deg, rgba(34, 193, 195, 1) 0%, rgba(253, 187, 45, 0.66) 100%);
            color: white;
            /* Ensures the text is readable against the gradient */
            border: none;
            border-radius: 5px;
            transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        /* Hover Effect for Tabs */
        .nav-link {
            color: #333;
            /* Default text color */
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(34, 193, 195, 0.2);
            /* Subtle background on hover */
            color: #22c1c3;
            /* Change text color to match gradient */
        }

        /* On Hover for Active Tab */
        .nav-link.active:hover {
            background: linear-gradient(339deg, rgba(34, 193, 195, 1) 0%, rgba(253, 187, 45, 1) 100%);
            color: white;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-success">General settings</h4>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            {{-- <a href="{{ route('view.studentreg.form') }}">Register New Student</a> --}}
                        </li>

                    </ol>
                </div>
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-schsettings-tab" data-toggle="pill"
                            href="#vert-tabs-schsettings" role="tab" aria-controls="vert-tabs-schsettings"
                            aria-selected="true">School settings</a>
                        <a class="nav-link" id="vert-tabs-schoolfees-tab" data-toggle="pill" href="#vert-tabs-schoolfees"
                            role="tab" aria-controls="vert-tabs-schoolfees" aria-selected="false">School Fees</a>
                        <a class="nav-link" id="vert-tabs-resultReportCard-tab" data-toggle="pill"
                            href="#vert-tabs-resultReportCard" role="tab" aria-controls="vert-tabs-resultReportCard"
                            aria-selected="false">Exam Results Settings</a>
                        <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings"
                            role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Settings</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade active show" id="vert-tabs-schsettings" role="tabpanel"
                            aria-labelledby="vert-tabs-schsettings-tab">
                            <div class="alert alert-info">
                                Note: After saving General Setting, please logout and relogin so changes will come into
                                effect.
                            </div>
                            <form>
                                <!-- General Information Card -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="text-success">General Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="schoolName">School Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="schoolName"
                                                    placeholder="Your school name" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="schoolCode">School Code</label>
                                                <input type="number" class="form-control form-control-sm" id="schoolCode"
                                                    placeholder="487438">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="schoolLogo">School Logo</label>
                                                <input type="file" class="form-control form-control-sm" id="schoolLogo"
                                                    name="school_logo" accept="image/png, image/jpeg, image/jpg, image/gif"
                                                    aria-describedby="schoolLogoHelp">
                                                <small id="schoolLogoHelp" class="form-text text-muted">Please upload a logo
                                                    in .jpg, .jpeg, .png, or .gif format.</small>
                                                <!-- Image preview -->
                                                <div id="logoPreview" style="margin-top:10px;">
                                                    <img id="previewImage" src="#" alt="Logo Preview"
                                                        style="display:none; max-width: 100px;">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="schoolMotto">School Motto <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="schoolMotto"
                                                    placeholder="Enter School Motto" required>
                                            </div>
                                        </div>

                                        <!-- Additional Fields -->
                                        <div class="form-row">

                                            <div class="form-group col-md-4">
                                                <label for="schoolYear">Establishment Year <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control form-control-sm" id="schoolYear"
                                                    placeholder="e.g., 1990" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="schoolType">School Type <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control form-control-sm" id="schoolType">
                                                    <option value="Primary">Primary</option>
                                                    <option value="Boarding Secondary">Boarding Secondary</option>
                                                    <option value="Day Secondary">Day Secondary</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="schoolWebsite">School Website</label>
                                                <input type="url" class="form-control form-control-sm"
                                                    id="schoolWebsite" placeholder="www.yourschool.com">
                                            </div>
                                        </div>



                                        <!-- Existing Fields -->
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="phone1">Line 1 <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control form-control-sm" id="phone1"
                                                    placeholder="097 XXXXXX" name="phone1" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="phone2">Line 2 <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control form-control-sm" id="phone2"
                                                    placeholder="097 XXXXXX" name="phone2" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control form-control-sm" id="email"
                                                    placeholder="yourschool@domain.com" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="address">Address & P.O Box No: <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control form-control-sm" id="address" rows="4"
                                                placeholder="Enter the school address here..." required>Plot No. 15, Kafue Road, Chilanga District, Lusaka Province, P.O. Box 34567</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- E.C.Z Exam School Details --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-success">E.C.Z Exam School Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="centerNoInternal_gnine">G9 Internal Center No:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="centerNoInternal_gnine"
                                                    placeholder="Enter School G9 -ECZ Center number"
                                                    name="centerNoInternal_gnine">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="centerNoInternal_gtwelve">G12 Internal Center No:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="centerNoInternal_gtwelve" name="centerNoInternal_gtwelve"
                                                    placeholder="Enter School G12 -ECZ Center number">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="centerNo_gnine_external">G9 External Center No:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="centerNo_gnine_external" name="centerNo_gnine_external"
                                                    placeholder="Enter School G9 -ECZ External Center No">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="centerNo_gtwelve_external">G12 External Center No:</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="centerNo_gtwelve_external" name="centerNo_gtwelve_external"
                                                    placeholder="Enter School G12 -ECZ External Center No">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="text-success">School Account Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group col-md-12">
                                            <label for="currencyFormat">Currency Format <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm" id="currencyFormat">
                                                <option value="ZMK">ZMK</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                        <!-- Account Fields Container -->
                                        <div id="accountFields">
                                            <!-- Initial Account Row -->
                                            <div class="form-row account-row">
                                                <div class="form-group col-md-12">
                                                    <h5 class="account-label" class="text-bold">ACCOUNT 1</h5>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="account_no">Account Number <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="account_no[]" placeholder="Enter account number" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="bank_name">Bank Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="bank_name[]" placeholder="Enter bank name" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="bank_branch">Bank Branch <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="bank_branch[]" placeholder="Enter bank branch" required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="swift_code">SWIFT Code <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="swift_code[]" placeholder="Enter SWIFT code" required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="iban">IBAN <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="iban[]" placeholder="Enter IBAN" required>
                                                </div>
                                                <div class="form-group col-md-2 align-self-end">
                                                    <button type="button" class="btn btn-success btn-sm add-account">Add
                                                        More Accounts</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Account Fields Container -->

                                    </div>
                                </div>

                                <!-- Template for New Account Rows (Hidden Initially) -->
                                <div class="form-row account-row d-none" id="accountTemplate">
                                    <div class="form-group col-md-12">
                                        <h5 class="account-label" class="text-bold"></h5>
                                        <!-- Placeholder for dynamic label -->
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="account_no">Account Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="account_no[]"
                                            placeholder="Enter account number" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="bank_name">Bank Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="bank_name[]"
                                            placeholder="Enter bank name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="bank_branch">Bank Branch <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="bank_branch[]"
                                            placeholder="Enter bank branch" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="swift_code">SWIFT Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="swift_code[]"
                                            placeholder="Enter SWIFT code" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="iban">IBAN <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="iban[]"
                                            placeholder="Enter IBAN" required>
                                    </div>
                                    <div class="form-group col-md-2 align-self-end">
                                        <button type="button"
                                            class="btn btn-danger btn-sm remove-account">Remove</button>
                                    </div>
                                </div>

                                <!-- Website Information Card -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="text-success">Your Website & Social Media</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Website Information -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="baseUrl">Base URL <span class="text-danger">*</span></label>
                                                <input type="url" class="form-control form-control-sm" id="baseUrl"
                                                    placeholder="www.yourschool.com" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="filePath">File Upload Path <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="filePath"
                                                    placeholder="/var/www/demo.smart-school.in/..." required>
                                            </div>
                                        </div>

                                        <!-- Social Media Information -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="facebookUrl">Facebook Page URL</label>
                                                <input type="url" class="form-control form-control-sm"
                                                    id="facebookUrl" placeholder="https://facebook.com/yourschool">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="twitterUrl">Twitter Handle URL</label>
                                                <input type="url" class="form-control form-control-sm"
                                                    id="twitterUrl" placeholder="https://twitter.com/yourschool">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="instagramUrl">Instagram Profile URL</label>
                                                <input type="url" class="form-control form-control-sm"
                                                    id="instagramUrl" placeholder="https://instagram.com/yourschool">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="linkedinUrl">LinkedIn Page URL</label>
                                                <input type="url" class="form-control form-control-sm"
                                                    id="linkedinUrl"
                                                    placeholder="https://linkedin.com/company/yourschool">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="youtubeUrl">YouTube Channel URL</label>
                                                <input type="url" class="form-control form-control-sm"
                                                    id="youtubeUrl" placeholder="https://youtube.com/channel/yourschool">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tiktokUrl">TikTok Profile URL</label>
                                                <input type="url" class="form-control form-control-sm" id="tiktokUrl"
                                                    placeholder="https://tiktok.com/@yourschool">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-sm col-md-12">Save</button>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="vert-tabs-schoolfees" role="tabpanel"
                            aria-labelledby="vert-tabs-schoolfees-tab">
                            <!-- School Fees Form Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="text-success">School Fees Records</h5>
                                    <!-- Add Fee Button -->
                                    <button class="btn btn-success float-right" data-toggle="modal"
                                        data-target="#addFeeModal">
                                        Add Fee
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fee Type</th>
                                                <th>Interval</th>
                                                <th>Amount</th>
                                                <th>Student Type</th>
                                                <th>Account ID</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="feeTableBody">
                                            @foreach ($fees as $fee)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $fee->fee_type }}</td>
                                                    <td>{{ ucfirst($fee->fee_interval) }}</td>
                                                    <td>{{ number_format($fee->amount, 2) }}</td>
                                                    <td>{{ ucfirst($fee->student_type) }}</td>
                                                    <td>{{ $fee->account_id }}</td>
                                                    <td>{{ $fee->fee_status ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <!-- Edit Button with Modal Trigger -->
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#editFeeModal{{ $fee->id }}">
                                                            Edit
                                                        </button>

                                                        <!-- Delete Button with Modal Trigger -->
                                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteFeeModal{{ $fee->id }}">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Fee Modal -->
                                                <div class="modal fade" id="editFeeModal{{ $fee->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editFeeModalLabel{{ $fee->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editFeeModalLabel{{ $fee->id }}">Edit Fee
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('fees.update', $fee->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <!-- Fee Type Input -->
                                                                    <div class="form-group">
                                                                        <label for="fee_type">Fee Type</label>
                                                                        <input type="text" name="fee_type"
                                                                            class="form-control"
                                                                            value="{{ $fee->fee_type }}" required>
                                                                    </div>

                                                                    <!-- Interval Input -->
                                                                    <div class="form-group">
                                                                        <label for="interval">Interval</label>
                                                                        <select name="interval" class="form-control"
                                                                            required>
                                                                            @php
                                                                                // Define an array of possible interval values
                                                                                $intervals = [
                                                                                    'termly',
                                                                                    'once-off',
                                                                                    'monthly',
                                                                                    'annually',
                                                                                ];
                                                                            @endphp
                                                                            @foreach ($intervals as $interval)
                                                                                <option value="{{ $interval }}"
                                                                                    {{ $fee->interval === $interval ? 'selected' : '' }}>
                                                                                    {{ ucfirst($interval) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>




                                                                    <!-- Amount Input -->
                                                                    <div class="form-group">
                                                                        <label for="amount">Amount</label>
                                                                        <input type="number" name="amount"
                                                                            class="form-control"
                                                                            value="{{ $fee->amount }}" required>
                                                                    </div>

                                                                    <!-- Student Type Input -->
                                                                    <div class="form-group">
                                                                        <label for="student_type">Student Type</label>
                                                                        <select name="student_type" class="form-control"
                                                                            required>
                                                                            <option value="Boarder"
                                                                                {{ $fee->student_type == 'Boarder' ? 'selected' : '' }}>
                                                                                Boarder</option>
                                                                            <option value="Day-Scholar"
                                                                                {{ $fee->student_type == 'Day-Scholar' ? 'selected' : '' }}>
                                                                                Day-Scholar</option>
                                                                            <option value="All"
                                                                                {{ $fee->student_type == 'All' ? 'selected' : '' }}>
                                                                                All</option>
                                                                        </select>
                                                                    </div>


                                                                    <!-- Account ID Input -->
                                                                    <div class="form-group">
                                                                        <label for="account_id">Account ID</label>
                                                                        <input type="text" name="account_id"
                                                                            class="form-control"
                                                                            value="{{ $fee->account_id }}" required>
                                                                    </div>

                                                                    <!-- Status Input -->
                                                                    <div class="form-group">
                                                                        <label for="status">Status</label>
                                                                        <select name="status" class="form-control">
                                                                            <option value="1"
                                                                                {{ $fee->status ? 'selected' : '' }}>Active
                                                                            </option>
                                                                            <option value="0"
                                                                                {{ !$fee->status ? 'selected' : '' }}>
                                                                                Inactive</option>
                                                                        </select>
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

                                                <!-- Delete Fee Modal -->
                                                <div class="modal fade" id="deleteFeeModal{{ $fee->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="deleteFeeModalLabel{{ $fee->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteFeeModalLabel{{ $fee->id }}">Confirm
                                                                    Deletion</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this fee record?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('fees.destroy', $fee->id) }}"
                                                                    method="POST">
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

                            <!-- Add Fee Modal -->
                            <div class="modal fade" id="addFeeModal" tabindex="-1" role="dialog"
                                aria-labelledby="addFeeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addFeeModalLabel">Add Fee</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('fees.store') }}" method="POST">
                                                @csrf
                                                <!-- Fee Type Input -->
                                                <div class="form-group">
                                                    <label for="fee_type">Fee Type</label>
                                                    <input type="text" class="form-control" name="fee_type" required>
                                                </div>
                                                <!-- Interval Input -->
                                                <div class="form-group">
                                                    <label for="interval">Interval</label>
                                                    <select class="form-control" name="interval" required>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly">Monthly</option>
                                                        <option value="termly">Termly</option>
                                                        <option value="topical">Topical</option>
                                                    </select>
                                                </div>
                                                <!-- Amount Input -->
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input type="number" class="form-control" name="amount" required>
                                                </div>
                                                <!-- Student Type Input -->
                                                <div class="form-group">
                                                    <label for="student_type">Student Type</label>
                                                    <select class="form-control" name="student_type" required>
                                                        <option value="boarder">Boarder</option>
                                                        <option value="day">Day</option>
                                                    </select>
                                                </div>
                                                <!-- Account ID Input -->
                                                <div class="form-group">
                                                    <label for="account_id">Account ID</label>
                                                    <input type="text" class="form-control" name="account_id"
                                                        required>
                                                </div>
                                                <button type="submit" class="btn btn-success">Add Fee</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Display Table for School Fees -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="text-success">School Fees Records</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fee Type</th>
                                                <th>Interval</th>
                                                <th>Amount</th>
                                                <th>Student Type</th>
                                                <th>Account ID</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="feeTableBody">
                                            <!-- Sample Row (can be dynamically populated via JavaScript or back-end) -->
                                            <tr>
                                                <td>1</td>
                                                <td>Tuition</td>
                                                <td>Termly</td>
                                                <td>1000.00</td>
                                                <td>Boarder</td>
                                                <td>123</td>
                                                <td>Active</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary">Edit</button>
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        {{-- Results Settings Tab  --}}
                        <div class="tab-pane fade" id="vert-tabs-resultReportCard" role="tabpanel"
                            aria-labelledby="vert-tabs-resultReportCard-tab">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Passing Percentage Settings</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('settings.updatePassingPercentage') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="form-group col-md-6 form-group-sm">
                                                <label for="junior_passing_percentage" class="form-label">Junior Passing
                                                    Percentage</label>
                                                <input type="number" class="form-control" id="junior_passing_percentage"
                                                    name="junior_passing_percentage" placeholder="e.g. 40" min="0"
                                                    max="100"
                                                    value="{{ old('junior_passing_percentage', $pass_percentage->junior_passing_percentage ?? '') }}"
                                                    required>
                                                <small class="form-text text-muted">Enter the passing percentage for junior
                                                    students (e.g., 40%).</small>
                                            </div>

                                            <div class="form-group col-md-6 form-group-sm">
                                                <label for="senior_passing_percentage" class="form-label">Senior Passing
                                                    Percentage</label>
                                                <input type="number" class="form-control" id="senior_passing_percentage"
                                                    name="senior_passing_percentage" placeholder="e.g. 50" min="0"
                                                    max="100"
                                                    value="{{ old('senior_passing_percentage', $pass_percentage->senior_passing_percentage ?? '') }}"
                                                    required>
                                                <small class="form-text text-muted">Enter the passing percentage for senior
                                                    students (e.g., 50%).</small>
                                            </div>
                                        </div>


                                        <div class="form-group d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success">Save Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- grading system --}}
                            <div class="card mt-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Grading System</h5>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addGradeModal">Add New Grade</button>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Score Range</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results_grades as $results_grade)
                                                <tr>
                                                    <td>{{ $results_grade->grade }}</td>
                                                    <td>{{ $results_grade->score_min . '-' . $results_grade->score_max }}
                                                    </td>
                                                    <td>
                                                        <!-- Edit Button with Modal Trigger -->
                                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                            data-target="#editGradeModal{{ $results_grade->id }}">Edit</button>

                                                        <!-- Delete Button with Modal Trigger -->
                                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteGradeModal{{ $results_grade->id }}">Delete</button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Grade Modal -->
                                                <div class="modal fade" id="editGradeModal{{ $results_grade->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editGradeModalLabel{{ $results_grade->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editGradeModalLabel{{ $results_grade->id }}">Edit
                                                                    Grade</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('results_grades.update', $results_grade->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="grade">Grade</label>
                                                                        <input type="text" class="form-control"
                                                                            id="grade" name="grade"
                                                                            value="{{ $results_grade->grade }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="score_min">Min Score</label>
                                                                        <input type="number" class="form-control"
                                                                            id="score_min" name="score_min"
                                                                            value="{{ $results_grade->score_min }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="score_max">Max Score</label>
                                                                        <input type="number" class="form-control"
                                                                            id="score_max" name="score_max"
                                                                            value="{{ $results_grade->score_max }}"
                                                                            required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Save
                                                                        changes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Grade Modal -->
                                                <div class="modal fade" id="deleteGradeModal{{ $results_grade->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="deleteGradeModalLabel{{ $results_grade->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteGradeModalLabel{{ $results_grade->id }}">
                                                                    Confirm Delete</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete the grade
                                                                    "{{ $results_grade->grade }}"?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('results_grades.destroy', $results_grade->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>



                                    <!-- Add New Grade Modal -->
                                    <div class="modal fade" id="addGradeModal" tabindex="-1" role="dialog"
                                        aria-labelledby="addGradeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addGradeModalLabel">Add New Grade</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('results_grades.store') }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="new_grade">Grade</label>
                                                            <input type="text" class="form-control" id="new_grade"
                                                                name="grade" placeholder="e.g. A" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="new_score_min">Min Score</label>
                                                            <input type="number" class="form-control" id="new_score_min"
                                                                name="score_min" placeholder="e.g. 80" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="new_score_max">Max Score</label>
                                                            <input type="number" class="form-control" id="new_score_max"
                                                                name="score_max" placeholder="e.g. 100" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Add Grade</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Exams settings card --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Manage Exam Types</h5>
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addExamTypeModal">Add Exam Type</button>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Exam Type</th>
                                                <th>Weight</th>
                                                <th>Interval</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($examTypes as $examType)
                                                <tr>
                                                    <td>{{ $examType->name }}</td>
                                                    <td>{{ $examType->weight }}</td>
                                                    <td>{{ ucfirst($examType->interval) }}</td>
                                                    <td>
                                                        <!-- Edit Button with Modal Trigger -->
                                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                            data-target="#editExamTypeModal{{ $examType->id }}">Edit</button>

                                                        <!-- Delete Button with Modal Trigger -->
                                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteExamTypeModal{{ $examType->id }}">Delete</button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editExamTypeModal{{ $examType->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editExamTypeModalLabel{{ $examType->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editExamTypeModalLabel{{ $examType->id }}">Edit
                                                                    Exam Type</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('examType.update', $examType->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="name">Exam Type</label>
                                                                        <input type="text" class="form-control"
                                                                            name="name" value="{{ $examType->name }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="weight">Weight</label>
                                                                        <input type="number" class="form-control"
                                                                            name="weight"
                                                                            value="{{ $examType->weight }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="interval">Interval</label>
                                                                        <select class="form-control" name="interval"
                                                                            required>
                                                                            <option value="weekly"
                                                                                {{ $examType->interval == 'weekly' ? 'selected' : '' }}>
                                                                                Weekly</option>
                                                                            <option value="monthly"
                                                                                {{ $examType->interval == 'monthly' ? 'selected' : '' }}>
                                                                                Monthly</option>
                                                                            <option value="termly"
                                                                                {{ $examType->interval == 'termly' ? 'selected' : '' }}>
                                                                                Termly</option>
                                                                            <option value="topical"
                                                                                {{ $examType->interval == 'topical' ? 'selected' : '' }}>
                                                                                Topical</option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-success">Update</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteExamTypeModal{{ $examType->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="deleteExamTypeModalLabel{{ $examType->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteExamTypeModalLabel{{ $examType->id }}">
                                                                    Confirm Deletion</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete the exam type:
                                                                <strong>{{ $examType->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('examType.destroy', $examType->id) }}"
                                                                    method="POST">
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


                            <!-- Add Exam Type Modal -->
                            <div class="modal fade" id="addExamTypeModal" tabindex="-1" role="dialog"
                                aria-labelledby="addExamTypeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addExamTypeModalLabel">Add New Exam Type</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('examTypes.store') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="name">Exam Type</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" placeholder="e.g. Midterm" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="weight">Weight</label>
                                                    <input type="number" class="form-control" id="weight"
                                                        name="weight" placeholder="Weight (e.g. 20)" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interval">Exam Interval</label>
                                                    <select class="form-control" id="interval" name="interval" required>
                                                        <option value="" disabled selected>Select Interval</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly">Monthly</option>
                                                        <option value="termly">Termly</option>
                                                        <option value="topical">Topical</option>
                                                        <option value="annually">Annually</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Exam Type</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Effort Comments Card -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="text-success">Effort Comments</h5>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addEffortModal">Add New Effort</button>
                                </div>
                                <div class="card-body">
                                    <!-- Table to display the list of efforts -->
                                    <table id="effortTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Effort Letter</th>
                                                <th>Effort Comment</th>
                                                <th>Score Range</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($efforts as $effort)
                                                <tr>
                                                    <td>{{ $effort->effort_letter }}</td>
                                                    <td>{{ $effort->effort_comment }}</td>
                                                    <td>
                                                        @if ($effort->resultsGrade)
                                                            {{ $effort->resultsGrade->score_min . '-' . $effort->resultsGrade->score_max }}
                                                        @else
                                                            N/A <!-- Or handle it however you prefer -->
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning editEffort"
                                                            data-toggle="modal"
                                                            data-target="#editEffortModal{{ $effort->id }}">Edit</button>
                                                        <button class="btn btn-sm btn-danger deleteEffort">Delete</button>
                                                    </td>
                                                </tr>
                                                <!-- Edit Effort Modal -->
                                                <div class="modal fade" id="editEffortModal{{ $effort->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editEffortModalLabel{{ $effort->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editEffortModalLabel{{ $effort->id }}">Edit
                                                                    Effort</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('efforts.update', $effort->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="effortLetter{{ $effort->id }}">Effort
                                                                            Letter</label>
                                                                        <input type="text" class="form-control"
                                                                            id="effortLetter{{ $effort->id }}"
                                                                            name="effort_letter"
                                                                            value="{{ $effort->effort_letter }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="effortComment{{ $effort->id }}">Effort
                                                                            Comment</label>
                                                                        <input type="text" class="form-control"
                                                                            id="effortComment{{ $effort->id }}"
                                                                            name="effort_comment"
                                                                            value="{{ $effort->effort_comment }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="scoreMin{{ $effort->id }}">Score
                                                                            Minimum</label>
                                                                        <input type="number" class="form-control"
                                                                            id="scoreMin{{ $effort->id }}"
                                                                            name="score_min"
                                                                            value="{{ $effort->resultsGrade->score_min }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="scoreMax{{ $effort->id }}">Score
                                                                            Maximum</label>
                                                                        <input type="number" class="form-control"
                                                                            id="scoreMax{{ $effort->id }}"
                                                                            name="score_max"
                                                                            value="{{ $effort->resultsGrade->score_max }}"
                                                                            required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Update
                                                                        Effort</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal to add new effort -->
                                <div class="modal fade" id="addEffortModal" tabindex="-1" role="dialog"
                                    aria-labelledby="addEffortModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addEffortModalLabel">Add New Effort</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addEffortForm" action="{{ route('efforts.store') }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="effortLetter">Effort Letter</label>
                                                        <input type="text" class="form-control" id="effortLetter"
                                                            name="letter" placeholder="e.g. A" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="effortComment">Effort Comment</label>
                                                        <input type="text" class="form-control" id="effortComment"
                                                            name="comment" placeholder="e.g. Consistently good" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="scoreRange">Score Range</label>
                                                        <select class="form-control" id="scoreRange" name="score_range"
                                                            required>
                                                            <option value="">--select range--</option>
                                                            @foreach ($efforts as $effort)
                                                                <option value="{{ $effort->resultsGrade->id }}">
                                                                    {{ $effort->resultsGrade->score_min . '-' . $effort->resultsGrade->score_max }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Add Effort</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>




                            {{-- Teachers comments card --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="text-primary">Manage Subject Teacher's Comments</h5>
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#addCommentModal">Add New Comment</button>
                                </div>
                                {{-- Teacher Comments card --}}
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Grade</th>
                                                <th>Comment</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subjectTeacherComments as $comment)
                                                <tr>
                                                    <td>{{ $comment->resultsGrade->grade }}</td>
                                                    <td>{{ $comment->comment }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                            data-target="#editCommentModal{{ $comment->id }}">Edit</button>
                                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                            data-target="#deleteCommentModal{{ $comment->id }}">Delete</button>
                                                    </td>
                                                </tr>
                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editCommentModal{{ $comment->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editCommentModalLabel{{ $comment->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editCommentModalLabel{{ $comment->id }}">Edit
                                                                    Comment</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('comments.update', $comment->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <label for="results_grade_id">Grade</label>
                                                                        <select class="form-control"
                                                                            name="results_grade_id" required>
                                                                            @foreach ($results_grades as $grade)
                                                                                <option value="{{ $grade->id }}"
                                                                                    {{ $comment->results_grade_id == $grade->id ? 'selected' : '' }}>
                                                                                    {{ $grade->grade }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="comment">Comment</label>
                                                                        <textarea class="form-control" name="comment" required>{{ $comment->comment }}</textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success">Update
                                                                        Comment</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <!-- Delete Comment Modal-->
                                                <div class="modal fade" id="deleteCommentModal{{ $comment->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="deleteCommentModalLabel{{ $comment->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteCommentModalLabel{{ $comment->id }}">
                                                                    Confirm Deletion
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="font-weight-bold">Are you sure you want to delete
                                                                    this comment?</p>
                                                                <div class="alert alert-warning" role="alert">
                                                                    <p><span class="font-weight-bold">Grade:</span>
                                                                        {{ $comment->resultsGrade->grade }}</p>
                                                                    <p><span class="font-weight-bold">Comment:</span>
                                                                        {{ $comment->comment }}</p>
                                                                </div>
                                                                <p class="text-danger"><strong>This action cannot be
                                                                        undone.</strong></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('comments.destroy', $comment->id) }}"
                                                                    method="POST">
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

                            <!-- Add Comment Modal -->
                            <div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog"
                                aria-labelledby="addCommentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addCommentModalLabel">Add New Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('comments.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="resultsGrade">Grade</label>
                                                    <select class="form-control" id="resultsGrade"
                                                        name="results_grade_id" required>
                                                        @foreach ($results_grades as $results_grade)
                                                            <option value="{{ $results_grade->id }}">
                                                                {{ $results_grade->grade }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="comment">Comment</label>
                                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Add Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>







                        </div>
                        <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel"
                            aria-labelledby="vert-tabs-settings-tab">
                            Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis
                            ac, ornare
                            sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod
                            molestie
                            tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec
                            pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut
                            nisl
                            commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet
                            facilisis.
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tabledit/1.2.3/jquery.tabledit.min.js"></script> --}}


    <script>
        // Function to dynamically add or remove account fields and update labels
        document.addEventListener('DOMContentLoaded', function() {
            const accountFields = document.getElementById('accountFields');
            const accountTemplate = document.getElementById('accountTemplate');

            // Add Account Button
            accountFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-account')) {
                    addNewAccountField();
                    updateLabels(); // Update labels after adding a new account
                }
            });

            // Remove Account Button
            accountFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-account')) {
                    const accountRow = e.target.closest('.account-row');
                    accountRow.remove();
                    updateLabels(); // Update labels after removing an account
                }
            });

            // Function to add new account fields
            function addNewAccountField() {
                const newAccount = accountTemplate.cloneNode(true);
                newAccount.classList.remove('d-none');
                newAccount.id = '';
                accountFields.appendChild(newAccount);
            }

            // Function to update account labels dynamically
            function updateLabels() {
                const accountRows = document.querySelectorAll('.account-row');
                accountRows.forEach((row, index) => {
                    const label = row.querySelector('.account-label');
                    if (label) {
                        label.textContent = `ACCOUNT ${index + 1}`;
                    }
                });
            }

            // Initialize with the first account label
            updateLabels();
        });



        // JavaScript to handle the preview of the uploaded image and resetting it
        document.getElementById('schoolLogo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    document.getElementById('resetLogoBtn').style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            }
        });

        // JavaScript to reset the image and hide the preview
        document.getElementById('resetLogoBtn').addEventListener('click', function() {
            document.getElementById('schoolLogo').value = ''; // Reset file input
            const previewImage = document.getElementById('previewImage');
            previewImage.src = '#'; // Reset the preview image source
            previewImage.style.display = 'none'; // Hide the preview
            this.style.display = 'none'; // Hide the reset button
        });




        //     // editing report card setting, save and lock tables
        //     function enableEdit(tableId) {
        //     let table = document.getElementById(tableId);
        //     let cells = table.querySelectorAll('td[contenteditable]');

        //     // Toggle contenteditable
        //     for (let i = 0; i < cells.length; i++) {
        //         let isEditable = cells[i].getAttribute('contenteditable') === "true";
        //         cells[i].setAttribute('contenteditable', !isEditable);
        //     }
        // }

        // function saveChanges(tableId, saveUrl) {
        //     let table = document.getElementById(tableId);
        //     let cells = table.querySelectorAll('td[contenteditable]');
        //     let data = {};

        //     // Collect data from the table
        //     for (let i = 0; i < cells.length; i++) {
        //         let row = cells[i].parentElement;
        //         let key = row.cells[0].textContent.trim();
        //         let value = cells[i].textContent.trim();
        //         data[key] = value;
        //     }

        //     // AJAX to send data to server
        //     $.ajax({
        //         url: saveUrl, // The backend URL to handle saving
        //         type: 'POST',
        //         data: { tableData: data },
        //         success: function(response) {
        //             alert('Changes saved successfully!');
        //             // Lock the table again after saving
        //             for (let i = 0; i < cells.length; i++) {
        //                 cells[i].setAttribute('contenteditable', false);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             alert('Failed to save changes.');
        //         }
        //     });
        // }
    </script>
@endsection

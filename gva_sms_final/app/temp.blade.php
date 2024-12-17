 <div class="card-body table-responsive p-2">
     <table class="table table-bordered table-hover text-nowrap" id="studentDetails">
         <thead>
             <tr>
                 <th>Exam Number</th>
                 <th>Pupil's Name</th>
                 <th>Grade</th>
                 <th>Student Type</th>
                 <th>D.O.B</th>
                 <th>Gender</th>
                 <th>Siblings</th>
                 <th>Hostel (Bedspace#)</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             @foreach ($students as $student)
                 <tr>
                     <td>{{ $student->ecz_no }}</td>
                     <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                     <td>
                         {{ $student->grade->gradeno ?? 'N/A' }} {{ $student->grade->class_name ?? '' }}
                     </td>
                     <td>{{ ucfirst($student->student_type) }}</td>
                     <td>{{ $student->dob ? $student->dob->format('d/m/Y') : 'N/A' }}</td>
                     <td>{{ ucfirst($student->gender) }}</td>
                     <td>
                         <a href="#" data-toggle="tooltip"
                             title="@foreach ($student->siblings as $sibling) {{ $sibling->firstname }} {{ $sibling->lastname }} @if (!$loop->last), @endif @endforeach">
                             {{ $student->siblings->count() }}
                         </a>
                     </td>
                     <td>
                         {{ $student->hostel ? $student->hostel->hostel_name : 'N/A' }}
                         @if ($student->bedspace)
                             ({{ $student->bedspace->bedspace_no }})
                         @endif
                     </td>
                     <td>
                         <button class="btn btn-primary btn-sm" data-toggle="modal"
                             data-target="#viewModal-{{ $student->id }}">View</button>
                         <button class="btn btn-danger btn-sm" data-toggle="modal"
                             data-target="#deleteConfirmModal-{{ $student->id }}">Delete</button>
                         <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                     </td>
                 </tr>

                 {{-- <!-- View Modal -->
                            @include('backend.students.partials.view-modal', ['student' => $student])

                            <!-- Delete Confirmation Modal -->
                            @include('backend.students.partials.delete-modal', ['student' => $student]) --}}
             @endforeach
         </tbody>
     </table>

 </div>





 @extends('admin.admim-master')
 @section('admin_content')
     <div class="content-header py-3 bg-light shadow-sm">
         <div class="container-fluid">
             <div class="row align-items-center mb-3">

             </div>
         </div>
     </div>

     {{-- Modal for Physical Admission --}}
     <div class="modal fade" id="physicalAdmissionModal" tabindex="-1" aria-labelledby="physicalAdmissionModalLabel"
         aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="physicalAdmissionModalLabel">Add Physical Admission</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form id="physicalAdmissionForm">
                         <div class="form-row">
                             <div class="form-group col-md-6">
                                 <label for="applicantName">Applicant Name</label>
                                 <input type="text" class="form-control" id="applicantName"
                                     placeholder="Enter applicant's name" required>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="applicationId">Application ID</label>
                                 <input type="text" class="form-control" id="applicationId"
                                     placeholder="Enter application ID" required>
                             </div>
                         </div>
                         <div class="form-row">
                             <div class="form-group col-md-6">
                                 <label for="admissionType">Admission Type</label>
                                 <select id="admissionType" class="form-control" required>
                                     <option>--Select--</option>
                                     <option>Physical</option>
                                     <option>Online</option>
                                 </select>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="applicationYear">Application Year</label>
                                 <input type="number" class="form-control" id="applicationYear"
                                     value="{{ date('Y') }}" required>
                             </div>
                         </div>
                         <div class="form-row">
                             <div class="form-group col-md-6">
                                 <label for="submissionDate">Submission Date</label>
                                 <input type="date" class="form-control" id="submissionDate" required>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="status">Status</label>
                                 <select id="status" class="form-control" required>
                                     <option selected>Pending</option>
                                     <option>Approved</option>
                                     <option>Rejected</option>
                                 </select>
                             </div>
                         </div>
                         <button type="submit" class="btn btn-primary">Save Admission</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <!-- View Applicant Modal -->
     <div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel"
         aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="viewApplicantModalLabel">Applicant Details</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <!-- Applicant Info -->
                     <div class="row">
                         <div class="col-md-6">
                             <h6><strong>Applicant Name:</strong> <span id="applicantName">Chileshe Mwansa</span></h6>
                         </div>
                         <div class="col-md-6">
                             <h6><strong>Application ID:</strong> <span id="applicationId">ADM004</span></h6>
                         </div>
                     </div>

                     <div class="row mt-3">
                         <div class="col-md-4">
                             <h6><strong>Admission Type:</strong> <span id="admissionType">Physical</span></h6>
                         </div>
                         <div class="col-md-4">
                             <h6><strong>Grade:</strong> <span id="grade">8</span></h6>
                         </div>
                         <div class="col-md-4">
                             <h6><strong>Citizenship:</strong> <span id="citizenship">Zambian</span></h6>
                         </div>
                     </div>

                     <div class="row mt-3">
                         <div class="col-md-4">
                             <h6><strong>District:</strong> <span id="district">Lusaka</span></h6>
                         </div>
                         <div class="col-md-4">
                             <h6><strong>Application Year:</strong> <span id="applicationYear">2024</span></h6>
                         </div>
                         <div class="col-md-4">
                             <h6><strong>Submission Date:</strong> <span id="submissionDate">05 Jan, 2024</span></h6>
                         </div>
                     </div>

                     <div class="row mt-3">
                         <div class="col-md-12">
                             <h6><strong>Application Status:</strong> <span id="applicationStatus"
                                     class="badge badge-warning">Pending</span></h6>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

     {{-- admission container  --}}
     <div class="container">
         <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
                 <div>
                     <h3>Online Admissions</h3>
                     <p>Manage and track applications from both physical and online applicants.</p>
                 </div>
                 <button class="btn btn-primary" data-toggle="modal" data-target="#physicalAdmissionModal">
                     Add New Admission
                 </button>
             </div>
             <div class="card-body table-responsive p-2">

                 <table id="admissionsTable" class="table table-bordered table-hover text-nowrap">
                     <thead>
                         <tr>
                             <th>Applicant Name</th>
                             <th>Application ID</th>
                             <th>Admission Type</th>
                             <th>Grade</th>
                             <th>District</th>
                             <th>Citizenship</th>
                             <th>Application Year</th>
                             <th>Submission Date</th>
                             <th>Status</th>
                             <th>Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td>Chileshe Mwansa</td>
                             <td>ADM004</td>
                             <td>Physical</td>
                             <td>8</td>
                             <td>Lusaka</td>
                             <td>Zambian</td>
                             <td>2024</td>
                             <td>05 Jan, 2024</td>
                             <td>
                                 <span class="badge badge-warning">Pending</span>
                             </td>
                             <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                     data-target="#viewApplicantModal">View</button>
                                 <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="#" class="btn btn-success btn-sm">Approve</a>
                                 <a href="#" class="btn btn-danger btn-sm">Reject</a>
                             </td>


                         </tr>
                         <tr>
                             <td>Mutale Mulenga</td>
                             <td>ADM005</td>
                             <td>Online</td>
                             <td>10</td>
                             <td>Ndola</td>
                             <td>Zambian</td>
                             <td>2024</td>
                             <td>10 Feb, 2024</td>
                             <td>
                                 <span class="badge badge-success">Approved</span>
                             </td>
                             <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                     data-target="#viewApplicantModal">View</button>
                                 <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="#" class="btn btn-success btn-sm">Approve</a>
                                 <a href="#" class="btn btn-danger btn-sm">Reject</a>
                             </td>

                         </tr>
                         <tr>
                             <td>Katongo Bwalya</td>
                             <td>ADM006</td>
                             <td>Physical</td>
                             <td>8</td>
                             <td>Kitwe</td>
                             <td>Zambian</td>
                             <td>2024</td>
                             <td>12 Mar, 2024</td>
                             <td>
                                 <span class="badge badge-danger">Rejected</span>
                             </td>
                             <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                     data-target="#viewApplicantModal">View</button>
                                 <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="#" class="btn btn-success btn-sm">Approve</a>
                                 <a href="#" class="btn btn-danger btn-sm">Reject</a>
                             </td>

                         </tr>
                         <tr>
                             <td>Mbita Lungu</td>
                             <td>ADM007</td>
                             <td>Online</td>
                             <td>9</td>
                             <td>Livingstone</td>
                             <td>Zambian</td>
                             <td>2024</td>
                             <td>18 Apr, 2024</td>
                             <td>
                                 <span class="badge badge-warning">Pending</span>
                             </td>
                             <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                     data-target="#viewApplicantModal">View</button>
                                 <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="#" class="btn btn-success btn-sm">Approve</a>
                                 <a href="#" class="btn btn-danger btn-sm">Reject</a>
                             </td>

                         </tr>
                         <tr>
                             <td>Nchimunya Banda</td>
                             <td>ADM008</td>
                             <td>Physical</td>
                             <td>11</td>
                             <td>Choma</td>
                             <td>Zambian</td>
                             <td>2024</td>
                             <td>25 May, 2024</td>
                             <td>
                                 <span class="badge badge-success">Approved</span>
                             </td>
                             <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                     data-target="#viewApplicantModal">View</button>
                                 <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                 <a href="#" class="btn btn-success btn-sm">Approve</a>
                                 <a href="#" class="btn btn-danger btn-sm">Reject</a>
                             </td>

                         </tr>
                     </tbody>
                 </table>


             </div>
         </div>
     </div>


     <script>
         $(document).ready(function() {
             $('#admissionsTable').DataTable();

             // Modal form submission
             $('#physicalAdmissionForm').on('submit', function(e) {
                 e.preventDefault();
                 // Perform AJAX request to save physical admission data
                 alert('Physical admission saved successfully!');
                 $('#physicalAdmissionModal').modal('hide');
             });


             $(document).ready(function() {
                 $('#admissionsTable').on('click', '.btn-info', function() {
                     // Get the table row where the button was clicked
                     let row = $(this).closest('tr');

                     // Fetch data from the clicked row
                     let applicantName = row.find('td:nth-child(1)').text();
                     let applicationId = row.find('td:nth-child(2)').text();
                     let admissionType = row.find('td:nth-child(3)').text();
                     let grade = row.find('td:nth-child(4)').text();
                     let district = row.find('td:nth-child(5)').text();
                     let citizenship = row.find('td:nth-child(6)').text();
                     let applicationYear = row.find('td:nth-child(7)').text();
                     let submissionDate = row.find('td:nth-child(8)').text();
                     let status = row.find('td:nth-child(9) span').text();

                     // Populate the modal fields with data
                     $('#applicantName').text(applicantName);
                     $('#applicationId').text(applicationId);
                     $('#admissionType').text(admissionType);
                     $('#grade').text(grade);
                     $('#district').text(district);
                     $('#citizenship').text(citizenship);
                     $('#applicationYear').text(applicationYear);
                     $('#submissionDate').text(submissionDate);
                     $('#applicationStatus').text(status);
                     $('#applicationStatus').removeClass().addClass('badge badge-' + getStatusClass(
                         status));
                 });

                 // Function to assign a class to the status badge
                 function getStatusClass(status) {
                     switch (status.toLowerCase()) {
                         case 'approved':
                             return 'success';
                         case 'rejected':
                             return 'danger';
                         case 'pending':
                             return 'warning';
                         default:
                             return 'secondary';
                     }
                 }
             });

         });
     </script>

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
             <div class="modal fade" id="editDepositModal{{ $deposit->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="editDepositModalLabel{{ $deposit->id }}" aria-hidden="true">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="editDepositModalLabel{{ $deposit->id }}">
                                 Edit Deposit For: <span class="text-white">
                                     {{ $deposit->student->firstname . ' ' . $deposit->student->lastname . ' (' . $deposit->student->grade->gradeno . $deposit->student->grade->class_name . ')' ?? 'Unknown' }}</span>
                             </h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                 <button type="submit" class="btn btn-primary">Save Changes</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>

             <!-- Delete Modal -->
             <div class="modal fade" id="deleteDepositModal{{ $deposit->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="deleteDepositModalLabel{{ $deposit->id }}" aria-hidden="true">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="deleteDepositModalLabel{{ $deposit->id }}">
                                 Confirm Deletion</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="modal-body">
                             Are you sure you want to delete this deposit record for
                             <strong>{{ $deposit->student->firstname . ' ' . $deposit->student->lastname }}</strong>?
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                             <form action="{{ route('deposits.destroy', $deposit->id) }}" method="POST">
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
                                     <label for="withdraw_amount_{{ $deposit->id }}" class="form-label">Withdrawal
                                         Amount</label>
                                     <input type="number" class="form-control" id="withdraw_amount_{{ $deposit->id }}"
                                         name="withdraw_amount" min="1" max="{{ $deposit->current_amount }}"
                                         placeholder="Enter withdrawal amount" required>
                                 </div>

                                 <!-- Withdrawal Description -->
                                 <div class="mb-3">
                                     <label for="withdraw_description_{{ $deposit->id }}" class="form-label">Description
                                         (Optional)</label>
                                     <textarea class="form-control" id="withdraw_description_{{ $deposit->id }}" name="withdraw_description"
                                         rows="3" placeholder="Enter description (optional)"></textarea>
                                 </div>
                             </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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




     <!-- View More Modal -->
     <div class="modal fade" id="viewModal-{{ $student->id }}" tabindex="-1" role="dialog"
         aria-labelledby="viewModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="viewModalLabel">Student Details</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <!-- Pupil's Photo ID -->
                         <div class="col-md-4 text-center">
                             <img src="{{ $student->student_photo ? asset('storage/students/' . $student->student_photo) : '/path/to/default-photo.jpg' }}"
                                 id="modalPupilPhoto" class="img-fluid img-thumbnail" alt="Pupil Photo"
                                 style="max-width: 150px;">
                             <h6 class="mt-2">Pupil's Photo</h6>
                         </div>

                         <!-- Pupil's Details -->
                         <div class="col-md-8">
                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Exam Number: <strong id="modalExamNumber">{{ $student->ecz_no }}</strong>
                                     </h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>Pupil's Name: <strong id="modalPupilName">{{ $student->firstname }}
                                             {{ $student->lastname }}</strong></h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Grade: <strong id="modalGrade">{{ $student->grade->gradeno ?? 'N/A' }}</strong>
                                     </h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>Class: <strong id="modalClass">{{ $student->class_id }}</strong></h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Student Type: <strong id="modalStudentType">{{ $student->student_type }}</strong>
                                     </h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>D.O.B: <strong id="modalDOB">{{ $student->dob->format('d/m/Y') }}</strong>
                                     </h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Gender: <strong id="modalGender">{{ $student->gender }}</strong></h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>Siblings:
                                         <strong id="modalSiblings">
                                             @if ($student->siblings && $student->siblings->count() > 0)
                                                 @foreach ($student->siblings as $sibling)
                                                     {{ $sibling->firstname }}
                                                     {{ $sibling->lastname }}
                                                     ({{ $sibling->grade->name ?? 'N/A' }} - Class
                                                     {{ $sibling->class_id ?? 'N/A' }})
                                                     @if (!$loop->last)
                                                         ,
                                                     @endif
                                                 @endforeach
                                                 <br>
                                                 <strong>Total Siblings:</strong>
                                                 {{ $student->siblings->count() }}
                                             @else
                                                 None
                                             @endif
                                         </strong>
                                     </h6>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Guardian Name: <strong
                                             id="modalGuardianName">{{ $student->father_name ?? $student->mother_name }}</strong>
                                     </h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>Guardian Contact: <strong
                                             id="modalGuardianContact">{{ $student->father_phone ?? $student->mother_phone }}</strong>
                                     </h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">
                                     <h6>Residential Address: <strong
                                             id="modalResAddress">{{ $student->father_address ?? ($student->mother_address ?? 'N/A') }}</strong>
                                     </h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Hostel: <strong
                                             id="modalHostel">{{ $student->hostel->hostel_name ?? 'N/A' }}</strong>
                                     </h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>Bedspace: <strong
                                             id="modalBedspace">{{ $student->hostel->bedspace_no ?? 'N/A' }}</strong>
                                     </h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <h6>Medical Condition: <strong
                                             id="modalMedical">{{ $student->medical_condition ?? 'None' }}</strong>
                                     </h6>
                                 </div>
                                 <div class="col-md-6">
                                     <h6>Admission Date: <strong
                                             id="modalAdmission">{{ $student->admission_date->format('d/m/Y') }}</strong>
                                     </h6>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

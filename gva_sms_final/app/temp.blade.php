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
     <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentDetails">
         <thead class="">
             <tr>
                 <th>Exam Number</th>
                 <th>Pupil's Name</th>
                 <th>Grade</th>
                 <th>Student Type</th>
                 <th>Guardian/Parent</th>
                 <th>Enrollment Status</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             @foreach ($students as $student)
                 <tr>
                     <td>{{ $student->ecz_no ?? 'N/A' }}</td>
                     <td>
                         {{ $student->firstname ?? 'N/A' }} {{ $student->lastname ?? '' }}
                         - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                     </td>
                     <td>
                         {{ $student->grade->gradeno ?? 'N/A' }} {{ $student->grade->class_name ?? '' }}
                     </td>
                     <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                     <td>
                         <ul style="list-style-type: disc; margin: 0; padding-left: 20px;">
                             @foreach ($student->guardians as $guardian)
                                 <li>
                                     {{ $guardian->name }}
                                     @if ($guardian->contact_number)
                                         ({{ $guardian->contact_number }})
                                     @endif
                                 </li>
                             @endforeach
                         </ul>
                     </td>
                     <td>
                         <span class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : 'warning' }}">
                             {{ ucfirst($student->active_status) }}
                         </span>
                     </td>
                     <td>
                         <!-- Permission Button -->
                         <button class="btn custom-btn-permission" data-toggle="modal"
                             data-target="#permissionModal-{{ $student->id }}" title="Grant Permission">
                             <i class="fas fa-home"></i>
                         </button>

                         <!-- Clean-In Button -->
                         <button class="btn custom-btn-Clear-in" data-toggle="modal"
                             data-target="#ClearInModal-{{ $student->id }}" title="Clear-In">
                             <i class="fas fa-sign-in-alt"></i>
                         </button>

                         <!-- Clean-Out Button -->
                         <button class="btn custom-btn-Clear-out" data-toggle="modal"
                             data-target="#clearOutModal-{{ $student->id }}" title="Clear-Out">
                             <i class="fas fa-sign-out-alt"></i>
                         </button>

                         <!-- Disciplinary Action Button -->
                         <button class="btn custom-btn-disciplinary" data-toggle="modal"
                             data-target="#disciplinaryModal-{{ $student->id }}" title="Disciplinary Action">
                             <i class="fas fa-gavel"></i>
                         </button>
                     </td>

                 </tr>


                 {{-- MODALS  --}}
                 <!-- Permissions Modal -->
                 <div class="modal fade" id="permissionModal-{{ $student->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="permissionModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-ml" role="document">
                         <div class="modal-content">
                             <!-- Modal Header -->
                             <div class="modal-header">
                                 <h5 class="modal-title" id="permissionModalLabel">Grant Permission for
                                     <span class="text-bold text-white"> {{ $student->firstname ?? 'N/A' }}
                                         {{ $student->lastname ?? '' }}</span>
                                 </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <form id="grantPermissionForm-{{ $student->id }}"
                                 action="{{ route('student-home-permission.store') }}" method="POST">

                                 @csrf
                                 <!-- Modal Body -->
                                 <div class="modal-body">
                                     {{-- student_id --}}
                                     <!-- Hidden Fields -->
                                     <input type="hidden" name="student_id" value="{{ $student->id }}">
                                     <input type="hidden" name="approved_by" value="{{ auth()->user()->id }}">

                                     <div class="form-row">
                                         <div class="form-group col-md-12">
                                             <label for="term">Select Term</label>
                                             <select class="form-control form-control-sm" id="academic_term"
                                                 name="academic_term" required>
                                                 <option value="">--Select a term--</option>
                                                 @foreach ($terms as $term)
                                                     <option value="{{ $term['id'] }}">
                                                         {{ $term['name'] }}</option>
                                                 @endforeach
                                             </select>
                                         </div>

                                         <!-- Permission Dates and Time -->
                                         <div class="form-group col-md-6">
                                             <label for="permission_start">Permission Start Date</label>
                                             <input type="date" class="form-control form-control-sm"
                                                 id="permission_start-{{ $student->id }}" name="permission_start"
                                                 required>
                                         </div>
                                         <div class="form-group col-md-6">
                                             <label for="permission_end">Permission End Date</label>
                                             <input type="date" class="form-control form-control-sm"
                                                 id="permission_end-{{ $student->id }}" name="permission_end" required>
                                         </div>
                                         <div class="form-group col-md-6">
                                             <label for="pickup_time">Pick-Up Time</label>
                                             <input type="time" class="form-control form-control-sm"
                                                 id="pickup_time-{{ $student->id }}" name="pickup_time" required>
                                         </div>
                                         <div class="form-group col-md-6">
                                             <label for="pickup_person">Pick-Up Person</label>
                                             <select class="form-control form-control-sm"
                                                 id="pickup_person-{{ $student->id }}" name="pickup_person" required>
                                                 <option value="parent">Parent</option>
                                                 <option value="other">Other</option>
                                             </select>
                                         </div>

                                     </div>

                                     <!-- Additional Inputs for "Other" Pick-Up Person -->
                                     <div id="other_pickup_details-{{ $student->id }}" class="d-none">
                                         <div class="form-row">
                                             <div class="form-group col-md-6">
                                                 <label for="other_name">Name</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_name-{{ $student->id }}" name="other_name"
                                                     placeholder="Full Name">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="other_nrc">NRC</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                     placeholder="National Registration Card Number">
                                             </div>

                                             <div class="form-group col-md-6">
                                                 <label for="other_contact">Contact Number</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_contact-{{ $student->id }}" name="other_contact"
                                                     placeholder="e.g., 097xxxxxxx">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="vehicle_reg">Vehicle Registration #</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                     placeholder="Vehicle Registration Number">
                                             </div>
                                         </div>


                                     </div>

                                     <select name="parent_id" id="parent_id" class="form-control form-control-sm">
                                         <option value="">--Select a guardian--</option>
                                         @foreach ($student->guardians as $guardian)
                                             <option value="{{ $guardian->id }}">
                                                 {{ $guardian->name }} ({{ $guardian->contact_number }})
                                             </option>
                                         @endforeach
                                     </select>


                                     <div class="form-row">
                                         <!-- Reason for Pick-up -->
                                         <div class="form-group col-md-6">
                                             <label for="reason">Reason for Pick-Up</label>
                                             <textarea class="form-control form-control-sm" id="reason-{{ $student->id }}" name="reason" rows="3"
                                                 placeholder="Provide a reason for the pick-up" required></textarea>
                                         </div>
                                         <!-- Comment by Deputy -->
                                         <div class="form-group col-md-6">
                                             <label for="deputy_comment">Comment by Deputy</label>
                                             <textarea class="form-control form-control-sm" id="deputy_comment-{{ $student->id }}" name="deputy_comment"
                                                 rows="3" placeholder="Enter comments"></textarea>
                                         </div>
                                     </div>


                                 </div>

                                 <!-- Modal Footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary btn-sm"
                                         data-dismiss="modal">Cancel</button>
                                     <button type="submit" class="btn btn-danger btn-sm"
                                         form="grantPermissionForm-{{ $student->id }}">Grant
                                         Permission</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>

                 {{-- ClearIn modals --}}
                 <div class="modal fade" id="ClearInModal-{{ $student->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="ClearInModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-ml" role="document">
                         <div class="modal-content">
                             <!-- Modal Header -->
                             <div class="modal-header">
                                 <h5 class="modal-title" id="ClearInModalLabel">Clear-In for
                                     <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                         {{ $student->lastname ?? '' }}</span>
                                 </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>

                             <form id="clearInForm-{{ $student->id }}" action="{{ route('student-clear-in.store') }}"
                                 method="POST">
                                 @csrf

                                 <!-- Modal Body -->
                                 <div class="modal-body">
                                     <!-- Hidden Fields -->
                                     <input type="hidden" name="student_id" value="{{ $student->id }}">
                                     <input type="hidden" name="cleared_by" value="{{ auth()->user()->id }}">

                                     <!-- Term and Year Selection -->
                                     <div class="form-row">
                                         <div class="form-group col-md-12">
                                             <label for="term" class="small">Select Term</label>
                                             <select class="form-control form-control-sm"
                                                 id="academic_term-{{ $student->id }}" name="academic_term" required>
                                                 <option value="">--Select a term--</option>
                                                 @foreach ($terms as $term)
                                                     <option value="{{ $term['id'] }}">
                                                         {{ $term['name'] }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>

                                     <!-- Clearance Checklist -->
                                     <div class="form-row">
                                         <label class="small">Clearance From:</label>
                                         <div class="form-group col-md-4">
                                             <!-- Hidden input to send false if checkbox is unchecked -->
                                             <input type="hidden" name="clearance_accounts" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_accounts-{{ $student->id }}"
                                                     name="clearance_accounts" value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_accounts-{{ $student->id }}">
                                                     Accounts Office
                                                 </label>
                                             </div>

                                             <input type="hidden" name="clearance_secretary" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_secretary-{{ $student->id }}"
                                                     name="clearance_secretary" value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_secretary-{{ $student->id }}">
                                                     Secretary
                                                 </label>
                                             </div>
                                         </div>
                                         <div class="form-group col-md-4">
                                             <input type="hidden" name="clearance_search" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_search-{{ $student->id }}" name="clearance_search"
                                                     value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_search-{{ $student->id }}">
                                                     Search Team
                                                 </label>
                                             </div>

                                             <input type="hidden" name="clearance_patron" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_patron-{{ $student->id }}" name="clearance_patron"
                                                     value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_patron-{{ $student->id }}">
                                                     Patron
                                                 </label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-md-12">
                                             <label for="clearIn_person" class="small">Clear-In
                                                 Guardian</label>
                                             <select class="form-control form-control-sm"
                                                 id="clearIn_person-{{ $student->id }}" name="clearIn_person" required>
                                                 <option value="">--Select--</option>
                                                 <option value="parent">Parent</option>
                                                 <option value="other">Other</option>
                                             </select>
                                         </div>

                                         <!-- Check-In Time -->
                                         <div class="form-group col-md-12">
                                             <label for="check_in_time-{{ $student->id }}" class="small">Check-In
                                                 Time</label>
                                             <input type="time" class="form-control form-control-sm"
                                                 id="check_in_time-{{ $student->id }}" name="check_in_time" required>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="hostel_name" class="small">Hostel
                                                     Name</label>
                                                 <select class="form-control form-control-sm"
                                                     id="hostel_name-{{ $student->id }}" name="hostel_id"
                                                     {{ $student->hostel ? 'disabled' : '' }}>
                                                     <option value="">Select Hostel</option>
                                                     @foreach ($hostels as $hostel)
                                                         <option value="{{ $hostel->id }}"
                                                             {{ $student->hostel && $student->hostel->id == $hostel->id ? 'selected' : '' }}>
                                                             {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                         </option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="bedspaceSelect" class="small">Bedspace
                                                     Number</label>
                                                 <select class="form-control form-control-sm"
                                                     id="bedspaceSelect-{{ $student->id }}" name="bedspace_id"
                                                     {{ $student->bedspace ? 'disabled' : '' }}>
                                                     <option value="">Select Bedspace</option>
                                                     @if ($student->bedspace)
                                                         <option value="{{ $student->bedspace->id }}" selected>
                                                             {{ $student->bedspace->bedspace_no }}
                                                         </option>
                                                     @endif
                                                 </select>
                                             </div>
                                         </div>



                                     </div>


                                     <div id="other_clearIn_details-{{ $student->id }}" class="d-none">
                                         <div class="form-row">
                                             <div class="form-group col-md-6">
                                                 <label for="other_name">Name</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_name-{{ $student->id }}" name="other_name"
                                                     placeholder="Full Name">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="other_nrc">NRC</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                     placeholder="National Registration Card Number">
                                             </div>

                                             <div class="form-group col-md-6">
                                                 <label for="other_contact">Contact Number</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_contact-{{ $student->id }}" name="other_contact"
                                                     placeholder="e.g., 097xxxxxxx">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="vehicle_reg">Vehicle Registration #</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                     placeholder="Vehicle Registration Number">
                                             </div>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="brought_by_relationship">brought-by-relationship</label>
                                             <select class="form-control form-control-sm"
                                                 id="brought_by_relationship-{{ $student->id }}"
                                                 name="brought_by_relationship">
                                                 <option value="">--Select--</option>
                                                 <option value="brother">Brother</option>
                                                 <option value="sister">Sister</option>
                                                 <option value="uncle">Uncle</option>
                                                 <option value="driver">Driver</option>
                                                 <option value="other">Other</option>
                                             </select>
                                         </div>


                                     </div>

                                     <div class="form-group" id="parent_idCheckIn">
                                         <select name="parent_id" class="form-control form-control-sm">
                                             <option value="">--Select a guardian--</option>
                                             @foreach ($student->guardians as $guardian)
                                                 <option value="{{ $guardian->id }}">
                                                     {{ $guardian->name }}
                                                     ({{ $guardian->contact_number }})
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>

                                 <!-- Modal Footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary btn-sm"
                                         data-dismiss="modal">Cancel</button>
                                     <button type="submit" class="btn btn-success btn-sm"
                                         form="clearInForm-{{ $student->id }}">
                                         Clear-In
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             @endforeach
         </tbody>

     </table>







     <div class="table accent-blue">
         <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentDetails">
             <thead>
                 <tr>
                     {{-- <th>Exam Number</th> --}}
                     <th>Pupil's Name (Gender)</th>
                     <th>Grade</th>
                     <th>Student Type</th>
                     {{-- <th>Guardian/Parent</th> --}}
                     <th>Hostel (Bedspace #)</th>
                     {{-- <th>Bedspace Number</th> --}}
                     <th>Check-In Status</th>
                     <th>Check-In Date</th>
                     <th>Enrollment Status</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($students as $student)
                     @php
                         $latestCheckIn = $student->checkIns->last();
                         $checkInStatus = $latestCheckIn ? 'check_in' : 'check_out';
                         $checkInDate = $latestCheckIn ? $latestCheckIn->created_at->format('Y-m-d') : 'N/A';
                     @endphp
                     <tr>
                         {{-- <td>{{ $student->ecz_no ?? 'N/A' }}</td> --}}
                         <td>
                             {{ $student->firstname ?? 'N/A' }} {{ $student->lastname ?? '' }}
                             - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                         </td>
                         <td>
                             {{ $student->grade->gradeno ?? 'N/A' }} {{ $student->grade->class_name ?? '' }}
                         </td>
                         <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                         {{-- <td>
                                            <ul style="list-style-type: disc; margin: 0; padding-left: 20px;">
                                                @foreach ($student->guardians as $guardian)
                                                    <li>
                                                        {{ $guardian->name }}
                                                        @if ($guardian->contact_number)
                                                            ({{ $guardian->contact_number }})
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td> --}}
                         <td>
                             {{ optional(optional($student->checkIns->last())->hostel)->hostel_name ?? 'N/A' }}
                             -
                             {{ optional(optional($student->checkIns->last())->bedspace)->bedspace_no ?? 'N/A' }}


                         </td>
                         {{-- <td></td> --}}
                         <td>
                             {{ $student->latestCheckInCheckout->bedspace_id }}

                             {{-- @if ($student->latestCheckInCheckout->room_status === 'check_in')
                                                <span class="badge badge-success">Checked In</span>
                                            @else
                                                <span class="badge badge-danger">Not Checked In</span>
                                            @endif --}}
                         </td>
                         <td>{{ $checkInDate }}</td>
                         <td>
                             <span
                                 class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : 'warning' }}">
                                 {{ ucfirst($student->active_status) }}
                                 {{-- {{$student->checkIns->room_status}} --}}
                             </span>
                         </td>
                         <td>
                             <!-- Permission Button -->
                             <button class="btn custom-btn-permission" data-toggle="modal"
                                 data-target="#permissionModal-{{ $student->id }}" title="Grant Permission">
                                 <i class="fas fa-home"></i>
                             </button>

                             <!-- Clear-In Button -->
                             <button class="btn custom-btn-clear-in" data-toggle="modal"
                                 data-target="#ClearInModal-{{ $student->id }}" title="Clear-In"
                                 {{ $checkInStatus === 'check_in' || $student->student_type === 'Day-Scholar' ? 'disabled' : '' }}>
                                 <i class="fas fa-sign-in-alt"></i>
                             </button>

                             <!-- Clear-Out Button -->
                             <button class="btn custom-btn-clear-out" data-toggle="modal"
                                 data-target="#clearOutModal-{{ $student->id }}" title="Clear-Out"
                                 {{ $student->student_type === 'Day-Scholar' ? 'disabled' : '' }}>
                                 <i class="fas fa-sign-out-alt"></i>
                             </button>

                             <!-- Disciplinary Action Button -->
                             <button class="btn custom-btn-disciplinary" data-toggle="modal"
                                 data-target="#disciplinaryModal-{{ $student->id }}" title="Disciplinary Action">
                                 <i class="fas fa-gavel"></i>
                             </button>
                         </td>
                     </tr>



                     <!-- Permissions Modal -->
                     <div class="modal fade" id="permissionModal-{{ $student->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="permissionModalLabel" aria-hidden="true">
                         <div class="modal-dialog modal-ml" role="document">
                             <div class="modal-content">
                                 <!-- Modal Header -->
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="permissionModalLabel">Grant Permission for
                                         <span class="text-bold text-white">
                                             {{ $student->firstname ?? 'N/A' }}
                                             {{ $student->lastname ?? '' }}</span>
                                     </h5>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                     </button>
                                 </div>
                                 <form id="grantPermissionForm-{{ $student->id }}"
                                     action="{{ route('student-home-permission.store') }}" method="POST">

                                     @csrf
                                     <!-- Modal Body -->
                                     <div class="modal-body">
                                         {{-- student_id --}}
                                         <!-- Hidden Fields -->
                                         <input type="hidden" name="student_id" value="{{ $student->id }}">
                                         <input type="hidden" name="approved_by" value="{{ auth()->user()->id }}">

                                         <div class="form-row">
                                             <div class="form-group col-md-12">
                                                 <label for="term">Select Term</label>
                                                 <select class="form-control form-control-sm" id="academic_term"
                                                     name="academic_term" required>
                                                     <option value="">--Select a term--</option>
                                                     @foreach ($terms as $term)
                                                         <option value="{{ $term['id'] }}">
                                                             {{ $term['name'] }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>

                                             <!-- Permission Dates and Time -->
                                             <div class="form-group col-md-6">
                                                 <label for="permission_start">Permission Start Date</label>
                                                 <input type="date" class="form-control form-control-sm"
                                                     id="permission_start-{{ $student->id }}" name="permission_start"
                                                     required>
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="permission_end">Permission End Date</label>
                                                 <input type="date" class="form-control form-control-sm"
                                                     id="permission_end-{{ $student->id }}" name="permission_end"
                                                     required>
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="pickup_time">Pick-Up Time</label>
                                                 <input type="time" class="form-control form-control-sm"
                                                     id="pickup_time-{{ $student->id }}" name="pickup_time" required>
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="pickup_person">Pick-Up Person</label>
                                                 <select class="form-control form-control-sm"
                                                     id="pickup_person-{{ $student->id }}" name="pickup_person"
                                                     required>
                                                     <option value="parent">Parent</option>
                                                     <option value="other">Other</option>
                                                 </select>
                                             </div>

                                         </div>

                                         <!-- Additional Inputs for "Other" Pick-Up Person -->
                                         <div id="other_pickup_details-{{ $student->id }}" class="d-none">
                                             <div class="form-row">
                                                 <div class="form-group col-md-6">
                                                     <label for="other_name">Name</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_name-{{ $student->id }}" name="other_name"
                                                         placeholder="Full Name">
                                                 </div>
                                                 <div class="form-group col-md-6">
                                                     <label for="other_nrc">NRC</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                         placeholder="National Registration Card Number">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                     <label for="other_contact">Contact Number</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_contact-{{ $student->id }}" name="other_contact"
                                                         placeholder="e.g., 097xxxxxxx">
                                                 </div>
                                                 <div class="form-group col-md-6">
                                                     <label for="vehicle_reg">Vehicle Registration #</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                         placeholder="Vehicle Registration Number">
                                                 </div>
                                             </div>


                                         </div>

                                         <select name="parent_id" id="parent_id" class="form-control form-control-sm">
                                             <option value="">--Select a guardian--</option>
                                             @foreach ($student->guardians as $guardian)
                                                 <option value="{{ $guardian->id }}">
                                                     {{ $guardian->name }}
                                                     ({{ $guardian->contact_number }})
                                                 </option>
                                             @endforeach
                                         </select>


                                         <div class="form-row">
                                             <!-- Reason for Pick-up -->
                                             <div class="form-group col-md-6">
                                                 <label for="reason">Reason for Pick-Up</label>
                                                 <textarea class="form-control form-control-sm" id="reason-{{ $student->id }}" name="reason" rows="3"
                                                     placeholder="Provide a reason for the pick-up" required></textarea>
                                             </div>
                                             <!-- Comment by Deputy -->
                                             <div class="form-group col-md-6">
                                                 <label for="deputy_comment">Comment by Deputy</label>
                                                 <textarea class="form-control form-control-sm" id="deputy_comment-{{ $student->id }}" name="deputy_comment"
                                                     rows="3" placeholder="Enter comments"></textarea>
                                             </div>
                                         </div>


                                     </div>

                                     <!-- Modal Footer -->
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary btn-sm"
                                             data-dismiss="modal">Cancel</button>
                                         <button type="submit" class="btn btn-danger btn-sm"
                                             form="grantPermissionForm-{{ $student->id }}">Grant
                                             Permission</button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>

                     {{-- ClearIn modals --}}
                     <div class="modal fade" id="ClearInModal-{{ $student->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="ClearInModalLabel" aria-hidden="true">
                         <div class="modal-dialog modal-ml" role="document">
                             <div class="modal-content">
                                 <!-- Modal Header -->
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="ClearInModalLabel">Clear-In for
                                         <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                             {{ $student->lastname ?? '' }}</span>
                                     </h5>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                     </button>
                                 </div>

                                 <form id="clearInForm-{{ $student->id }}"
                                     action="{{ route('student-clear-in.store') }}" method="POST">
                                     @csrf

                                     <!-- Modal Body -->
                                     <div class="modal-body">
                                         <!-- Hidden Fields -->
                                         <input type="hidden" name="student_id" value="{{ $student->id }}">
                                         <input type="hidden" name="cleared_by" value="{{ auth()->user()->id }}">

                                         <!-- Term and Year Selection -->
                                         <div class="form-row">
                                             <div class="form-group col-md-12">
                                                 <label for="term" class="small">Select Term</label>
                                                 <select class="form-control form-control-sm"
                                                     id="academic_term-{{ $student->id }}" name="academic_term"
                                                     required>
                                                     <option value="">--Select a term--</option>
                                                     @foreach ($terms as $term)
                                                         <option value="{{ $term['id'] }}">
                                                             {{ $term['name'] }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>

                                         <!-- Clearance Checklist -->
                                         <div class="form-row">
                                             <label class="small">Clearance From:</label>
                                             <div class="form-group col-md-4">
                                                 <!-- Hidden input to send false if checkbox is unchecked -->
                                                 <input type="hidden" name="clearance_accounts" value="false">
                                                 <div class="form-check">
                                                     <input class="form-check-input" type="checkbox"
                                                         id="clearance_accounts-{{ $student->id }}"
                                                         name="clearance_accounts" value="true">
                                                     <label class="form-check-label"
                                                         for="clearance_accounts-{{ $student->id }}">
                                                         Accounts Office
                                                     </label>
                                                 </div>

                                                 <input type="hidden" name="clearance_secretary" value="false">
                                                 <div class="form-check">
                                                     <input class="form-check-input" type="checkbox"
                                                         id="clearance_secretary-{{ $student->id }}"
                                                         name="clearance_secretary" value="true">
                                                     <label class="form-check-label"
                                                         for="clearance_secretary-{{ $student->id }}">
                                                         Secretary
                                                     </label>
                                                 </div>
                                             </div>
                                             <div class="form-group col-md-4">
                                                 <input type="hidden" name="clearance_search" value="false">
                                                 <div class="form-check">
                                                     <input class="form-check-input" type="checkbox"
                                                         id="clearance_search-{{ $student->id }}"
                                                         name="clearance_search" value="true">
                                                     <label class="form-check-label"
                                                         for="clearance_search-{{ $student->id }}">
                                                         Search Team
                                                     </label>
                                                 </div>

                                                 <input type="hidden" name="clearance_patron" value="false">
                                                 <div class="form-check">
                                                     <input class="form-check-input" type="checkbox"
                                                         id="clearance_patron-{{ $student->id }}"
                                                         name="clearance_patron" value="true">
                                                     <label class="form-check-label"
                                                         for="clearance_patron-{{ $student->id }}">
                                                         Patron
                                                     </label>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="form-group col-md-12">
                                                 <label for="clearIn_person" class="small">Clear-In
                                                     Guardian</label>
                                                 <select class="form-control form-control-sm"
                                                     id="clearIn_person-{{ $student->id }}" name="clearIn_person"
                                                     required>
                                                     <option value="">--Select--</option>
                                                     <option value="parent">Parent</option>
                                                     <option value="other">Other</option>
                                                 </select>
                                             </div>

                                             <!-- Check-In Time -->
                                             <div class="form-group col-md-12">
                                                 <label for="check_in_time-{{ $student->id }}" class="small">Check-In
                                                     Time</label>
                                                 <input type="time" class="form-control form-control-sm"
                                                     id="check_in_time-{{ $student->id }}" name="check_in_time"
                                                     required>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="hostel_name" class="small">Hostel
                                                         Name</label>
                                                     <select class="form-control form-control-sm"
                                                         id="hostel_name-{{ $student->id }}" name="hostel_id"
                                                         {{ $student->hostel ? 'disabled' : '' }}>
                                                         <option value="">Select Hostel</option>
                                                         @foreach ($hostels as $hostel)
                                                             <option value="{{ $hostel->id }}"
                                                                 {{ $student->hostel && $student->hostel->id == $hostel->id ? 'selected' : '' }}>
                                                                 {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                             </option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="bedspaceSelect" class="small">Bedspace
                                                         Number</label>
                                                     <select class="form-control form-control-sm"
                                                         id="bedspaceSelect-{{ $student->id }}" name="bedspace_id"
                                                         {{ $student->bedspace ? 'disabled' : '' }}>
                                                         <option value="">Select Bedspace</option>
                                                         @if ($student->bedspace)
                                                             <option value="{{ $student->bedspace->id }}" selected>
                                                                 {{ $student->bedspace->bedspace_no }}
                                                             </option>
                                                         @endif
                                                     </select>
                                                 </div>
                                             </div>



                                         </div>


                                         <div id="other_clearIn_details-{{ $student->id }}" class="d-none">
                                             <div class="form-row">
                                                 <div class="form-group col-md-6">
                                                     <label for="other_name">Name</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_name-{{ $student->id }}" name="other_name"
                                                         placeholder="Full Name">
                                                 </div>
                                                 <div class="form-group col-md-6">
                                                     <label for="other_nrc">NRC</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                         placeholder="National Registration Card Number">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                     <label for="other_contact">Contact Number</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_contact-{{ $student->id }}" name="other_contact"
                                                         placeholder="e.g., 097xxxxxxx">
                                                 </div>
                                                 <div class="form-group col-md-6">
                                                     <label for="vehicle_reg">Vehicle Registration #</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                         placeholder="Vehicle Registration Number">
                                                 </div>
                                             </div>
                                             <div class="form-group col-md-12">
                                                 <label for="brought_by_relationship">brought-by-relationship</label>
                                                 <select class="form-control form-control-sm"
                                                     id="brought_by_relationship-{{ $student->id }}"
                                                     name="brought_by_relationship">
                                                     <option value="">--Select--</option>
                                                     <option value="brother">Brother</option>
                                                     <option value="sister">Sister</option>
                                                     <option value="uncle">Uncle</option>
                                                     <option value="driver">Driver</option>
                                                     <option value="other">Other</option>
                                                 </select>
                                             </div>


                                         </div>

                                         <div class="form-group" id="parent_idCheckIn">
                                             <select name="parent_id" class="form-control form-control-sm">
                                                 <option value="">--Select a guardian--</option>
                                                 @foreach ($student->guardians as $guardian)
                                                     <option value="{{ $guardian->id }}">
                                                         {{ $guardian->name }}
                                                         ({{ $guardian->contact_number }})
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>

                                     <!-- Modal Footer -->
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary btn-sm"
                                             data-dismiss="modal">Cancel</button>
                                         <button type="submit" class="btn btn-success btn-sm"
                                             form="clearInForm-{{ $student->id }}">
                                             Clear-In
                                         </button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>

                     <!-- Clear-Out Modal -->
                     <div class="modal fade" id="clearOutModal-{{ $student->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="clearOutModalLabel-{{ $student->id }}" aria-hidden="true">
                         <div class="modal-dialog modal-md" role="document">
                             <div class="modal-content">
                                 <!-- Modal Header -->
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="clearOutModalLabel-{{ $student->id }}">
                                         Clear-Out For:
                                         <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                             {{ $student->lastname ?? '' }}</span>
                                     </h5>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                     </button>
                                 </div>

                                 <!-- Modal Form -->
                                 <form id="clearOutForm-{{ $student->id }}"
                                     action="{{ route('student-clear-out.store') }}" method="POST">
                                     @csrf

                                     <!-- Modal Body -->
                                     <div class="modal-body">
                                         <!-- Hidden Fields -->
                                         <input type="hidden" name="student_id" value="{{ $student->id }}">
                                         <input type="hidden" name="cleared_by" value="{{ auth()->user()->id }}">

                                         <!-- Term and Year Selection -->
                                         <div class="form-row">
                                             <div class="form-group col-md-12">
                                                 <label for="term" class="small">Select Term</label>
                                                 <select class="form-control form-control-sm"
                                                     id="academic_term-{{ $student->id }}" name="academic_term"
                                                     required>
                                                     <option value="">--Select a term--</option>
                                                     @foreach ($terms as $term)
                                                         <option value="{{ $term['id'] }}">
                                                             {{ $term['name'] }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>

                                         <!-- Clear-Out Time -->
                                         <div class="form-row">
                                             <div class="form-group col-md-12">
                                                 <label for="check_out_time-{{ $student->id }}"
                                                     class="small">Clear-Out Time</label>
                                                 <input type="time" class="form-control form-control-sm"
                                                     id="check_out_time-{{ $student->id }}" name="check_out_time"
                                                     required>
                                             </div>
                                         </div>

                                         <!-- Clear-Out Guardian Dropdown -->
                                         <div class="form-row">
                                             <div class="form-group col-md-12">
                                                 <label for="clearOut_person-{{ $student->id }}"
                                                     class="small">Clear-Out Guardian</label>
                                                 <select class="form-control form-control-sm"
                                                     id="clearOut_person-{{ $student->id }}" name="clearOut_person"
                                                     required>
                                                     <option value="">--Select--</option>
                                                     <option value="parent">Parent</option>
                                                     <option value="other">Other</option>
                                                 </select>
                                             </div>
                                         </div>

                                         <!-- Parent ID Selection -->
                                         <div class="form-group" id="parent_id_wrapper-{{ $student->id }}">
                                             <label for="parent_id" class="small">Select Guardian</label>
                                             <select name="parent_id" class="form-control form-control-sm">
                                                 <option value="">--Select a guardian--</option>
                                                 @foreach ($student->guardians as $guardian)
                                                     <option value="{{ $guardian->id }}">
                                                         {{ $guardian->name }}
                                                         ({{ $guardian->contact_number }})
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>

                                         <!-- Additional Guardian or Vehicle Details -->
                                         <div id="other_clearOut_details-{{ $student->id }}" class="d-none">
                                             <div class="form-row">
                                                 <div class="form-group col-md-6">
                                                     <label for="other_name">Name</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_name-{{ $student->id }}" name="other_name"
                                                         placeholder="Full Name">
                                                 </div>
                                                 <div class="form-group col-md-6">
                                                     <label for="other_nrc">NRC</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                         placeholder="National Registration Card Number">
                                                 </div>

                                                 <div class="form-group col-md-6">
                                                     <label for="other_contact">Contact Number</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="other_contact-{{ $student->id }}" name="other_contact"
                                                         placeholder="e.g., 097xxxxxxx">
                                                 </div>
                                                 <div class="form-group col-md-6">
                                                     <label for="vehicle_reg">Vehicle Registration #</label>
                                                     <input type="text" class="form-control form-control-sm"
                                                         id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                         placeholder="Vehicle Registration Number">
                                                 </div>
                                             </div>
                                             <div class="form-group col-md-12">
                                                 <label for="brought_by_relationship">Brought By
                                                     Relationship</label>
                                                 <select class="form-control form-control-sm"
                                                     id="brought_by_relationship-{{ $student->id }}"
                                                     name="brought_by_relationship">
                                                     <option value="">--Select--</option>
                                                     <option value="brother">Brother</option>
                                                     <option value="sister">Sister</option>
                                                     <option value="uncle">Uncle</option>
                                                     <option value="driver">Driver</option>
                                                     <option value="other">Other</option>
                                                 </select>
                                             </div>
                                         </div>

                                     </div>

                                     <!-- Modal Footer -->
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary btn-sm"
                                             data-dismiss="modal">Cancel</button>
                                         <button type="submit" class="btn btn-danger btn-sm"
                                             form="clearOutForm-{{ $student->id }}">Clear-Out</button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 @endforeach
             </tbody>
         </table>



     </div>



     <!-- Permissions Modal -->
     <div class="modal fade" id="permissionModal-{{ $student->id }}" tabindex="-1" role="dialog"
         aria-labelledby="permissionModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-ml" role="document">
             <div class="modal-content">
                 <!-- Modal Header -->
                 <div class="modal-header">
                     <h5 class="modal-title" id="permissionModalLabel">Grant
                         Permission for
                         <span class="text-bold text-white">
                             {{ $student->firstname ?? 'N/A' }}
                             {{ $student->lastname ?? '' }}</span>
                     </h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <form id="grantPermissionForm-{{ $student->id }}"
                     action="{{ route('student-home-permission.store') }}" method="POST">

                     @csrf
                     <!-- Modal Body -->
                     <div class="modal-body">
                         {{-- student_id --}}
                         <!-- Hidden Fields -->
                         <input type="hidden" name="student_id" value="{{ $student->id }}">
                         <input type="hidden" name="approved_by" value="{{ auth()->user()->id }}">

                         <div class="form-row">
                             <div class="form-group col-md-12">
                                 <label for="term">Select Term</label>
                                 <select class="form-control form-control-sm" id="academic_term" name="academic_term"
                                     required>
                                     <option value="">--Select a term--
                                     </option>
                                     @foreach ($terms as $term)
                                         <option value="{{ $term['id'] }}">
                                             {{ $term['name'] }}</option>
                                     @endforeach
                                 </select>
                             </div>

                             <!-- Permission Dates and Time -->
                             <div class="form-group col-md-6">
                                 <label for="permission_start">Permission Start
                                     Date</label>
                                 <input type="date" class="form-control form-control-sm"
                                     id="permission_start-{{ $student->id }}" name="permission_start" required>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="permission_end">Permission End
                                     Date</label>
                                 <input type="date" class="form-control form-control-sm"
                                     id="permission_end-{{ $student->id }}" name="permission_end" required>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="pickup_time">Pick-Up Time</label>
                                 <input type="time" class="form-control form-control-sm"
                                     id="pickup_time-{{ $student->id }}" name="pickup_time" required>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="pickup_person">Pick-Up
                                     Person</label>
                                 <select class="form-control form-control-sm" id="pickup_person-{{ $student->id }}"
                                     name="pickup_person" required>
                                     <option value="parent">Parent</option>
                                     <option value="other">Other</option>
                                 </select>
                             </div>

                         </div>

                         <!-- Additional Inputs for "Other" Pick-Up Person -->
                         <div id="other_pickup_details-{{ $student->id }}" class="d-none">
                             <div class="form-row">
                                 <div class="form-group col-md-6">
                                     <label for="other_name">Name</label>
                                     <input type="text" class="form-control form-control-sm"
                                         id="other_name-{{ $student->id }}" name="other_name"
                                         placeholder="Full Name">
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="other_nrc">NRC</label>
                                     <input type="text" class="form-control form-control-sm"
                                         id="other_nrc-{{ $student->id }}" name="other_nrc"
                                         placeholder="National Registration Card Number">
                                 </div>

                                 <div class="form-group col-md-6">
                                     <label for="other_contact">Contact
                                         Number</label>
                                     <input type="text" class="form-control form-control-sm"
                                         id="other_contact-{{ $student->id }}" name="other_contact"
                                         placeholder="e.g., 097xxxxxxx">
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="vehicle_reg">Vehicle
                                         Registration #</label>
                                     <input type="text" class="form-control form-control-sm"
                                         id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                         placeholder="Vehicle Registration Number">
                                 </div>
                             </div>


                         </div>

                         <select name="parent_id" id="parent_id" class="form-control form-control-sm">
                             <option value="">--Select a guardian--
                             </option>
                             @foreach ($student->guardians as $guardian)
                                 <option value="{{ $guardian->id }}">
                                     {{ $guardian->name }}
                                     ({{ $guardian->contact_number }})
                                 </option>
                             @endforeach
                         </select>


                         <div class="form-row">
                             <!-- Reason for Pick-up -->
                             <div class="form-group col-md-6">
                                 <label for="reason">Reason for
                                     Pick-Up</label>
                                 <textarea class="form-control form-control-sm" id="reason-{{ $student->id }}" name="reason" rows="3"
                                     placeholder="Provide a reason for the pick-up" required></textarea>
                             </div>
                             <!-- Comment by Deputy -->
                             <div class="form-group col-md-6">
                                 <label for="deputy_comment">Comment by
                                     Deputy</label>
                                 <textarea class="form-control form-control-sm" id="deputy_comment-{{ $student->id }}" name="deputy_comment"
                                     rows="3" placeholder="Enter comments"></textarea>
                             </div>

                         </div>
                         <div class="form-group col-md-12">
                             <label for="permission_status" class="d-block">Select Status</label>
                             <select class="form-control form-control-sm" id="permission_status"
                                 name="permission_status" required>
                                 <option value="">--Select Status--
                                 </option>
                                 <option value="permission_granted">On
                                     Permission</option>
                                 <option value="permission_rejected">
                                     Rejected Permission</option>
                                 <option value="permission_pending">Pending
                                     Permissions</option>
                                 <option value="permission_expired">Expired
                                     Permissions</option>
                             </select>
                         </div>


                     </div>

                     <!-- Modal Footer -->
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                         <button type="submit" class="btn btn-danger btn-sm"
                             form="grantPermissionForm-{{ $student->id }}">Save Permission</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>






     <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentDetails">
         <thead>
             <tr>
                 {{-- <th>Exam Number</th> --}}
                 <th>Pupil's Name (Gender)</th>
                 <th>Grade</th>
                 <th>Student Type</th>
                 <th>Year-Term</th>
                 <th>Hostel (Bedspace #)</th>
                 <th>Check-In Status</th>
                 <th>Enrollment Status</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             @foreach ($students as $student)
                 @php
                     // Get the latest check-in for the student
                     $latestCheckIn = $student->checkIns->last();
                     $roomStatus = $latestCheckIn ? $latestCheckIn->room_status : null;
                     $isDayScholar = $student->student_type === 'Day-Scholar';
                     $checkInDate = $latestCheckIn ? $latestCheckIn->created_at->format('d-m-Y') : 'N/A';
                 @endphp
                 <tr>
                     <td>
                         {{ $student->firstname ?? 'N/A' }}
                         {{ $student->lastname ?? '' }}
                         - {{ ucfirst('(' . $student->gender . ')' ?? 'N/A') }}
                     </td>
                     <td>
                         {{ $student->grade->gradeno ?? 'N/A' }}
                         {{ $student->grade->class_name ?? '' }}
                     </td>
                     <td>{{ ucfirst($student->student_type ?? 'N/A') }}</td>
                     <td>
                         @if ($student->termlyReports->isNotEmpty())
                             @foreach ($student->termlyReports as $report)
                                 <div>
                                     {{ $report->academicYear->academic_year ?? 'N/A' }} -
                                     Term {{ $report->term_number ?? 'N/A' }}
                                 </div>
                             @endforeach
                         @else
                             No Reports Available
                         @endif
                     </td>

                     <td>
                         {{ optional(optional($student->checkIns->last())->hostel)->hostel_name ?? 'N/A' }}
                         -
                         {{ optional(optional($student->checkIns->last())->bedspace)->bedspace_no ?? 'N/A' }}
                     </td>
                     <td>
                         @php
                             $latestCheckIn = $student->checkIns->last(); // Get the most recent check-in
                         @endphp
                         {{ $latestCheckIn ? ucfirst($latestCheckIn->room_status) : 'No Record' }}
                     </td>
                     {{-- <td>{{ $checkInDate }}</td> --}}
                     <td>
                         <span class="badge badge-{{ $student->active_status === 'enrolled' ? 'success' : 'warning' }}">
                             {{ ucfirst($student->active_status) }}
                         </span>
                     </td>
                     <td>
                         <!-- Clear-In Button -->
                         {{-- Conditional button based on room_status and student_type --}}
                         <button class="btn custom-btn-clear-in" data-toggle="modal"
                             data-target="#ClearInModal-{{ $student->id }}" title="Clear-In"
                             {{ $roomStatus === 'checked_in' || $isDayScholar ? 'disabled' : '' }}>
                             <i class="fas fa-sign-in-alt"></i>
                         </button>

                         <!-- Clear-Out Button -->
                         <button class="btn custom-btn-clear-out" data-toggle="modal"
                             data-target="#clearOutModal-{{ $student->id }}" title="Clear-Out"
                             {{ $roomStatus === 'checked_out' || $isDayScholar ? 'disabled' : '' }}>
                             <i class="fas fa-sign-out-alt"></i>
                         </button>
                     </td>
                 </tr>
                 {{-- ClearIn modals --}}
                 <div class="modal fade" id="ClearInModal-{{ $student->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="ClearInModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-ml" role="document">
                         <div class="modal-content">
                             <!-- Modal Header -->
                             <div class="modal-header">
                                 <h5 class="modal-title" id="ClearInModalLabel">Clear-In
                                     for
                                     <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                         {{ $student->lastname ?? '' }}</span>
                                 </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>

                             <form id="clearInForm-{{ $student->id }}"
                                 action="{{ route('student-clear-in.store') }}" method="POST">
                                 @csrf

                                 <!-- Modal Body -->
                                 <div class="modal-body">
                                     <!-- Hidden Fields -->
                                     <input type="hidden" name="student_id" value="{{ $student->id }}">
                                     <input type="hidden" name="cleared_by" value="{{ auth()->user()->id }}">

                                     <!-- Term and Year Selection -->
                                     <div class="form-row">
                                         <div class="form-group col-md-12">
                                             <label for="term" class="small">Select
                                                 Term</label>
                                             <select class="form-control form-control-sm"
                                                 id="academic_term-{{ $student->id }}" name="academic_term" required>
                                                 <option value="">--Select a term--
                                                 </option>
                                                 @foreach ($academicYears as $year)
                                                     @foreach ($year->terms as $term)
                                                         <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                             {{ $year->academic_year }} - Term
                                                             {{ $term->term_number }}
                                                         </option>
                                                     @endforeach
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>

                                     <!-- Clearance Checklist -->
                                     <div class="form-row">
                                         <label class="small">Clearance From:</label>
                                         <div class="form-group col-md-4">
                                             <!-- Hidden input to send false if checkbox is unchecked -->
                                             <input type="hidden" name="clearance_accounts" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_accounts-{{ $student->id }}"
                                                     name="clearance_accounts" value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_accounts-{{ $student->id }}">
                                                     Accounts Office
                                                 </label>
                                             </div>

                                             <input type="hidden" name="clearance_secretary" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_secretary-{{ $student->id }}"
                                                     name="clearance_secretary" value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_secretary-{{ $student->id }}">
                                                     Secretary
                                                 </label>
                                             </div>
                                         </div>
                                         <div class="form-group col-md-4">
                                             <input type="hidden" name="clearance_search" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_search-{{ $student->id }}" name="clearance_search"
                                                     value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_search-{{ $student->id }}">
                                                     Search Team
                                                 </label>
                                             </div>

                                             <input type="hidden" name="clearance_patron" value="false">
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox"
                                                     id="clearance_patron-{{ $student->id }}" name="clearance_patron"
                                                     value="true">
                                                 <label class="form-check-label"
                                                     for="clearance_patron-{{ $student->id }}">
                                                     Patron
                                                 </label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-md-12">
                                             <label for="clearIn_person" class="small">Clear-In
                                                 Guardian</label>
                                             <select class="form-control form-control-sm"
                                                 id="clearIn_person-{{ $student->id }}" name="clearIn_person"
                                                 required>
                                                 <option value="">--Select--</option>
                                                 <option value="parent">Parent</option>
                                                 <option value="other">Other</option>
                                             </select>
                                         </div>

                                         <!-- Check-In Time -->
                                         <div class="form-group col-md-12">
                                             <label for="check_in_time-{{ $student->id }}" class="small">Check-In
                                                 Time</label>
                                             <input type="time" class="form-control form-control-sm"
                                                 id="check_in_time-{{ $student->id }}" name="check_in_time" required>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="hostel_name-{{ $student->id }}" class="small">Hostel
                                                     Name</label>
                                                 <select class="form-control form-control-sm"
                                                     id="hostel_name-{{ $student->id }}" name="hostel_id"
                                                     {{ $student->checkIns->last() ? 'disabled' : '' }}>
                                                     <option value="">Select Hostel
                                                     </option>
                                                     @foreach ($hostels as $hostel)
                                                         <option value="{{ $hostel->id }}"
                                                             {{ $student->checkIns->last() && $student->checkIns->last()->hostel_id == $hostel->id ? 'selected' : '' }}>
                                                             {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                         </option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="bedspaceSelect-{{ $student->id }}"
                                                     class="small">Bedspace Number</label>
                                                 <select class="form-control form-control-sm"
                                                     id="bedspaceSelect-{{ $student->id }}" name="bedspace_id"
                                                     {{ $student->checkIns->last() ? 'disabled' : '' }}>
                                                     <option value="">Select Bedspace
                                                     </option>
                                                     @if ($student->checkIns->last() && $student->checkIns->last()->bedspace)
                                                         <option value="{{ $student->checkIns->last()->bedspace->id }}"
                                                             selected>
                                                             {{ $student->checkIns->last()->bedspace->bedspace_no }}
                                                         </option>
                                                     @endif
                                                 </select>
                                             </div>
                                         </div>
                                     </div>


                                     <div id="other_clearIn_details-{{ $student->id }}" class="d-none">
                                         <div class="form-row">
                                             <div class="form-group col-md-6">
                                                 <label for="other_name">Name</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_name-{{ $student->id }}" name="other_name"
                                                     placeholder="Full Name">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="other_nrc">NRC</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                     placeholder="National Registration Card Number">
                                             </div>

                                             <div class="form-group col-md-6">
                                                 <label for="other_contact">Contact
                                                     Number</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_contact-{{ $student->id }}" name="other_contact"
                                                     placeholder="e.g., 097xxxxxxx">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="vehicle_reg">Vehicle
                                                     Registration #</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                     placeholder="Vehicle Registration Number">
                                             </div>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="brought_by_relationship">brought-by-relationship</label>
                                             <select class="form-control form-control-sm"
                                                 id="brought_by_relationship-{{ $student->id }}"
                                                 name="brought_by_relationship">
                                                 <option value="">--Select--</option>
                                                 <option value="brother">Brother</option>
                                                 <option value="sister">Sister</option>
                                                 <option value="uncle">Uncle</option>
                                                 <option value="driver">Driver</option>
                                                 <option value="other">Other</option>
                                             </select>
                                         </div>


                                     </div>

                                     <div class="form-group" id="parent_idCheckIn">
                                         <select name="parent_id" class="form-control form-control-sm">
                                             <option value="">--Select a guardian--
                                             </option>
                                             @foreach ($student->guardians as $guardian)
                                                 <option value="{{ $guardian->id }}">
                                                     {{ $guardian->name }}
                                                     ({{ $guardian->contact_number }})
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>

                                 <!-- Modal Footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary btn-sm"
                                         data-dismiss="modal">Cancel</button>
                                     <button type="submit" class="btn btn-success btn-sm"
                                         form="clearInForm-{{ $student->id }}">
                                         Clear-In
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>

                 <!-- Clear-Out Modal -->
                 <div class="modal fade" id="clearOutModal-{{ $student->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="clearOutModalLabel-{{ $student->id }}" aria-hidden="true">
                     <div class="modal-dialog modal-md" role="document">
                         <div class="modal-content">
                             <!-- Modal Header -->
                             <div class="modal-header">
                                 <h5 class="modal-title" id="clearOutModalLabel-{{ $student->id }}">
                                     Clear-Out For:
                                     <span class="text-bold text-white">{{ $student->firstname ?? 'N/A' }}
                                         {{ $student->lastname ?? '' }}</span>
                                 </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>

                             <!-- Modal Form -->
                             <form id="clearOutForm-{{ $student->id }}"
                                 action="{{ route('student-clear-out.store') }}" method="POST">
                                 @csrf

                                 <!-- Modal Body -->
                                 <div class="modal-body">
                                     <!-- Hidden Fields -->
                                     <input type="hidden" name="student_id" value="{{ $student->id }}">
                                     <input type="hidden" name="cleared_by" value="{{ auth()->user()->id }}">

                                     <!-- Term and Year Selection -->
                                     <div class="form-row">
                                         <div class="form-group col-md-12">
                                             <label for="term" class="small">Select
                                                 Term</label>
                                             <select class="form-control form-control-sm"
                                                 id="academic_term-{{ $student->id }}" name="academic_term" required>
                                                 <option value="">--Select a term--
                                                 </option>
                                                 @foreach ($academicYears as $year)
                                                     @foreach ($year->terms as $term)
                                                         <option value="{{ $year->id }}-{{ $term->term_number }}">
                                                             {{ $year->academic_year }} - Term
                                                             {{ $term->term_number }}
                                                         </option>
                                                     @endforeach
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>

                                     <!-- Clear-Out Time -->
                                     <div class="form-row">
                                         <div class="form-group col-md-12">
                                             <label for="check_out_time-{{ $student->id }}" class="small">Clear-Out
                                                 Time</label>
                                             <input type="time" class="form-control form-control-sm"
                                                 id="check_out_time-{{ $student->id }}" name="check_out_time"
                                                 required>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="hostel_name-{{ $student->id }}" class="small">Hostel
                                                     Name</label>
                                                 <select class="form-control form-control-sm"
                                                     id="hostel_name-{{ $student->id }}" name="hostel_id"
                                                     {{ $student->checkIns->last() ? 'disabled' : '' }}>
                                                     <option value="">Select Hostel
                                                     </option>
                                                     @foreach ($hostels as $hostel)
                                                         <option value="{{ $hostel->id }}"
                                                             {{ $student->checkIns->last() && $student->checkIns->last()->hostel_id == $hostel->id ? 'selected' : '' }}>
                                                             {{ $hostel->hostel_name . ' (' . ucfirst($hostel->hostel_gender) . ')' }}
                                                         </option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="form-group col-md-6">
                                             <label for="bedspaceSelect-{{ $student->id }}" class="small">Bedspace
                                                 Number</label>
                                             <select class="form-control form-control-sm"
                                                 id="bedspaceSelect-{{ $student->id }}" name="bedspace_id"
                                                 {{ $student->checkIns->last() ? 'disabled' : '' }}>
                                                 <option value="">Select Bedspace
                                                 </option>
                                                 @if ($student->checkIns->last() && $student->checkIns->last()->bedspace)
                                                     <option value="{{ $student->checkIns->last()->bedspace->id }}"
                                                         selected>
                                                         {{ $student->checkIns->last()->bedspace->bedspace_no }}
                                                     </option>
                                                 @endif
                                             </select>
                                         </div>
                                     </div>
                                     <!-- Clear-Out Guardian Dropdown -->

                                     <div class="form-group col-md-12">
                                         <label for="clearOut_person-{{ $student->id }}" class="small">Clear-Out
                                             Guardian</label>
                                         <select class="form-control form-control-sm"
                                             id="clearOut_person-{{ $student->id }}" name="clearOut_person" required>
                                             <option value="">--Select--</option>
                                             <option value="parent">Parent</option>
                                             <option value="other">Other</option>
                                         </select>
                                     </div>

                                     <!-- Parent ID Selection -->
                                     <div class="form-group" id="parent_id_wrapper-{{ $student->id }}">
                                         <label for="parent_id" class="small">Select
                                             Guardian</label>
                                         <select name="parent_id" class="form-control form-control-sm">
                                             <option value="">--Select a guardian--
                                             </option>
                                             @foreach ($student->guardians as $guardian)
                                                 <option value="{{ $guardian->id }}">
                                                     {{ $guardian->name }}
                                                     ({{ $guardian->contact_number }})
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>

                                     <!-- Additional Guardian or Vehicle Details -->
                                     <div id="other_clearOut_details-{{ $student->id }}" class="d-none">
                                         <div class="form-row">
                                             <div class="form-group col-md-6">
                                                 <label for="other_name" class="small">Name</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_name-{{ $student->id }}" name="other_name"
                                                     placeholder="Full Name">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="other_nrc" class="small">NRC</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_nrc-{{ $student->id }}" name="other_nrc"
                                                     placeholder="National Registration Card Number">
                                             </div>

                                             <div class="form-group col-md-6">
                                                 <label for="other_contact" class="small">Contact
                                                     Number</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="other_contact-{{ $student->id }}" name="other_contact"
                                                     placeholder="e.g., 097xxxxxxx">
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="vehicle_reg" class="small">Vehicle
                                                     Registration #</label>
                                                 <input type="text" class="form-control form-control-sm"
                                                     id="vehicle_reg-{{ $student->id }}" name="vehicle_reg"
                                                     placeholder="Vehicle Registration Number">
                                             </div>
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="brought_by_relationship" class="small">Brought By
                                                 Relationship</label>
                                             <select class="form-control form-control-sm"
                                                 id="brought_by_relationship-{{ $student->id }}"
                                                 name="brought_by_relationship">
                                                 <option value="">--Select--</option>
                                                 <option value="brother">Brother</option>
                                                 <option value="sister">Sister</option>
                                                 <option value="uncle">Uncle</option>
                                                 <option value="driver">Driver</option>
                                                 <option value="other">Other</option>
                                             </select>
                                         </div>
                                     </div>

                                 </div>

                                 <!-- Modal Footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary btn-sm"
                                         data-dismiss="modal">Cancel</button>
                                     <button type="submit" class="btn btn-danger btn-sm"
                                         form="clearOutForm-{{ $student->id }}">Clear-Out</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             @endforeach
         </tbody>
     </table>

















































     {{-- // Function to render students with modals
            function renderStudents(students) {
                tableBody.empty();

                if (students.length > 0) {
                    students.forEach(student => {
                        let termReports = student.termly_reports
                            .map(report => {
                                return `${report.academic_year?.academic_year ?? 'N/A'} - Term ${report.term_number ?? 'N/A'}`;
                            }).join('<br>');

                        let row = `
            <tr>
                <td>${student.firstname} ${student.lastname} (${student.gender})</td>
                <td>${student.grade?.gradeno ?? 'N/A'} ${student.grade?.class_name ?? ''}</td>
                <td>${student.student_type ?? 'N/A'}</td>
                <td>${termReports || 'No Reports Available'}</td>
                <td>${student.check_ins?.length ? student.check_ins[0]?.hostel?.hostel_name + ' (' + student.check_ins[0]?.bedspace?.bedspace_no + ')' : 'N/A'}</td>
                <td>${student.check_ins?.length ? student.check_ins[0]?.room_status ?? 'No Record' : 'No Record'}</td>
                <td><span class="badge badge-${student.active_status === 'enrolled' ? 'success' : 'warning'}">${student.active_status}</span></td>
                <td>
                    <button class="btn custom-btn-clear-out" data-student='${JSON.stringify(student)}' data-toggle="modal" data-target="#clearOutModal" title="Clear-Out">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </td>
            </tr>
            `;

                        tableBody.append(row);
                    });
                } else {
                    tableBody.append('<tr><td colspan="8" class="text-center">No data available.</td></tr>');
                }
            }

            // Event listener for custom-btn-clear-out button
            tableBody.on('click', '.custom-btn-clear-out', function() {
                let student = JSON.parse($(this).attr('data-student'));

                // Populate modal with student data
                $('#clearOutModalLabel').text(`Clear-Out For: ${student.firstname} ${student.lastname}`);
                $('#clearOutModal [name="student_id"]').val(student.id);

                // Populate term and guardian dropdowns dynamically
                let termSelect = $('#clearOutModal [name="academic_term"]');
                termSelect.empty().append('<option value="">--Select a term--</option>');

                student.termly_reports.forEach(report => {
                    termSelect.append(
                        `<option value="${report.academic_year.id}-${report.term_number}">${report.academic_year.academic_year} - Term ${report.term_number}</option>`
                    );
                });

                let guardianSelect = $('#clearOutModal [name="parent_id"]');
                guardianSelect.empty().append('<option value="">--Select a guardian--</option>');
                student.guardians.forEach(guardian => {
                    guardianSelect.append(
                        `<option value="${guardian.id}">${guardian.name} (${guardian.contact_number})</option>`
                    );
                });

                // Handle other fields as required
            });

            // Fetch and render all students on page load
            $.ajax({
                url: '{{ route('fetch.student.termly.report') }}',
                method: 'GET',
                success: function(response) {
                    renderStudents(response.students);
                },
                error: function() {
                    alert('An error occurred while fetching data.');
                }
            }); --}}



     <div class="content p-2 row">
         <!-- Statistics Section -->
         <!-- Chart Section -->
         <div class="col-md-9">
             <div class="row">
                 <div class="col-md-3">
                     <label for="term" class="form-label">Term</label>
                     <select class="form-control form-control-sm" id="term" name="term">
                         <option value="">Select Term</option>
                         <option value="1">Term 1</option>
                         <option value="2">Term 2</option>
                         <option value="3">Term 3</option>
                     </select>
                 </div>
                 <div class="col-md-3">
                     <label for="year" class="form-label">Year</label>
                     <select class="form-control form-control-sm" id="year" name="year">
                         <option value="">Select Year</option>
                         <option value="2025">2025</option>
                         <option value="2024">2024</option>
                         <option value="2023">2023</option>
                     </select>
                 </div>
                 <div class="col-md-3 d-flex align-items-end">
                     <button class="btn btn-primary btn-sm w-100" id="fetchStats">View Statistics</button>
                 </div>
             </div>
             <div class="col-md-12">
                 <div class="chart-container" style="position: relative; height:250px;">
                     <canvas id="statisticsChart"></canvas>
                 </div>
             </div>
         </div>





         <!-- Search Results Table -->
         <div class="col-md-4">
             <!-- Search Filters -->

             <div class="col-md-3">
                 <label for="academic_year_id">Academic Year</label>
                 <select id="academic_year_id" name="academic_year_id" class="form-control form-control-sm">
                     <option value="">--Select year--
                     </option>
                     @foreach ($academicYears as $year)
                         <option value="{{ $year->id }}">{{ $year->academic_year }}
                         </option>
                     @endforeach
                 </select>
             </div>
             <div class="col-md-3">
                 <label for="term">Term</label>
                 <select id="term" name="term" class="form-control form-control-sm">
                     <option value="">--Select Term--</option>
                     <option value="1">Term 1</option>
                     <option value="2">Term 2</option>
                     <option value="3">Term 3</option>
                 </select>
             </div>
             <div class="col-md-3">
                 <div class="form-group">
                     <label for="roll_no" class="small">Grade/Class</label>
                     <select id="class_id" name="class_id" class="form-control form-control-sm">
                         <option value="">Select</option>
                         @foreach ($grades as $grade)
                             <option value="{{ $grade->id }}">
                                 {{ $grade->gradeno . ' ' . $grade->class_name }}
                             </option>
                         @endforeach
                     </select>
                 </div>
             </div>
             <div class="col-md-3 d-flex align-items-end">
                 <button class="btn btn-primary btn-sm w-100" id="searchRegisters">Search</button>
             </div>

             <div class="col-md-12">
                 <table class="table table-bordered table-hover text-nowrap mb-4 table-sm" id="studentsTable">
                     <thead class="table-dark">
                         <tr>
                             <th>Student Exam Number</th>
                             <th>Student Name</th>
                             <th>Gender</th>
                             {{-- <th>Report Status</th>
                            <th>Date</th> --}}
                         </tr>
                     </thead>
                     <tbody>
                         <!-- Dynamic content will be appended here -->
                     </tbody>
                 </table>

             </div>
         </div>
     </div>
















     <section class="content p-4">
         <div class="container-fluid">
             <div class="card">
                 <div class="card-header">
                     <h3 class="card-title">Manage Student Accounts</h3>
                 </div>
                 <div class="card-body">
                     <!-- Filter Section -->
                     <div class="mb-4">
                         <div id="filterForm" class="row">
                             {{-- @csrf --}}
                             <!-- Academic Year -->
                             <div class="col-md-4">
                                 <label for="filterAcademicYear" class="form-label">Academic Year</label>
                                 <select id="filterAcademicYear" name="academic_year_id"
                                     class="form-select form-control-sm">
                                     <option value="" selected>All Years</option>
                                     @foreach ($academicYears as $year)
                                         <option value="{{ $year->id }}">{{ $year->academic_year }}</option>
                                     @endforeach
                                 </select>
                             </div>

                             <!-- Term -->
                             <div class="col-md-3">
                                 <label for="filterTerm" class="form-label">Term</label>
                                 <select id="filterTerm" name="term" class="form-select form-control-sm">
                                     <option value="" selected>All Terms</option>
                                     <option value="1">Term 1</option>
                                     <option value="2">Term 2</option>
                                     <option value="3">Term 3</option>
                                 </select>
                             </div>

                             <!-- Grade -->
                             <div class="col-md-3">
                                 <label for="filterGrade" class="form-label">Grade</label>
                                 <select id="filterGrade" name="class_id" class="form-select form-control-sm">
                                     <option value="" selected>All Grades</option>
                                     @foreach ($grades as $grade)
                                         <option value="{{ $grade->id }}">{{ $grade->gradeno }} -
                                             {{ $grade->class_name }}
                                         </option>
                                     @endforeach
                                 </select>
                             </div>
                             <!-- Filter Button -->
                             <div class="col-md-2 d-flex align-items-end">
                                 <button type="button" id="applyFilter" class="btn btn-primary btn-sm"> <i
                                         class="fa fa-search"></i> Search</button>
                             </div>
                         </div>
                     </div>


                     <!-- Student Table -->
                     <!-- Student Table -->
                     <div class="table-responsive">
                         <table class="table table-striped table-hover table-hover text-nowrap ">
                             <thead class="table-sm">
                                 <tr>
                                     <th>ECZ No</th>
                                     <th>Name</th>
                                     <th>Grade-Class</th>
                                     <th>Actions</th>
                                 </tr>
                             </thead>
                             <tbody id="studentTableBody">
                                 <!-- Dummy Content for Now -->

                             </tbody>
                         </table>
                         <nav>
                             <ul class="pagination" id="pagination"></ul>
                         </nav>

                     </div>
                 </div>
             </div>
         </div>
     </section>



     <div class="card-body">
         <div class="table-responsive">
             <table id="feesTable" class="table table-bordered table-hover text-nowrap table-sm dataTable no-footer">
                 <thead>
                     <tr>
                         <th>Fee Category</th>
                         <th>Fee Interval</th>
                         <th>Status</th>
                         <th>Amount (ZMK)</th>
                         <th>Paid (ZMK)</th>
                         <th>Balance (ZMK)</th>
                         <th>Recent Transaction (ZMK)</th>
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody id="pupils_data_body">
                     @forelse ($student->feeCategories as $feeCategory)
                         @php
                             // Total paid for this fee category
                             $totalPaid = $student->feePayments
                                 ->where('fee_category_id', $feeCategory->id)
                                 ->sum('amount_paid');

                             // Balance calculation
                             $balance = $feeCategory->amount - $totalPaid;

                             // Determine payment status
                             $status = $totalPaid == 0 ? 'Not Yet Paid' : ($balance > 0 ? 'Partial' : 'Paid');

                             // Most recent transaction
                             $recentTransaction = $student->feePayments
                                 ->where('fee_category_id', $feeCategory->id)
                                 ->sortByDesc('payment_date')
                                 ->first();
                         @endphp

                         <tr>
                             <td>{{ $feeCategory->fee_type ?? 'N/A' }}</td>
                             <td>{{ $feeCategory->fee_interval ?? 'N/A' }}</td>
                             <td>
                                 <span
                                     class="badge 
                    {{ $status == 'Not Yet Paid' ? 'bg-danger' : ($status == 'Partial' ? 'bg-warning' : 'bg-success') }}">
                                     {{ $status }}
                                 </span>
                             </td>
                             <td>{{ number_format($feeCategory->amount, 2) }}</td>
                             <td>{{ number_format($totalPaid, 2) }}</td>
                             <td>{{ number_format($balance, 2) }}</td>
                             <td>
                                 {{ $recentTransaction
                                     ? 'ZMK ' .
                                         number_format($recentTransaction->amount_paid, 2) .
                                         ' on ' .
                                         $recentTransaction->payment_date->format('d M Y')
                                     : 'No Recent Transaction' }}
                             </td>
                             <td>
                                 <button class="btn btn-success btn-sm" data-toggle="modal"
                                     data-target="#submitPaymentModal-{{ $feeCategory->id }}">Submit
                                     Payment</button>
                                 <button class="btn btn-info btn-sm" data-toggle="modal"
                                     data-target="#payment-history-{{ $feeCategory->id }}">Payment
                                     History</button>
                             </td>
                         </tr>


                         <!-- Submit Payment Modal -->
                         <div class="modal fade" id="submitPaymentModal-{{ $feeCategory->id }}" tabindex="-1"
                             role="dialog" aria-labelledby="submitPaymentModalLabel" aria-hidden="true">
                             <div class="modal-dialog" role="document">
                                 <form action="{{ route('feePayments.store') }}" method="POST"
                                     enctype="multipart/form-data">
                                     @csrf
                                     <input type="hidden" name="student_id" value="{{ $student->id }}">
                                     <input type="hidden" name="fee_category_id" value="{{ $feeCategory->id }}">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="submitPaymentModalLabel">Submit<span
                                                     class="text-white">
                                                     {{ $feeCategory->fee_type ?? 'N/A' }}</span> Payment
                                             </h5>
                                             <button type="button" class="close" data-dismiss="modal"
                                                 aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                             </button>
                                         </div>
                                         <div class="modal-body">
                                             <!-- Academic Year -->
                                             <div class="form-group">
                                                 <label for="academic_year_id" class="small">Academic
                                                     Year</label>
                                                 <select name="academic_year_id" class="form-control form-control-sm"
                                                     required>
                                                     <option value="" disabled selected>Select Academic
                                                         Year</option>
                                                     @foreach ($academicYears as $year)
                                                         <option value="{{ $year['id'] }}">
                                                             {{ $year['academic_year'] }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>

                                             <!-- Term -->
                                             <div class="form-group">
                                                 <label for="term_no" class="small">Term</label>
                                                 <select name="term_no" class="form-control form-control-sm" required>
                                                     <option value="" disabled selected>Select Term
                                                     </option>
                                                     <option value="1">Term 1
                                                     </option>
                                                     <option value="2">Term 2
                                                     </option>
                                                     <option value="3">Term 3
                                                     </option>


                                                 </select>
                                             </div>

                                             <!-- Amount Paid -->
                                             <div class="form-group">
                                                 <label for="amount_paid" class="small">Amount Paid
                                                     (ZMK)
                                                 </label>
                                                 <input type="number" name="amount_paid"
                                                     class="form-control form-control-sm" step="0.01" required>
                                             </div>

                                             <!-- Payment Date -->
                                             <div class="form-group">
                                                 <label for="payment_date" class="small">Payment Date</label>
                                                 <input type="date" name="payment_date"
                                                     class="form-control form-control-sm" required>
                                             </div>

                                             <!-- Payment Method -->
                                             <div class="form-group">
                                                 <label for="payment_method" class="small">Payment
                                                     Method</label>
                                                 <select name="payment_method" class="form-control form-control-sm"
                                                     required>
                                                     <option value="Cash">Cash</option>
                                                     <option value="Bank Transfer">Bank Transfer</option>
                                                     <option value="Mobile Money">Mobile Money</option>
                                                 </select>
                                             </div>

                                             <!-- Reference Number -->
                                             <div class="form-group">
                                                 <label for="reference_no" class="small">Reference
                                                     Number</label>
                                                 <input type="text" name="reference_no"
                                                     class="form-control form-control-sm">
                                             </div>

                                             <!-- Attachment -->
                                             <div class="form-group">
                                                 <label for="attachment" class="small">Upload Attachment
                                                     (Optional)</label>
                                                 <input type="file" name="attachment"
                                                     class="form-control form-control-sm">
                                             </div>
                                         </div>
                                         <div class="modal-footer">
                                             <button type="submit" class="btn btn-primary btn-sm">Submit
                                                 Payment</button>
                                             <button type="button" class="btn btn-secondary"
                                                 data-dismiss="modal">Close</button>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>

                     @empty
                         <tr>
                             <td colspan="7" class="text-center">No fee data available.</td>
                         </tr>
                     @endforelse
                 </tbody>

             </table>



         </div>

     </div>






     @extends('layouts.app')

     @section('title', 'Payment History')

 @section('content')
     <div class="container mt-4">
         <!-- Page Header -->
         <div class="row align-items-center mb-4">
             <div class="col-md-8">
                 <h2 class="text-primary">Payment Receipt</h2>
                 <p class="text-muted">Detailed information about the selected payment and related records.</p>
             </div>
             <div class="col-md-4 text-md-right">
                 <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                     <i class="fas fa-print"></i> Print Receipt
                 </button>
             </div>
         </div>

         <!-- Payment Details Card -->
         <div class="card shadow-sm mb-4">
             <div class="card-header bg-primary text-white">
                 <h5 class="mb-0">Payment Details</h5>
             </div>
             <div class="card-body">
                 <div class="row">
                     <!-- Transaction Info -->
                     <div class="col-md-6">
                         <p><strong>Transaction Date:</strong> {{ $transaction->payment_date->format('d M Y') }}</p>
                         <p><strong>Amount Paid:</strong> ZMK {{ number_format($transaction->amount_paid, 2) }}</p>
                         <p><strong>Payment Method:</strong> {{ $transaction->payment_method }}</p>
                     </div>
                     <!-- Student Info -->
                     <div class="col-md-6">
                         <p><strong>Student Name:</strong> {{ $transaction->student->name }}</p>
                         <p><strong>Grade:</strong> {{ $transaction->student->grade->name ?? 'N/A' }}</p>
                         <p><strong>Reference No:</strong> {{ $transaction->reference_no ?? 'N/A' }}</p>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Fee Details Card -->
         <div class="card shadow-sm mb-4">
             <div class="card-header bg-secondary text-white">
                 <h5 class="mb-0">Fee Category Details</h5>
             </div>
             <div class="card-body">
                 <div class="row">
                     <div class="col-md-6">
                         <p><strong>Fee Type:</strong> {{ $transaction->feeCategory->fee_type }}</p>
                         <p><strong>Fee Interval:</strong> {{ $transaction->feeCategory->fee_interval }}</p>
                     </div>
                     <div class="col-md-6">
                         <p><strong>Academic Year:</strong> {{ $transaction->academicSession->academic_year ?? 'N/A' }}
                         </p>
                         <p><strong>Amount:</strong> ZMK {{ number_format($transaction->feeCategory->amount, 2) }}</p>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Related Payments Section -->
         <div class="card shadow-sm">
             <div class="card-header bg-info text-white">
                 <h5 class="mb-0">Other Payments for {{ $transaction->feeCategory->fee_type }}</h5>
             </div>
             <div class="card-body">
                 @if ($relatedPayments->isEmpty())
                     <p class="text-center text-muted">No other payments found for this fee category.</p>
                 @else
                     <div class="table-responsive">
                         <table class="table table-bordered table-hover text-center">
                             <thead class="bg-light">
                                 <tr>
                                     <th>Date</th>
                                     <th>Amount Paid (ZMK)</th>
                                     <th>Payment Method</th>
                                     <th>Reference No</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($relatedPayments as $payment)
                                     <tr>
                                         <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                         <td>ZMK {{ number_format($payment->amount_paid, 2) }}</td>
                                         <td>{{ $payment->payment_method }}</td>
                                         <td>{{ $payment->reference_no ?? 'N/A' }}</td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 @endif
             </div>
         </div>
     </div>
 @endsection

















 <script>

 // Print All Rows
 $('#printAll').click(function() {
 const tableContent = document.getElementById('summaryTable').outerHTML;

 // Add a custom header with the school details and logo
 const printContent = `
 <div style="text-align: center; margin-bottom: 20px;">
     <img src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="School Logo"
         style="height: 100px;">
     <h3>School Name</h3>
     <p>Address: School Address, City</p>
     <p>Contact: +260 123 456 789</p>
 </div>
 ${tableContent}
 `;

 // Use Print.js to print the content
 printJS({
 printable: printContent,
 type: 'raw-html',
 css: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
 });
 });

 // Print Individual Row
 $('.print-row').click(function() {
 const rowId = $(this).data('row-id'); // Get the data-row-id
 const tableRow = $(this).closest('tr').html(); // Get the HTML content of the row

 // Add a custom header with the school details and logo
 const printContent = `
 <div style="text-align: center; margin-bottom: 20px;">
     <img src="{{ asset('assets/images/gva_logo/grand view-PNG.png') }}" alt="School Logo"
         style="height: 100px;">
     <h3>School Name</h3>
     <p>Address: School Address, City</p>
     <p>Contact: +260 123 456 789</p>
 </div>
 <table class="table table-bordered">
     <thead class="thead-light">
         <tr>
             <th>Date of Payment</th>
             <th>Amount Paid (ZMK)</th>
             <th>Payment Method</th>
             <th>Reference No</th>
         </tr>
     </thead>
     <tbody>
         <tr>${tableRow}</tr>
     </tbody>
 </table>
 `;

 // Print the row using Print.js
 printJS({
 printable: printContent,
 type: 'raw-html',
 css: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
 });
 });
</script>




 {{-- STUDENT INFO CARD TEMPLATE --}}
 <!-- Image Section -->
 <div class="row">
     <div class="col-md-2 col-sm-4 text-center">
         <img src="{{ $student->student_photo ? asset('path/to/uploads/' . $student->student_photo) : asset('path/to/default_female.jpg') }}"
             alt="No Image" class="img-fluid img-thumbnail rounded-circle">
     </div>
     <!-- Details Section -->
     <div class="col-md-10 col-sm-8">
         <table class="table table-borderless table-responsive">
             <tbody>
                 <tr>
                     <th>Name</th>
                     <td>{{ $student->firstname }} {{ $student->other_name ?? '' }}
                         {{ $student->lastname }}
                     </td>
                     <th>Admission Date</th>
                     <td>{{ $student->admission_date }}</td>
                 </tr>
                 <tr>
                     <th>Father Name</th>
                     <td>{{ optional($student->guardians->first())->name ?? 'N/A' }}</td>
                     <th>Admission No</th>
                     <td>{{ $student->ecz_no }}</td>
                 </tr>
                 <tr>
                     <th>Mobile Number</th>
                     <td>{{ optional($student->guardians->first())->contact_number ?? 'N/A' }}</td>
                     <th>Grade/Class</th>
                     <td>Grade {{ $student->grade->gradeno ?? 'N/A' }} -
                         {{ $student->grade->class_name ?? 'N/A' }}</td>
                 </tr>
                 <tr>
                     <th>Student Type</th>
                     <td>{{ $student->student_type }}</td>
                     <th>Exam No</th>
                     <td>{{ $student->ecz_no }}</td>
                 </tr>
                 <tr>
                     <th>Date of Birth</th>
                     <td>{{ $student->dob->format('d M Y') ?? 'N/A' }}</td>
                     <th>Religion</th>
                     <td>{{ $student->religion ?? 'N/A' }}</td>
                 </tr>
             </tbody>

         </table>
     </div>
 </div>


  @if ($relatedPayments->isEmpty())
                    <p class="text-center text-muted">No other payments found for this fee category.</p>
                @else
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary btn-sm" id="printAll">
                            <i class="fas fa-print"></i> Print All
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="summaryTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Date of Payment</th>
                                    <th>Amount Paid (ZMK)</th>
                                    <th>Payment Method</th>
                                    <th>Reference No</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($relatedPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                        <td>ZMK {{ number_format($payment->amount_paid, 2) }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->reference_no ?? 'N/A' }}</td>
                                        <td class="no-print">
                                            <button class="btn btn-outline-primary btn-sm print-row"
                                                data-row-id="{{ $payment->id }}" title="Print Row">
                                                <i class="fas fa-print"></i> Print
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
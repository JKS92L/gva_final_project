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

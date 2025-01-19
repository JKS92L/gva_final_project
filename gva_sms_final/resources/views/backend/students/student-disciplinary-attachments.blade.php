@extends('admin.admim-master')
@section('admin_content')
    <!-- Content Header (Page header) -->
    <div class="content-header py-3 bg-light shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">Student Disciplinary Attachments</h2>
                    <p class="text-muted">View/Download attachments</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0 btn-group-sm">
                    {{-- <a href="{{ route('student.disciplinaryForm.view') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Add Disciplinary Record
                    </a> --}}

                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content p-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-fluid">
            <div class="container">
                <!-- Transfer Records Table -->
                <div class="card">
                    <div class="card-header small">
                        <h4 class="text-white">Attachments for {{ $studentName }} - Class {{ $className }}</h4>
                    </div>
                    
                    <div class="card-body">
                        <!-- Display the Title -->
                       

                        <table class="table table-bordered table-sm dataTables_wrapper no-footer" id="disciplianaryAttachments">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Document Title</th>
                                    <th>Type</th>
                                    <th>Size (KB)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attachments as $index => $attachment)
                                    @php
                                        $path = storage_path('app/public/' . $attachment);
                                        $fileExists = file_exists($path);
                                        $fileSize = $fileExists ? filesize($path) / 1024 : 'N/A'; // Size in KB
                                        $fileType = $fileExists ? mime_content_type($path) : 'Unknown';
                                        $originalName = $originalAttachments[$index] ?? basename($attachment); // Use original name if available
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ pathinfo($originalName, PATHINFO_FILENAME) }}</td>
                                        <!-- Original file name -->
                                        <td>{{ $fileType }}</td>
                                        <td>{{ $fileSize !== 'N/A' ? number_format($fileSize, 2) : $fileSize }}</td>
                                        <td>
                                            @if ($fileExists)
                                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank"
                                                    class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download</a>
                                            @else
                                                <span class="text-danger">File not found</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No attachments available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


    </div>


    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a Student',
                width: '100%'
            });


            $('#disciplianaryAttachments').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: false,
            });
        });
    </script>
@endsection

@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'User Profile')
@section('content_header_title', 'Profile')
@section('content_header_subtitle', "Your ({$user->first_name}) Profile")

{{-- Content body: main page content --}}
@section('content_body')

    <div class="container-fluid">
        <div class="row">
            <!-- Profile Details Card -->


            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <!-- User Image -->
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-profile.png') }}"
                                alt="User profile picture">

                        </div>

                        <h3 class="profile-username text-center">{{ $user->first_name . ' ' . $user->last_name }}</h3>
                        <p class="text-muted text-center">{{ $user->email }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right">{{ $user->username }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Joined</b> <a class="float-right">{{ $user->created_at->format('d M Y') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>




            <!-- Edit Profile Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <div class="card-body">
                        {{-- <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"> --}}
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Full Name -->
                            <div class="form-group row">
                                <label for="full_name" class="col-sm-3 col-form-label">Full Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="full_name" name="full_name"
                                        value="{{ old('full_name', $user->first_name . ' ' . $user->last_name) }}">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $user->username) }}">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Profile Picture Upload -->
                            <div class="form-group row">
                                <label for="profile_picture" class="col-sm-3 col-form-label">Profile Picture</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control-file" id="profile_picture"
                                        name="profile_picture">
                                    <small class="text-muted">Optional: Upload a new profile picture.</small>
                                </div>
                            </div>

                            <!-- Password Update Section -->
                            <hr>
                            <h5>Change Password</h5>

                            <!-- Current Password -->
                            <div class="form-group row">
                                <label for="current_password" class="col-sm-3 col-form-label">Current Password</label>
                                <div class="col-sm-9">
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="form-group row">
                                <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                        id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm New Password -->
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-sm-3 col-form-label">Confirm New
                                    Password</label>
                                <div class="col-sm-9">
                                    <input type="password"
                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                        id="new_password_confirmation" name="new_password_confirmation">
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- Push extra CSS --}}
@push('css')
    <link rel="stylesheet" href="/css/custom_profile.css">
    <style>
        /* .img-circle {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        } */
    </style>
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        // Add any custom JavaScript for the profile page here
    </script>
@endpush

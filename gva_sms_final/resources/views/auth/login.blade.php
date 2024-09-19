@extends('layouts.app')

@section('content')
    <div class="login-container">

        <div class="sliding-background"></div>

        <div class="login-box">
            <div class="login-header">
                <img src="{{asset('assets/images/gva_logo/grand view-PNG.png')}}" alt="Grandview School Logo" class="logo">
                <h2>Welcome to Grandview School Management System</h2>
            </div>
            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="@error('password') is-invalid @enderror"
                            name="password" required placeholder="Enter your password">
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="input-group">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="input-group">
                        <button type="submit" class="btn">Sign In</button>
                    </div>

                    <!-- Forgot Password and Register Links -->
                    <div class="form-footer">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                        @endif
                        <a href="{{ route('register') }}">Register a new account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Global Styles */
    body,
    html {
        margin: 0;
        padding: 0;
        height: 90%;
        font-family: Arial, sans-serif;
    }

    /* Static Navbar */
    /* .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #0f559b;
        color: white;
        padding: 15px 0;
        text-align: center;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    } */

    /* .navbar-content h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: bold;
    } */

    /* Sliding Background Images */
    .sliding-background {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: -1;
        animation: slide 20s infinite;
        background: url('path_to_image1.jpg') no-repeat center center/cover;
    }
@keyframes slide {
    /* Image 1: public/assets/images/gva_env/IMG_0852.jpg */
    0%,
    100% {
        background: url('{{ asset('assets/images/gva_env/IMG_0852.jpg') }}') no-repeat center center/cover;
    }

    /* Image 2: public/assets/images/gva_env/gva_admin_view.jpeg */
    25% {
        background: url('{{ asset('assets/images/gva_env/gva_admin_view.jpeg') }}') no-repeat center center/cover;
    }

    /* Image 3: public/assets/images/gva_env/IMG_5536.jpg */
    50% {
        background: url('{{ asset('assets/images/gva_env/IMG_5536.jpg') }}') no-repeat center center/cover;
    }

    /* Image 4: public/assets/images/gva_env/IMG_5558.jpg */
    75% {
        background: url('{{ asset('assets/images/gva_env/IMG_5558.jpg') }}') no-repeat center center/cover;
    }
}


    /* Blue Blur Filter */
    .sliding-background::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 139, 0.5);
        /* Dark blue */
        filter: blur(10px);
        z-index: -1;
    }

    /* Login Container */
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 88vh;
        padding-top: 0px;
        /* Space for the navbar */
    }

    .login-box {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        width: 100%;
        max-width: 450px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    /* Form Header */
    .login-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-header .logo {
        width: 80px;
        margin-bottom: 10px;
    }

    .login-header h2 {
        font-size: 1.4rem;
        color: #333;
    }

    /* Form Body */
    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #555;
    }

    .input-group input[type="email"],
    .input-group input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 0.9rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: border 0.3s ease;
    }

    .input-group input[type="email"]:focus,
    .input-group input[type="password"]:focus {
        border-color: #28a745;
    }

    .input-group input[type="checkbox"] {
        margin-right: 5px;
    }

    .input-group .btn {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .input-group .btn:hover {
        background-color: #218838;
    }

    /* Form Footer */
    .form-footer {
        text-align: center;
        margin-top: 10px;
    }

    .form-footer a {
        color: #28a745;
        font-size: 0.9rem;
        text-decoration: none;
        margin-right: 10px;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    /* Error Message Styling */
    .error-message {
        color: red;
        font-size: 0.8rem;
        margin-top: 5px;
    }
</style>

@extends('layouts.main')

@section('title', 'Login')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .back-button {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 12px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        text-decoration: none;
        z-index: 1000;
    }
    .back-button:hover { background-color: #0056b3; color: white; }
    td.label-td { position: relative; }
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 55%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 13px;
        color: #666;
    }
</style>
@endsection

@section('content')
<a href="/" class="back-button"><i class="fa fa-arrow-left"></i> Back</a>

<center>
    <div class="container">
        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <p class="header-text">Welcome Back !</p>
                </td>
            </tr>
            <div class="form-body">
                <tr>
                    <td>
                        <p class="sub-text">Login with your details to continue.</p>
                    </td>
                </tr>
                <tr>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <td class="label-td">
                            <label for="email" class="form-label">Email: </label>
                        </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <input type="email" name="email" class="input-text" placeholder="Email Address" required value="{{ old('email') }}">
                    </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <label for="password" class="form-label">Password: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <input type="password" id="password" name="password" class="input-text" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        @if(session('error'))
                            <label class="form-label" style="color:rgb(255, 62, 62);text-align:center;">{{ session('error') }}</label>
                        @endif
                        @if(session('success'))
                            <label class="form-label" style="color:rgb(0, 182, 0);text-align:center;">{{ session('success') }}</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Login" class="login-btn btn-primary btn">
                    </td>
                </tr>
            </div>
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account? </label>
                    <a href="{{ route('register') }}" class="hover-link1 non-style-link">Sign Up</a><br><br><br>
                </td>
            </tr>
            </form>
        </table>
    </div>
</center>

<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>
@endsection
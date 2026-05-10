@extends('layouts.main')

@section('title', 'Register')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/signup.css') }}">
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

.back-button:hover {
    background-color: #0056b3;
    color: white;
}

td.label-td {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 55%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 13px;
    color: #666;
}

.error-text {
    color: rgb(255, 62, 62);
    font-size: 13px;
    margin-top: 4px;
    display: block;
}
</style>
@endsection

@section('content')

<a href="/" class="back-button">
    <i class="fa fa-arrow-left"></i> Back
</a>

<center>
    <div class="container">

        <table border="0" style="margin: 0;padding: 0;width: 75%;">

            <tr>
                <td>
                    <p class="header-text">Create Account</p>
                </td>
            </tr>

            <tr>
                <td>
                    <p class="sub-text">
                        Join TalkToMe - Online Therapy System
                    </p>
                </td>
            </tr>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <tr>
                    <td class="label-td">
                        <label class="form-label">Full Name</label>
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <input type="text" name="name" class="input-text" placeholder="Enter Full Name"
                            value="{{ old('name') }}" required>

                        @error('name')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <label class="form-label">Email Address</label>
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <input type="email" name="email" class="input-text" placeholder="Enter Email Address"
                            value="{{ old('email') }}" required>

                        @error('email')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <label class="form-label">Password</label>
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <input type="password" id="password" name="password" class="input-text"
                            placeholder="Enter Password" required>

                        <span class="toggle-password" onclick="togglePassword()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>

                        @error('password')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <label class="form-label">Address</label>
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <input type="text" name="address" class="input-text" placeholder="Enter Address"
                            value="{{ old('address') }}" required>

                        @error('address')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <label class="form-label">Date of Birth</label>
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <input type="date" name="dob" class="input-text" value="{{ old('dob') }}" required>

                        @error('dob')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <label class="form-label">Phone Number</label>
                    </td>
                </tr>

                <tr>
                    <td class="label-td">
                        <input type="tel" name="tel" class="input-text" placeholder="Enter Phone Number"
                            value="{{ old('tel') }}" required>

                        @error('tel')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>

                <tr>
                    <td>
                        <br>

                        @if(session('success'))
                        <label class="form-label" style="color:rgb(0, 182, 0);text-align:center;">
                            {{ session('success') }}
                        </label>
                        @endif

                        @if ($errors->any())
                        <label class="form-label" style="color:rgb(255, 62, 62);text-align:center;">
                            Please fix the errors above.
                        </label>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" value="Create Account" class="login-btn btn-primary btn">
                    </td>
                </tr>

            </form>

            <tr>
                <td>
                    <br>

                    <label class="sub-text" style="font-weight: 280;">
                        Already have an account?
                    </label>

                    <a href="{{ route('login') }}" class="hover-link1 non-style-link">
                        Login
                    </a>

                    <br><br><br>
                </td>
            </tr>

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
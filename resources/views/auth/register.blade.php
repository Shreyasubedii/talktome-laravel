@extends('layouts.main')

@section('title', 'Register')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/signup.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="box">
            <div class="form-header">
                <h1>Create Account</h1>
                <p>Join TalkToMe - Online Therapy System</p>
            </div>
            
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            
            <div class="input-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            
            <div class="input-group">
                <label for="tel">Phone Number</label>
                <input type="tel" id="tel" name="tel" required>
            </div>
            
            <button type="submit" class="btn-primary">Register</button>
            
            <div class="links">
                <a href="{{ route('login') }}">Already have an account? Login</a>
            </div>
        </div>
    </div>
</form>
@endsection
@extends('layouts.main')

@section('title', 'eSewa Payment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">
@endsection

@section('content')
<div class="sidebar">
    <h2>Patient Panel</h2>
    <a href="{{ route('patient.dashboard') }}">Dashboard</a>
    <a href="{{ route('patient.doctors') }}">Doctors</a>
    <a href="{{ route('patient.appointments') }}">My Appointments</a>
    <a href="{{ route('patient.recommendation') }}">Get Recommendation</a>
    <a href="{{ route('patient.settings') }}">Settings</a>
    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</div>

<div class="main-content">
    <h1>Pay with eSewa</h1>
    
    <div class="form-container">
        <p>Appointment ID: {{ $appointmentId }}</p>
        <p>Amount: NPR {{ $amount }}</p>
        
        <form action="https://esewa.com.np/epay/main" method="POST">
            <input type="hidden" name="amt" value="{{ $amount }}">
            <input type="hidden" name="pdc" value="0">
            <input type="hidden" name="psc" value="0">
            <input type="hidden" name="txncd" value="FG">
            <input type="hidden" name="pid" value="{{ $appointmentId }}">
            <input type="hidden" name="scd" value="talktome"> <!-- Replace with your merchant code -->
            <input type="hidden" name="su" value="{{ route('patient.esewa.success') }}">
            <input type="hidden" name="fu" value="{{ route('patient.esewa.failure') }}">
            
            <button type="submit" class="btn-primary">Pay NPR {{ $amount }} via eSewa</button>
        </form>
    </div>
</div>
@endsection
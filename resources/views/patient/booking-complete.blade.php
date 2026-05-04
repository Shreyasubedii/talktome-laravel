@extends('layouts.main')

@section('title', 'Booking Complete')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="dash-body">
        <center>
            <div style="margin-top: 100px; padding: 50px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); width: 60%;">
                <img src="{{ asset('img/icons/book-hover.svg') }}" width="100px">
                <h1 style="color: #007bff;">Booking Successful!</h1>
                <p class="heading-sub12">Your appointment has been booked. Your appointment number is:</p>
                <h2 style="font-size: 50px; color: #333;">{{ str_pad($appointment->apponum, 2, '0', STR_PAD_LEFT) }}</h2>
                <br>
                <div style="text-align: left; background: #f8f9fa; padding: 20px; border-radius: 5px;">
                    <p><b>Session:</b> {{ $appointment->schedule?->title }}</p>
                    <p><b>Doctor:</b> Dr. {{ $appointment->schedule?->doctor?->docname }}</p>
                    <p><b>Date:</b> {{ $appointment->schedule?->scheduledate }}</p>
                    <p><b>Time:</b> {{ substr($appointment->schedule?->scheduletime, 0, 5) }}</p>
                </div>
                <br>
                <a href="{{ route('patient.appointments') }}" class="non-style-link"><button class="login-btn btn-primary btn" style="padding: 15px 30px;">View My Bookings</button></a>
                <a href="{{ route('patient.dashboard') }}" class="non-style-link" style="margin-left: 20px;"><button class="login-btn btn-primary-soft btn" style="padding: 15px 30px;">Back to Dashboard</button></a>
            </div>
        </center>
    </div>
</div>
@endsection
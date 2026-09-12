@extends('layouts.main')

@section('title', 'eSewa Payment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">
@endsection

@section('content')
<div class="container payment-page">
    <div class="menu">
        <table class="menu-container" border="0">
            <tr><td style="padding:10px" colspan="2">
                <table border="0" class="profile-container"><tr>
                    <td width="30%" style="padding-left:20px"><img src="{{ asset('img/user.png') }}" alt="" width="100%" style="border-radius:50%"></td>
                    <td style="padding:0;margin:0"><p class="profile-title">{{ Str::limit($patient->pname, 13) }}</p><p class="profile-subtitle">{{ Str::limit($patient->pemail, 22) }}</p></td>
                </tr><tr><td colspan="2"><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="logout-btn btn-primary-soft btn" style="width:100%">Log out</button></form></td></tr></table>
            </td></tr>
            <tr class="menu-row"><td class="menu-btn menu-icon-home"><a href="{{ route('patient.dashboard') }}" class="non-style-link-menu"><p class="menu-text">Home</p></a></td></tr>
            <tr class="menu-row"><td class="menu-btn menu-icon-doctor"><a href="{{ route('patient.doctors') }}" class="non-style-link-menu"><p class="menu-text">All Therapists</p></a></td></tr>
            <tr class="menu-row"><td class="menu-btn menu-icon-session"><a href="{{ route('patient.schedules') }}" class="non-style-link-menu"><p class="menu-text">Available Sessions</p></a></td></tr>
            <tr class="menu-row"><td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active"><a href="{{ route('patient.appointments') }}" class="non-style-link-menu non-style-link-menu-active"><p class="menu-text">My Bookings</p></a></td></tr>
            <tr class="menu-row"><td class="menu-btn menu-icon-settings"><a href="{{ route('patient.settings') }}" class="non-style-link-menu"><p class="menu-text">Settings</p></a></td></tr>
        </table>
    </div>

    <div class="dash-body">
        <div class="payment-card">
            <a href="{{ route('patient.appointments') }}" class="login-btn btn-primary-soft btn" style="display:inline-block;text-decoration:none;padding:11px 20px">Back to My Bookings</a>
            <h1 class="heading-main12" style="margin-top:25px">Pay with eSewa</h1>
            <p class="heading-sub12">Review your appointment details before continuing.</p>

            <div class="payment-details">
                <!-- <div><span class="payment-detail-label">Appointment</span><span class="payment-detail-value">{{ $appointment->appoid }}</span></div> -->
                <div><span class="payment-detail-label">Therapist</span><span class="payment-detail-value">Dr. {{ ucwords($appointment->schedule?->doctor?->docname ?? 'Unknown') }}</span></div>
                <div><span class="payment-detail-label">Session</span><span class="payment-detail-value">{{ $appointment->schedule?->title ?? 'Deleted Session' }}</span></div>
                <div><span class="payment-detail-label">Date</span><span class="payment-detail-value">{{ $appointment->schedule ? $appointment->schedule->scheduledate->format('M d, Y') : 'N/A' }}</span></div>
                <div><span class="payment-detail-label">Time</span><span class="payment-detail-value">{{ $appointment->schedule ? \Carbon\Carbon::parse($appointment->schedule->start_time ?? $appointment->schedule->scheduletime)->format('h:i A') : 'N/A' }}</span></div>
                <div><span class="payment-detail-label">Payment Method</span><span class="payment-detail-value">eSewa</span></div>
            </div>

            <div class="payment-disclaimer-box">Disclaimer: If your booking is cancelled, please kindly contact the office regarding your refund.</div>

            <form action="{{ $paymentUrl }}" method="POST">
            <input type="hidden" name="amount" value="{{ number_format($amount, 2, '.', '') }}">
            <input type="hidden" name="tax_amount" value="0">
            <input type="hidden" name="total_amount" value="{{ number_format($amount, 2, '.', '') }}">
            <input type="hidden" name="transaction_uuid" value="{{ $transactionUuid }}">
            <input type="hidden" name="product_code" value="{{ $merchantCode }}">
            <input type="hidden" name="product_service_charge" value="0">
            <input type="hidden" name="product_delivery_charge" value="0">
            <input type="hidden" name="success_url" value="{{ route('patient.esewa.success') }}">
            <input type="hidden" name="failure_url" value="{{ route('patient.esewa.failure') }}">
            <input type="hidden" name="signed_field_names" value="{{ $signedFieldNames }}">
            <input type="hidden" name="signature" value="{{ $signature }}">
            
                <button type="submit" class="login-btn btn-primary btn" style="width:100%;padding:14px">Pay NPR {{ number_format($amount, 2) }} via eSewa</button>
            </form>
        </div>
    </div>
</div>
@endsection
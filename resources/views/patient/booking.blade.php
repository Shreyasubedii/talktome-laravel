@extends('layouts.main')

@section('title', 'Book Appointment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">
<style>
.popup {
    animation: transitionIn-Y-bottom 0.5s;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="menu">
        <table class="menu-container" border="0">
            <tr>
                <td style="padding:10px" colspan="2">
                    <table border="0" class="profile-container">
                        <tr>
                            <td width="30%" style="padding-left:20px">
                                <img src="{{ asset('img/user.png') }}" alt="" width="100%" style="border-radius:50%">
                            </td>
                            <td style="padding:0px;margin:0px;">
                                <p class="profile-title">{{ Str::limit($patient->pname, 13) }}..</p>
                                <p class="profile-subtitle">{{ Str::limit($patient->pemail, 22) }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-btn btn-primary-soft btn"
                                        style="width: 100%;">Log out</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-home"><a href="{{ route('patient.dashboard') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Home</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active"><a
                        href="{{ route('patient.doctors') }}" class="non-style-link-menu non-style-link-menu-active">
                        <div>
                            <p class="menu-text">All Doctors</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session"><a href="{{ route('patient.schedules') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Scheduled Sessions</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment"><a href="{{ route('patient.appointments') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">My Bookings</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings"><a href="{{ route('patient.settings') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Settings</p>
                        </div>
                    </a></td>
            </tr>
        </table>
    </div>

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="{{ route('patient.doctors') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Let's Book!</p>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's
                        Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">{{ $today }}</p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img
                            src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <center>
                        <div style="display: flex; justify-content: center;">
                            <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0"
                                    style="padding: 30px;">
                                    <tr>
                                        <td>
                                            <p
                                                style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">
                                                Confirm Your Booking.</p><br>
                                            <p class="heading-sub12">Dr. {{ $doctor->docname }}</p>
                                            <p class="heading-sub12">{{ $doctor->specialty?->sname }}</p>
                                        </td>
                                    </tr>
                                    <form action="{{ route('patient.booking.store') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td class="label-td">
                                                <label for="schedule" class="form-label">Select Session: </label>
                                                <select name="schedule" class="box" required>
                                                    <option value="" disabled selected hidden>Choose a session</option>
                                                    @foreach($schedules as $schedule)
                                                    <option value="{{ $schedule->scheduleid }}">
                                                        {{ $schedule->title }} - {{ $schedule->scheduledate }}
                                                        ({{ substr($schedule->scheduletime, 0, 5) }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td">
                                                <label for="date" class="form-label">Appointment Date: </label>
                                                <input type="date" name="date" class="input-text" value="{{ $today }}"
                                                    required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 20px;">
                                                <input type="submit" value="Book Now" class="login-btn btn-primary btn"
                                                    style="width: 100%;">
                                            </td>
                                        </tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
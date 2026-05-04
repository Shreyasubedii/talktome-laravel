@extends('layouts.main')

@section('title', 'My Bookings')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
    .popup { animation: transitionIn-Y-bottom 0.5s; }
    .sub-table { animation: transitionIn-Y-bottom 0.5s; }
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
                                    <button type="submit" class="logout-btn btn-primary-soft btn" style="width: 100%;">Log out</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-home">
                    <a href="{{ route('patient.dashboard') }}" class="non-style-link-menu"><div><p class="menu-text">Home</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor">
                    <a href="{{ route('patient.doctors') }}" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">
                    <a href="{{ route('patient.schedules') }}" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                    <a href="{{ route('patient.appointments') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Bookings</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings">
                    <a href="{{ route('patient.settings') }}" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                </td>
            </tr>
        </table>
    </div>

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="{{ route('patient.dashboard') }}"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Booking history</p>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">{{ $today }}</p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Bookings ({{ $appointments->count() }})</p>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0" style="border:none">
                                <tbody>
                                    @foreach($appointments->chunk(3) as $chunk)
                                    <tr>
                                        @foreach($chunk as $appo)
                                        <td style="width: 25%;">
                                            <div class="dashboard-items search-items">
                                                <div style="width:100%;">
                                                    <div class="h3-search">
                                                        Booking Date: {{ $appo->appodate }}<br>
                                                        Reference Number: OC-000-{{ $appo->appoid }}
                                                    </div>
                                                    <div class="h1-search">
                                                        {{ Str::limit($appo->schedule?->title ?? 'Deleted Session', 21) }}<br>
                                                    </div>
                                                    <div class="h3-search">
                                                        Appointment Number:<div class="h1-search">{{ str_pad($appo->apponum, 2, '0', STR_PAD_LEFT) }}</div>
                                                    </div>
                                                    <div class="h3-search">
                                                        {{ $appo->schedule?->doctor?->docname ?? 'Unknown Doctor' }}
                                                    </div>
                                                    <div class="h4-search">
                                                        Scheduled Date: {{ $appo->schedule?->scheduledate ?? 'N/A' }}<br>Starts: <b>@ {{ $appo->schedule ? substr($appo->schedule->scheduletime, 0, 5) : 'N/A' }}</b> (24h)
                                                    </div>
                                                    <br>
                                                    <form action="{{ route('patient.appointments.destroy', $appo->appoid) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Cancel Booking</font></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    @if($appointments->isEmpty())
                                    <tr>
                                        <td colspan="3">
                                            <br><br><br><br>
                                            <center>
                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                            <br>
                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">You haven't booked anything yet!</p>
                                            </center>
                                            <br><br><br><br>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
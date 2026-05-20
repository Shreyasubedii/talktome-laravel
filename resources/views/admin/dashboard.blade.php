@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
                                <p class="profile-title">{{ Auth::guard('admin')->user()->aname ?? 'Administrator' }}
                                </p>
                                <p class="profile-subtitle">
                                    {{ Auth::guard('admin')->user()->aemail ?? 'admin@ttm.com' }}</p>
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
                <td
                    class="menu-btn menu-icon-dashbord {{ Route::is('admin.dashboard') ? 'menu-active menu-icon-dashbord-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"
                        class="non-style-link-menu {{ Route::is('admin.dashboard') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Dashboard</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td
                    class="menu-btn menu-icon-doctor {{ Route::is('admin.doctors') ? 'menu-active menu-icon-doctor-active' : '' }}">
                    <a href="{{ route('admin.doctors') }}"
                        class="non-style-link-menu {{ Route::is('admin.doctors') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Doctors</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td
                    class="menu-btn menu-icon-schedule {{ Route::is('admin.schedules') ? 'menu-active menu-icon-schedule-active' : '' }}">
                    <a href="{{ route('admin.schedules') }}"
                        class="non-style-link-menu {{ Route::is('admin.schedules') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Schedule</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td
                    class="menu-btn menu-icon-appoinment {{ Route::is('admin.appointments') ? 'menu-active menu-icon-appoinment-active' : '' }}">
                    <a href="{{ route('admin.appointments') }}"
                        class="non-style-link-menu {{ Route::is('admin.appointments') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Appointment</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td
                    class="menu-btn menu-icon-patient {{ Route::is('admin.patients') ? 'menu-active menu-icon-patient-active' : '' }}">
                    <a href="{{ route('admin.patients') }}"
                        class="non-style-link-menu {{ Route::is('admin.patients') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Patients</p>
                        </div>
                    </a>
                </td>
            </tr>
        </table>

    </div>

    <!-- <div class="dash-body" style="margin-top: 15px"> -->
    <div class="dash-body" style="margin-left:260px;">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
            <tr>
                <td colspan="2" class="nav-bar">
                    <form action="{{ route('admin.doctors') }}" method="get" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;
                        <input type="Submit" value="Search" class="login-btn btn-primary-soft btn"
                            style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        {{ \Carbon\Carbon::now()->format('Y-m-d') }}
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;">
                        <img src="{{ asset('img/calendar.svg') }}" width="100%">
                    </button>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">
                                    <div class="dashboard-items"
                                        style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div>
                                            <div class="h1-dashboard">{{ $doctorsCount }}</div><br>
                                            <div class="h3-dashboard">Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons"
                                            style="background-image: url('{{ asset('img/icons/doctors-hover.svg') }}');">
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items"
                                        style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                            <div class="h1-dashboard">{{ $patientsCount }}</div><br>
                                            <div class="h3-dashboard">Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons"
                                            style="background-image: url('{{ asset('img/icons/patients-hover.svg') }}');">
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items"
                                        style="padding:20px;margin:auto;width:95%;display: flex; ">
                                        <div>
                                            <div class="h1-dashboard">{{ $appointmentsCount }}</div><br>
                                            <div class="h3-dashboard">NewBooking &nbsp;&nbsp;</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons"
                                            style="margin-left: 0px;background-image: url('{{ asset('img/icons/book-hover.svg') }}');">
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items"
                                        style="padding:20px;margin:auto;width:95%;display: flex;padding-top:26px;padding-bottom:26px;">
                                        <div>
                                            <div class="h1-dashboard">{{ $sessionsCount }}</div><br>
                                            <div class="h3-dashboard" style="font-size: 15px">Today Sessions</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons"
                                            style="background-image: url('{{ asset('img/icons/session-iceblue.svg') }}');">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <table width="100%" border="0" class="dashbord-tables">
                        <tr>
                            <td>
                                <p
                                    style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                    Upcoming Appointments until Next
                                    {{ \Carbon\Carbon::now()->addWeek()->format('l') }}
                                </p>
                                <p
                                    style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                    Here's Quick access to Upcoming Appointments until 7 days<br>
                                    More details available in @Appointment section.
                                </p>
                            </td>
                            <td>
                                <p
                                    style="text-align:right;padding:10px;padding-right:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                    Upcoming Sessions until Next {{ \Carbon\Carbon::now()->addWeek()->format('l') }}
                                </p>
                                <p
                                    style="padding-bottom:19px;text-align:right;padding-right:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                    Here's Quick access to Upcoming Sessions that Scheduled until 7 days<br>
                                    Add, Remove and Many features available in @Schedule section.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <center>
                                    <div class="abc scroll" style="height: 200px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin" style="font-size: 12px;">Appointment
                                                        number
                                                    </th>
                                                    <th class="table-headin">Patient name</th>
                                                    <th class="table-headin">Doctor</th>
                                                    <th class="table-headin">Session</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($upcomingAppointments as $appo)
                                                <tr>
                                                    <td
                                                        style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);padding:20px;">
                                                        {{ $appo->apponum }}</td>
                                                    <td style="font-weight:600;">
                                                        &nbsp;{{ Str::limit($appo->patient?->pname ?? 'Unknown', 25) }}
                                                    </td>
                                                    <td style="font-weight:600;">
                                                        &nbsp;{{ Str::limit($appo->schedule?->doctor?->docname ?? 'Unknown', 25) }}
                                                    </td>
                                                    <td>{{ Str::limit($appo->schedule?->title ?? 'N/A', 15) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <center>
                                                            <br><br><br><br>
                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                            <p class="heading-main12"
                                                                style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                                Nothing to show!</p>
                                                            <br><br><br><br>
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </center>
                            </td>
                            <td width="50%" style="padding: 0;">
                                <center>
                                    <div class="abc scroll" style="height: 200px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin">Session Title</th>
                                                    <th class="table-headin">Doctor</th>
                                                    <th class="table-headin">Scheduled Date & Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($upcomingSessions as $session)
                                                <tr>
                                                    <td style="padding:20px;">
                                                        &nbsp;{{ Str::limit($session->title, 30) }}</td>
                                                    <td>{{ Str::limit($session->doctor?->docname ?? 'Unknown', 20) }}
                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $session->scheduledate }}<br>{{ $session->scheduletime }}
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <center>
                                                            <br><br><br><br>
                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                            <p class="heading-main12"
                                                                style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                                Nothing to show!</p>
                                                            <br><br><br><br>
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                    <a href="{{ route('admin.appointments') }}" class="non-style-link"><button
                                            class="btn-primary btn" style="width:85%">Show all
                                            Appointments</button></a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a href="{{ route('admin.schedules') }}" class="non-style-link"><button
                                            class="btn-primary btn" style="width:85%">Show all Sessions</button></a>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <!-- added feature from here  -->

        <!-- ADVANCED ANALYTICS SECTION -->

        <tr>
            <td colspan="4">

                <table width="100%" border="0" class="dashbord-tables" style="margin-top:20px;">

                    <!-- SECTION TITLE -->
                    <tr>
                        <td colspan="3">

                            <div style="
                        display:flex;
                        align-items:center;
                        gap:15px;
                        padding:20px;
                    ">

                                <div style="
                            width:60px;
                            height:60px;
                            border-radius:16px;
                            background:linear-gradient(135deg,#e0f2ff,#f4fbff);
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            box-shadow:0 4px 10px rgba(0,0,0,0.05);
                        ">
                                    <img src="{{ asset('img/icons/dashboard.svg') }}" width="30">
                                </div>

                                <div>
                                    <h2 style="
                                margin:0;
                                color:var(--primarycolor);
                                font-size:28px;
                                font-weight:700;
                            ">
                                        Advanced Analytics Dashboard
                                    </h2>

                                    <p style="
                                margin-top:5px;
                                color:#6c757d;
                                font-size:15px;
                            ">
                                        Real-time system insights and booking analytics
                                    </p>
                                </div>

                            </div>

                        </td>
                    </tr>

                    <!-- ANALYTICS CARDS -->
                    <tr>

                        <!-- TOP DOCTORS -->
                        <td width="33%" style="vertical-align:top;">

                            <div class="dashboard-items" style="
                        padding:25px;
                        margin:10px;
                        border-radius:20px;
                        min-height:320px;
                    ">

                                <div style="
                            display:flex;
                            align-items:center;
                            margin-bottom:25px;
                        ">

                                    <div style="
                                width:50px;
                                height:50px;
                                border-radius:14px;
                                background:#edf7ff;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                margin-right:15px;
                            ">
                                        <img src="{{ asset('img/icons/doctors-hover.svg') }}" width="24">
                                    </div>

                                    <div>
                                        <h3 style="margin:0;">
                                            Most Booked Doctors
                                        </h3>

                                        <p style="
                                    margin:0;
                                    color:#777;
                                    font-size:13px;
                                ">
                                            Highest patient engagement
                                        </p>
                                    </div>

                                </div>

                                @forelse($topDoctors as $doctor)

                                <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-bottom:16px;
                            padding-bottom:12px;
                            border-bottom:1px solid #f1f1f1;
                        ">

                                    <span style="font-weight:600;">
                                        {{ $doctor->docname }}
                                    </span>

                                    <span style="
                                background:#daf1ff;
                                color:#0077b6;
                                padding:6px 12px;
                                border-radius:12px;
                                font-weight:700;
                                font-size:14px;
                            ">
                                        {{ $doctor->total_bookings }}
                                    </span>

                                </div>

                                @empty

                                <p>No doctor analytics available.</p>

                                @endforelse

                            </div>

                        </td>

                        <!-- TOP PATIENTS -->
                        <td width="33%" style="vertical-align:top;">

                            <div class="dashboard-items" style="
                        padding:25px;
                        margin:10px;
                        border-radius:20px;
                        min-height:320px;
                    ">

                                <div style="
                            display:flex;
                            align-items:center;
                            margin-bottom:25px;
                        ">

                                    <div style="
                                width:50px;
                                height:50px;
                                border-radius:14px;
                                background:#effff2;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                margin-right:15px;
                            ">
                                        <img src="{{ asset('img/icons/patients-hover.svg') }}" width="24">
                                    </div>

                                    <div>
                                        <h3 style="margin:0;">
                                            Active Patients
                                        </h3>

                                        <p style="
                                    margin:0;
                                    color:#777;
                                    font-size:13px;
                                ">
                                            Most frequent bookings
                                        </p>
                                    </div>

                                </div>

                                @forelse($topPatients as $patient)

                                <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-bottom:16px;
                            padding-bottom:12px;
                            border-bottom:1px solid #f1f1f1;
                        ">

                                    <span style="font-weight:600;">
                                        {{ $patient->pname }}
                                    </span>

                                    <span style="
                                background:#e7ffe9;
                                color:#2b9348;
                                padding:6px 12px;
                                border-radius:12px;
                                font-weight:700;
                                font-size:14px;
                            ">
                                        {{ $patient->total_appointments }}
                                    </span>

                                </div>

                                @empty

                                <p>No patient analytics available.</p>

                                @endforelse

                            </div>

                        </td>

                        <!-- SPECIALTIES -->
                        <td width="33%" style="vertical-align:top;">

                            <div class="dashboard-items" style="
                        padding:25px;
                        margin:10px;
                        border-radius:20px;
                        min-height:320px;
                    ">

                                <div style="
                            display:flex;
                            align-items:center;
                            margin-bottom:25px;
                        ">

                                    <div style="
                                width:50px;
                                height:50px;
                                border-radius:14px;
                                background:#fff6ea;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                margin-right:15px;
                            ">
                                        <img src="{{ asset('img/icons/session-iceblue.svg') }}" width="24">
                                    </div>

                                    <div>
                                        <h3 style="margin:0;">
                                            Popular Specialties
                                        </h3>

                                        <p style="
                                    margin:0;
                                    color:#777;
                                    font-size:13px;
                                ">
                                            Most available specialties
                                        </p>
                                    </div>

                                </div>

                                @forelse($topSpecialties as $specialty)

                                <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-bottom:16px;
                            padding-bottom:12px;
                            border-bottom:1px solid #f1f1f1;
                        ">

                                    <span style="font-weight:600;">
                                        {{ $specialty->sname }}
                                    </span>

                                    <span style="
                                background:#fff0d6;
                                color:#bc6c25;
                                padding:6px 12px;
                                border-radius:12px;
                                font-weight:700;
                                font-size:14px;
                            ">
                                        {{ $specialty->total_doctors }}
                                    </span>

                                </div>

                                @empty

                                <p>No specialty analytics available.</p>

                                @endforelse

                            </div>

                        </td>

                    </tr>

                    <!-- APPOINTMENT STATS -->
                    <tr>

                        <td colspan="2" style="vertical-align:top;">

                            <div class="dashboard-items" style="
                        padding:30px;
                        margin:10px;
                        border-radius:20px;
                    ">

                                <div style="
                            display:flex;
                            align-items:center;
                            margin-bottom:30px;
                        ">

                                    <img src="{{ asset('img/icons/book-hover.svg') }}" width="35"
                                        style="margin-right:15px;">

                                    <div>
                                        <h2 style="margin:0;">
                                            Appointment Statistics
                                        </h2>

                                        <p style="
                                    margin:0;
                                    color:#777;
                                    font-size:14px;
                                ">
                                            Weekly and monthly booking overview
                                        </p>
                                    </div>

                                </div>

                                <div style="
                            display:flex;
                            gap:25px;
                            justify-content:space-between;
                            flex-wrap:wrap;
                        ">

                                    <!-- MONTH -->
                                    <div style="
                                flex:1;
                                min-width:220px;
                                background:#f8fbff;
                                border-radius:18px;
                                padding:30px;
                                text-align:center;
                            ">

                                        <img src="{{ asset('img/icons/book-hover.svg') }}" width="45"
                                            style="margin-bottom:15px;">

                                        <div class="h1-dashboard" style="margin-bottom:10px;">
                                            {{ $monthlyAppointments }}
                                        </div>

                                        <div class="h2-dashboard" style="margin-top:5px;">
                                            Monthly Appointments
                                        </div>

                                    </div>

                                    <!-- WEEK -->
                                    <div style=" flex:1; min-width:220px; background:#f8fffa; border-radius:18px;
                                            padding:30px; text-align:center; ">

                                        <img src=" {{ asset('img/icons/session-iceblue.svg') }}" width="45"
                                            style="margin-bottom:15px;">

                                        <div class="h1-dashboard" style="margin-bottom:10px;">
                                            {{ $weeklyAppointments }}
                                        </div>

                                        <div class="h2-dashboard" style="margin-top:5px;">
                                            Weekly Appointments
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </td>

                        <!-- SYSTEM INSIGHTS -->
                        <td style="vertical-align:top;">

                            <div class="dashboard-items" style="
                        padding:30px;
                        margin:10px;
                        border-radius:20px;
                        min-height:280px;
                    ">

                                <div style="
                            display:flex;
                            align-items:center;
                            margin-bottom:25px;
                        ">

                                    <img src="{{ asset('img/icons/dashboard.svg') }}" width="35"
                                        style="margin-right:15px;">

                                    <div>
                                        <h2 style="margin:0;">
                                            System Insights
                                        </h2>

                                        <p style="
                                    margin:0;
                                    color:#777;
                                    font-size:14px;
                                ">
                                            Platform performance summary
                                        </p>
                                    </div>

                                </div>

                                <div style="
                            background:#f9fbfc;
                            border-radius:18px;
                            padding:25px;
                            line-height:32px;
                            color:#555;
                            font-size:16px;
                        ">

                                    <strong>{{ $doctorsCount }}</strong> doctors are currently active on the
                                    platform.

                                    <br><br>

                                    <strong>{{ $patientsCount }}</strong> registered patients are using the system.

                                    <br><br>

                                    This month recorded
                                    <strong>{{ $monthlyAppointments }}</strong>
                                    successful appointment bookings.

                                </div>

                            </div>

                        </td>

                    </tr>

                </table>

            </td>
        </tr>
        <!-- added till here -->


    </div>
</div>
@endsection
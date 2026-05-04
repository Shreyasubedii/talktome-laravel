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
                                <p class="profile-title">{{ Auth::guard('admin')->user()->aname ?? 'Administrator' }}</p>
                                <p class="profile-subtitle">{{ Auth::guard('admin')->user()->aemail ?? 'admin@ttm.com' }}</p>
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
                <td class="menu-btn menu-icon-dashbord {{ Route::is('admin.dashboard') ? 'menu-active menu-icon-dashbord-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="non-style-link-menu {{ Route::is('admin.dashboard') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Dashboard</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor {{ Route::is('admin.doctors') ? 'menu-active menu-icon-doctor-active' : '' }}">
                    <a href="{{ route('admin.doctors') }}" class="non-style-link-menu {{ Route::is('admin.doctors') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Doctors</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-schedule {{ Route::is('admin.schedules') ? 'menu-active menu-icon-schedule-active' : '' }}">
                    <a href="{{ route('admin.schedules') }}" class="non-style-link-menu {{ Route::is('admin.schedules') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Schedule</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment {{ Route::is('admin.appointments') ? 'menu-active menu-icon-appoinment-active' : '' }}">
                    <a href="{{ route('admin.appointments') }}" class="non-style-link-menu {{ Route::is('admin.appointments') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Appointment</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-patient {{ Route::is('admin.patients') ? 'menu-active menu-icon-patient-active' : '' }}">
                    <a href="{{ route('admin.patients') }}" class="non-style-link-menu {{ Route::is('admin.patients') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Patients</p>
                        </div>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="dash-body" style="margin-top: 15px">
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
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div>
                                            <div class="h1-dashboard">{{ $doctorsCount }}</div><br>
                                            <div class="h3-dashboard">Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/doctors-hover.svg') }}');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                            <div class="h1-dashboard">{{ $patientsCount }}</div><br>
                                            <div class="h3-dashboard">Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/patients-hover.svg') }}');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex; ">
                                        <div>
                                            <div class="h1-dashboard">{{ $appointmentsCount }}</div><br>
                                            <div class="h3-dashboard">NewBooking &nbsp;&nbsp;</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('{{ asset('img/icons/book-hover.svg') }}');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;padding-top:26px;padding-bottom:26px;">
                                        <div>
                                            <div class="h1-dashboard">{{ $sessionsCount }}</div><br>
                                            <div class="h3-dashboard" style="font-size: 15px">Today Sessions</div>
                                        </div>
                                        <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/session-iceblue.svg') }}');"></div>
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
                                <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                    Upcoming Appointments until Next {{ \Carbon\Carbon::now()->addWeek()->format('l') }}
                                </p>
                                <p style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                    Here's Quick access to Upcoming Appointments until 7 days<br>
                                    More details available in @Appointment section.
                                </p>
                            </td>
                            <td>
                                <p style="text-align:right;padding:10px;padding-right:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                    Upcoming Sessions until Next {{ \Carbon\Carbon::now()->addWeek()->format('l') }}
                                </p>
                                <p style="padding-bottom:19px;text-align:right;padding-right:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
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
                                                    <th class="table-headin" style="font-size: 12px;">Appointment number</th>
                                                    <th class="table-headin">Patient name</th>
                                                    <th class="table-headin">Doctor</th>
                                                    <th class="table-headin">Session</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($upcomingAppointments as $appo)
                                                <tr>
                                                    <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);padding:20px;">{{ $appo->apponum }}</td>
                                                    <td style="font-weight:600;"> &nbsp;{{ Str::limit($appo->patient?->pname ?? 'Unknown', 25) }}</td>
                                                    <td style="font-weight:600;"> &nbsp;{{ Str::limit($appo->schedule?->doctor?->docname ?? 'Unknown', 25) }}</td>
                                                    <td>{{ Str::limit($appo->schedule?->title ?? 'N/A', 15) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <center>
                                                            <br><br><br><br>
                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nothing to show!</p>
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
                                                    <td style="padding:20px;"> &nbsp;{{ Str::limit($session->title, 30) }}</td>
                                                    <td>{{ Str::limit($session->doctor?->docname ?? 'Unknown', 20) }}</td>
                                                    <td style="text-align:center;">{{ $session->scheduledate }}<br>{{ $session->scheduletime }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <center>
                                                            <br><br><br><br>
                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nothing to show!</p>
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
                                    <a href="{{ route('admin.appointments') }}" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show all Appointments</button></a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a href="{{ route('admin.schedules') }}" class="non-style-link"><button class="btn-primary btn" style="width:85%">Show all Sessions</button></a>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
@extends('layouts.main')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
    .dashbord-tables {
        animation: transitionIn-Y-over 0.5s;
    }
    .filter-container {
        animation: transitionIn-Y-bottom 0.5s;
    }
    .sub-table, .anime {
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
                                    <button type="submit" class="logout-btn btn-primary-soft btn" style="width: 100%;">Log out</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-home {{ Route::is('patient.dashboard') ? 'menu-active menu-icon-home-active' : '' }}">
                    <a href="{{ route('patient.dashboard') }}" class="non-style-link-menu {{ Route::is('patient.dashboard') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">Home</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor {{ Route::is('patient.doctors') ? 'menu-active menu-icon-doctor-active' : '' }}">
                    <a href="{{ route('patient.doctors') }}" class="non-style-link-menu {{ Route::is('patient.doctors') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">All Doctors</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">
                    <a href="{{ route('patient.schedules') }}" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment {{ Route::is('patient.appointments') ? 'menu-active menu-icon-appoinment-active' : '' }}">
                    <a href="{{ route('patient.appointments') }}" class="non-style-link-menu {{ Route::is('patient.appointments') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">My Bookings</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings {{ Route::is('patient.settings') ? 'menu-active menu-icon-settings-active' : '' }}">
                    <a href="{{ route('patient.settings') }}" class="non-style-link-menu {{ Route::is('patient.settings') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">Settings</p></div></a>
                </td>
            </tr>
        </table>
    </div>

    <div class="dash-body" style="margin-top: 15px">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
            <tr>
                <td colspan="1" class="nav-bar">
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Home</p>
                </td>
                <td width="25%"></td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">{{ $today }}</p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <center>
                        <table class="filter-container doctor-header patient-header" style="border: none;width:95%" border="0">
                            <tr>
                                <td>
                                    <h3>Welcome!</h3>
                                    <h1>{{ $patient->pname }}.</h1>
                                    <p>Haven't any idea about doctors? no problem let's jump to <a href="{{ route('patient.doctors') }}" class="non-style-link"><b>"All Doctors"</b></a> section.<br>
                                        Track your past and future appointments history.<br>Also find out the expected arrival time of your doctor or medical consultant.<br><br>
                                    </p>
                                    <h3>Channel a Doctor Here</h3>
                                    <form action="{{ route('patient.doctors') }}" method="get" style="display: flex">
                                        <input type="search" name="search" class="input-text" placeholder="Search Doctor and We will Find The Session Available" list="doctors" style="width:45%;">&nbsp;&nbsp;
                                        <datalist id="doctors">
                                            @foreach(\App\Models\Doctor::all() as $doc)
                                            <option value="{{ $doc->docname }}">
                                            @endforeach
                                        </datalist>
                                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding: 10px 25px;">
                                    </form>
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table border="0" width="100%">
                        <tr>
                            <td width="50%">
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
                                                        <div class="h1-dashboard">{{ \App\Models\Doctor::count() }}</div><br>
                                                        <div class="h3-dashboard">All Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/doctors-hover.svg') }}');"></div>
                                                </div>
                                            </td>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex; ">
                                                    <div>
                                                        <div class="h1-dashboard">{{ $appointments->count() }}</div><br>
                                                        <div class="h3-dashboard">New Booking &nbsp;&nbsp;</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('{{ asset('img/icons/book-hover.svg') }}');"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                                    <div>
                                                        <div class="h1-dashboard">{{ \App\Models\Schedule::where('scheduledate', $today)->count() }}</div><br>
                                                        <div class="h3-dashboard" style="font-size: 15px">Today Sessions</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/session-iceblue.svg') }}');"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </td>
                            <td>
                                <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Your Upcoming Bookings</p>
                                <center>
                                    <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin">Appoint. Number</th>
                                                    <th class="table-headin">Session Title</th>
                                                    <th class="table-headin">Doctor</th>
                                                    <th class="table-headin">Scheduled Date & Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($appointments->where('appodate', '>=', $today) as $appo)
                                                <tr>
                                                    <td style="padding:30px;font-size:25px;font-weight:700;">{{ $appo->apponum }}</td>
                                                    <td style="padding:20px;">{{ Str::limit($appo->schedule?->title ?? 'Deleted Session', 30) }}</td>
                                                    <td>{{ Str::limit($appo->schedule?->doctor?->docname ?? 'Unknown', 20) }}</td>
                                                    <td style="text-align:center;">{{ $appo->schedule?->scheduledate }}<br>{{ substr($appo->schedule?->scheduletime, 0, 5) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <br><br>
                                                        <center>
                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                            <p class="heading-main12" style="font-size:20px;color:rgb(49, 49, 49)">Nothing to show!</p>
                                                        </center>
                                                        <br><br>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
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
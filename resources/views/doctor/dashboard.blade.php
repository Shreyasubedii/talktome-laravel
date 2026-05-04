@extends('layouts.main')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">  
<link rel="stylesheet" href="{{ asset('css/main.css') }}">  
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
    .dashbord-tables,.doctor-heade{
        animation: transitionIn-Y-over 0.5s;
    }
    .filter-container{
        animation: transitionIn-Y-bottom  0.5s;
    }
    .sub-table,#anim{
        animation: transitionIn-Y-bottom 0.5s;
    }
    .doctor-heade{
        animation: transitionIn-Y-over 0.5s;
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
                            <td width="30%" style="padding-left:20px" >
                                <img src="{{ asset('img/user.png') }}" alt="" width="100%" style="border-radius:50%">
                            </td>
                            <td style="padding:0px;margin:0px;">
                                <p class="profile-title">{{ Str::limit($doctor->docname, 13) }}..</p>
                                <p class="profile-subtitle">{{ Str::limit($doctor->docemail, 22) }}</p>
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
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-dashbord {{ Route::is('doctor.dashboard') ? 'menu-active menu-icon-dashbord-active' : '' }}" >
                    <a href="{{ route('doctor.dashboard') }}" class="non-style-link-menu {{ Route::is('doctor.dashboard') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">Dashboard</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment {{ Route::is('doctor.appointments') ? 'menu-active menu-icon-appoinment-active' : '' }}">
                    <a href="{{ route('doctor.appointments') }}" class="non-style-link-menu {{ Route::is('doctor.appointments') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">My Appointments</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-session {{ Route::is('doctor.schedules') ? 'menu-active menu-icon-session-active' : '' }}">
                    <a href="{{ route('doctor.schedules') }}" class="non-style-link-menu {{ Route::is('doctor.schedules') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">My Sessions</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-patient {{ Route::is('doctor.patients') ? 'menu-active menu-icon-patient-active' : '' }}">
                    <a href="{{ route('doctor.patients') }}" class="non-style-link-menu {{ Route::is('doctor.patients') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">My Patients</p></div></a>
                </td>
            </tr>
            <tr class="menu-row" >
                <td class="menu-btn menu-icon-settings {{ Route::is('doctor.settings') ? 'menu-active menu-icon-settings-active' : '' }}">
                    <a href="{{ route('doctor.settings') }}" class="non-style-link-menu {{ Route::is('doctor.settings') ? 'non-style-link-menu-active' : '' }}"><div><p class="menu-text">Settings</p></div></a>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="dash-body" style="margin-top: 15px">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
            <tr>
                <td colspan="1" class="nav-bar" >
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Dashboard</p>
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
                <td colspan="4" >
                    <center>
                    <table class="filter-container doctor-header" style="border: none;width:95%" border="0" >
                    <tr>
                        <td >
                            <h3>Welcome!</h3>
                            <h1>{{ $doctor->docname }}.</h1>
                            <p>Thanks for joining with us. We are always trying to get you a complete service<br>
                            You can view your daily schedule, Reach Patients Appointment at home!<br><br>
                            </p>
                            <a href="{{ route('doctor.appointments') }}" class="non-style-link"><button class="btn-primary btn" style="width:30%">View My Appointments</button></a>
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
                                                <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                                    <div>
                                                        <div class="h1-dashboard">{{ \App\Models\Patient::count() }}</div><br>
                                                        <div class="h3-dashboard">All Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/patients-hover.svg') }}');"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex; ">
                                                    <div>
                                                        <div class="h1-dashboard">{{ \App\Models\Appointment::where('appodate', '>=', $today)->count() }}</div><br>
                                                        <div class="h3-dashboard">New Booking &nbsp;&nbsp;</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('{{ asset('img/icons/book-hover.svg') }}');"></div>
                                                </div>
                                            </td>
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
                                <p id="anim" style="font-size: 20px;font-weight:600;padding-left: 40px;">Your Upcoming Sessions until Next week</p>
                                <center>
                                    <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                    <table width="85%" class="sub-table scrolldown" border="0" >
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Session Title</th>
                                            <th class="table-headin">Scheduled Date</th>
                                            <th class="table-headin">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($schedules->where('scheduledate', '>=', $today)->where('scheduledate', '<=', date('Y-m-d', strtotime('+1 week'))) as $schedule)
                                        <tr>
                                            <td style="padding:20px;"> &nbsp;{{ Str::limit($schedule->title, 30) }}</td>
                                            <td style="padding:20px;font-size:13px;">{{ $schedule->scheduledate }}</td>
                                            <td style="text-align:center;">{{ substr($schedule->scheduletime, 0, 5) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3">
                                                <br><br><br><br>
                                                <center>
                                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nothing to show!</p>
                                                </center>
                                                <br><br><br><br>
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
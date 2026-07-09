@extends('layouts.main')

@section('title', 'My Patients')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
<style>
.popup {
    animation: transitionIn-Y-bottom 0.5s;
}

.sub-table {
    animation: transitionIn-Y-bottom 0.5s;
}

.overlay{
    position:fixed;
    top:0;
    bottom:0;
    left:0;
    right:0;
    background:rgba(0,0,0,0.5);
    transition:opacity 500ms;
    z-index:999;
}

.popup{
    margin:70px auto;
    padding:20px;
    background:#fff;
    border-radius:8px;
    width:45%;
    position:relative;
}

.popup .close{
    position:absolute;
    top:15px;
    right:25px;
    font-size:30px;
    text-decoration:none;
    color:#333;
}

.popup .close:hover{
    color:red;
}

.content{
    max-height:80vh;
    overflow:auto;
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
                                <p class="profile-title">Dr. {{ Str::limit(ucwords($doctor->docname), 13) }}</p>
                                <p class="profile-subtitle">{{ Str::limit($doctor->docemail, 22) }}</p>
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
                <td class="menu-btn menu-icon-dashbord">
                    <a href="{{ route('doctor.dashboard') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Dashboard</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment">
                    <a href="{{ route('doctor.appointments') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">My Appointments</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">
                    <a href="{{ route('doctor.schedules') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">My Availability</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                    <a href="{{ route('doctor.patients') }}" class="non-style-link-menu non-style-link-menu-active">
                        <div>
                            <p class="menu-text">My Patients</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings">
                    <a href="{{ route('doctor.settings') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Settings</p>
                        </div>
                    </a>
                </td>
            </tr>
        </table>
    </div>

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="{{ route('doctor.dashboard') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <form action="{{ route('doctor.patients') }}" method="get" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Patient name or Email" value="{{ request('search') }}">&nbsp;&nbsp;
                        <input type="Submit" value="Search" class="login-btn btn-primary btn"
                            style="padding: 10px 25px;">
                    </form>
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
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Patients
                        ({{ $patients->count() }})</p>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                <thead>
                                    <tr>
                                        <th class="table-headin">Name</th>
                                        <th class="table-headin">NIC</th>
                                        <th class="table-headin">Telephone</th>
                                        <th class="table-headin">Email</th>
                                        <th class="table-headin">Date of Birth</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patients as $patient)
                                    <tr>
                                        <td> &nbsp;{{ Str::limit($patient->pname, 35) }}</td>
                                        <td>{{ $patient->pnic }}</td>
                                        <td>{{ $patient->ptel }}</td>
                                        <td>{{ Str::limit($patient->pemail, 20) }}</td>
                                        <td>{{ $patient->pdob }}</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                {{-- View button or action can be added here --}}
                                                <a href="?action=view&id={{ $patient->pid }}"
                                                class="non-style-link">
                                                 <button class="btn-primary-soft btn button-icon btn-view"
                                                  style="padding-left:40px;padding-top:12px;padding-bottom:12px;margin-top:10px;">
                                                   <font class="tn-in-text">View</font>
                                                 </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('img/nothingfound.png') }}" width="25%">
                                                <br>
                                                <p class="heading-main12"
                                                    style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No
                                                    patients found!</p>
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
    </div>
</div>

@if(request('action') == 'view')

@php
    $viewPatient = $patients->where('pid', request('id'))->first();
@endphp

@if($viewPatient)

<div id="popup1" class="overlay">
    <div class="popup">

        <center>

            <a class="close" href="{{ route('doctor.patients') }}">&times;</a>

            <div class="content">
                <br>

                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">

                    <tr>
                        <td colspan="2">
                            <p class="heading-main12"
                                style="margin-left:0;font-size:24px;color:rgb(49,49,49)">
                                Patient Details
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td class="label-td">Name:</td>
                        <td>{{ $viewPatient->pname }}</td>
                    </tr>

                    <tr>
                        <td class="label-td">Email:</td>
                        <td>{{ $viewPatient->pemail }}</td>
                    </tr>

                    <tr>
                        <td class="label-td">Phone:</td>
                        <td>{{ $viewPatient->ptel }}</td>
                    </tr>

                    <tr>
                        <td class="label-td">NIC:</td>
                        <td>{{ $viewPatient->pnic }}</td>
                    </tr>

                    <tr>
                        <td class="label-td">Date of Birth:</td>
                        <td>{{ $viewPatient->pdob }}</td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br>

                            <a href="{{ route('doctor.patients') }}">
                                <input type="button"
                                    value="Close"
                                    class="login-btn btn-primary-soft btn">
                            </a>

                        </td>
                    </tr>

                </table>

            </div>

        </center>

    </div>
</div>

@endif
@endif

@endsection
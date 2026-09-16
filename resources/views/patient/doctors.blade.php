@extends('layouts.main')

@section('title', 'All Doctors')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">
<style>
.popup {
    animation: transitionIn-Y-bottom 0.5s;
}

.sub-table {
    animation: transitionIn-Y-bottom 0.5s;
}

.overlay{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    background: rgba(0,0,0,.55);

    display: flex;
    justify-content: center;
    align-items: center;

    z-index: 99999;
}

.popup{
    position: relative;

    width: 45%;
    max-width: 700px;
    max-height: 85vh;

    background: #fff;
    border-radius: 10px;

    padding: 25px;

    overflow-y: auto;

    z-index: 100000;
}

.popup .close{
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    text-decoration: none;
    color: #444;
}

.popup .close:hover{
    color: red;
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
                                <p class="profile-title">{{ Str::limit($patient->pname, 13) }}</p>
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
                <td class="menu-btn menu-icon-home">
                    <a href="{{ route('patient.dashboard') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Home</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                    <a href="{{ route('patient.doctors') }}" class="non-style-link-menu non-style-link-menu-active">
                        <div>
                            <p class="menu-text">All Therapists </p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">
                    <a href="{{ route('patient.schedules') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Available Sessions</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment">
                    <a href="{{ route('patient.appointments') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">My Bookings</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings">

                    <a href="{{ route('patient.daylog') }}" class="non-style-link-menu">

                        <div>
                            <p class="menu-text">Log Your Day</p>
                        </div>

                    </a>

                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">

                    <a href="{{ route('patient.journal') }}" class="non-style-link-menu">

                        <div>
                            <p class="menu-text">
                                Journal Reflection
                            </p>
                        </div>

                    </a>

                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings">
                    <a href="{{ route('patient.settings') }}" class="non-style-link-menu">
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
                    <a href="{{ route('patient.dashboard') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <form action="{{ route('patient.doctors') }}" method="get" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Doctor name or Email" value="{{ request('search') }}">&nbsp;&nbsp;
                        <input type="Submit" value="Search" class="login-btn btn-primary btn"
                            style="padding: 10px 25px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's
                        Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0; text-align:right;">{{ $today }}</p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img
                            src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Doctors
                        ({{ $doctors->count() }})</p>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">Therapist Name</th>
                                        <th class="table-headin">Email</th>
                                        <th class="table-headin">Specialties</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($doctors as $doc)
                                    <tr>
                                        <td> &nbsp;{{'Dr. ' .Str::limit($doc->docname, 30) }}</td>
                                        <td>{{ Str::limit($doc->docemail, 20) }}</td>
                                        <td>{{ Str::limit($doc->specialty?->sname ?? 'General', 20) }}</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                <a href="?action=view&id={{ $doc->docid }}" class="non-style-link">
                                                    <button class="btn-primary-soft btn button-icon btn-view"
                                                      style="padding-left:40px;padding-top:12px;padding-bottom:12px;margin-top:10px;">
                                                       <font class="tn-in-text">View</font>
                                                     </button>
                                                    </a>

                                                &nbsp;&nbsp;&nbsp;
                                                <a href="{{ route('patient.schedules', ['search' => $doc->docname]) }}"
                                                    class="non-style-link"><button
                                                        class="btn-primary-soft btn button-icon menu-icon-session-active"
                                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                        <font class="tn-in-text">Sessions</font>
                                                    </button></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                <br>
                                                <p class="heading-main12"
                                                    style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No
                                                    doctors found!</p>
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
    $viewDoctor = $doctors->where('docid', request('id'))->first();
@endphp

@if($viewDoctor)

<div class="overlay">
    <div class="popup">

        <center>

            <a class="close" href="{{ route('patient.doctors') }}">&times;</a>

            <div class="content">

                <br>

                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">

                    <tr>
                        <td colspan="2">
                            <p class="heading-main12"
                                style="margin-left:0;font-size:24px;color:rgb(49,49,49)">
                                Therapist Details
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td class="label-td">Name:</td>
                        <td>Dr. {{ $viewDoctor->docname }}</td>
                    </tr>

                    <tr>
                        <td class="label-td">Email:</td>
                        <td>{{ $viewDoctor->docemail }}</td>
                    </tr>

                    <tr>
                        <td class="label-td">Phone:</td>
                        <td>{{ $viewDoctor->doctel ?? 'N/A' }}</td>
                    </tr>
 
                    <tr>
                        <td class="label-td">Specialization:</td>
                        <td>{{ $viewDoctor->specialty?->sname ?? 'General' }}</td>
                    </tr>

                    <!-- @if(isset($viewDoctor->experience))
                    <tr>
                        <td class="label-td">Experience:</td>
                        <td>{{ $viewDoctor->experience }} Years</td>
                    </tr>
                    @endif

                    @if(isset($viewDoctor->qualification))
                    <tr>
                        <td class="label-td">Qualification:</td>
                        <td>{{ $viewDoctor->qualification }}</td>
                    </tr>
                    @endif

                    @if(isset($viewDoctor->bio))
                    <tr>
                        <td class="label-td">About</td>
                        <td>{{ $viewDoctor->bio }}</td>
                    </tr>
                    @endif -->

                    <tr>
                        <td colspan="2">
                            <br>

                            <a href="{{ route('patient.doctors') }}">
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
@extends('layouts.main')

@section('title', 'My Sessions')

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
                                <p class="profile-title">{{ Str::limit($doctor->docname, 13) }}..</p>
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
                <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                    <a href="{{ route('doctor.schedules') }}" class="non-style-link-menu non-style-link-menu-active">
                        <div>
                            <p class="menu-text">My Sessions</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-patient">
                    <a href="{{ route('doctor.patients') }}" class="non-style-link-menu">
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
                    <a href="{{ route('doctor.schedules') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Sessions</p>

                <td width="25%" style="text-align:right;">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        {{ $today }}
                    </p>

                    <!-- ADD SESSION BUTTON (clean placement) -->
                    <div style="margin-top:10px;">
                        <button onclick="document.getElementById('addSessionBox').style.display='block'"
                            class="btn-primary btn" style="padding:10px 15px; font-size:14px; border-radius:6px;">
                            + Add Session
                        </button>
                    </div>
                </td>

                <td width="10%" style="text-align:center;">
                    <button class="btn-label"
                        style="display:flex;justify-content:center;align-items:center;margin:auto;">
                        <img src="{{ asset('img/calendar.svg') }}" width="100%">
                    </button>
                </td>

            </tr>

            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Sessions
                        ({{ $schedules->count() }}) </p>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="padding-top:0px;width: 100%;">
                    <center>
                        <table class="filter-container" border="0">
                            <tr>
                                <td width="10%"></td>
                                <td width="5%" style="text-align: center;">Date:</td>
                                <td width="30%">
                                    <form action="{{ route('doctor.schedules') }}" method="get">
                                        <input type="date" name="scheduledate" id="date"
                                            class="input-text filter-container-items" style="margin: 0;width: 95%;"
                                            value="{{ request('scheduledate') }}">
                                </td>
                                <td width="12%">
                                    <input type="submit" name="filter" value=" Filter"
                                        class=" btn-primary-soft btn button-icon btn-filter"
                                        style="padding: 15px; margin :0;width:100%">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">Session Title</th>
                                        <th class="table-headin">Scheduled Date & Time</th>
                                        <th class="table-headin">Max num that can be booked</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                    <tr>
                                        <td> &nbsp;{{ Str::limit($schedule->title, 30) }}</td>
                                        <td style="text-align:center;">{{ $schedule->scheduledate }}
                                            {{ substr($schedule->scheduletime, 0, 5) }}</td>
                                        <td style="text-align:center;">{{ $schedule->nop }}</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                {{-- Action links for view details or delete can be added here --}}
                                                <form
                                                    action="{{ route('doctor.schedules.destroy', $schedule->scheduleid) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-primary-soft btn button-icon btn-delete"
                                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                        <font class="tn-in-text">Cancel Session</font>
                                                    </button>
                                                </form>
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
                                                    style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We
                                                    couldn't find anything!</p>
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
@endsection
@extends('layouts.main')

@section('title', 'Doctor Recommendation')

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
                <td class="menu-btn menu-icon-home">
                    <a href="{{ route('patient.dashboard') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Home</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor">
                    <a href="{{ route('patient.doctors') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">All Doctors</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">
                    <a href="{{ route('patient.schedules') }}" class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Scheduled Sessions</p>
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
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Doctor Recommendation</p>
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
                <td colspan="4">
                    <center>
                        <table border="0" width="80%" class="sub-table scrolldown" style="padding:50px;border:none;">
                            <tr>
                                <td colspan="2">
                                    <p class="heading-main12">Find Your Specialist</p>
                                    <p class="heading-sub12">Describe your symptoms or problem below, and we'll
                                        recommend the best professional for you.</p>
                                    <br>
                                    <form method="POST" action="{{ route('patient.recommendation') }}">
                                        @csrf
                                        <textarea name="problem" rows="5" class="input-text"
                                            placeholder="e.g. I have been feeling very stressed and having trouble sleeping lately..."
                                            style="width: 100%; padding: 15px;"
                                            required>{{ $problem ?? '' }}</textarea><br><br>
                                        <input type="submit" value="Get Recommendations"
                                            class="login-btn btn-primary btn" style="width: 100%;">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>

            @if(isset($doctors) && $doctors->count() > 0)
            <tr>
                <td colspan="4">
                    <center>
                        <p class="heading-main12" style="font-size: 20px;">Recommended Specialists</p>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">Doctor Name</th>
                                        <th class="table-headin">Specialty</th>
                                        <th class="table-headin">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctors as $doc)
                                    <tr>
                                        <td>Dr. {{ $doc->docname }}</td>
                                        <td>{{ $doc->specialty?->sname }}</td>
                                        <td>
                                            <a href="{{ route('patient.booking', $doc->docid) }}"
                                                class="non-style-link"><button
                                                    class="btn-primary-soft btn button-icon menu-icon-session-active"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;">
                                                    <font class="tn-in-text">Book Now</font>
                                                </button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>


            @elseif(isset($problem))
            <tr>
                <td colspan="4">
                    <center>

                        @if(isset($fallback) && $fallback)

                        <div style="margin-bottom:20px;padding:15px;background:#fff3cd;border-radius:10px;width:70%;">
                            <strong>We couldn’t understand your input clearly.</strong><br>
                            Showing general therapists you can consider.
                        </div>

                        @else

                        <img src="{{ asset('img/notfound.svg') }}" width="25%">
                        <p class="heading-main12" style="font-size:20px;color:rgb(49, 49, 49)">
                            No specific matches found. Try different keywords or browse all doctors.
                        </p>

                        @endif

                    </center>
                </td>
            </tr>
            @endif

        </table>
    </div>
</div>
@endsection
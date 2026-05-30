@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
.analytics-card {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    padding: 25px 25px;
    background: linear-gradient(145deg, #ffffff, #f8fbff);
    border: 1px solid rgba(255, 255, 255, 0.7);

    box-shadow:
        0 10px 30px rgba(30, 90, 150, 0.08),
        0 2px 10px rgba(0, 0, 0, 0.03);

    transition: all .35s ease;
}

.analytics-card:hover {
    transform: translateY(-6px);
    box-shadow:
        0 18px 40px rgba(30, 90, 150, 0.14),
        0 4px 14px rgba(0, 0, 0, 0.06);
}

.analytics-card::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;

    width: 120px;
    height: 120px;

    background: radial-gradient(rgba(124, 168, 198, 0.18),
            transparent 70%);

    border-radius: 50%;
}

.analytics-title {
    font-size: 15px;
    color: #6b7280;
    margin-top: 5px;
}

.analytics-number {
    font-size: 38px;
    font-weight: 800;
    color: #123;
    margin-top: 10px;
}

.dashboard-glow {
    position: relative;
}

.dashboard-glow::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    inset: 0;
    border-radius: 24px;

    background: linear-gradient(135deg,
            rgba(124, 168, 198, 0.08),
            transparent);

    pointer-events: none;
}

.analytics-progress {
    height: 8px;
    border-radius: 20px;
    background: #edf2f7;
    overflow: hidden;
    margin-top: 12px;
}

.analytics-progress span {
    display: block;
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(90deg, #7ca8c6, #5b8db0);
}

.fade-slide {
    animation: fadeSlide .7s ease;
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(15px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
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
                            <p class="menu-text">Therapists</p>
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
                                            <div class="h3-dashboard">Therapists &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                    <th class="table-headin">Therapist</th>
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
                                                            <img src="{{ asset('img/nothingfound.png') }}" width="25%">
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
                                                    <th class="table-headin">Therapist</th>
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
                                                            <img src="{{ asset('img/nothingfound.png') }}" width="25%">
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

        <!-- ========================================================= -->
        <!-- ADVANCED ANALYTICS SECTION -->
        <!-- ========================================================= -->

        <div style="padding:20px 10px 30px 10px;">

            <!-- HEADER -->
            <div class="analytics-hero fade-slide">

                <div class="analytics-hero-left">

                    <div class="analytics-icon-wrap pulse-soft">
                        <img src="{{ asset('img/icons/dashboard.svg') }}" width="32">
                    </div>

                    <div>
                        <h1 class="analytics-main-title">
                            Advanced Analytics Dashboard
                        </h1>

                        <p class="analytics-subtitle">
                            Real-time insights, platform growth metrics and booking activity overview.
                        </p>
                    </div>

                </div>

                <div class="live-badge">
                    <span class="live-dot"></span>
                    LIVE DATA
                </div>

            </div>

            <!-- QUICK INSIGHT STRIP -->
            <div class="quick-strip fade-slide">

                <div class="quick-strip-card blue-strip">
                    <p>Total Therapists</p>
                    <h2 class="counter" data-target="{{ $doctorsCount }}">0</h2>

                    <div class="analytics-progress">
                        <span style="width:85%"></span>
                    </div>
                </div>

                <div class="quick-strip-card green-strip">
                    <p>Registered Patients</p>
                    <h2 class="counter" data-target="{{ $patientsCount }}">0</h2>

                    <div class="analytics-progress">
                        <span style="width:78%"></span>
                    </div>
                </div>

                <div class="quick-strip-card orange-strip">
                    <p>Monthly Bookings</p>
                    <h2 class="counter" data-target="{{ $monthlyAppointments }}">0</h2>

                    <div class="analytics-progress">
                        <span style="width:90%"></span>
                    </div>
                </div>

                <div class="quick-strip-card purple-strip">
                    <p>Weekly Sessions</p>
                    <h2 class="counter" data-target="{{ $weeklyAppointments }}">0</h2>

                    <div class="analytics-progress">
                        <span style="width:68%"></span>
                    </div>
                </div>

            </div>

            <!-- ANALYTICS GRID -->
            <div class="analytics-grid">

                <!-- MOST BOOKED THERAPISTS -->
                <div class="analytics-card dashboard-glow fade-slide">

                    <div class="analytics-card-header">

                        <div class="analytics-mini-icon blue-bg">
                            <img src="{{ asset('img/icons/doctors-hover.svg') }}" width="24">
                        </div>

                        <div>
                            <h3>Most Booked Therapists</h3>
                            <p>Highest patient engagement</p>
                        </div>

                    </div>

                    @forelse($topDoctors as $doctor)

                    <div class="analytics-row">

                        <div>
                            <strong>{{ $doctor->docname }}</strong>
                        </div>

                        <div class="analytics-pill blue-pill">
                            {{ $doctor->total_bookings }}
                        </div>

                    </div>

                    @empty

                    <div class="empty-state">
                        No therapist analytics available.
                    </div>

                    @endforelse

                </div>

                <!-- ACTIVE PATIENTS -->
                <div class="analytics-card dashboard-glow fade-slide">

                    <div class="analytics-card-header">

                        <div class="analytics-mini-icon green-bg">
                            <img src="{{ asset('img/icons/patients-hover.svg') }}" width="24">
                        </div>

                        <div>
                            <h3>Active Patients</h3>
                            <p>Most frequent bookings</p>
                        </div>

                    </div>

                    @forelse($topPatients as $patient)

                    <div class="analytics-row">

                        <div>
                            <strong>{{ $patient->pname }}</strong>
                        </div>

                        <div class="analytics-pill green-pill">
                            {{ $patient->total_appointments }}
                        </div>

                    </div>

                    @empty

                    <div class="empty-state">
                        No patient analytics available.
                    </div>

                    @endforelse

                </div>

                <!-- SPECIALTIES -->
                <div class="analytics-card dashboard-glow fade-slide">

                    <div class="analytics-card-header">

                        <div class="analytics-mini-icon orange-bg">
                            <img src="{{ asset('img/icons/session-iceblue.svg') }}" width="24">
                        </div>

                        <div>
                            <h3>Popular Specialties</h3>
                            <p>Most available specialties</p>
                        </div>

                    </div>

                    @forelse($topSpecialties as $specialty)

                    <div class="analytics-row">

                        <div>
                            <strong>{{ $specialty->sname }}</strong>
                        </div>

                        <div class="analytics-pill orange-pill">
                            {{ $specialty->total_doctors }}
                        </div>

                    </div>

                    @empty

                    <div class="empty-state">
                        No specialty analytics available.
                    </div>

                    @endforelse

                </div>

            </div>

            <!-- LOWER GRID -->
            <div class="lower-grid">

                <!-- APPOINTMENT STATS -->
                <div class="analytics-card dashboard-glow fade-slide large-card">

                    <div class="analytics-card-header">

                        <div class="analytics-mini-icon blue-bg">
                            <img src="{{ asset('img/icons/book-hover.svg') }}" width="24">
                        </div>

                        <div>
                            <h3>Appointment Statistics</h3>
                            <p>Weekly and monthly booking trends</p>
                        </div>

                    </div>

                    <div class="stats-grid">

                        <div class="stats-box stats-blue">
                            <img src="{{ asset('img/icons/book-hover.svg') }}" width="42">

                            <h1 class="counter" data-target="{{ $monthlyAppointments }}">0</h1>

                            <p>Monthly Appointments</p>
                        </div>

                        <div class="stats-box stats-green">
                            <img src="{{ asset('img/icons/session-iceblue.svg') }}" width="42">

                            <h1 class="counter" data-target="{{ $weeklyAppointments }}">0</h1>

                            <p>Weekly Appointments</p>
                        </div>

                    </div>

                </div>

                <!-- SYSTEM INSIGHTS -->
                <div class="analytics-card dashboard-glow fade-slide insights-card">

                    <div class="analytics-card-header">

                        <div class="analytics-mini-icon purple-bg">
                            <img src="{{ asset('img/icons/dashboard.svg') }}" width="24">
                        </div>

                        <div>
                            <h3>System Insights</h3>
                            <p>Platform performance summary</p>
                        </div>

                    </div>

                    <div class="insight-box">

                        <div class="insight-item">
                            <span class="insight-label">Active Therapists</span>
                            <span class="insight-value">{{ $doctorsCount }}</span>
                        </div>

                        <div class="insight-item">
                            <span class="insight-label">Registered Patients</span>
                            <span class="insight-value">{{ $patientsCount }}</span>
                        </div>

                        <div class="insight-item">
                            <span class="insight-label">Monthly Bookings</span>
                            <span class="insight-value">{{ $monthlyAppointments }}</span>
                        </div>

                        <div class="insight-item">
                            <span class="insight-label">Today's Sessions</span>
                            <span class="insight-value">{{ $sessionsCount }}</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================================= -->
        <!-- EXTRA STYLES -->
        <!-- ========================================================= -->

        <style>
        .analytics-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px;
            border-radius: 28px;
            background: linear-gradient(135deg, #f8fbff, #ffffff);
            box-shadow: 0 10px 40px rgba(15, 80, 140, 0.08);
            margin-bottom: 25px;
        }

        .analytics-hero-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .analytics-icon-wrap {
            width: 75px;
            height: 75px;
            border-radius: 22px;
            background: linear-gradient(135deg, #dbeeff, #f5fbff);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .analytics-main-title {
            margin: 0;
            font-size: 30px;
            color: #123;
            font-weight: 800;
        }

        .analytics-subtitle {
            margin-top: 8px;
            color: #6c757d;
            font-size: 15px;
        }

        .live-badge {
            background: #e8fff1;
            color: #159447;
            padding: 10px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .live-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #19c15f;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.4);
                opacity: .6;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .quick-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .quick-strip-card {
            padding: 25px;
            border-radius: 22px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .quick-strip-card h2 {
            margin: 15px 0 0 0;
            font-size: 34px;
            font-weight: 800;
        }

        .quick-strip-card p {
            margin: 0;
            font-size: 14px;
            opacity: .9;
        }

        .blue-strip {
            background: linear-gradient(135deg, #5ea3d6, #7cb8e2);
        }

        .green-strip {
            background: linear-gradient(135deg, #45b97c, #7dd6a4);
        }

        .orange-strip {
            background: linear-gradient(135deg, #e6a34c, #f4bf75);
        }

        .purple-strip {
            background: linear-gradient(135deg, #7d7cff, #a3a2ff);
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .lower-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .large-card {
            padding: 30px;
        }

        .insights-card {
            padding: 30px;
        }

        .analytics-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .analytics-card-header h3 {
            margin: 0;
            color: #123;
        }

        .analytics-card-header p {
            margin: 3px 0 0 0;
            font-size: 13px;
            color: #777;
        }

        .analytics-mini-icon {
            width: 55px;
            height: 55px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blue-bg {
            background: #e9f5ff;
        }

        .green-bg {
            background: #ebfff0;
        }

        .orange-bg {
            background: #fff3e3;
        }

        .purple-bg {
            background: #f0ebff;
        }

        .analytics-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #eef2f6;
        }

        .analytics-pill {
            padding: 7px 14px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 13px;
        }

        .blue-pill {
            background: #daf1ff;
            color: #0077b6;
        }

        .green-pill {
            background: #dfffe8;
            color: #239b56;
        }

        .orange-pill {
            background: #fff0da;
            color: #bc6c25;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .stats-box {
            border-radius: 24px;
            padding: 35px;
            text-align: center;
        }

        .stats-box h1 {
            font-size: 42px;
            margin: 15px 0 10px 0;
        }

        .stats-box p {
            color: #666;
            margin: 0;
        }

        .stats-blue {
            background: #f4faff;
        }

        .stats-green {
            background: #f4fff7;
        }

        .insight-box {
            background: #f9fbff;
            border-radius: 20px;
            padding: 20px;
        }

        .insight-item {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .insight-item:last-child {
            border-bottom: none;
        }

        .insight-label {
            color: #666;
        }

        .insight-value {
            font-weight: 800;
            color: #123;
        }

        .empty-state {
            color: #888;
            padding-top: 20px;
        }

        @media(max-width:1100px) {

            .lower-grid {
                grid-template-columns: 1fr;
            }

            .analytics-hero {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
        }
        </style>

        <!-- ========================================================= -->
        <!-- JAVASCRIPT -->
        <!-- ========================================================= -->

        <script>
        document.addEventListener("DOMContentLoaded", () => {

            const counters = document.querySelectorAll('.counter');

            counters.forEach(counter => {

                const target = +counter.getAttribute('data-target');

                let current = 0;

                const increment = Math.ceil(target / 40);

                const updateCounter = () => {

                    current += increment;

                    if (current > target) {
                        current = target;
                    }

                    counter.innerText = current;

                    if (current < target) {
                        requestAnimationFrame(updateCounter);
                    }
                };

                updateCounter();
            });

        });
        </script>
        @endsection
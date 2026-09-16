@extends('layouts.main')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">

<style>
.dashbord-tables {
    animation: transitionIn-Y-over .5s;
}

.filter-container {
    animation: transitionIn-Y-bottom .5s;
}

.sub-table,
.anime {
    animation: transitionIn-Y-bottom .5s;
}


/* =======================================================
   Emotional Insight Card
=======================================================*/

/* Card */

.insight-card {
    width: 95%;
    margin: 30px auto;
    padding: 35px;
    background: white;
    border-radius: 28px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, .06);
}



/* Header */

.insight-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.insight-title {
    font-size: 26px;
    font-weight: 700;
    color: #1d1d1f;
}



/* Segmented Control */

.period-tabs {
    display: flex;
    background: #f3f3f5;
    padding: 5px;
    border-radius: 30px;
    gap: 5px;
}

.period-btn {
    text-decoration: none;
    color: #666;
    padding: 8px 18px;
    border-radius: 20px;
    transition: .25s;
    font-weight: 600;
}

.period-btn.active {
    background: white;
    color: #007AFF;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
}



/* Top */

.summary-top {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

    margin-bottom: 35px;

}

.summary-item {

    background: #f7f7f8;

    padding: 30px;

    border-radius: 22px;

}

.summary-label {

    color: #6e6e73;

    font-size: 15px;

}

.summary-value {

    font-size: 42px;

    font-weight: 700;

    margin: 10px 0;

    color: #1d1d1f;

}

.summary-subtitle {

    color: #8a8a8f;

}



/* Sections */

.insight-section {

    margin-top: 35px;

    padding-top: 25px;

    border-top: 1px solid #ececec;

}

.insight-section h3 {

    margin-bottom: 15px;

}

.insight-section p {

    color: #555;

    line-height: 1.8;

}



/* Graph Placeholder */

.trend-placeholder {

    height: 90px;

    background: #f7f7f8;

    border-radius: 18px;

    display: flex;

    justify-content: center;

    align-items: center;

    color: #888;

}



/* Trigger Cards */

.trigger-grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

    margin-top: 35px;

}

.trigger-card {

    background: #f7f7f8;

    border-radius: 20px;

    padding: 25px;

}

.trigger-chip {

    display: inline-block;

    margin: 6px;

    padding: 8px 16px;

    border-radius: 20px;

    font-size: 14px;

    font-weight: 600;

}

.trigger-chip.negative {

    background: #FFF1F1;

    color: #D84040;

}

.trigger-chip.positive {

    background: #EEF9F1;

    color: #2E8B57;

}



/* Footer */

.insight-footer {

    margin-top: 40px;

    padding-top: 25px;

    border-top: 1px solid #ececec;

    display: flex;

    justify-content: space-between;

    align-items: center;

}

.report-btn {

    border: none;

    background: #007AFF;

    color: white;

    padding: 14px 28px;

    border-radius: 15px;

    cursor: pointer;

    font-weight: 600;

}

.report-btn:hover {
    background: #0062c3;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 113, 227, .25);
}

#moodChart {
    width: 100% !important;
    height: 280px !important;
}

.chart-container {

    position: relative;

    height: 250px;

    width: 100%;

    margin-top: 20px;

}

.summary-box.chart-box {

    grid-column: 1 / span 2;

    background: white;

    border-radius: 24px;

    padding: 24px;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, .05);

}

/* report section */
    .report-download-card{

display:flex;

justify-content:space-between;

align-items:center;

margin-top:35px;

padding:25px 30px;

background:#f8fafc;

border:1px solid #e5e7eb;

border-radius:18px;

}

.report-download-info h3{

margin:0;

font-size:20px;

font-weight:700;

color:#1f2937;

}

.report-download-info p{

margin:10px 0;

color:#6b7280;

line-height:1.6;

max-width:520px;

}

.report-download-info span{

font-size:14px;

font-weight:600;

color:#4b5563;

}

.download-btn{

background:#5b7cff;

color:white;

padding:14px 26px;

border-radius:12px;

text-decoration:none;

font-weight:600;

transition:.25s;

box-shadow:0 8px 20px rgba(91,124,255,.25);

}

.download-btn:hover{

background:#4769ee;

transform:translateY(-2px);

color:white;

text-decoration:none;

}

/* report section */

.report-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:18px;

}

.table-card{

background:white;

border-radius:16px;

overflow:hidden;

border:1px solid #edf2f7;

box-shadow:0 6px 18px rgba(0,0,0,.05);

}

.reflection-table{

width:100%;

border-collapse:collapse;

}

.reflection-table thead{

background:#5B7CFF;

color:white;

}

.reflection-table th{

padding:15px;

font-size:14px;

font-weight:600;

text-align:left;

}

.reflection-table td{

padding:15px;

border-bottom:1px solid #edf2f7;

font-size:14px;

color:#374151;

}

.reflection-table tbody tr:nth-child(even){

background:#fafcff;

}

.reflection-table tbody tr:hover{

background:#f4f7ff;

transition:.2s;

}

.table-responsive{

overflow-x:auto;

}


/* Mobile */

@media(max-width:900px) {

    .insight-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .insight-footer {
        flex-direction: column;
        gap: 20px;
        align-items: flex-start;
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
                <td
                    class="menu-btn menu-icon-home {{ Route::is('patient.dashboard') ? 'menu-active menu-icon-home-active' : '' }}">
                    <a href="{{ route('patient.dashboard') }}"
                        class="non-style-link-menu {{ Route::is('patient.dashboard') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Home</p>
                        </div>
                    </a>
                </td>
            </tr>
            <tr class="menu-row">
                <td
                    class="menu-btn menu-icon-doctor {{ Route::is('patient.doctors') ? 'menu-active menu-icon-doctor-active' : '' }}">
                    <a href="{{ route('patient.doctors') }}"
                        class="non-style-link-menu {{ Route::is('patient.doctors') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">All Therapists</p>
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
                <td
                    class="menu-btn menu-icon-appoinment {{ Route::is('patient.appointments') ? 'menu-active menu-icon-appoinment-active' : '' }}">
                    <a href="{{ route('patient.appointments') }}"
                        class="non-style-link-menu {{ Route::is('patient.appointments') ? 'non-style-link-menu-active' : '' }}">
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
                <td
                    class="menu-btn menu-icon-settings {{ Route::is('patient.settings') ? 'menu-active menu-icon-settings-active' : '' }}">
                    <a href="{{ route('patient.settings') }}"
                        class="non-style-link-menu {{ Route::is('patient.settings') ? 'non-style-link-menu-active' : '' }}">
                        <div>
                            <p class="menu-text">Settings</p>
                        </div>
                    </a>
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
                        <table class="filter-container doctor-header patient-header" style="border: none;width:95%"
                            border="0">
                            <tr>
                                <td>
                                    <h3>Welcome!</h3>
                                    <h1>{{ $patient->pname }}</h1>
                                    <p>Haven't any idea about doctors? No problem, let's jump to <a
                                            href="{{ route('patient.doctors') }}" class="non-style-link"><b>"All
                                                Doctors"</b></a> section.<br>
                                        <br>Also find out the expected
                                        arrival time of your doctor or medical consultant.<br><br>
                                    </p>
                                    <h3>Confused which doctor to book? Channel a Doctor Here</h3>
                                    <form action="{{ route('patient.doctors') }}" method="get" style="display: flex">
                                        <!-- <input type="search" name="search" class="input-text"
                                            placeholder="Search Doctor and We will Find The Session Available"
                                            list="doctors" style="width:45%;">&nbsp;&nbsp;
                                        <datalist id="doctors">
                                            @foreach(\App\Models\Doctor::all() as $doc)
                                            <option value="{{ $doc->docname }}">
                                                @endforeach
                                        </datalist> -->
                                        <form action="{{ route('patient.recommendation') }}" method="GET"
                                            style="display:flex">
                                            <a href="{{ route('patient.recommendation') }}"
                                                class="login-btn btn-primary btn"
                                                style="padding:10px 25px;text-decoration:none;display:inline-block;">
                                                Get Recommendation
                                            </a>
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
                                                <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items"
                                                    style="padding:20px;margin:auto;width:95%;display: flex">
                                                    <div>
                                                        <div class="h1-dashboard">{{ \App\Models\Doctor::count() }}
                                                        </div><br>
                                                        <div class="h3-dashboard">All Doctors
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons"
                                                        style="background-image: url('{{ asset('img/icons/doctors-hover.svg') }}');">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items"
                                                    style="padding:20px;margin:auto;width:95%;display: flex; ">
                                                    <div>
                                                        <div class="h1-dashboard">{{ $appointments->count() }}</div><br>
                                                        <div class="h3-dashboard">New Booking &nbsp;&nbsp;</div>
                                                    </div>
                                                    <div class="btn-icon-back dashboard-icons"
                                                        style="margin-left: 0px;background-image: url('{{ asset('img/icons/book-hover.svg') }}');">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items"
                                                    style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                                    <div>
                                                        <div class="h1-dashboard">
                                                            {{ \App\Models\Schedule::where('scheduledate', $today)->count() }}
                                                        </div><br>
                                                        <div class="h3-dashboard" style="font-size: 15px">Today Sessions
                                                        </div>
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
                            <td>
                                <p style="font-size: 20px;font-weight:600;padding-left: 40px;" class="anime">Your
                                    Upcoming Bookings</p>
                                <center>
                                    <div class="abc scroll" style="height: 250px;padding: 0;margin: 0;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                            <thead>
                                                <tr>
                                                    <th class="table-headin">Appointment Number</th>
                                                    <th class="table-headin">Session Title</th>
                                                    <th class="table-headin">Therapists</th>
                                                    <th class="table-headin">Scheduled Date & Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($appointments->where('appodate', '>=', $today) as $appo)
                                                <tr>
                                                    <td style="padding:30px;font-size:25px;font-weight:700;">
                                                        {{ $appo->apponum }}</td>
                                                    <td style="padding:20px;">
                                                        {{ Str::limit($appo->schedule?->title ?? 'Deleted Session', 30) }}
                                                    </td>
                                                    <td>Dr.
                                                        {{ Str::limit(ucwords($appo->schedule?->doctor?->docname ?? 'Unknown'), 20) }}
                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $appo->schedule
                                                           ? \Carbon\Carbon::parse($appo->schedule->scheduledate)->format('M d, Y')
                                                            : 'N/A' }}
                                                        <br>
                                                        {{ $appo->schedule
                                                                ? \Carbon\Carbon::parse($appo->schedule->start_time ?? $appo->schedule->scheduletime)->format('h:i A')
                                                                  : 'N/A' }}
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <br><br>
                                                        <center>
                                                            <img src="{{ asset('img/nothingfound.png') }}" width="25%">
                                                            <p class="heading-main12"
                                                                style="font-size:20px;color:rgb(49, 49, 49)">Nothing to
                                                                show!</p>
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

        <!-- added for emotional insight -->

            <div class="insight-card">

                <div class="insight-header">

                    <div class="insight-title">
                        My Emotional Insights
                    </div>

                    <div class="period-tabs">

                        <a href="{{ route('patient.dashboard',['period'=>'W']) }}"
                            class="period-btn {{ $period=='W' ? 'active':'' }}">
                            W
                        </a>

                        <a href="{{ route('patient.dashboard',['period'=>'M']) }}"
                            class="period-btn {{ $period=='M' ? 'active':'' }}">
                            M
                        </a>

                        <a href="{{ route('patient.dashboard',['period'=>'6M']) }}"
                            class="period-btn {{ $period=='6M' ? 'active':'' }}">
                            6M
                        </a>

                        <a href="{{ route('patient.dashboard',['period'=>'Y']) }}"
                            class="period-btn {{ $period=='Y' ? 'active':'' }}">
                            Y
                        </a>

                    </div>
                </div>

                <!-- Top Summary -->

                <div class="summary-top">

                    <div class="summary-item">

                        <div class="summary-label">
                            Average Mood
                        </div>

                        <div class="summary-value">
                              {{ number_format((float) $averageMood, 1) }}/10
                        </div>

                        <div class="summary-subtitle">
                            {{ $entryCount }} reflections analysed
                        </div>

                    </div>

                    <div class="summary-item">

                        <div class="summary-label">
                            Most Common Emotion
                        </div>

                        <div class="summary-value">
                            {{ $topEmotion }}
                        </div>

                        <div class="summary-subtitle">
                            {{ $bestDay }}
                        </div>

                    </div>

                </div>

<div class="insight-section">

@if($period == 'W')

<h3>Weekly Reflection Report</h3>

<p class="summary-subtitle">
    {{ \Carbon\Carbon::parse($selectedWeek)->format('d M Y') }}
    -
    {{ \Carbon\Carbon::parse($selectedWeek)->copy()->addDays(6)->format('d M Y') }}
</p>
        <!-- <table class="table table-bordered"> -->

<div class="table-card">

<div class="table-responsive">

<table class="reflection-table">

            <thead>

            <tr>

                <th>Date</th>

                <th>Day</th>

                <th>Primary Emotions</th>

                <th>Possible Triggers</th>

                <th>Reflection status</th>

            </tr>

            </thead>

            <tbody>

            @foreach($reportRows ?? [] as $row)

                <tr>

                    <td>{{ $row['date'] }}</td>

                    <td>{{ $row['day'] }}</td>

                    <td>{{ $row['primary_emotions'] }}</td>

                    <td>{{ $row['possible_triggers'] }}</td>

                    <td>{{ $row['reflection_status'] }}</td>

                </tr>

            @endforeach

            </tbody>

        </table>
        </div>
</div>

   @elseif($period == 'M')

<!-- <h3>Monthly Reflection Report</h3>

<p class="summary-subtitle">
Last 30 Days Overview
</p> -->

<div class="report-header">

    <div>

        <h3>Monthly Reflection Report</h3>

        <p class="summary-subtitle">
            {{ \Carbon\Carbon::parse($selectedWeek)->format('d M Y') }}
            -
            {{ \Carbon\Carbon::parse($selectedWeek)->copy()->addDays(6)->format('d M Y') }}
        </p>

    </div>

</div>

<div class="table-card">

    <div class="table-responsive">

<table class="reflection-table">
    <thead>

        <tr>

            <th>Week</th>

            <th>Average Mood</th>

            <th>Dominant Emotion</th>

            <th>Main Trigger</th>

            <th>Reflection Completion</th>

        </tr>

    </thead>

    <tbody>

        @foreach($reportRows ?? [] as $row)
        <tr>

            <td>{{ $row['week'] }}</td>

            <td>{{ $row['average_mood'] }}</td>

            <td>{{ ucfirst($row['emotion']) }}</td>

            <td>{{ ucfirst($row['trigger']) }}</td>

            <td>{{ $row['completion'] }}</td>

        </tr>

    @endforeach

    </tbody>

</table>
        </div>
    </div>

   @elseif($period == '6M')

<h3>Six Month Reflection Report</h3>

<p class="summary-subtitle">
Last 6 Months Overview
</p>

<div class="table-card">
    <div class="table-responsive">

<table class="reflection-table">

    <thead>

        <tr>

            <th>Month</th>

            <th>Average Mood</th>

            <th>Dominant Emotions</th>

            <th>Main Trigger</th>

            <th>Reflection Habit</th>

        </tr>

    </thead>

    <tbody>

    @foreach($reportRows as $row)

        <tr>

            <td>{{ $row['month'] }}</td>

            <td>{{ $row['average_mood'] }}</td>

            <td>{{ $row['emotion'] }}</td>

            <td>{{ ucfirst($row['trigger']) }}</td>

            <td>{{ $row['completion'] }}</td>

        </tr>

    @endforeach

    </tbody>

</table>
        </div>
    </div>

    @else

       <h3>Yearly Reflection Report</h3>

<p class="summary-subtitle">
Last 12 Months Overview
</p>


<div class="table-card">

    <div class="table-responsive">

<table class="reflection-table">

<thead>

<tr>

<th>Period</th>

<th>Average Mood</th>

<th>Dominant Emotions</th>

<th>Main Triggers</th>

<th>Reflections</th>

</tr>

</thead>

<tbody>

@foreach($reportRows as $row)

<tr>

<td>{{ $row['period'] }}</td>

<td>{{ $row['average_mood'] }}</td>

<td>{{ $row['emotions'] }}</td>

<td>{{ $row['triggers'] }}</td>

<td>{{ $row['reflections'] }}</td>

</tr>

@endforeach

</tbody>

</table>
        </div>
    </div>
    @endif

</div>

                <!-- Mood Trend -->



                <!-- Emotional Story -->

                <div class="insight-section">

                    <h3>Your Emotional Story</h3>

                    <p>

                        {{ $pattern }}

                    </p>

                </div>



                <!-- Trigger Section -->

                <!-- <div class="trigger-grid">

                    <div class="trigger-card">

                        <h3>⚠ Frequently Linked with Difficult Emotions</h3>

                        @forelse($negativeTriggers as $trigger)

                        <span class="trigger-chip negative">

                            {{ $trigger }}

                        </span>

                        @empty

                        <span class="trigger-chip">

                            No clear pattern yet

                        </span>

                        @endforelse

                    </div> -->



                    <!-- <div class="trigger-card">

                        <h3> Frequently Linked with Positive Emotions</h3>

                        @forelse($positiveTriggers as $trigger)

                        <span class="trigger-chip positive">

                            {{ $trigger }}

                        </span>

                        @empty

                        <span class="trigger-chip">

                            No clear pattern yet

                        </span>

                        @endforelse

                    </div>

                </div> -->


<div class="report-download-card">

    <div class="report-download-info">

        <h3>Reflection Report</h3>

        <p>
            Download a detailed summary of your emotional patterns,
            mood trends and reflections for the selected period.
        </p>

        <span>
            {{ $entryCount }} reflections analysed
        </span>

    </div>

    <a href="{{ route('patient.report',[
        'period'=>$period,
        'download'=>1
    ]) }}"
    class="download-btn">

        Download PDF

    </a>

</div>

</div>


    </div>

</div>

@endsection


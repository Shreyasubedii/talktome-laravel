@extends('layouts.main')

@section('title', 'Log Your Day')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">

<style>
.dashbord-tables {
    animation: transitionIn-Y-over 0.5s;
}

.filter-container,
.sub-table,
.anime {
    animation: transitionIn-Y-bottom 0.5s;
}

/* ================= DAYLOG UI ================= */

.mood-grid,
.emotion-grid,
.impact-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-top: 20px;
}

.mood-btn,
.tag-btn {
    border: none;
    padding: 12px 18px;
    border-radius: 30px;
    cursor: pointer;
    background: #eef4f8;
    transition: 0.3s;
    font-size: 14px;
}

.mood-btn:hover,
.tag-btn:hover {
    background: #7ca8c6;
    color: white;
}

.selected-mood {
    background: #7ca8c6 !important;
    color: white;
}

.hidden-checkbox {
    display: none;
}

/* safer custom card */
.daylog-card {
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}
</style>
@endsection


@section('content')

<div class="container">

    {{-- ================= SIDEBAR ================= --}}
    <div class="menu">

        <table class="menu-container" border="0">

            <tr>
                <td style="padding:10px" colspan="2">

                    <table border="0" class="profile-container">

                        <tr>
                            <td width="30%" style="padding-left:20px">
                                <img src="{{ asset('img/user.png') }}" alt="" width="100%" style="border-radius:50%">
                            </td>

                            <td style="padding:0;margin:0;">
                                <p class="profile-title">
                                    {{ Str::limit($patient->pname, 13) }}..
                                </p>

                                <p class="profile-subtitle">
                                    {{ Str::limit($patient->pemail, 22) }}
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-btn btn-primary-soft btn" style="width:100%;">
                                        Log out
                                    </button>
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
                            <p class="menu-text">Group Sessions</p>
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
                <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
                    <a href="{{ route('patient.daylog') }}" class="non-style-link-menu non-style-link-menu-active">
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


    {{-- ================= MAIN BODY ================= --}}
    <div class="dash-body" style="margin-top:15px;">

        <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;">

            <tr>
                <td>
                    <p style="
                        font-size:23px;
                        padding-left:12px;
                        font-weight:600;
                        margin-left:20px;
                    ">
                        Log Your Day
                    </p>
                </td>

                <td width="25%"></td>

                <td width="15%">
                    <p style="
                        font-size:14px;
                        color:rgb(119,119,119);
                        padding:0;
                        margin:0;
                        text-align:right;
                    ">
                        Today's Date
                    </p>

                    <p class="heading-sub12" style="padding:0;margin:0;">
                        {{ $today }}
                    </p>
                </td>

                <td width="10%">
                    <button class="btn-label" style="
                            display:flex;
                            justify-content:center;
                            align-items:center;
                        ">
                        <img src="{{ asset('img/calendar.svg') }}" width="100%">
                    </button>
                </td>
            </tr>

        </table>


        <center>

            {{-- ================= FORM ================= --}}
            <form action="{{ route('patient.daylog.store') }}" method="POST" style="width:95%;max-width:1100px;">

                @csrf

                <div class="dashboard-items daylog-card" style="padding:35px;margin-top:20px;">

                    <h2>Log how you felt overall today</h2>

                    {{-- MOOD SCALE --}}
                    <div class="mood-grid">

                        @foreach([
                        [1,'Very Unpleasant'],
                        [2,'Unpleasant'],
                        [3,'Slightly Unpleasant'],
                        [4,'Neutral'],
                        [5,'Slightly Pleasant'],
                        [6,'Pleasant'],
                        [7,'Very Pleasant']
                        ] as $m)

                        <button type="button" class="mood-btn" data-score="{{ $m[0] }}" data-label="{{ $m[1] }}">

                            {{ $m[1] }}

                        </button>

                        @endforeach

                    </div>

                    <input type="hidden" name="mood_score" id="mood_score">

                    <input type="hidden" name="mood_label" id="mood_label">

                    <br><br>

                    {{-- EMOTIONS --}}
                    <div id="emotion-section" style="display:none;">

                        <h3>What best describes this feeling?</h3>

                        <div id="emotion-options" class="emotion-grid"></div>

                    </div>

                    <br>

                    {{-- IMPACT --}}
                    <div id="impact-section" style="display:none;">

                        <h3>
                            What's having the biggest impact on you?
                        </h3>

                        <div class="impact-grid">

                            @foreach([
                            "Family",
                            "Work",
                            "Education",
                            "Money",
                            "Fitness",
                            "Travel",
                            "Self-care",
                            "Relationships"
                            ] as $i)

                            <label class="tag-btn">

                                <input type="checkbox" class="hidden-checkbox" name="impact_area[]" value="{{ $i }}">

                                {{ $i }}

                            </label>

                            @endforeach

                        </div>

                    </div>

                    <br><br>

                    <button type="submit" class="login-btn btn-primary btn">

                        Done

                    </button>

                </div>

            </form>


            {{-- ================= ANALYTICS ================= --}}
            @if(isset($analytics))

            <div style="
                margin-top:40px;
                width:95%;
                max-width:1100px;
            ">

                <h2 style="margin-bottom:20px;">
                    Mood Summary
                </h2>

                <div style="
                    display:flex;
                    gap:15px;
                    flex-wrap:wrap;
                    width:100%;
                ">

                    <div class="dashboard-items daylog-card" style="
                            flex:1;
                            min-width:220px;
                            padding:25px;
                        ">

                        <h3>Avg Mood</h3>

                        <h1>{{ $analytics['avg_mood'] }}</h1>

                    </div>

                    <div class="dashboard-items daylog-card" style="
                            flex:1;
                            min-width:220px;
                            padding:25px;
                        ">

                        <h3>Top Emotion</h3>

                        <h2>
                            {{ $analytics['top_emotion'] ?? 'N/A' }}
                        </h2>

                    </div>

                    <div class="dashboard-items daylog-card" style="
                            flex:1;
                            min-width:220px;
                            padding:25px;
                        ">

                        <h3>Top Impact</h3>

                        <h2>
                            {{ $analytics['top_impact'] ?? 'N/A' }}
                        </h2>

                    </div>

                </div>

            </div>

            @endif


            {{-- ================= CHARTS ================= --}}
            @if(isset($trend))

            <div class="dashboard-items daylog-card" style="
                    margin-top:40px;
                    width:95%;
                    max-width:1100px;
                    padding:30px;
                ">

                <h2>Mood Trend</h2>

                <canvas id="moodChart"></canvas>

            </div>

            @endif


            @if(isset($emotionStats))

            <div class="dashboard-items daylog-card" style="
                    margin-top:30px;
                    width:95%;
                    max-width:1100px;
                    padding:30px;
                ">

                <h2>Emotion Breakdown</h2>

                <canvas id="emotionChart"></canvas>

            </div>

            @endif


            @if(isset($impactStats))

            <div class="dashboard-items daylog-card" style="
                    margin-top:30px;
                    width:95%;
                    max-width:1100px;
                    padding:30px;
                ">

                <h2>Impact Areas</h2>

                <canvas id="impactChart"></canvas>

            </div>

            @endif

        </center>

    </div>
</div>


{{-- ================= JS ================= --}}
<script>
const emotions = {
    pleasant: [
        "Happy",
        "Excited",
        "Amazed",
        "Passionate",
        "Calm",
        "Proud",
        "Grateful",
        "Relaxed"
    ],

    unpleasant: [
        "Anxious",
        "Sad",
        "Angry",
        "Overwhelmed",
        "Lonely",
        "Tired",
        "Frustrated",
        "Drained"
    ],

    neutral: [
        "Okay",
        "Thoughtful",
        "Relaxed",
        "Meh"
    ]
};


// mood selection
document.querySelectorAll('.mood-btn').forEach(btn => {

    btn.addEventListener('click', function() {

        document.querySelectorAll('.mood-btn')
            .forEach(b => b.classList.remove('selected-mood'));

        this.classList.add('selected-mood');

        const score = parseInt(this.dataset.score);
        const label = this.dataset.label;

        document.getElementById('mood_score').value = score;
        document.getElementById('mood_label').value = label;

        let type = "neutral";

        if (score >= 5) {
            type = "pleasant";
        } else if (score <= 3) {
            type = "unpleasant";
        }

        loadEmotions(type);

        document.getElementById('emotion-section').style.display = 'block';
        document.getElementById('impact-section').style.display = 'block';
    });

});


// load emotions
function loadEmotions(type) {

    const container = document.getElementById('emotion-options');

    container.innerHTML = '';

    emotions[type].forEach(e => {

        container.innerHTML += `
            <label class="tag-btn">
                <input type="checkbox"
                    class="hidden-checkbox"
                    name="emotion[]"
                    value="${e}">
                ${e}
            </label>
        `;
    });
}


// checkbox UI
document.addEventListener('change', function(e) {

    if (e.target.classList.contains('hidden-checkbox')) {

        const label = e.target.parentElement;

        label.classList.toggle(
            'selected-mood',
            e.target.checked
        );
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
@if(isset($trend))

const trend = @json($trend);

new Chart(document.getElementById('moodChart'), {

    type: 'line',

    data: {

        labels: trend.map(i => i.log_date),

        datasets: [{
            label: 'Mood Score',
            data: trend.map(i => i.mood_score),
            fill: true,
            tension: 0.4
        }]
    }
});

@endif



@if(isset($emotionStats))

const emotionData = @json($emotionStats);

new Chart(document.getElementById('emotionChart'), {

    type: 'bar',

    data: {

        labels: Object.keys(emotionData),

        datasets: [{
            label: 'Emotions',
            data: Object.values(emotionData)
        }]
    }
});

@endif



@if(isset($impactStats))

const impactData = @json($impactStats);

new Chart(document.getElementById('impactChart'), {

    type: 'bar',

    data: {

        labels: Object.keys(impactData),

        datasets: [{
            label: 'Impact Areas',
            data: Object.values(impactData)
        }]
    }
});

@endif
</script>

@endsection
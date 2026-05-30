@extends('layouts.main')

@section('title', 'Journal Reflection')

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
                <td class="menu-btn menu-icon-home"> <a href="{{ route('patient.daylog') }}"
                        class="non-style-link-menu ">
                        <div>
                            <p class="menu-text">Log Your Day</p>
                        </div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                    <a href="{{ route('patient.journal') }}" class="non-style-link-menu non-style-link-menu-active">

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


    {{-- ================= MAIN BODY ================= --}}
    <div class="dash-body" style="margin-top:15px;">

        <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;">

            <tr>

                <td>

                    <p style="
                    font-size:17px;
                    padding-left:12px;
                    font-weight:600;
                    margin-left:20px;
                ">
                        Journal Reflection
                    </p>

                    <p style="
                    padding-left:12px;
                    margin-left:20px;
                    color:#777;
                ">
                        Reflect on your day and discover emotional patterns over time.
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

                    <p class="heading-sub12" style="padding:0;margin:0;text-align:right;">

                        {{ $today }}

                    </p>

                </td>

                <td width="10%">

                    <button class="btn-label">

                        <img src="{{ asset('img/calendar.svg') }}" width="100%">

                    </button>

                </td>

            </tr>

        </table>

        <center>

            @if(session('success'))
            <div class="dashboard-items daylog-card"
                style="width:95%;max-width:1100px;padding:15px;margin-top:20px;background:#e8fff1;">
                {{ session('success') }}
            </div>
            @endif


            {{-- JOURNAL FORM --}}
            <form action="{{ route('patient.journal.store') }}" method="POST" style="width:95%;max-width:1100px;">

                @csrf

                <div class="dashboard-items daylog-card" style="padding:35px;margin-top:20px;">

                    <h2>Journal Reflection</h2>

                    <p style="color:#777;margin-bottom:20px;">
                        Write freely about your day, emotions, thoughts,
                        worries, achievements or anything on your mind.
                    </p>

                    <textarea name="journal_text" rows="12" style="
                width:100%;
                padding:15px;
                border:1px solid #ddd;
                border-radius:12px;
                resize:vertical;
                font-size:15px;
            " placeholder="Start writing here..." required>{{ old('journal_text') }}</textarea>

                    @error('journal_text')
                    <p style="color:red;margin-top:10px;">
                        {{ $message }}
                    </p>
                    @enderror

                    <br><br>

                    <button type="submit" class="login-btn btn-primary btn">
                        Save Journal
                    </button>

                </div>

            </form>


            {{-- LATEST ANALYSIS --}}
            @if($latestJournal)

            <div class="dashboard-items daylog-card" style="
        margin-top:30px;
        width:95%;
        max-width:1100px;
        padding:30px;
     ">

                <h2>Latest Reflection Insights</h2>

                <br>

                <div style="
        display:flex;
        gap:15px;
        flex-wrap:wrap;
    ">

                    <div style="
            flex:1;
            min-width:220px;
            background:#f8f9fa;
            padding:20px;
            border-radius:12px;
        ">
                        <h4>Primary Emotion</h4>
                        <h2>
                            {{ $latestJournal->primary_emotion ?? 'Unknown' }}
                        </h2>
                    </div>

                    <div style="
            flex:1;
            min-width:220px;
            background:#f8f9fa;
            padding:20px;
            border-radius:12px;
        ">
                        <h4>Secondary Emotion</h4>
                        <h2>
                            {{ $latestJournal->secondary_emotion ?? 'Unknown' }}
                        </h2>
                    </div>

                    <div style="
            flex:1;
            min-width:220px;
            background:#f8f9fa;
            padding:20px;
            border-radius:12px;
        ">
                        <h4>Word Count</h4>
                        <h2>
                            {{ $latestJournal->word_count }}
                        </h2>
                    </div>

                </div>

            </div>


            {{-- EMOTION BREAKDOWN --}}
            @if(!empty($latestJournal->emotion_scores))

            <div class="dashboard-items daylog-card" style="
        margin-top:30px;
        width:95%;
        max-width:1100px;
        padding:30px;
     ">

                <h2>Emotion Breakdown</h2>

                <br>

                @foreach($latestJournal->emotion_scores as $emotion => $score)

                <div style="margin-bottom:18px;">

                    <div style="
                display:flex;
                justify-content:space-between;
                margin-bottom:6px;
            ">
                        <strong>{{ $emotion }}</strong>
                        <span>{{ $score }}%</span>
                    </div>

                    <div style="
                width:100%;
                height:12px;
                background:#eee;
                border-radius:50px;
                overflow:hidden;
            ">
                        <div style="
                    width:{{ $score }}%;
                    height:100%;
                    background:#7ca8c6;
                "></div>
                    </div>

                </div>

                @endforeach

            </div>

            @endif

            @endif



            {{-- JOURNAL HISTORY --}}
            @if($journals->count())

            <div class="dashboard-items daylog-card" style="
        margin-top:30px;
        width:95%;
        max-width:1100px;
        padding:30px;
     ">

                <h2>Previous Journal Entries</h2>

                <br>

                @foreach($journals as $journal)

                <div style="
        border:1px solid #eee;
        border-radius:12px;
        padding:20px;
        margin-bottom:20px;
        text-align:left;
    ">

                    <div style="
            display:flex;
            justify-content:space-between;
            flex-wrap:wrap;
        ">

                        <strong>
                            {{ $journal->journal_date }}
                        </strong>

                        <span>
                            {{ $journal->primary_emotion }}
                        </span>

                    </div>

                    <br>

                    <p style="line-height:1.8;color:#555;">
                        {{ Str::limit($journal->journal_text, 180) }}
                    </p>

                    <button class="btn-primary-soft btn" style="margin-top:15px;" onclick="openJournalModal(
        '{{ $journal->id }}',
        `{{ addslashes($journal->journal_text) }}`,
        '{{ $journal->journal_date }}',
        '{{ $journal->primary_emotion }}',
        '{{ $journal->secondary_emotion }}'
    )">
                        View Entry
                    </button>

                </div>

                @endforeach

            </div>

            @endif

        </center>



        <!-- JOURNAL VIEW MODAL -->

        <div id="journalModal" style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.45);
z-index:9999;
justify-content:center;
align-items:center;
">

            <div style="
    background:white;
    width:90%;
    max-width:800px;
    border-radius:18px;
    padding:30px;
    max-height:85vh;
    overflow-y:auto;
    position:relative;
    ">

                <button onclick="closeJournalModal()" style="
        position:absolute;
        right:20px;
        top:15px;
        border:none;
        background:none;
        font-size:28px;
        cursor:pointer;
        ">
                    ×
                </button>

                <h2 id="modalDate"></h2>

                <p>
                    <strong>Primary Emotion:</strong>
                    <span id="modalPrimary"></span>
                </p>

                <p>
                    <strong>Secondary Emotion:</strong>
                    <span id="modalSecondary"></span>
                </p>

                <hr style="margin:20px 0;">

                <div id="modalJournalText" style="
        line-height:1.9;
        white-space:pre-wrap;
        color:#444;
        ">
                </div>

                <br><br>

                <form id="deleteForm" method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-primary" style="
                background:#dc3545;
                border:none;
                ">
                        Delete Entry
                    </button>

                </form>

            </div>

        </div>
    </div>


    <!-- <script>
    const journalText =
        document.getElementById('journal_text');

    const wordCount =
        document.getElementById('wordCount');

    journalText.addEventListener('input', function() {

        let words = this.value
            .trim()
            .split(/\s+/)
            .filter(word => word.length > 0);

        wordCount.innerText =
            words.length + " words";
    });
    </script> -->

    <script>
    function openJournalModal(
        id,
        text,
        date,
        primary,
        secondary
    ) {
        document.getElementById('journalModal').style.display = 'flex';

        document.getElementById('modalDate').innerText =
            date;

        document.getElementById('modalPrimary').innerText =
            primary;

        document.getElementById('modalSecondary').innerText =
            secondary;

        document.getElementById('modalJournalText').innerText =
            text;

        document.getElementById('deleteForm').action =
            "/patient/journal/" + id;
    }

    function closeJournalModal() {
        document.getElementById('journalModal').style.display =
            'none';
    }

    window.onclick = function(event) {
        const modal =
            document.getElementById('journalModal');

        if (event.target === modal) {
            closeJournalModal();
        }
    };
    </script>

    @endsection
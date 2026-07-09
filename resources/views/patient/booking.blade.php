@extends('layouts.main')

@section('title', 'Book Appointment')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/patient.css') }}">
<style>
.popup {
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
                <td class="menu-btn menu-icon-home"><a href="{{ route('patient.dashboard') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Home</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active"><a
                        href="{{ route('patient.doctors') }}" class="non-style-link-menu non-style-link-menu-active">
                        <div>
                            <p class="menu-text">All Therapists</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session"><a href="{{ route('patient.schedules') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Available Sessions</p>
                        </div>
                    </a></td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment"><a href="{{ route('patient.appointments') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">My Bookings</p>
                        </div>
                    </a></td>
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
                <td class="menu-btn menu-icon-settings"><a href="{{ route('patient.settings') }}"
                        class="non-style-link-menu">
                        <div>
                            <p class="menu-text">Settings</p>
                        </div>
                    </a></td>
            </tr>
        </table>
    </div>

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="{{ route('patient.doctors') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Let's Book!</p>
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
                    <center>
                        <div style="display: flex; justify-content: center; width: 100%;">
                            <div class="abc" style="width: min(760px, 92%); border-radius: 18px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);">
                                <div style="padding: 24px 28px 0;">
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 600;">Book available session</p>
                                    <p style="margin: 8px 0 0; color: #4b5563;">Choose a slot that works for you and confirm it in one step.</p>
                                    <div style="margin-top: 14px; padding: 12px 14px; border-radius: 12px; background: #f8fbff; border: 1px solid #dbeafe;">
                                        <strong>Doctor:</strong> Dr. {{ ucwords ($doctor->docname) }}<br>
                                        <strong>Specialty:</strong> {{ $doctor->specialty?->sname }}<br><br>
                                        <strong>Slot length:</strong> 30 minutes • <strong>One booking per patient</strong>
                                    </div>
                                </div>
                                <table width="100%" class="sub-table scrolldown add-doc-form-container" border="0"
                                    style="padding: 24px 28px 28px;">
                                    @php
                                        $bookingDates = $bookingDates ?? [];
                                        $defaultBookingDate = $bookingDates[0] ?? $today;
                                    @endphp
                                    <form action="{{ route('patient.booking.store') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td class="label-td">
                                                <label class="form-label">Pick a date:</label>
                                                <div class="calendar-card" style="margin-top:8px;">
                                                    <div class="calendar-toolbar">
                                                        <button type="button" class="calendar-nav" onclick="changeBookingMonth(-1)">&lsaquo;</button>
                                                        <span id="bookingCalendarLabel">Loading...</span>
                                                        <button type="button" class="calendar-nav" onclick="changeBookingMonth(1)">&rsaquo;</button>
                                                    </div>
                                                    <div class="calendar-weekdays">
                                                        <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                                                    </div>
                                                    <div id="bookingCalendarGrid" class="calendar-grid"></div>
                                                </div>
                                                <input type="hidden" name="selected_date" id="bookingSelectedDate" value="{{ $defaultBookingDate }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td">
                                               <br> <label class="form-label">Available 30-minute slots: </label>
                                                <p id="selectedSlotDateLabel" style="margin: 8px 0 0; color: #2563eb; font-size: 14px; font-weight: 600;">Showing slots for {{ \Carbon\Carbon::parse($defaultBookingDate)->format('M d, Y') }}</p><br>
                                                <div style="display:grid; gap:10px; margin-top:8px;">
                                                    @foreach($groupedSchedules as $date => $slots)
                                                    <div class="slot-group" id="slots-{{ $date }}" data-slot-date="{{ $date }}" style="display: {{ $loop->first ? 'block' : 'none' }};">
                                                        @foreach($slots as $schedule)
                                                        <label style="display:flex; justify-content:space-between; align-items:center; padding:12px 14px; border:1px solid #dbeafe; border-radius:12px; background:white; cursor:pointer;">
                                                            <span>
                                                                <strong>{{ $schedule->title }}</strong><br>
                                                                <span style="color:#4b5563; font-size:13px;">
                                                                    {{ \Carbon\Carbon::parse($schedule->start_time ?? $schedule->scheduletime)->format('h:i A') }}
                                                                     -
                                                                      {{ \Carbon\Carbon::parse($schedule->end_time ?? $schedule->scheduletime)->format('h:i A') }}
                                                                    </span>
                                                            </span>
                                                            <span style="font-size:13px; color:#2563eb;">{{ $schedule->remaining_capacity }}/{{ $schedule->nop }} open</span>
                                                            <input type="radio" name="schedule" value="{{ $schedule->scheduleid }}" {{ $loop->first && $loop->parent->first ? 'checked' : '' }} required>
                                                        </label>
                                                        @endforeach
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 20px;">
                                                <input type="submit" value="Book Now" class="login-btn btn-primary btn"
                                                    style="width: 100%; border-radius: 10px;">
                                            </td>
                                        </tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
<script>
const bookingAvailabilityDates = @json($bookingDates);
const bookingDefaultDate = @json($defaultBookingDate);
let bookingMonth = bookingDefaultDate.slice(0, 7);

function renderBookingCalendar() {
    const [year, month] = bookingMonth.split('-').map(Number);
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const daysInMonth = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const label = firstDay.toLocaleString('en', { month: 'long', year: 'numeric' });
    document.getElementById('bookingCalendarLabel').textContent = label;

    let html = '';
    for (let i = 0; i < firstDayIndex; i++) {
        html += '<div class="calendar-day muted"></div>';
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const date = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const isAvailable = bookingAvailabilityDates.includes(date);
        const isSelected = date === document.getElementById('bookingSelectedDate').value;
        html += `<button type="button" class="calendar-day ${isSelected ? 'selected' : ''} ${isAvailable ? 'active' : ''}" onclick="selectBookingDate('${date}')">${day}</button>`;
    }

    document.getElementById('bookingCalendarGrid').innerHTML = html;
}

function selectBookingDate(date) {
    document.getElementById('bookingSelectedDate').value = date;
    document.querySelectorAll('.slot-group').forEach(function(group) {
        group.style.display = 'none';
    });

    const target = document.getElementById('slots-' + date);
    if (target) {
        target.style.display = 'block';
        const firstChoice = target.querySelector('input[type="radio"]');
        if (firstChoice) {
            firstChoice.checked = true;
        }
    }

    const label = document.getElementById('selectedSlotDateLabel');
    if (label) {
        const formatted = new Date(date + 'T00:00:00').toLocaleDateString('en', { month: 'short', day: 'numeric', year: 'numeric' });
        label.textContent = target
            ? 'Showing slots for ' + formatted
            : 'No availability for ' + formatted;
    }

    renderBookingCalendar();
}

function changeBookingMonth(delta) {
    const [year, month] = bookingMonth.split('-').map(Number);
    const nextDate = new Date(year, month - 1 + delta, 1);
    bookingMonth = `${nextDate.getFullYear()}-${String(nextDate.getMonth() + 1).padStart(2, '0')}`;
    renderBookingCalendar();
}

document.addEventListener('DOMContentLoaded', function() {
    renderBookingCalendar();
    if (bookingAvailabilityDates.includes(bookingDefaultDate)) {
        selectBookingDate(bookingDefaultDate);
    } else if (bookingAvailabilityDates.length) {
        selectBookingDate(bookingAvailabilityDates[0]);
    }
});
</script>
@endsection
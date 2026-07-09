@extends('layouts.main')

@section('title', 'My Availability')

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
                <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                    <a href="{{ route('doctor.schedules') }}" class="non-style-link-menu non-style-link-menu-active">
                        <div>
                            <p class="menu-text">My Availability</p>
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
                    <a href="{{ route('doctor.dashboard') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Availability</p>
                    <!-- <p style="font-size: 13px;color:#666;padding-left:12px;margin:4px 0 0;">Create simple 30-minute slots patients can book instantly.</p> -->

                <td width="25%" style="text-align:right;">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        {{ $today }}
                    </p>

                    <!-- ADD SESSION BUTTON -->
                    <div style="margin-top:10px;">
                        <button onclick="document.getElementById('addSessionBox').style.display='block'"
                            class="btn-primary btn" style="padding:10px 15px; font-size:14px; border-radius:6px; box-shadow: 0 3px 8px rgba(0,0,0,0.12);">
                            + Add Availability
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
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All booking slots
                        ({{ $schedules->count() }}) </p>
                </td>
            </tr>

            <!-- <tr>
                <td colspan="4">
                    <div style="margin: 10px 45px 18px; padding: 16px 18px; border-radius: 14px; background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%); border: 1px solid #dbeafe;">
                        <p style="margin: 0 0 6px; font-weight: 700; color: #1d4ed8;">Quick guide</p>
                        <ul style="margin: 0; padding-left: 18px; color: #4b5563; line-height: 1.6;">
                            <li>Create a time range and the system turns it into easy 30-minute booking slots.</li>
                            <li>Patients can book one slot at a time.</li>
                            <li>Slots automatically become unavailable when full.</li>
                        </ul>
                    </div>
                </td>
            </tr> -->

            <tr>
                <td colspan="4" style="padding: 0 45px 10px;">
                    @php
                        $doctorScheduleDates = $scheduleDates ?? [];
                        $defaultDoctorViewDate = request('scheduledate') ?: $today;
                    @endphp
                    <div class="calendar-card" style="margin-top: 8px;">
                        <div class="calendar-toolbar">
                            <button type="button" class="calendar-nav" onclick="changeDoctorOverviewMonth(-1)">&lsaquo;</button>
                            <span id="doctorOverviewLabel">Loading...</span>
                            <button type="button" class="calendar-nav" onclick="changeDoctorOverviewMonth(1)">&rsaquo;</button>
                        </div>
                        <div class="calendar-weekdays">
                            <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                        </div>
                        <div id="doctorOverviewGrid" class="calendar-grid"></div>
                    </div>
                    <br><br>
                    <p style="margin: 10px 0 0; font-size: 14px; color: #4b5563;">Selected day: <strong id="doctorOverviewSelectedText">{{ \Carbon\Carbon::parse($defaultDoctorViewDate)->format('M d, Y') }}</strong></p>
                    <input type="hidden" id="doctorOverviewSelectedDate" value="{{ $defaultDoctorViewDate }}">
                    <br><br><br>
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
                                        <th class="table-headin">Date & Time</th>
                                        <th class="table-headin">Capacity</th>
                                        <th class="table-headin">Status</th>
                                        <th class="table-headin">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (session('success'))
                                    <tr id="success-row">
                                        <td colspan="5">
                                             <div style="margin:8px 0; padding:10px 12px; background:#ecfdf3; color:#047857; border-radius:8px; font-size:14px;">
                                                  {{ session('success') }}
                                                 </div>
                                                </td>
                                            </tr>
                                            @endif
                                            
                                    @if (session('error'))
                                    <tr>
                                        <td colspan="5">
                                            <div style="margin: 8px 0; padding: 10px 12px; background: #fef2f2; color: #b91c1c; border-radius: 8px; font-size: 14px;">
                                                {{ session('error') }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @forelse($schedules as $schedule)
                                    <tr class="doctor-schedule-row" data-date="{{ $schedule->scheduledate instanceof \Carbon\Carbon ? $schedule->scheduledate->format('Y-m-d') : $schedule->scheduledate }}" style="display: table-row;">
                                        <td> &nbsp;{{ Str::limit($schedule->title, 30) }}</td>
                                        <td style="text-align:center;">
                                            <div style="font-weight:600; color:#111827;">{{ \Carbon\Carbon::parse($schedule->scheduledate)->format('M d, Y') }}</div>
                                            <div style="margin-top:4px; color:#4b5563;">{{ \Carbon\Carbon::parse($schedule->start_time ?? $schedule->scheduletime)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time ?? $schedule->scheduletime)->format('h:i A') }}</div>
                                        </td>
                                        <td style="text-align:center;">{{ $schedule->remaining_capacity ?? $schedule->nop }}/{{ $schedule->nop }}</td>
                                        <td style="text-align:center;">{{ ucfirst($schedule->status ?? 'available') }}</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;align-items:center;gap: 8px;flex-wrap: wrap;min-width:220px;">
                                                <button type="button" class="btn-primary-soft btn button-icon btn-view"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"
                                                    onclick="openViewAvailability({{ $schedule->scheduleid }}, '{{ addslashes($schedule->title) }}', '{{ $schedule->scheduledate }}', '{{ $schedule->start_time ?? $schedule->scheduletime }}', '{{ $schedule->end_time ?? $schedule->scheduletime }}', '{{ $schedule->nop }}', '{{ $schedule->remaining_capacity ?? $schedule->nop }}', '{{ $schedule->status ?? 'available' }}')">
                                                    <font class="tn-in-text">View</font>
                                                </button>
                                                <button type="button" class="btn-primary-soft btn button-icon btn-edit"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"
                                                    onclick="openEditAvailability({{ $schedule->scheduleid }}, '{{ addslashes($schedule->title) }}', '{{ $schedule->scheduledate }}', '{{ $schedule->start_time ?? $schedule->scheduletime }}', '{{ $schedule->end_time ?? $schedule->scheduletime }}', '{{ $schedule->nop }}')">
                                                    <font class="tn-in-text">Edit</font>
                                                </button>
                                                <form action="{{ route('doctor.schedules.destroy', $schedule->scheduleid) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-primary-soft btn button-icon btn-delete"
                                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                        <font class="tn-in-text">Delete</font>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('img/nothingfound.png') }}" width="25%">
                                                <br>
                                                <p class="heading-main12"
                                                    style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Looks
                                                    like you have not added any availability yet.
                                                </p>
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

<script>
function openViewAvailability(id, title, date, startTime, endTime, max, remaining, status) {

    function formatDate(date) {
        return new Date(date).toLocaleDateString('en-US', {
            month: 'short',
            day: '2-digit',
            year: 'numeric'
        });
    }

    function formatTime(time) {
        return new Date('1970-01-01T' + time).toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    }

    document.getElementById('viewAvailabilityTitle').innerText = title;
    document.getElementById('viewAvailabilityDate').innerText = formatDate(date);
    document.getElementById('viewAvailabilityTime').innerText =
        formatTime(startTime) + ' - ' + formatTime(endTime);
    document.getElementById('viewAvailabilityCapacity').innerText = remaining + '/' + max;
    document.getElementById('viewAvailabilityStatus').innerText =
        status.charAt(0).toUpperCase() + status.slice(1);

    document.getElementById('viewSessionBox').style.display = 'block';
}

function openEditAvailability(id, title, date, startTime, endTime, max) {
    document.getElementById('editAvailabilityForm').action = '/doctor/schedules/' + id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_start_time').value = startTime.slice(0, 5);
    document.getElementById('edit_end_time').value = endTime.slice(0, 5);
    document.getElementById('edit_nop').value = max;
    renderEditDoctorCalendar();
    document.getElementById('editSessionBox').style.display = 'block';
}

let doctorCalendarMonth = '{{ date('Y-m') }}';
let editDoctorCalendarMonth = '{{ date('Y-m') }}';
let doctorOverviewMonth = '{{ date('Y-m') }}';
const doctorExistingDates = @json($doctorScheduleDates);

function renderDoctorCalendar() {
    const [year, month] = doctorCalendarMonth.split('-').map(Number);
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const daysInMonth = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    document.getElementById('doctorCalendarLabel').textContent = firstDay.toLocaleString('en', { month: 'long', year: 'numeric' });

    let html = '';
    for (let i = 0; i < firstDayIndex; i++) {
        html += '<div class="calendar-day muted"></div>';
    }
    for (let day = 1; day <= daysInMonth; day++) {
        const date = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const selected = document.getElementById('doctorDateInput').value === date;
        const existing = doctorExistingDates.includes(date);
        html += `<button type="button" class="calendar-day ${selected ? 'selected' : ''} ${existing ? 'active' : ''}" onclick="selectDoctorDate('${date}')">${day}</button>`;
    }
    document.getElementById('doctorCalendarGrid').innerHTML = html;
}

function renderEditDoctorCalendar() {
    const [year, month] = editDoctorCalendarMonth.split('-').map(Number);
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const daysInMonth = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    document.getElementById('editDoctorCalendarLabel').textContent = firstDay.toLocaleString('en', { month: 'long', year: 'numeric' });

    let html = '';
    for (let i = 0; i < firstDayIndex; i++) {
        html += '<div class="calendar-day muted"></div>';
    }
    for (let day = 1; day <= daysInMonth; day++) {
        const date = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const selected = document.getElementById('edit_date').value === date;
        const existing = doctorExistingDates.includes(date);
        html += `<button type="button" class="calendar-day ${selected ? 'selected' : ''} ${existing ? 'active' : ''}" onclick="selectEditDoctorDate('${date}')">${day}</button>`;
    }
    document.getElementById('editDoctorCalendarGrid').innerHTML = html;
}

function selectDoctorDate(date) {
    document.getElementById('doctorDateInput').value = date;
    renderDoctorCalendar();
}

function selectEditDoctorDate(date) {
    document.getElementById('edit_date').value = date;
    renderEditDoctorCalendar();
}

function renderDoctorOverviewCalendar() {
    const [year, month] = doctorOverviewMonth.split('-').map(Number);
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const daysInMonth = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    document.getElementById('doctorOverviewLabel').textContent = firstDay.toLocaleString('en', { month: 'long', year: 'numeric' });

    let html = '';
    for (let i = 0; i < firstDayIndex; i++) {
        html += '<div class="calendar-day muted"></div>';
    }
    for (let day = 1; day <= daysInMonth; day++) {
        const date = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const selected = document.getElementById('doctorOverviewSelectedDate').value === date;
        const existing = doctorExistingDates.includes(date);
        html += `<button type="button" class="calendar-day ${selected ? 'selected' : ''} ${existing ? 'active' : ''}" onclick="selectDoctorOverviewDate('${date}')">${day}</button>`;
    }
    document.getElementById('doctorOverviewGrid').innerHTML = html;
}

function selectDoctorOverviewDate(date) {
    document.getElementById('doctorOverviewSelectedDate').value = date;
    document.querySelectorAll('.doctor-schedule-row').forEach(function(row) {
        row.style.display = row.getAttribute('data-date') === date ? 'table-row' : 'none';
    });
    document.getElementById('doctorOverviewSelectedText').textContent = new Date(date + 'T00:00:00').toLocaleDateString('en', { month: 'short', day: 'numeric', year: 'numeric' });
    renderDoctorOverviewCalendar();
}

function changeDoctorOverviewMonth(delta) {
    const [year, month] = doctorOverviewMonth.split('-').map(Number);
    const nextDate = new Date(year, month - 1 + delta, 1);
    doctorOverviewMonth = `${nextDate.getFullYear()}-${String(nextDate.getMonth() + 1).padStart(2, '0')}`;
    renderDoctorOverviewCalendar();
}

function changeDoctorMonth(delta) {
    const [year, month] = doctorCalendarMonth.split('-').map(Number);
    const nextDate = new Date(year, month - 1 + delta, 1);
    doctorCalendarMonth = `${nextDate.getFullYear()}-${String(nextDate.getMonth() + 1).padStart(2, '0')}`;
    renderDoctorCalendar();
}

function changeEditDoctorMonth(delta) {
    const [year, month] = editDoctorCalendarMonth.split('-').map(Number);
    const nextDate = new Date(year, month - 1 + delta, 1);
    editDoctorCalendarMonth = `${nextDate.getFullYear()}-${String(nextDate.getMonth() + 1).padStart(2, '0')}`;
    renderEditDoctorCalendar();
}

document.addEventListener('DOMContentLoaded', function() {
    renderDoctorCalendar();
    renderEditDoctorCalendar();
    renderDoctorOverviewCalendar();
    if (doctorExistingDates.includes(document.getElementById('doctorOverviewSelectedDate').value)) {
        selectDoctorOverviewDate(document.getElementById('doctorOverviewSelectedDate').value);
    } else if (doctorExistingDates.length) {
        selectDoctorOverviewDate(doctorExistingDates[0]);
    }
});
</script>

<div id="addSessionBox" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('addSessionBox').style.display='none'">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Availability</p><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <form action="{{ route('doctor.schedules.store') }}" method="POST">
                                    @csrf
                                    <label for="title" class="form-label">Session Title: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="title" class="input-text" placeholder="e.g. Evening Consultation" required><br>
                                <p style="font-size:12px;color:#666;margin-top:4px;">Each booking slot will be created as a 30-minute appointment window.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="nop" class="form-label">Patients per 30-minute slot: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="number" name="nop" class="input-text" min="1" placeholder="Maximum bookings per slot" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="date" class="form-label">Availability Date: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <div class="calendar-card" style="margin-top:8px;">
                                    <div class="calendar-toolbar">
                                        <button type="button" class="calendar-nav" onclick="changeDoctorMonth(-1)">&lsaquo;</button>
                                        <span id="doctorCalendarLabel">Loading...</span>
                                        <button type="button" class="calendar-nav" onclick="changeDoctorMonth(1)">&rsaquo;</button>
                                    </div>
                                    <div class="calendar-weekdays">
                                        <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                                    </div>
                                    <div id="doctorCalendarGrid" class="calendar-grid"></div>
                                </div>
                                <input type="date" name="date" id="doctorDateInput" class="input-text" min="{{ date('Y-m-d') }}" required><br>
                                <p style="font-size:12px;color:#666;margin-top:4px;">Click a day in the calendar to choose the date.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="start_time" class="form-label">Start Time: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="time" name="start_time" class="input-text" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="end_time" class="form-label">End Time: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="time" name="end_time" class="input-text" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Save Availability" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                                </form>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

<div id="viewSessionBox" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('viewSessionBox').style.display='none'">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr><td><p style="padding:0;margin:0;text-align:left;font-size:25px;font-weight:500;">Availability Details</p><br></td></tr>
                        <tr><td><strong>Title:</strong> <span id="viewAvailabilityTitle"></span></td></tr>
                        <tr><td><strong>Date:</strong> <span id="viewAvailabilityDate"></span></td></tr>
                        <tr><td><strong>Time:</strong> <span id="viewAvailabilityTime"></span></td></tr>
                        <tr><td><strong>Capacity:</strong> <span id="viewAvailabilityCapacity"></span></td></tr>
                        <tr><td><strong>Status:</strong> <span id="viewAvailabilityStatus"></span></td></tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

<div id="editSessionBox" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('editSessionBox').style.display='none'">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr><td><p style="padding:0;margin:0;text-align:left;font-size:25px;font-weight:500;">Edit Availability</p><br></td></tr>
                        <tr><td>
                            <form id="editAvailabilityForm" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="form-label">Availability Title:</label>
                                <input type="text" id="edit_title" name="title" class="input-text" required><br>
                                <label class="form-label">Max patients:</label>
                                <input type="number" id="edit_nop" name="nop" class="input-text" min="1" required><br>
                                <label class="form-label">Availability Date:</label>
                                <div class="calendar-card" style="margin-top:8px;">
                                    <div class="calendar-toolbar">
                                        <button type="button" class="calendar-nav" onclick="changeEditDoctorMonth(-1)">&lsaquo;</button>
                                        <span id="editDoctorCalendarLabel">Loading...</span>
                                        <button type="button" class="calendar-nav" onclick="changeEditDoctorMonth(1)">&rsaquo;</button>
                                    </div>
                                    <div class="calendar-weekdays">
                                        <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                                    </div>
                                    <div id="editDoctorCalendarGrid" class="calendar-grid"></div>
                                </div>
                                <input type="date" id="edit_date" name="date" class="input-text" min="{{ date('Y-m-d') }}" required><br>
                                <label class="form-label">Start Time:</label>
                                <input type="time" id="edit_start_time" name="start_time" class="input-text" required><br>
                                <label class="form-label">End Time:</label>
                                <input type="time" id="edit_end_time" name="end_time" class="input-text" required><br>
                                <input type="submit" value="Update Availability" class="login-btn btn-primary btn" style="margin-top:10px;">
                            </form>
                        </td></tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

<script>
window.addEventListener('load', function () {
    const row = document.getElementById('success-row');

    if (row) {
        setTimeout(function () {
            row.style.transition = 'opacity 0.5s ease';
            row.style.opacity = '0';

            setTimeout(function () {
                row.remove();
            }, 500);
        }, 3000); // 3 seconds
    }
});
</script>

@endsection
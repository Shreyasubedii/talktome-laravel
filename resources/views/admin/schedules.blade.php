@extends('layouts.main')

@section('title', 'Schedules')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
.schedule-error-message {
    transition: opacity 0.5s ease;
}

.schedule-error-message.is-hidden {
    opacity: 0;
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

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="{{ route('admin.schedules') }}"><button
                            class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Schedule Manager</p>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        {{ $today }}
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img
                            src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <div style="display: flex;margin-top: 40px;align-items: center;justify-content: space-between;">
                        <div class="heading-main12"
                            style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;"></div>
                        <!-- <div style="margin-right: 45px;color: rgb(102, 102, 102);font-size: 14px;">
                            Doctors add their availability slots and patients book from those open times.
                        </div> -->
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All
                        Sessions ({{ $schedules->count() }})</p>
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
                                    <form action="{{ route('admin.schedules') }}" method="get">
                                        <input type="date" name="sheduledate" id="date"
                                            class="input-text filter-container-items" style="margin: 0;width: 95%;"
                                            value="{{ request('sheduledate') }}">
                                </td>
                                <td width="5%" style="text-align: center;">Doctor:</td>
                                <td width="30%">
                                    <select name="docid" id="" class="box filter-container-items"
                                        style="width:90% ;height: 37px;margin: 0;">
                                        <option value="" disabled selected hidden>Choose Doctor Name from the list
                                        </option>
                                        @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->docid }}"
                                            {{ request('docid') == $doctor->docid ? 'selected' : '' }}>
                                            {{ $doctor->docname }}</option>
                                        @endforeach
                                    </select>
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
                                        <th class="table-headin">Therapist</th>
                                        <th class="table-headin">Scheduled Date & Time</th>
                                        <th class="table-headin">Max number that can be booked</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                    <tr>
                                        <td> &nbsp;{{ Str::limit($schedule->title, 30) }}</td>
                                        <td>Dr. {{ Str::limit(ucwords($schedule->doctor?->docname ?? 'Unknown'), 20) }}</td>
                                        <td style="text-align:center;">
                                            <div style="font-weight:600; color:#111827;">{{ \Carbon\Carbon::parse($schedule->scheduledate)->format('M d, Y') }}</div>
                                            <div style="margin-top:4px; color:#4b5563;">{{ \Carbon\Carbon::parse($schedule->start_time ?? $schedule->scheduletime)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time ?? $schedule->scheduletime)->format('h:i A') }}</div>
                                        </td>
                                        <td style="text-align:center;">{{ $schedule->remaining_capacity ?? $schedule->nop }}/{{ $schedule->nop }}</td>
                                        <td>
                                            <div style="display:flex;justify-content:center;align-items:center;gap:8px;flex-wrap:wrap;">
                                                <button type="button" class="btn-primary-soft btn button-icon btn-edit"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"
                                                    onclick="openAdminEditAvailability({{ $schedule->scheduleid }}, '{{ addslashes($schedule->title) }}', '{{ \Carbon\Carbon::parse($schedule->scheduledate)->format('Y-m-d') }}', '{{ $schedule->start_time ?? $schedule->scheduletime }}', '{{ $schedule->end_time ?? $schedule->scheduletime }}', '{{ $schedule->nop }}')">
                                                    <font class="tn-in-text">Edit</font>
                                                </button>
                                                <form action="{{ route('admin.schedules.destroy', $schedule->scheduleid) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-primary-soft btn button-icon btn-delete"
                                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                        <font class="tn-in-text">Remove</font>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <br><br><br><br>
                                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                <p class="heading-main12"
                                                    style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We
                                                    couldn't find anything!</p>
                                                <a class="non-style-link" href="{{ route('admin.schedules') }}"><button
                                                        class="login-btn btn-primary-soft btn"
                                                        style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp;
                                                        Show all Sessions &nbsp;</button></a>
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
function openAdminEditAvailability(id, title, date, startTime, endTime, max) {
    document.getElementById('editAvailabilityForm').action = '/admin/schedules/' + id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_start_time').value = startTime.slice(0, 5);
    document.getElementById('edit_end_time').value = endTime.slice(0, 5);
    document.getElementById('edit_nop').value = max;
    document.getElementById('editPopup').style.display = 'block';
}

@if(session('error') && session('edit_schedule_id'))
@php
    $editSchedule = $schedules->firstWhere('scheduleid', session('edit_schedule_id'));
@endphp
@if($editSchedule)
document.addEventListener('DOMContentLoaded', function () {
    openAdminEditAvailability(
        {{ $editSchedule->scheduleid }},
        @json($editSchedule->title),
        @json($editSchedule->scheduledate->format('Y-m-d')),
        @json($editSchedule->start_time ?? $editSchedule->scheduletime),
        @json($editSchedule->end_time ?? $editSchedule->scheduletime),
        {{ $editSchedule->nop }}
    );
});
@endif
@endif

@if(session('error'))
document.addEventListener('DOMContentLoaded', function () {
    const errorMessage = document.querySelector('.schedule-error-message');

    if (!errorMessage) {
        return;
    }

    setTimeout(function () {
        errorMessage.classList.add('is-hidden');
        setTimeout(function () {
            errorMessage.remove();
        }, 500);
    }, 4000);
});
@endif
</script>

{{-- Add Session Popup --}}
<div id="add-popup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('add-popup').style.display='none'">&times;</a>
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add
                                    New Session.</p><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <form action="{{ route('admin.schedules.store') }}" method="POST">
                                    @csrf
                                    <label for="title" class="form-label">Session Title : </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="title" class="input-text" placeholder="Name of this Session"
                                    required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="doctor" class="form-label">Select Doctor: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <select name="doctor" class="box">
                                    <option value="" disabled selected hidden>Choose Doctor Name from the list</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->docid }}">{{ $doctor->docname }}</option>
                                    @endforeach
                                </select><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="nop" class="form-label">Number of Patients/Appointment Numbers : </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="number" name="nop" class="input-text" min="0" placeholder="Max patients"
                                    required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="date" class="form-label">Session Date: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="date" name="date" class="input-text" min="{{ now()->addDay()->toDateString() }}"
                                    required><br>
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
                                <input type="reset" value="Reset"
                                    class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Place this Session" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                        </form>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

<div id="editPopup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('editPopup').style.display='none'">&times;</a>
            <div style="display:flex;justify-content:center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding:0;margin:0;text-align:left;font-size:25px;font-weight:500;">Edit Availability</p><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form id="editAvailabilityForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if(session('error'))
                                        <div class="schedule-error-message" style="margin-bottom:12px;padding:10px 12px;border:1px solid #fecaca;border-radius:6px;background:#fef2f2;color:#b91c1c;font-size:14px;text-align:left;">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <label class="form-label">Availability Title:</label>
                                    <input type="text" id="edit_title" name="title" class="input-text" required><br>
                                    <label class="form-label">Max patients:</label>
                                    <input type="number" id="edit_nop" name="nop" class="input-text" min="1" required><br>
                                    <label class="form-label">Availability Date:</label>
                                    <input type="date" id="edit_date" name="date" class="input-text" min="{{ now()->addDay()->toDateString() }}" required><br>
                                    <label class="form-label">Start Time:</label>
                                    <input type="time" id="edit_start_time" name="start_time" class="input-text" required><br>
                                    <label class="form-label">End Time:</label>
                                    <input type="time" id="edit_end_time" name="end_time" class="input-text" required><br>
                                    <input type="submit" value="Update Availability" class="login-btn btn-primary btn" style="margin-top:10px;">
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>
@endsection
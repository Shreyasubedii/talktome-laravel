@extends('layouts.main')

@section('title', 'Manage Doctors')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/doctor.css') }}">
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
                    <a href="{{ route('admin.doctors') }}"><button class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <form action="{{ route('admin.doctors') }}" method="get" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Doctor name or Email" list="doctors"
                            value="{{ request('search') }}">&nbsp;&nbsp;
                        <input type="Submit" value="Search" class="login-btn btn-primary btn"
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
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img
                            src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding-top:30px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Manage
                        Therapists</p>
                </td>
                <td colspan="2">
                    <button onclick="document.getElementById('add-popup').style.display='block'"
                        class="login-btn btn-primary btn button-icon"
                        style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('{{ asset('img/icons/add.svg') }}');">Add
                        New</button>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All
                        Therapists
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
                                    @forelse($doctors as $doctor)
                                    <tr>
                                        <td> &nbsp;{{ Str::limit($doctor->docname, 30) }}</td>
                                        <td>{{ Str::limit($doctor->docemail, 20) }}</td>
                                        <td>{{ Str::limit($doctor->specialty?->sname, 20) }}</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;">
                                                <button class="btn-primary-soft btn button-icon btn-edit"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                    <font class="tn-in-text">Edit</font>
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <button class="btn-primary-soft btn button-icon btn-view"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                    <font class="tn-in-text">View</font>
                                                </button>
                                                &nbsp;&nbsp;&nbsp;
                                                <form action="{{ route('admin.doctors.destroy', $doctor->docid) }}"
                                                    method="POST">
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
                                        <td colspan="4">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
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

{{-- Add Doctor Popup --}}
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
                                    New Therapist.</p><br><br>
                            </td>
                        </tr>
                        <tr>
                            <form action="{{ route('admin.doctors.store') }}" method="POST">
                                @csrf
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="name" class="input-text" placeholder="Therapists Name"
                                    required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="email" name="email" class="input-text" placeholder="Email Address"
                                    required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="tel" name="tel" class="input-text" placeholder="Telephone Number"
                                    required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="nic" class="form-label">NID: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="nic" class="input-text" placeholder="NID Number" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="specialty" class="form-label">Choose specialties: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <select name="specialty" class="box">
                                    @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}">{{ $specialty->sname }}</option>
                                    @endforeach
                                </select><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="password" class="form-label">Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="password" name="password" class="input-text"
                                    placeholder="Define a Password" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset"
                                    class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Add" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                        </form>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>
@endsection
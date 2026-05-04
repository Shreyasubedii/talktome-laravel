@extends('layouts.main')

@section('title', 'Settings')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/animations.css') }}">
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
    .popup { animation: transitionIn-Y-bottom 0.5s; }
    .setting-tabs { cursor: pointer; transition: 0.3s; }
    .setting-tabs:hover { background-color: #f0f0f0; }
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
                                    <button type="submit" class="logout-btn btn-primary-soft btn" style="width: 100%;">Log out</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-home">
                    <a href="{{ route('patient.dashboard') }}" class="non-style-link-menu"><div><p class="menu-text">Home</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor">
                    <a href="{{ route('patient.doctors') }}" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-session">
                    <a href="{{ route('patient.schedules') }}" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment">
                    <a href="{{ route('patient.appointments') }}" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></div></a>
                </td>
            </tr>
            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings menu-active menu-icon-settings-active">
                    <a href="{{ route('patient.settings') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Settings</p></div></a>
                </td>
            </tr>
        </table>
    </div>

    <div class="dash-body" style="margin-top: 15px">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
            <tr>
                <td width="13%" >
                    <a href="{{ route('patient.dashboard') }}" ><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Settings</p>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">{{ $today }}</p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <center>
                    <table class="filter-container" style="border: none;" border="0">
                        <tr>
                            <td colspan="4"><p style="font-size: 20px">&nbsp;</p></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;">
                                <div onclick="document.getElementById('edit-popup').style.display='block'" class="dashboard-items setting-tabs" style="padding:20px;margin:auto;width:95%;display: flex">
                                    <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/doctors-hover.svg') }}');"></div>
                                    <div>
                                        <div class="h1-dashboard">Account Settings &nbsp;</div><br>
                                        <div class="h3-dashboard" style="font-size: 15px;">Edit your Account Details & Change Password</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                             <td style="width: 25%; padding-top: 20px;">
                                <div onclick="document.getElementById('view-popup').style.display='block'" class="dashboard-items setting-tabs" style="padding:20px;margin:auto;width:95%;display: flex">
                                    <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/view-iceblue.svg') }}');"></div>
                                    <div>
                                        <div class="h1-dashboard">View Account Details</div><br>
                                        <div class="h3-dashboard" style="font-size: 15px;">View Personal information About Your Account</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                             <td style="width: 25%; padding-top: 20px;">
                                <div onclick="document.getElementById('delete-popup').style.display='block'" class="dashboard-items setting-tabs" style="padding:20px;margin:auto;width:95%;display: flex">
                                    <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('{{ asset('img/icons/patients-hover.svg') }}');"></div>
                                    <div>
                                        <div class="h1-dashboard" style="color: #ff5050;">Delete Account</div><br>
                                        <div class="h3-dashboard" style="font-size: 15px;">Will Permanently Remove your Account</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- Edit Popup --}}
<div id="edit-popup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('edit-popup').style.display='none'">&times;</a> 
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td><p style="text-align: left;font-size: 25px;font-weight: 500;">Edit Account Details.</p><br></td>
                        </tr>
                        <form action="{{ route('patient.settings.update') }}" method="POST">
                            @csrf @method('PUT')
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                    <input type="text" name="name" class="input-text" value="{{ $patient->pname }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="address" class="form-label">Address: </label>
                                    <input type="text" name="address" class="input-text" value="{{ $patient->paddress }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="tel" class="form-label">Telephone: </label>
                                    <input type="tel" name="tel" class="input-text" value="{{ $patient->ptel }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="password" class="form-label">New Password (leave blank to keep current): </label>
                                    <input type="password" name="password" class="input-text" placeholder="New Password">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="Save Changes" class="login-btn btn-primary btn">
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

{{-- View Popup --}}
<div id="view-popup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('view-popup').style.display='none'">&times;</a> 
            <div style="display: flex;justify-content: center;">
                <table width="80%" class="sub-table scrolldown" border="0">
                    <tr>
                        <td><p style="text-align: left;font-size: 25px;font-weight: 500;">Account Details.</p><br></td>
                    </tr>
                    <tr>
                        <td class="label-td"><label class="form-label">Name: </label></td>
                        <td>{{ $patient->pname }}</td>
                    </tr>
                    <tr>
                        <td class="label-td"><label class="form-label">Email: </label></td>
                        <td>{{ $patient->pemail }}</td>
                    </tr>
                    <tr>
                        <td class="label-td"><label class="form-label">NIC: </label></td>
                        <td>{{ $patient->pnic }}</td>
                    </tr>
                    <tr>
                        <td class="label-td"><label class="form-label">Telephone: </label></td>
                        <td>{{ $patient->ptel }}</td>
                    </tr>
                </table>
            </div>
        </center>
    </div>
</div>

{{-- Delete Popup --}}
<div id="delete-popup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <h2>Are you sure?</h2>
            <a class="close" href="#" onclick="document.getElementById('delete-popup').style.display='none'">&times;</a>
            <div class="content">You want to permanently delete your account?</div>
            <div style="display: flex;justify-content: center;">
                <form action="{{ route('patient.settings.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-primary btn" style="margin:10px;padding:10px;">Yes</button>
                </form>
                <button onclick="document.getElementById('delete-popup').style.display='none'" class="btn-primary btn" style="margin:10px;padding:10px;">No</button>
            </div>
        </center>
    </div>
</div>

@if(session('success'))
<div id="success-popup" class="overlay">
    <div class="popup">
        <center>
            <br><br>
            <h2>Updated Successfully!</h2>
            <a class="close" href="{{ route('patient.settings') }}">&times;</a>
            <div class="content">Your profile information has been updated.</div>
            <div style="display: flex;justify-content: center;">
                <a href="{{ route('patient.settings') }}" class="non-style-link"><button class="btn-primary btn">OK</button></a>
            </div>
            <br><br>
        </center>
    </div>
</div>
@endif
@endsection
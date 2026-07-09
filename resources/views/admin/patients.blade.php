@extends('layouts.main')

@section('title', 'Patients')

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
                    <a href="{{ route('admin.patients') }}"><button class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Patients Manager</p>
                </td>
                <td>
                    <form action="{{ route('admin.patients') }}" method="get" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar"
                            placeholder="Search Patient name or Email" list="patient"
                            value="{{ request('search') }}">&nbsp;&nbsp;
                        <datalist id="patient">
                            @foreach($allPatients as $p)
                            <option value="{{ $p->pname }}">
                            <option value="{{ $p->pemail }}">
                                @endforeach
                        </datalist>
                        <input type="Submit" value="Search" class="login-btn btn-primary btn"
                            style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
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
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All
                        Patients ({{ $patients->count() }})</p>
                        <br><br><br>
                </td>
            </tr>

            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                <thead>
                                    <tr>
                                        <th class="table-headin">Name</th>
                                        <th class="table-headin">Telephone</th>
                                        <th class="table-headin">Email</th>
                                        <th class="table-headin">Date of Birth</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patients as $patient)
                                    <tr>
                                        <td> &nbsp;{{ Str::limit($patient->pname, 35) }}</td>
                                        <td>{{ Str::limit($patient->ptel, 10) }}</td>
                                        <td>{{ Str::limit($patient->pemail, 20) }}</td>
                                        <td>{{ Str::limit($patient->pdob, 10) }}</td>
                                        <td>
                                            <div style="display:flex;justify-content: center;align-items:center;gap:8px;flex-wrap:wrap;">
                                                <button type="button" class="btn-primary-soft btn button-icon btn-edit"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"
                                                    onclick="openAdminPatientEdit({{ $patient->pid }}, '{{ addslashes($patient->pname) }}', '{{ $patient->pemail }}', '{{ $patient->ptel }}', '{{ $patient->pdob }}', '{{ $patient->pnic }}')">
                                                    <font class="tn-in-text">Edit</font>
                                                </button>
                                                <button type="button" class="btn-primary-soft btn button-icon btn-view"
                                                    style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"
                                                    onclick="openAdminPatientView('{{ addslashes($patient->pname) }}', '{{ $patient->pemail }}', '{{ $patient->ptel }}', '{{ $patient->pdob }}', '{{ $patient->pnic }}')">
                                                    <font class="tn-in-text">View</font>
                                                </button>
                                                <form action="{{ route('admin.patients.destroy', $patient->pid) }}"
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
                                        <td colspan="5">
                                            <center>
                                                <br><br><br><br>
                                                <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                <p class="heading-main12"
                                                    style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We
                                                    couldn't find anything!</p>
                                                <a class="non-style-link" href="{{ route('admin.patients') }}"><button
                                                        class="login-btn btn-primary-soft btn"
                                                        style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp;
                                                        Show all Patients &nbsp;</button></a>
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
function openAdminPatientEdit(id, name, email, tel, dob, nic) {
    document.getElementById('editPatientForm').action = '/admin/patients/' + id;
    document.getElementById('edit_patient_name').value = name;
    document.getElementById('edit_patient_email').value = email;
    document.getElementById('edit_patient_tel').value = tel;
    document.getElementById('edit_patient_dob').value = dob;
    document.getElementById('edit_patient_nic').value = nic;
    document.getElementById('edit-patient-popup').style.display = 'block';
}

function openAdminPatientView(name, email, tel, dob, nic) {
    document.getElementById('view_patient_name').textContent = name;
    document.getElementById('view_patient_email').textContent = email;
    document.getElementById('view_patient_tel').textContent = tel;
    document.getElementById('view_patient_dob').textContent = dob;
    document.getElementById('view_patient_nic').textContent = nic;
    document.getElementById('view-patient-popup').style.display = 'block';
}
</script>

<div id="edit-patient-popup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('edit-patient-popup').style.display='none'">&times;</a>
            <div style="display:flex;justify-content:center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr><td><p style="padding:0;margin:0;text-align:left;font-size:25px;font-weight:500;">Edit Patient</p><br></td></tr>
                        <tr><td>
                            <form id="editPatientForm" method="POST">
                                @csrf
                                @method('PUT')
                                <label class="form-label">Name:</label>
                                <input type="text" id="edit_patient_name" name="name" class="input-text" required><br>
                                <label class="form-label">Email:</label>
                                <input type="email" id="edit_patient_email" name="email" class="input-text" required><br>
                                <label class="form-label">Telephone:</label>
                                <input type="tel" id="edit_patient_tel" name="tel" class="input-text" required><br>
                                <label class="form-label">Date of Birth:</label>
                                <input type="date" id="edit_patient_dob" name="dob" class="input-text" required><br>
                                <label class="form-label">NID:</label>
                                <input type="text" id="edit_patient_nic" name="nic" class="input-text" required><br>
                                <input type="submit" value="Save Changes" class="login-btn btn-primary btn" style="margin-top:10px;">
                            </form>
                        </td></tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

<div id="view-patient-popup" class="overlay" style="display: none;">
    <div class="popup">
        <center>
            <a class="close" href="#" onclick="document.getElementById('view-patient-popup').style.display='none'">&times;</a>
            <div style="display:flex;justify-content:center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr><td><p style="padding:0;margin:0;text-align:left;font-size:25px;font-weight:500;">Patient Details</p><br></td></tr>
                        <tr><td><strong>Name:</strong> <span id="view_patient_name"></span></td></tr>
                        <tr><td><strong>Email:</strong> <span id="view_patient_email"></span></td></tr>
                        <tr><td><strong>Telephone:</strong> <span id="view_patient_tel"></span></td></tr>
                        <tr><td><strong>Date of Birth:</strong> <span id="view_patient_dob"></span></td></tr>
                        <tr><td><strong>NID:</strong> <span id="view_patient_nic"></span></td></tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>
@endsection
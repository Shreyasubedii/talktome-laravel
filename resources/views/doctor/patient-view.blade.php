@extends('layouts.main')

@section('title', 'Patient Details')

@section('content')
<div class="container">
    <h2>Patient Details</h2>

    <table class="sub-table">
        <tr>
            <td><strong>Name:</strong></td>
            <td>{{ $patient->pname }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td>{{ $patient->pemail }}</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong></td>
            <td>{{ $patient->ptel }}</td>
        </tr>
        <tr>
            <td><strong>NIC:</strong></td>
            <td>{{ $patient->pnic }}</td>
        </tr>
        <tr>
            <td><strong>Date of Birth:</strong></td>
            <td>{{ $patient->pdob }}</td>
        </tr>
    </table>

    <br>

    <a href="{{ route('doctor.patients') }}" class="btn btn-primary-soft">
        Back
    </a>
</div>
@endsection
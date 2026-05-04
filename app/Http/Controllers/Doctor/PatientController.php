<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;

class PatientController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $patientIds = Appointment::whereHas('schedule', function($q) use ($doctor) {
            $q->where('docid', $doctor->docid);
        })->pluck('pid')->unique();
        
        $patients = Patient::whereIn('pid', $patientIds)->get();
        $today = date('Y-m-d');
        return view('doctor.patients', compact('patients', 'today', 'doctor'));
    }
}

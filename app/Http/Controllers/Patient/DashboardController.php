<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\History;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) return redirect()->route('login');
        
        $appointments = \App\Models\Appointment::where('pid', $patient->pid)->with('schedule.doctor')->get();
        $today = date('Y-m-d');
        
        return view('patient.dashboard', compact('appointments', 'today', 'patient'));
    }
}
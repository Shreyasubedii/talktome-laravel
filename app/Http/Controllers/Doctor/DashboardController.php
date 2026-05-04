<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        if (!$doctor) return redirect()->route('login');
        
        $schedules = \App\Models\Schedule::where('docid', $doctor->docid)->get();
        $appointments = \App\Models\Appointment::whereHas('schedule', function($q) use ($doctor) {
            $q->where('docid', $doctor->docid);
        })->with('patient')->get();
        
        $today = date('Y-m-d');
        
        return view('doctor.dashboard', compact('schedules', 'appointments', 'today', 'doctor'));
    }
}
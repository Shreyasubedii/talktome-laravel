<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;

class BookingController extends Controller
{
    public function index($doctorId)
    {
        $doctor = Doctor::with('specialty')->findOrFail($doctorId);
        $schedules = Schedule::where('docid', $doctorId)
            ->where('scheduledate', '>=', now()->toDateString())
            ->get();
        $today = date('Y-m-d');
        $patient = Auth::guard('patient')->user();
        
        return view('patient.booking', compact('doctor', 'schedules', 'today', 'patient'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'schedule' => 'required',
            'date' => 'required|date'
        ]);
        
        $patient = Auth::guard('patient')->user();
        $schedule = Schedule::findOrFail($request->schedule);
        
        // Check available slots
        $bookedCount = Appointment::where('scheduleid', $request->schedule)->count();
        if ($bookedCount >= $schedule->nop) {
            return back()->with('error', 'No available slots');
        }
        
        $appointment = Appointment::create([
            'pid' => $patient->pid,
            'apponum' => $bookedCount + 1,
            'scheduleid' => $request->schedule,
            'appodate' => $request->date
        ]);
        
        return redirect()->route('patient.booking.complete', $appointment->appoid);
    }
    
    public function complete($id)
    {
        $appointment = Appointment::with('schedule.doctor', 'patient')->findOrFail($id);
        $today = date('Y-m-d');
        $patient = Auth::guard('patient')->user();
        
        return view('patient.booking-complete', compact('appointment', 'today', 'patient'));
    }
}

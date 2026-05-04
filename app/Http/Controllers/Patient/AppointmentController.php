<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $appointments = Appointment::where('pid', $patient->pid)
            ->with('schedule.doctor')
            ->get();
        $today = date('Y-m-d');
        
        return view('patient.appointments', compact('appointments', 'today', 'patient'));
    }
    
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return back()->with('success', 'Appointment cancelled');
    }
}

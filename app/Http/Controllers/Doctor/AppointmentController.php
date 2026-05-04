<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $appointments = Appointment::whereHas('schedule', function($q) use ($doctor) {
            $q->where('docid', $doctor->docid);
        })->with('patient', 'schedule')->get();
        $today = date('Y-m-d');
        
        return view('doctor.appointments', compact('appointments', 'today', 'doctor'));
    }
    
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return back()->with('success', 'Appointment deleted');
    }
}

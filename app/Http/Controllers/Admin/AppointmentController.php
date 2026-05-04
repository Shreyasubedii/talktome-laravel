<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $query = Appointment::with(['patient', 'schedule.doctor']);
        
        if ($request->filled('sheduledate')) {
            $query->whereHas('schedule', function($q) use ($request) {
                $q->where('scheduledate', $request->sheduledate);
            });
        }
        
        if ($request->filled('docid')) {
            $query->whereHas('schedule', function($q) use ($request) {
                $q->where('docid', $request->docid);
            });
        }
        
        $appointments = $query->orderBy('appodate', 'desc')->get();
        $doctors = \App\Models\Doctor::orderBy('docname', 'asc')->get();
        
        return view('admin.appointments', compact('appointments', 'doctors', 'today'));
    }
    
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return back()->with('success', 'Appointment deleted');
    }
}

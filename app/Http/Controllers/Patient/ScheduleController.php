<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Doctor;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $date = $request->scheduledate;
        
        $query = Schedule::with('doctor.specialty', 'appointments')
            ->where('scheduledate', '>=', now()->toDateString());
            
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('doctor', function($dq) use ($search) {
                      $dq->where('docname', 'like', "%$search%");
                  });
            });
        }
        
        if ($date) {
            $query->where('scheduledate', $date);
        }
        
        $schedules = $query->orderBy('scheduledate')->orderBy('scheduletime')->get()
            ->filter(function ($schedule) {
                return $schedule->status === 'available' && ! $schedule->is_full && $schedule->remaining_capacity > 0;
            })
            ->values();
        $today = date('Y-m-d');
        $patient = Auth::guard('patient')->user();
        
        return view('patient.schedules', compact('schedules', 'today', 'patient', 'search'));
    }
//     public function individualSessions()
// {
//     return view('patient.individualsessions',compact('schedules', 'today', 'patient', 'search'));
// }
// 
}
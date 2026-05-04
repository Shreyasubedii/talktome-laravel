<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Specialty;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $nextweek = date('Y-m-d', strtotime('+1 week'));
        
        $doctorsCount = Doctor::count();
        $patientsCount = Patient::count();
        $appointmentsCount = Appointment::where('appodate', '>=', $today)->count();
        $sessionsCount = Schedule::where('scheduledate', $today)->count();
        
        $upcomingAppointments = Appointment::with(['patient', 'schedule.doctor'])
            ->whereHas('schedule', function($query) use ($today, $nextweek) {
                $query->whereBetween('scheduledate', [$today, $nextweek]);
            })
            ->orderBy('appodate', 'desc')
            ->limit(10)
            ->get();
            
        $upcomingSessions = Schedule::with('doctor')
            ->whereBetween('scheduledate', [$today, $nextweek])
            ->orderBy('scheduledate', 'desc')
            ->limit(10)
            ->get();
            
        return view('admin.dashboard', [
            'doctorsCount' => $doctorsCount,
            'patientsCount' => $patientsCount,
            'appointmentsCount' => $appointmentsCount,
            'sessionsCount' => $sessionsCount,
            'upcomingAppointments' => $upcomingAppointments,
            'upcomingSessions' => $upcomingSessions,
            'today' => $today
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Specialty;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        $nextweek = date('Y-m-d', strtotime('+1 week'));

        // Basic Counts
        $doctorsCount = Doctor::count();

        $patientsCount = Patient::count();

        $appointmentsCount = Appointment::where('appodate', '>=', $today)
            ->count();

        $sessionsCount = Schedule::where('scheduledate', $today)
            ->count();

        // Upcoming Appointments
        $upcomingAppointments = Appointment::with(['patient', 'schedule.doctor'])
            ->whereHas('schedule', function ($query) use ($today, $nextweek) {
                $query->whereBetween('scheduledate', [$today, $nextweek]);
            })
            ->orderBy('appodate', 'desc')
            ->limit(10)
            ->get();

        // Upcoming Sessions
        $upcomingSessions = Schedule::with('doctor')
            ->whereBetween('scheduledate', [$today, $nextweek])
            ->orderBy('scheduledate', 'desc')
            ->limit(10)
            ->get();

        // Most Booked Doctors
        $topDoctors = Appointment::select(
                'doctor.docid',
                'doctor.docname',
                DB::raw('COUNT(appointment.appoid) as total_bookings')
            )
            ->join('schedule', 'appointment.scheduleid', '=', 'schedule.scheduleid')
            ->join('doctor', 'schedule.docid', '=', 'doctor.docid')
            ->groupBy('doctor.docid', 'doctor.docname')
            ->orderByDesc('total_bookings')
            ->take(5)
            ->get();

        // Most Active Patients
        $topPatients = Appointment::select(
                'patient.pid',
                'patient.pname',
                DB::raw('COUNT(appointment.appoid) as total_appointments')
            )
            ->join('patient', 'appointment.pid', '=', 'patient.pid')
            ->groupBy('patient.pid', 'patient.pname')
            ->orderByDesc('total_appointments')
            ->take(5)
            ->get();

        // Most Common Specialties
        $topSpecialties = Doctor::select(
                'specialties.sname',
                DB::raw('COUNT(doctor.docid) as total_doctors')
            )
            ->join('specialties', 'doctor.specialties', '=', 'specialties.id')
            ->groupBy('specialties.sname')
            ->orderByDesc('total_doctors')
            ->take(5)
            ->get();

        // Monthly Appointment Analytics
        $monthlyAppointments = Appointment::whereMonth(
                'appodate',
                date('m')
            )->count();

        // Weekly Appointments
        $weeklyAppointments = Appointment::whereBetween(
                'appodate',
                [
                    date('Y-m-d', strtotime('-7 days')),
                    $today
                ]
            )->count();

        return view('admin.dashboard', compact(
            'doctorsCount',
            'patientsCount',
            'appointmentsCount',
            'sessionsCount',
            'upcomingAppointments',
            'upcomingSessions',
            'topDoctors',
            'topPatients',
            'topSpecialties',
            'monthlyAppointments',
            'weeklyAppointments',
            'today'
        ));
    }
}
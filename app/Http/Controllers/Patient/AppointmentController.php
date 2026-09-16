<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $appointments = Appointment::where('pid', $patient->pid)
            ->whereHas('schedule', function ($query) {
                $query->where('scheduledate', '>=', now()->addDay()->toDateString());
            })
            ->with(['schedule.doctor', 'payment'])
            ->get();
        $today = date('Y-m-d');
        
        return view('patient.appointments', compact('appointments', 'today', 'patient'));
    }
    
    // public function destroy($id)
    // {
    //     $appointment = Appointment::findOrFail($id);
    //     $schedule = $appointment->schedule;

    //     $appointment->delete();

    //     if ($schedule) {
    //         $bookedCount = $schedule->appointments()->count();
    //         $remainingCapacity = max($schedule->nop - $bookedCount, 0);
    //         $schedule->update([
    //             'remaining_capacity' => $remainingCapacity,
    //             'is_full' => $remainingCapacity <= 0,
    //             'status' => $remainingCapacity <= 0 ? 'full' : 'available',
    //         ]);
    //     }

    //     return back()->with('success', 'Appointment cancelled');
    // }

    public function destroy($id)
{
    $appointment = Appointment::with('schedule')->findOrFail($id);
    $schedule = $appointment->schedule;

    if ($schedule) {
        $appointmentDateTime = $schedule->scheduledate->copy();

$appointmentDateTime->setTimeFromTimeString(
    $schedule->start_time ?? $schedule->scheduletime
);

        // Prevent cancellation within 24 hours of the appointment
        if (now()->diffInHours($appointmentDateTime, false) < 24) {
            return back()->with(
                'error',
                'Cancellation is not allowed within 24 hours of the appointment.'
            );
        }
    }

    // Delete appointment
    $appointment->delete();

    // Update schedule capacity
    if ($schedule) {
        $bookedCount = $schedule->appointments()->count();
        $remainingCapacity = max($schedule->nop - $bookedCount, 0);

        $schedule->update([
            'remaining_capacity' => $remainingCapacity,
            'is_full' => $remainingCapacity <= 0,
            'status' => $remainingCapacity <= 0 ? 'full' : 'available',
        ]);
    }

    return back()->with('success', 'Appointment cancelled successfully.');
}
}

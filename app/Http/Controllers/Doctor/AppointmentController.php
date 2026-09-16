<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\PatientNotification;

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
        $doctor = Auth::guard('doctor')->user();
        $appointment = Appointment::where('appoid', $id)
            ->whereHas('schedule', function ($query) use ($doctor) {
                $query->where('docid', $doctor->docid);
            })
            ->with('schedule')
            ->findOrFail($id);
        $schedule = $appointment->schedule;

        $notificationType = 'appointment_cancelled:' . $appointment->appoid;
        if (!PatientNotification::where('type', $notificationType)->exists()) {
            PatientNotification::create([
                'patient_id' => $appointment->pid,
                'type' => $notificationType,
                'title' => 'Appointment cancelled',
                'message' => sprintf(
                    'Dr. %s cancelled your appointment scheduled for %s. Status: Cancelled.',
                    ucwords($doctor->docname),
                    $schedule?->scheduledate?->format('M d, Y') ?? $appointment->appodate
                ),
            ]);
        }

        $appointment->delete();

        if ($schedule) {
            $bookedCount = $schedule->appointments()->count();
            $remainingCapacity = max($schedule->nop - $bookedCount, 0);
            $schedule->update([
                'remaining_capacity' => $remainingCapacity,
                'is_full' => $remainingCapacity <= 0,
                'status' => $remainingCapacity <= 0 ? 'full' : 'available',
            ]);
        }

        return back()->with('success', 'Appointment deleted');
    }
}

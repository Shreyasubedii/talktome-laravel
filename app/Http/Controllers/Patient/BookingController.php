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
        $tomorrow = now()->addDay()->toDateString();
        $schedules = Schedule::where('docid', $doctorId)
            ->where('scheduledate', '>=', $tomorrow)
            ->where('status', 'available')
            ->where('is_full', false)
            ->orderBy('scheduledate')
            ->orderBy('start_time')
            ->get()
            ->filter(function ($schedule) {
                return $schedule->remaining_capacity > 0;
            })
            ->values();
        $groupedSchedules = $schedules->groupBy(function ($schedule) {
            return $schedule->scheduledate instanceof \Carbon\Carbon
                ? $schedule->scheduledate->format('Y-m-d')
                : (string) $schedule->scheduledate;
        });
        $bookingDates = $schedules->pluck('scheduledate')
            ->map(function ($date) {
                return $date instanceof \Carbon\Carbon ? $date->format('Y-m-d') : (string) $date;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
        $today = date('Y-m-d');
        $patient = Auth::guard('patient')->user();
        
        return view('patient.booking', compact('doctor', 'schedules', 'groupedSchedules', 'bookingDates', 'today', 'patient'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'schedule' => 'required|exists:schedule,scheduleid',
            'selected_date' => 'required|date',
        ]);

        $patient = Auth::guard('patient')->user();
        $schedule = Schedule::findOrFail($request->schedule);

        if (!$schedule->isBookable()
            || $schedule->scheduledate->format('Y-m-d') !== $request->selected_date) {
            return back()->with('error', 'This availability slot is no longer available.');
        }

        $existingBooking = Appointment::where('scheduleid', $schedule->scheduleid)
            ->where('pid', $patient->pid)
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'You already booked this availability slot.');
        }

        $bookedCount = Appointment::where('scheduleid', $schedule->scheduleid)->count();
        if ($bookedCount >= $schedule->nop || $schedule->is_full || $schedule->status !== 'available' || $schedule->remaining_capacity <= 0) {
            return back()->with('error', 'This slot is no longer available.');
        }

        $appointment = Appointment::create([
            'pid' => $patient->pid,
            'apponum' => $bookedCount + 1,
            'scheduleid' => $schedule->scheduleid,
            'appodate' => $schedule->scheduledate
        ]);

        $remainingCapacity = $schedule->nop - ($bookedCount + 1);
        $schedule->update([
            'remaining_capacity' => max($remainingCapacity, 0),
            'is_full' => $remainingCapacity <= 0,
            'status' => $remainingCapacity <= 0 ? 'full' : 'available',
        ]);

        return redirect()->route('patient.booking.complete', $appointment->appoid);
    }
    
    public function complete($id)
    {
        $patient = Auth::guard('patient')->user();
        $appointment = Appointment::with('schedule.doctor', 'patient')
            ->where('pid', $patient->pid)
            ->whereHas('schedule', function ($query) {
                $query->where('scheduledate', '>=', now()->addDay()->toDateString());
            })
            ->findOrFail($id);
        $today = date('Y-m-d');
        
        return view('patient.booking-complete', compact('appointment', 'today', 'patient'));
    }
}

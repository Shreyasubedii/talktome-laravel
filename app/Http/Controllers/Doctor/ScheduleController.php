<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\PatientNotification;
use App\Services\ScheduleUpdateService;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        $query = Schedule::where('docid', $doctor->docid);

        if ($request->filled('scheduledate')) {
            $query->where('scheduledate', $request->scheduledate);
        }

        $schedules = $query->orderBy('scheduledate')->orderBy('start_time')->get();
        $scheduleDates = $schedules->pluck('scheduledate')
            ->map(function ($date) {
                return $date instanceof \Carbon\Carbon ? $date->format('Y-m-d') : (string) $date;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
        $today = date('Y-m-d');
        return view('doctor.schedules', compact('schedules', 'today', 'doctor', 'scheduleDates'));
    }
     
    public function store(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();

        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'nop' => 'required|integer|min:1',
        ]);

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $date = $request->input('date');

        $overlap = Schedule::where('docid', $doctor->docid)
            ->where('scheduledate', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'This time overlaps with an existing availability slot.');
        }

        $slotData = Schedule::buildThirtyMinuteSlots($request->title, $date, $startTime, $endTime, (int) $request->nop);

        foreach ($slotData as $slot) {
            Schedule::create(array_merge($slot, ['docid' => $doctor->docid]));
        }

        return redirect()->route('doctor.schedules')->with('success', '30-minute availability slots created successfully.');
    }

    public function update(Request $request, $id, ScheduleUpdateService $scheduleUpdateService)
    {
        $doctor = Auth::guard('doctor')->user();
        $schedule = Schedule::where('docid', $doctor->docid)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'nop' => 'required|integer|min:1',
        ]);

        $error = $scheduleUpdateService->update($schedule, [
            'title' => $request->title,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'nop' => (int) $request->nop,
        ]);

        if ($error) {
            return back()->with('error', $error);
        }

        return redirect()->route('doctor.schedules')->with('success', 'Availability updated successfully.');
    }

    public function destroy($id)
    {
        $doctor = Auth::guard('doctor')->user();
        $schedule = Schedule::where('docid', $doctor->docid)
            ->with('appointments')
            ->findOrFail($id);

        foreach ($schedule->appointments as $appointment) {
            $notificationType = 'appointment_cancelled:' . $appointment->appoid;

            if (!PatientNotification::where('type', $notificationType)->exists()) {
                PatientNotification::create([
                    'patient_id' => $appointment->pid,
                    'type' => $notificationType,
                    'title' => 'Appointment cancelled',
                    'message' => sprintf(
                        'Dr. %s cancelled your appointment scheduled for %s because the availability slot was deleted. Status: Cancelled.',
                        ucwords($doctor->docname),
                        $schedule->scheduledate?->format('M d, Y') ?? $appointment->appodate
                    ),
                ]);
            }
        }

        $schedule->delete();
        return back()->with('success', 'Availability deleted');
    }
}
<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;

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

    public function update(Request $request, $id)
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

        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $date = $request->input('date');

        if ($schedule->appointments()->exists()) {
            return back()->with('error', 'Booked availability slots cannot be edited.');
        }

        $overlappingSchedules = Schedule::where('docid', $doctor->docid)
            ->where('scheduleid', '!=', $schedule->scheduleid)
            ->where('scheduledate', $date)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->get();

        $bookedOverlap = $overlappingSchedules->first(function ($overlappingSchedule) {
            return $overlappingSchedule->appointments()->exists();
        });

        if ($bookedOverlap) {
            return back()->with('error', 'This time overlaps with a booked availability slot.');
        }

        DB::transaction(function () use ($schedule, $overlappingSchedules, $request, $date, $startTime, $endTime) {
            $overlappingSchedules->each->delete();

            $bookedCount = $schedule->appointments()->count();
            $remainingCapacity = max($request->nop - $bookedCount, 0);

            $schedule->update([
                'title' => $request->title,
                'scheduledate' => $date,
                'scheduletime' => $startTime,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'nop' => $request->nop,
                'remaining_capacity' => $remainingCapacity,
                'status' => $remainingCapacity > 0 ? 'available' : 'full',
                'is_full' => $remainingCapacity < 1,
            ]);
        });

        return redirect()->route('doctor.schedules')->with('success', 'Availability updated successfully.');
    }

    public function destroy($id)
    {
        $doctor = Auth::guard('doctor')->user();
        Schedule::where('docid', $doctor->docid)->findOrFail($id)->delete();
        return back()->with('success', 'Availability deleted');
    }
}
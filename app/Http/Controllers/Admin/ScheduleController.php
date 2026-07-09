<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $query = Schedule::with('doctor');

        if ($request->filled('sheduledate')) {
            $query->where('scheduledate', $request->sheduledate);
        }

        if ($request->filled('docid')) {
            $query->where('docid', $request->docid);
        }

        $schedules = $query->orderBy('scheduledate', 'asc')->orderBy('start_time')->get();
        $doctors = \App\Models\Doctor::orderBy('docname', 'asc')->get();

        return view('admin.schedules', compact('schedules', 'doctors', 'today'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor' => 'required|exists:doctors,docid',
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'nop' => 'required|integer|min:1',
        ]);

        $overlap = Schedule::where('docid', $request->doctor)
            ->where('scheduledate', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'This time overlaps with an existing availability slot.');
        }

        $slotData = \App\Models\Schedule::buildThirtyMinuteSlots(
            $request->title,
            $request->date,
            $request->start_time,
            $request->end_time,
            (int) $request->nop
        );

        foreach ($slotData as $slot) {
            Schedule::create(array_merge($slot, ['docid' => $request->doctor]));
        }

        return back()->with('success', 'Availability slots added');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'nop' => 'required|integer|min:1',
        ]);

        $schedule = Schedule::findOrFail($id);

        $overlap = Schedule::where('docid', $schedule->docid)
            ->where('scheduleid', '!=', $schedule->scheduleid)
            ->where('scheduledate', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'This time overlaps with another availability slot.');
        }

        $schedule->update([
            'title' => $request->title,
            'scheduledate' => $request->date,
            'scheduletime' => $request->start_time,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'nop' => $request->nop,
            'remaining_capacity' => max($request->nop - $schedule->appointments()->count(), 0),
            'status' => max($request->nop - $schedule->appointments()->count(), 0) > 0 ? 'available' : 'full',
            'is_full' => max($request->nop - $schedule->appointments()->count(), 0) < 1,
        ]);

        return back()->with('success', 'Availability updated');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return back()->with('success', 'Availability deleted');
    }
}

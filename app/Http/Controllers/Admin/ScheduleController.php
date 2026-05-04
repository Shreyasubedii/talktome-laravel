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
        
        $schedules = $query->orderBy('scheduledate', 'desc')->get();
        $doctors = \App\Models\Doctor::orderBy('docname', 'asc')->get();
        
        return view('admin.schedules', compact('schedules', 'doctors', 'today'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'doctor' => 'required',
            'title' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'nop' => 'required|integer'
        ]);
        
        Schedule::create([
            'docid' => $request->doctor,
            'title' => $request->title,
            'scheduledate' => $request->date,
            'scheduletime' => $request->time,
            'nop' => $request->nop
        ]);
        
        return back()->with('success', 'Schedule added');
    }
    
    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return back()->with('success', 'Schedule deleted');
    }
}

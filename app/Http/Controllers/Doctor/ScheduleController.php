<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $schedules = Schedule::where('docid', $doctor->docid)->get();
        $today = date('Y-m-d');
        return view('doctor.schedules', compact('schedules', 'today', 'doctor'));
    }
    
    public function store(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'nop' => 'required|integer'
        ]);
        
        Schedule::create([
            'docid' => $doctor->docid,
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

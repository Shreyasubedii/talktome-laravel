<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $today = date('Y-m-d');
        return view('doctor.settings', compact('doctor', 'today'));
    }
    
    public function update(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'name' => 'required',
            'tel' => 'required',
            'password' => 'nullable|min:6'
        ]);
        
        $doctor->docname = $request->name;
        $doctor->doctel = $request->tel;
        if ($request->password) {
            $doctor->docpassword = $request->password;
        }
        $doctor->save();
        
        return back()->with('success', 'Profile updated');
    }
}

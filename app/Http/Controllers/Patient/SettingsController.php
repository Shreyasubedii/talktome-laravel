<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class SettingsController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $today = date('Y-m-d');
        return view('patient.settings', compact('patient', 'today'));
    }
    
    public function update(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'tel' => 'required',
            'password' => 'nullable|min:6'
        ]);
        
        $patient->pname = $request->name;
        $patient->paddress = $request->address;
        $patient->ptel = $request->tel;
        if ($request->password) {
            $patient->ppassword = $request->password;
        }
        $patient->save();
        
        return back()->with('success', 'Profile updated');
    }
    
    public function destroy()
    {
        $patient = Auth::guard('patient')->user();
        $email = $patient->pemail;
        
        Appointment::where('pid', $patient->pid)->delete();
        $patient->delete();
        
        \App\Models\WebUser::where('email', $email)->delete();
        
        Auth::logout();
        return redirect('/')->with('success', 'Account deleted');
    }
}

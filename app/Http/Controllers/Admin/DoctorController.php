<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\WebUser;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('specialty')->get();
        $specialties = \App\Models\Specialty::orderBy('sname', 'asc')->get();
        return view('admin.doctors', compact('doctors', 'specialties'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
            'nic' => 'required',
            'tel' => 'required',
            'specialty' => 'required'
        ]);
        
        $doctor = Doctor::create([
            'docemail' => $request->email,
            'docname' => $request->name,
            'docpassword' => $request->password,
            'docnic' => $request->nic,
            'doctel' => $request->tel,
            'specialties' => $request->specialty
        ]);
        
        // Add to webuser
        WebUser::create([
            'email' => $request->email,
            'usertype' => 'd'
        ]);
        
        return back()->with('success', 'Doctor added successfully');
    }
    
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $email = $doctor->docemail;
        $doctor->delete();
        
        WebUser::where('email', $email)->delete();
        
        return back()->with('success', 'Doctor deleted');
    }
}

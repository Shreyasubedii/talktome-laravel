<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialty;

class DoctorsController extends Controller
{
    public function index(Request $request)
    {
        $specialty = $request->specialty;
        
        if ($specialty) {
            $doctors = Doctor::where('specialties', $specialty)->with('specialty')->get();
        } else {
            $doctors = Doctor::with('specialty')->get();
        }
        
        $specialties = Specialty::all();
        $today = date('Y-m-d');
        $patient = auth()->guard('patient')->user();
        
        return view('patient.doctors', compact('doctors', 'specialties', 'today', 'patient'));
    }
}

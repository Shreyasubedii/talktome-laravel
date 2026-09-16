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
        $search = trim((string) $request->input('search', ''));
        $specialty = $request->input('specialty');

        $query = Doctor::with('specialty');

        if ($specialty) {
            $query->where('specialties', $specialty);
        }

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('docname', 'like', '%' . $search . '%')
                    ->orWhere('docemail', 'like', '%' . $search . '%')
                    ->orWhereHas('specialty', function ($specialtyQuery) use ($search) {
                        $specialtyQuery->where('sname', 'like', '%' . $search . '%');
                    });
            });
        }

        $doctors = $query->get();
        
        $specialties = Specialty::all();
        $today = date('Y-m-d');
        $patient = auth()->guard('patient')->user();
        
        return view('patient.doctors', compact('doctors', 'specialties', 'today', 'patient', 'search'));
    }
}

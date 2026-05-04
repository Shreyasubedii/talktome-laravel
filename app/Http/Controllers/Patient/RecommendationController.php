<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Specialty;
use App\Models\Doctor;
use App\Models\History;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $problem = $request->problem;
        $today = date('Y-m-d');
        $patient = Auth::guard('patient')->user();
        
        if (!$problem) {
            return view('patient.recommendation', compact('today', 'patient'));
        }
        
        // Find matching specialties based on keywords
        $specialties = Specialty::all()->filter(function($specialty) use ($problem) {
            $keywords = strtolower($specialty->keywords);
            $problemLower = strtolower($problem);
            return str_contains($keywords, $problemLower);
        });
        
        if ($specialties->isEmpty()) {
            // Get all specialties if no match found
            $specialties = Specialty::all();
        }
        
        $specialtyIds = $specialties->pluck('id');
        $doctors = Doctor::whereIn('specialties', $specialtyIds)->with('specialty')->get();
        
        // Save to history
        History::create([
            'user_id' => $patient->pid,
            'problem' => $problem,
            'matched_specialties' => $specialties->pluck('sname')->implode(', '),
            'matched_specialties_ids' => $specialtyIds->implode(','),
            'recommended_doctors' => $doctors->pluck('docid')->implode(',')
        ]);
        
        return view('patient.recommendation', compact('doctors', 'specialties', 'problem', 'today', 'patient'));
    }
}

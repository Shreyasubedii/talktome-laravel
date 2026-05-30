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
    // public function index(Request $request)
    // {
    //     $problem = $request->problem;
    //     $today = date('Y-m-d');
    //     $patient = Auth::guard('patient')->user();
        
    //     if (!$problem) {
    //         return view('patient.recommendation', compact('today', 'patient'));
    //     }
        
    //     // Find matching specialties based on keywords
    //     $specialties = Specialty::all()->filter(function($specialty) use ($problem) {
    //         $keywords = strtolower($specialty->keywords);
    //         $problemLower = strtolower($problem);
    //         return str_contains($keywords, $problemLower);
    //     });
        
    //     if ($specialties->isEmpty()) {
    //         // Get all specialties if no match found
    //         $specialties = Specialty::all();
    //     }
        
    //     $specialtyIds = $specialties->pluck('id');
    //     $doctors = Doctor::whereIn('specialties', $specialtyIds)->with('specialty')->get();
        
    //     // Save to history
    //     History::create([
    //         'user_id' => $patient->pid,
    //         'problem' => $problem,
    //         'matched_specialties' => $specialties->pluck('sname')->implode(', '),
    //         'matched_specialties_ids' => $specialtyIds->implode(','),
    //         'recommended_doctors' => $doctors->pluck('docid')->implode(',')
    //     ]);
        
    //     return view('patient.recommendation', compact('doctors', 'specialties', 'problem', 'today', 'patient'));
    // }
    private function calculateIDF($specialties)
{
    $totalDocs = $specialties->count();
    $df = [];

    foreach ($specialties as $specialty) {
        $keywords = array_unique(
            array_map('trim', explode(',', strtolower($specialty->keywords)))
        );

        foreach ($keywords as $word) {
            if (!isset($df[$word])) {
                $df[$word] = 0;
            }
            $df[$word]++;
        }
    }

    $idf = [];

    foreach ($df as $word => $count) {
        $idf[$word] = log(($totalDocs + 1) / ($count + 1)) + 1;
    }

    return $idf;
}

    public function index(Request $request)
{
    $problem = $request->problem;
    $today = date('Y-m-d');
    $patient = Auth::guard('patient')->user();

    if (!$problem) {
        return view('patient.recommendation', compact('today', 'patient'));
    }

    $problemWords = array_unique(
        array_filter(
            explode(' ', strtolower($problem))
        )
    );

    $specialties = Specialty::all()->map(function ($specialty) use ($problemWords) {

        $keywords = array_map(
            'trim',
            explode(',', strtolower($specialty->keywords))
        );

        $score = 0;

        foreach ($problemWords as $word) {
            if (in_array($word, $keywords)) {
                $score++;
            }
        }

        $specialty->score = $score;

        return $specialty;
    })
    ->filter(function ($specialty) {
        return $specialty->score > 0;
    })
    ->sortByDesc('score');

    // if ($specialties->isEmpty()) {
    //     $specialties = Specialty::all()->map(function ($s) {
    //         $s->score = 0;
    //         return $s;
    //     });
    // }


    if ($specialties->isEmpty()) {
      $doctors = collect();
      return view(
          'patient.recommendation',
          compact('doctors', 'specialties', 'problem', 'today', 'patient')
      )->with('message', 'No matching specialties found. Please try a different problem description.')  ;
    }

    $specialtyIds = $specialties->pluck('id');

    $doctors = Doctor::whereIn('specialties', $specialtyIds)
        ->with('specialty')
        ->get();

    History::create([
        'user_id' => $patient->pid,
        'problem' => $problem,
        'matched_specialties' => $specialties->pluck('sname')->implode(', '),
        'matched_specialties_ids' => $specialtyIds->implode(','),
        'recommended_doctors' => $doctors->pluck('docid')->implode(',')
    ]);

    return view(
        'patient.recommendation',
        compact('doctors', 'specialties', 'problem', 'today', 'patient')
    );
}
}
<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DayLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DayLogController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $today = Carbon::now()->format('Y-m-d');

        // today's log
        $log = DayLog::where('patient_id', $patient->pid)
            ->where('log_date', $today)
            ->first();

        // all logs (single fetch)
        $logs = DayLog::where('patient_id', $patient->pid)->get();

        /*
        |--------------------------------------------------------------------------
        | TREND DATA (Apple Health style line chart)
        |--------------------------------------------------------------------------
        */
        $trend = DayLog::where('patient_id', $patient->pid)
            ->orderBy('log_date')
            ->get(['log_date', 'mood_score']);

        /*
        |--------------------------------------------------------------------------
        | EMOTION + IMPACT ANALYTICS
        |--------------------------------------------------------------------------
        */
        $emotionStats = [];
        $impactStats = [];

        foreach ($logs as $l) {

    $emotions = is_array($l->emotion)
        ? $l->emotion
        : json_decode($l->emotion, true);

    $impacts = is_array($l->impact_area)
        ? $l->impact_area
        : json_decode($l->impact_area, true);

    foreach ($emotions ?? [] as $e) {
        $emotionStats[$e] = ($emotionStats[$e] ?? 0) + 1;
    }

    foreach ($impacts ?? [] as $i) {
        $impactStats[$i] = ($impactStats[$i] ?? 0) + 1;
    }
}

        arsort($emotionStats);
        arsort($impactStats);

        /*
        |--------------------------------------------------------------------------
        | OVERALL ANALYTICS (APPLE HEALTH SUMMARY CARDS)
        |--------------------------------------------------------------------------
        */
        $avgMood = $logs->avg('mood_score');

        $analytics = [
            'avg_mood' => $avgMood ? round($avgMood, 2) : 0,
            'top_emotion' => !empty($emotionStats) ? array_key_first($emotionStats) : null,
            'top_impact' => !empty($impactStats) ? array_key_first($impactStats) : null,
        ];

        return view('patient.daylog', compact(
            'patient',
            'today',
            'log',
            'trend',
            'emotionStats',
            'impactStats',
            'analytics'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mood_score' => 'required|integer|min:1|max:7',
            'mood_label' => 'required|string',
        ]);

        $patient = Auth::guard('patient')->user();

        if (!$patient) {
            return redirect()->route('login');
        }

        DayLog::updateOrCreate(
            [
                'patient_id' => $patient->pid,
                'log_date' => Carbon::now()->format('Y-m-d'),
            ],
            [
                'mood_score' => $request->mood_score,
                'mood_label' => $request->mood_label,

                // IMPORTANT FIX: no json_encode (because of casts)
                'emotion' => $request->emotion ?? [],
                'impact_area' => $request->impact_area ?? [],
            ]
        );

        return redirect()
            ->route('patient.daylog')
            ->with('success', 'Day logged successfully!');
    }
}
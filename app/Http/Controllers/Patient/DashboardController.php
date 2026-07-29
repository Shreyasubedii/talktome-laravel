<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\History;
use App\Models\Journal;
use App\Models\DayLog;
use Carbon\Carbon;
class DashboardController extends Controller
{
    
    
 public function index(Request $request)
{
    $patient = Auth::guard('patient')->user();

    if (!$patient) {
        return redirect()->route('login');
    }

    $today = Carbon::today();

    // Default period = Monthly
    $period = $request->get('period', 'M');

 $selectedWeek = Carbon::today()
    ->subDays(6)
    ->format('Y-m-d');

    switch ($period) {

     case 'W':

    $start = Carbon::today()->subDays(6);

    break;

        case '6M':
            $start = $today->copy()->subMonths(6);
            break;

        case 'Y':
            $start = $today->copy()->subYear();
            break;

        default:
            $start = $today->copy()->startOfMonth();
            break;
    }

    $appointments = Appointment::where('pid', $patient->pid)
        ->with('schedule.doctor')
        ->get();

    $daylogs = DayLog::where('patient_id', $patient->pid)
        ->whereDate('log_date', '>=', $start)
        ->get();

    $journals = Journal::where('patient_id', $patient->pid)
        ->whereDate('journal_date', '>=', $start)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Mood Summary
    |--------------------------------------------------------------------------
    */

    $entryCount = $daylogs->count();

    $averageMood = $entryCount
        ? round($daylogs->avg('mood_score'), 1)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Top Emotion
    |--------------------------------------------------------------------------
    */

    $emotionCounter = [];

    
foreach ($daylogs as $log) {

    if (!$log->emotion) {
        continue;
    }

    $emotions = is_array($log->emotion)
        ? $log->emotion
        : [$log->emotion];

    foreach ($emotions as $emotion) {

        $emotionCounter[$emotion] =
            ($emotionCounter[$emotion] ?? 0) + 1;
    }
}
    
    arsort($emotionCounter);

    $topEmotion = count($emotionCounter)
        ? array_key_first($emotionCounter)
        : 'Not enough data';

    /*
    |--------------------------------------------------------------------------
    | Best Day
    |--------------------------------------------------------------------------
    */

    if ($entryCount) {

        $bestLog = $daylogs->sortByDesc('mood_score')->first();

        $bestDay = Carbon::parse($bestLog->log_date)->format('d M Y');

    } else {

        $bestDay = '--';
    }

    /*
    |--------------------------------------------------------------------------
    | Trigger Analysis
    |--------------------------------------------------------------------------
    */

    $negativeTriggers = [];
    $positiveTriggers = [];

    // foreach ($daylogs as $log) {

    //     if (!$log->impact_area) continue;

    //     foreach ($log->impact_area as $area) {

    //         if ($log->mood_score <= 4) {

    //             $negativeTriggers[$area] =
    //                 ($negativeTriggers[$area] ?? 0) + 1;

    //         } elseif ($log->mood_score >= 7) {

    //             $positiveTriggers[$area] =
    //                 ($positiveTriggers[$area] ?? 0) + 1;
    //         }
    //     }
    // }
foreach ($daylogs as $log) {

    if (!$log->impact_area) {
        continue;
    }

    $areas = is_array($log->impact_area)
        ? $log->impact_area
        : [$log->impact_area];

    foreach ($areas as $area) {

        if ($log->mood_score <= 4) {

            $negativeTriggers[$area] =
                ($negativeTriggers[$area] ?? 0) + 1;

        } elseif ($log->mood_score >= 7) {

            $positiveTriggers[$area] =
                ($positiveTriggers[$area] ?? 0) + 1;
        }
    }
}
    

    arsort($negativeTriggers);
    arsort($positiveTriggers);

    $negativeTriggers = array_slice(
        array_keys($negativeTriggers),
        0,
        3
    );

    $positiveTriggers = array_slice(
        array_keys($positiveTriggers),
        0,
        3
    );

    /*
    |--------------------------------------------------------------------------
    | Pattern
    |--------------------------------------------------------------------------
    */

    if (!empty($negativeTriggers)) {

        $pattern = ucfirst($negativeTriggers[0]) .
            " was frequently linked with lower moods during this period.";

    } elseif (!empty($positiveTriggers)) {

        $pattern = ucfirst($positiveTriggers[0]) .
            " was often associated with better emotional wellbeing.";

    } else {

        $pattern = "Not enough data yet to identify emotional patterns.";
    }

    /*
|--------------------------------------------------------------------------
| Mood History (NEW)
|--------------------------------------------------------------------------
*/

$moodHistory = $daylogs
    ->sortBy('log_date')
    ->map(function ($log) {
        return [
            'date' => Carbon::parse($log->log_date)->format('M d'),
            'score' => $log->mood_score,
        ];
    })
    ->values();

$moodLabels = $moodHistory->pluck('date')->all();
$moodScores = $moodHistory->pluck('score')->all();

// dd($current->toDateString(), $daylog, $journal);

$reportRows = [];

if ($period == 'W') {

    $current = $start->copy();

    while ($current <= $start->copy()->addDays(6)) {

        $daylog = DayLog::where('patient_id', $patient->pid)
            ->whereDate('log_date', $current)
            ->latest()
            ->first();

        $journal = Journal::where('patient_id', $patient->pid)
            ->whereDate('journal_date', $current)
            ->latest()
            ->first();

        // Primary emotions
        $emotions = [];

        if ($journal && $journal->primary_emotion) {
            $emotions[] = $journal->primary_emotion;
        }

        if ($journal && $journal->secondary_emotion) {
            $emotions[] = $journal->secondary_emotion;
        }

        if ($daylog && $daylog->emotion) {

            $extra = is_array($daylog->emotion)
                ? $daylog->emotion
                : json_decode($daylog->emotion, true);

            if (!$extra) {
                $extra = [$daylog->emotion];
            }

            $emotions = array_merge($emotions, $extra);
        }

        $emotions = collect($emotions)
            ->unique()
            ->take(4)
            ->implode(', ');

        // Triggers
        $triggers = "-";

        if ($daylog && $daylog->impact_area) {

            $areas = is_array($daylog->impact_area)
                ? $daylog->impact_area
                : json_decode($daylog->impact_area, true);

            if (!$areas) {
                $areas = [$daylog->impact_area];
            }

            $triggers = implode(', ', $areas);
        }
// Reflection Status

$status = "-";

if ($journal) {

    $status = "Reflection completed";

} elseif ($daylog) {

    $status = "Mood check-in recorded";

}

        $reportRows[] = [

            'date' => $current->format('d M Y'),

            'day' => $current->format('l'),

            'primary_emotions' => $emotions,

            'possible_triggers' => $triggers,

            'reflection_status' => $status,
        ];

        $current->addDay();
    }
}

//monthly section
elseif ($period == 'M') {

    $weekStart = Carbon::today()->copy()->subDays(29);

    while ($weekStart <= Carbon::today()) {

        $weekEnd = $weekStart->copy()->addDays(6);

        if ($weekEnd->gt(Carbon::today())) {
            $weekEnd = Carbon::today();
        }

        $logs = DayLog::where('patient_id', $patient->pid)
            ->whereBetween('log_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->get();

        $journals = Journal::where('patient_id', $patient->pid)
            ->whereBetween('journal_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->get();

        // Average mood
       $weekAverageMood = $logs->count()
    ? round($logs->avg('mood_score'),1)
    : '-';

        // Dominant emotion
        $emotionCounter = [];

        foreach ($journals as $journal) {

            if ($journal->primary_emotion) {

                $emotionCounter[$journal->primary_emotion] =
                    ($emotionCounter[$journal->primary_emotion] ?? 0) + 1;
            }
        }

        arsort($emotionCounter);

        $emotion = count($emotionCounter)
            ? array_key_first($emotionCounter)
            : '-';

        // Main trigger
        $triggerCounter = [];

        foreach ($logs as $log) {

            if (!$log->impact_area) continue;

            $areas = is_array($log->impact_area)
                ? $log->impact_area
                : [$log->impact_area];

            foreach ($areas as $area) {

                $triggerCounter[$area] =
                    ($triggerCounter[$area] ?? 0) + 1;
            }
        }

        arsort($triggerCounter);

        $trigger = count($triggerCounter)
            ? array_key_first($triggerCounter)
            : '-';

        // Reflection completion
        $completion = $journals->count() . " reflections";

        $reportRows[] = [

            'week' => $weekStart->format('d M')
                        . ' - ' .
                        $weekEnd->format('d M'),

            'average_mood' => $weekAverageMood,

            'emotion' => $emotion,

            'trigger' => $trigger,

            'completion' => $completion,

        ];

        $weekStart->addDays(7);

    }

    

}

elseif ($period == '6M') {

    $monthStart = Carbon::today()
        ->copy()
        ->startOfMonth()
        ->subMonths(5);

    for ($i = 0; $i < 6; $i++) {

        $monthEnd = $monthStart->copy()->endOfMonth();

        $logs = DayLog::where('patient_id', $patient->pid)
            ->whereBetween('log_date', [
                $monthStart->toDateString(),
                $monthEnd->toDateString()
            ])
            ->get();

        $journals = Journal::where('patient_id', $patient->pid)
            ->whereBetween('journal_date', [
                $monthStart->toDateString(),
                $monthEnd->toDateString()
            ])
            ->get();

        // Average Mood
        $averageMood = $logs->count()
            ? round($logs->avg('mood_score'), 1)
            : '-';

        // -----------------------------
        // Dominant Emotions (Top 4)
        // -----------------------------
        $emotionCounter = [];

        foreach ($journals as $journal) {

            if ($journal->primary_emotion) {

                $emotionCounter[$journal->primary_emotion] =
                    ($emotionCounter[$journal->primary_emotion] ?? 0) + 1;
            }

            if ($journal->secondary_emotion) {

                $emotionCounter[$journal->secondary_emotion] =
                    ($emotionCounter[$journal->secondary_emotion] ?? 0) + 1;
            }
        }

        arsort($emotionCounter);

        $emotion = count($emotionCounter)
            ? implode(', ', array_slice(array_keys($emotionCounter), 0, 4))
            : '-';

        // -----------------------------
        // Main Trigger
        // -----------------------------
        $triggerCounter = [];

        foreach ($logs as $log) {

            if (!$log->impact_area) continue;

            $areas = is_array($log->impact_area)
                ? $log->impact_area
                : [$log->impact_area];

            foreach ($areas as $area) {

                $triggerCounter[$area] =
                    ($triggerCounter[$area] ?? 0) + 1;
            }
        }

        arsort($triggerCounter);

        $trigger = count($triggerCounter)
            ? array_key_first($triggerCounter)
            : '-';

        // Reflection Habit
        $completion = $journals->count() . " entries";

        $reportRows[] = [

            'month' => $monthStart->format('M Y'),

            'average_mood' => $averageMood,

            'emotion' => $emotion,

            'trigger' => $trigger,

            'completion' => $completion,

        ];

        $monthStart->addMonth();
    }
}
elseif ($period == 'Y') {

    $halfStart = Carbon::today()->copy()->subYear()->addDay();

    while ($halfStart <= Carbon::today()) {

        $halfEnd = $halfStart->copy()->addMonths(5)->endOfMonth();

        if ($halfEnd->gt(Carbon::today())) {
            $halfEnd = Carbon::today();
        }

        $logs = DayLog::where('patient_id', $patient->pid)
            ->whereBetween('log_date', [
                $halfStart->toDateString(),
                $halfEnd->toDateString()
            ])
            ->get();

        $journals = Journal::where('patient_id', $patient->pid)
            ->whereBetween('journal_date', [
                $halfStart->toDateString(),
                $halfEnd->toDateString()
            ])
            ->get();

        // Average mood

        $averageMood = $logs->count()
            ? round($logs->avg('mood_score'),1)
            : '-';

        // Dominant emotions

        $emotionCounter = [];

        foreach ($journals as $journal) {

            foreach ([
                $journal->primary_emotion,
                $journal->secondary_emotion
            ] as $emotion) {

                if (!$emotion) continue;

                $emotionCounter[$emotion] =
                    ($emotionCounter[$emotion] ?? 0) + 1;
            }
        }

        arsort($emotionCounter);

        $emotions = implode(', ',
            array_slice(array_keys($emotionCounter),0,4)
        );

        if ($emotions == '') {
            $emotions = '-';
        }

        // Main triggers

        $triggerCounter = [];

        foreach ($logs as $log) {

            if (!$log->impact_area) continue;

            $areas = is_array($log->impact_area)
                ? $log->impact_area
                : [$log->impact_area];

            foreach ($areas as $area) {

                $triggerCounter[$area] =
                    ($triggerCounter[$area] ?? 0) + 1;
            }
        }

        arsort($triggerCounter);

        $triggers = implode(', ',
            array_slice(array_keys($triggerCounter),0,3)
        );

        if ($triggers == '') {
            $triggers = '-';
        }

        $reportRows[] = [

            'period' =>
                $halfStart->format('M Y')
                .' - '.
                $halfEnd->format('M Y'),

            'average_mood' => $averageMood,

            'emotions' => $emotions,

            'triggers' => $triggers,

            'reflections' => $journals->count(),

        ];

        $halfStart->addMonths(6)->startOfMonth();

    }

}
    return view('patient.dashboard', [

        'appointments' => $appointments,

        'today' => $today->format('Y-m-d'),

        'patient' => $patient,

        'averageMood' => $averageMood,

        'topEmotion' => ucfirst($topEmotion),

        'bestDay' => $bestDay,

        'negativeTriggers' => $negativeTriggers,

        'positiveTriggers' => $positiveTriggers,

        'pattern' => $pattern,

        'entryCount' => $entryCount,

        'period' => $period,

        'selectedWeek' => $selectedWeek,

        'moodHistory' => $moodHistory,

        'moodLabels' => $moodLabels,

        'moodScores' => $moodScores,
        'reportRows' => $reportRows,

    ]);
}



}
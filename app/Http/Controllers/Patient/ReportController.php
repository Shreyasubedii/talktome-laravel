<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\DayLog;
use App\Models\Journal;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
public function generate(Request $request)
{
    $patient = Auth::guard('patient')->user();

    if (!$patient) {
        return redirect()->route('login');
    }

    $period = $request->get('period', 'M');

    $today = Carbon::today();

    switch ($period) {

        case 'W':
            $start = $today->copy()->subDays(6);
            break;

        case 'M':
            $start = $today->copy()->subDays(29);
            break;

        case '6M':
            $start = $today->copy()->subMonths(6);
            break;

        case 'Y':
            $start = $today->copy()->subYear();
            break;

        default:
            $start = $today->copy()->subDays(29);
            break;
    }

    switch ($period) {

        case 'W':
            $reportRows = $this->buildWeeklyReport(
                $patient->pid,
                $start,
                $today
            );
            break;

        case 'M':
            $reportRows = $this->buildMonthlyReport(
                $patient->pid,
                $start,
                $today
            );
            break;

        case '6M':
            $reportRows = $this->buildSixMonthReport(
                $patient->pid,
                $start,
                $today
            );
            break;

        case 'Y':
            $reportRows = $this->buildYearlyReport(
                $patient->pid,
                $start,
                $today
            );
            break;

        default:
            $reportRows = [];
    }

    $periodText = match ($period) {

        'W' => 'Weekly Reflection Report',

        'M' => 'Monthly Reflection Report',

        '6M' => 'Six Month Reflection Report',

        'Y' => 'Yearly Reflection Report',

        default => 'Reflection Report'
    };

   if ($request->get('download') == 1) {

    $pdf = Pdf::loadView(
        'patient.report',
        compact(
            'patient',
            'period',
            'periodText',
            'reportRows'
        )
    );

    return $pdf->download('Reflection_Report.pdf');
}

return view(
    'patient.report',
    compact(
        'patient',
        'period',
        'periodText',
        'reportRows'
    )
);
    
}

private function buildWeeklyReport($patientId, $start, $end)
{
    $rows = [];

    $current = $start->copy();

    while ($current <= $end) {

        $daylog = DayLog::where('patient_id', $patientId)
            ->whereDate('log_date', $current->toDateString())
            ->latest()
            ->first();

        $journal = Journal::where('patient_id', $patientId)
            ->whereDate('journal_date', $current->toDateString())
            ->latest()
            ->first();

        $rows[] = [

            'date' => $current->format('d M Y'),

            'day' => $current->format('l'),

            'primary_emotions' =>
                $this->getPrimaryEmotions($daylog, $journal),

            'possible_triggers' =>
                $this->getTriggers($daylog),

            'reflection_status' =>
                $this->getReflectionStatus($daylog, $journal),

            'notes' =>
                $this->getNotes($journal),

        ];

        $current->addDay();
    }

    return $rows;
}
private function buildMonthlyReport($patientId, $start, $end)
{
    $rows = [];

    $weekStart = $start->copy();

    while ($weekStart <= $end) {

        $weekEnd = $weekStart->copy()->addDays(6);

        if ($weekEnd->gt($end)) {
            $weekEnd = $end->copy();
        }

        $logs = DayLog::where('patient_id', $patientId)
            ->whereBetween('log_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->get();

        $journals = Journal::where('patient_id', $patientId)
            ->whereBetween('journal_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString()
            ])
            ->get();

        /*
        ----------------------------
        Average Mood
        ----------------------------
        */

        $averageMood = $logs->count()
            ? round($logs->avg('mood_score'),1)
            : '-';

        /*
        ----------------------------
        Top 4 Emotions
        ----------------------------
        */

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

        $dominantEmotions = count($emotionCounter)
            ? implode(', ', array_slice(array_keys($emotionCounter),0,4))
            : '-';

        /*
        ----------------------------
        Main Trigger
        ----------------------------
        */

        $triggerCounter = [];

        foreach ($logs as $log) {

            if (!$log->impact_area) {
                continue;
            }

            $areas = is_array($log->impact_area)
                ? $log->impact_area
                : json_decode($log->impact_area,true);

            if (!$areas) {
                $areas = [$log->impact_area];
            }

            foreach ($areas as $area) {

                $triggerCounter[$area] =
                    ($triggerCounter[$area] ?? 0) + 1;
            }
        }

        arsort($triggerCounter);

        $trigger = count($triggerCounter)
            ? implode(', ', array_slice(array_keys($triggerCounter),0,3))
            : '-';

        /*
        ----------------------------
        Reflection Completion
        ----------------------------
        */

        $completion = $journals->count() . " reflections";

        $rows[] = [

            'week' =>
                $weekStart->format('d M')
                . " - "
                . $weekEnd->format('d M'),

            'average_mood' => $averageMood,

            'dominant_emotions' => $dominantEmotions,

            'trigger' => $trigger,

            'completion' => $completion,

        ];

        $weekStart->addDays(7);

    }

    return $rows;
}


private function buildSixMonthReport($patientId, $start, $end)
{
    $rows = [];

    $monthStart = $start->copy()->startOfMonth();

    while ($monthStart <= $end) {

        $monthEnd = $monthStart->copy()->endOfMonth();

        if ($monthEnd->gt($end)) {
            $monthEnd = $end->copy();
        }

        $logs = DayLog::where('patient_id', $patientId)
            ->whereBetween('log_date', [
                $monthStart->toDateString(),
                $monthEnd->toDateString()
            ])
            ->get();

        $journals = Journal::where('patient_id', $patientId)
            ->whereBetween('journal_date', [
                $monthStart->toDateString(),
                $monthEnd->toDateString()
            ])
            ->get();

        // Average mood
        $averageMood = $logs->count()
            ? round($logs->avg('mood_score'), 1)
            : '-';

        // Top emotions
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

        $dominantEmotions = count($emotionCounter)
            ? implode(', ', array_slice(array_keys($emotionCounter), 0, 4))
            : '-';

        // Triggers
        $triggerCounter = [];

        foreach ($logs as $log) {

            if (!$log->impact_area) {
                continue;
            }

            $areas = is_array($log->impact_area)
                ? $log->impact_area
                : json_decode($log->impact_area, true);

            if (!$areas) {
                $areas = [$log->impact_area];
            }

            foreach ($areas as $area) {
                $triggerCounter[$area] =
                    ($triggerCounter[$area] ?? 0) + 1;
            }
        }

        arsort($triggerCounter);

        $trigger = count($triggerCounter)
            ? implode(', ', array_slice(array_keys($triggerCounter), 0, 3))
            : '-';

        $completion = $journals->count() . " reflections";

        $rows[] = [

            'month' => $monthStart->format('F Y'),

            'average_mood' => $averageMood,

            'dominant_emotions' => $dominantEmotions,

            'trigger' => $trigger,

            'completion' => $completion,

        ];

        $monthStart->addMonth()->startOfMonth();
    }

    return $rows;
}

private function buildYearlyReport($patientId, $start, $end)
{
    $rows = [];

    $yearStart = $start->copy()->startOfYear();

    while ($yearStart <= $end) {

        $yearEnd = $yearStart->copy()->endOfYear();

        if ($yearEnd->gt($end)) {
            $yearEnd = $end->copy();
        }

        $logs = DayLog::where('patient_id', $patientId)
            ->whereBetween('log_date', [
                $yearStart->toDateString(),
                $yearEnd->toDateString()
            ])
            ->get();

        $journals = Journal::where('patient_id', $patientId)
            ->whereBetween('journal_date', [
                $yearStart->toDateString(),
                $yearEnd->toDateString()
            ])
            ->get();

        // Average Mood
        $averageMood = $logs->count()
            ? round($logs->avg('mood_score'), 1)
            : '-';

        // Top emotions
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

        $dominantEmotions = count($emotionCounter)
            ? implode(', ', array_slice(array_keys($emotionCounter), 0, 4))
            : '-';

        // Main trigger
        $triggerCounter = [];

        foreach ($logs as $log) {

            if (!$log->impact_area) {
                continue;
            }

            $areas = is_array($log->impact_area)
                ? $log->impact_area
                : json_decode($log->impact_area, true);

            if (!$areas) {
                $areas = [$log->impact_area];
            }

            foreach ($areas as $area) {
                $triggerCounter[$area] =
                    ($triggerCounter[$area] ?? 0) + 1;
            }
        }

        arsort($triggerCounter);

        $trigger = count($triggerCounter)
            ? implode(', ', array_slice(array_keys($triggerCounter), 0, 3))
            : '-';

        $completion = $journals->count() . " reflections";

        $rows[] = [

            'year' => $yearStart->format('Y'),

            'average_mood' => $averageMood,

            'dominant_emotions' => $dominantEmotions,

            'trigger' => $trigger,

            'completion' => $completion,

        ];

        $yearStart->addYear()->startOfYear();
    }

    return $rows;
}



private function getPrimaryEmotions($daylog, $journal)
{
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

    return collect($emotions)
        ->unique()
        ->take(4)
        ->implode(', ');
}


private function getTriggers($daylog)
{
    if (!$daylog || !$daylog->impact_area) {
        return "-";
    }

    $areas = is_array($daylog->impact_area)
        ? $daylog->impact_area
        : json_decode($daylog->impact_area, true);

    if (!$areas) {
        $areas = [$daylog->impact_area];
    }

    return implode(', ', $areas);
}

private function getReflectionStatus($daylog, $journal)
{
    if ($journal) {
        return "Reflection completed";
    }

    if ($daylog) {
        return "Mood check-in recorded";
    }

    return "-";
}
private function getNotes($journal)
{
    if (!$journal || !$journal->journal_text) {
        return "-";
    }

    return \Illuminate\Support\Str::limit(
        strip_tags($journal->journal_text),
        80
    );
}

}
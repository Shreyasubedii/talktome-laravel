<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    private function getEmotionDictionary()
{
    return [

       'Stress' => [
    'stress'=>5,
    'stressed'=>5,
    'overwhelmed'=>6,
    'pressure'=>4,
    'burnout'=>6,
    'burnedout'=>6,
    'exhausted'=>5,
    'drained'=>5,
    'tired'=>3,
    'fatigue'=>4,
    'busy'=>2,
    'deadline'=>3,
    'workload'=>4,
],

        'Anxiety' => [
    'anxious'=>5,
    'worried'=>4,
    'worry'=>4,
    'nervous'=>4,
    'panic'=>6,
    'panicking'=>6,
    'fear'=>5,
    'fearful'=>5,
    'afraid'=>4,
    'uneasy'=>4,
    'restless'=>3,
    'tense'=>3,
    'uncertain'=>3,
    'doubt'=>2,
],

     'Sadness' => [
    'sad'=>5,
    'lonely'=>5,
    'alone'=>4,
    'empty'=>5,
    'hopeless'=>6,
    'crying'=>6,
    'cried'=>6,
    'hurt'=>4,
    'heartbroken'=>6,
    'depressed'=>6,
    'down'=>3,
    'miserable'=>5,
    'unhappy'=>4,
    'loss'=>4,
    'miss'=>3,
],

        'Anger' => [
    'angry'=>5,
    'frustrated'=>4,
    'annoyed'=>3,
    'irritated'=>3,
    'mad'=>4,
    'furious'=>6,
    'rage'=>6,
    'hate'=>5,
    'upset'=>3,
    'resentful'=>5,
],

       'Happy' => [
    'happy'=>5,
    'joyful'=>5,
    'excited'=>4,
    'grateful'=>4,
    'thankful'=>4,
    'cheerful'=>4,
    'delighted'=>5,
    'pleased'=>3,
    'smile'=>3,
    'smiling'=>3,
    'laughed'=>4,
    'laughing'=>4,
    'wonderful'=>5,
    'amazing'=>5,
    'fantastic'=>5,
    'great'=>3,
    'awesome'=>4,
    'good'=>2,
    'best'=>3,
    'enjoyed'=>4,
    'enjoy'=>4,
    'celebrated'=>5,
    'achievement'=>4,
    'accomplished'=>5,
    'proud'=>4,
    'success'=>4,
],
        'Calm' => [
    'calm'=>5,
    'peaceful'=>5,
    'relaxed'=>5,
    'content'=>4,
    'comfortable'=>3,
    'stable'=>3,
    'balanced'=>4,
    'settled'=>4,
    'quiet'=>3,
    'safe'=>3,
    'relief'=>4,
    'relieved'=>5,
],

        'Motivation' => [
    'motivated'=>5,
    'determined'=>5,
    'focused'=>4,
    'productive'=>4,
    'goal'=>4,
    'goals'=>4,
    'progress'=>4,
    'improve'=>4,
    'improved'=>4,
    'growth'=>4,
    'learning'=>3,
    'discipline'=>5,
    'consistent'=>4,
    'ambitious'=>5,
]
    ];
}
private function analyzeJournal($text)
{
    $dictionary = $this->getEmotionDictionary();

    $scores = [];

    foreach ($dictionary as $emotion => $words) {
        $scores[$emotion] = 0;
    }

    $text = strtolower($text);

    $tokens = str_word_count($text, 1);

    foreach ($tokens as $token) {

        foreach ($dictionary as $emotion => $keywords) {

            if(isset($keywords[$token])) {

                $scores[$emotion] += $keywords[$token];
            }
        }
    }

    $maxScore = max($scores);

if($maxScore == 0)
{
    return [
        'primary' => 'Neutral',
        'secondary' => null,
        'scores' => []
    ];
}

    arsort($scores);

    $primary = array_key_first($scores);

    $keys = array_keys($scores);

    $secondary = $keys[1] ?? null;

    $total = array_sum($scores);

    $percentages = [];

    if($total > 0){

        foreach($scores as $emotion => $score){

            $percentages[$emotion] =
                round(($score / $total) * 100);
        }
    }

    return [
        'primary' => $primary,
        'secondary' => $secondary,
        'scores' => $percentages
    ];
}
// public function index()
// {
//     $patient = Auth::guard('patient')->user();

//     $today = Carbon::now()->format('Y-m-d');

//     $journals = Journal::where(
//         'patient_id',
//         $patient->pid
//     )->latest()->get();

//     $latestJournal = $journals->first();

//     return view(
//         'patient.journal',
//         compact(
//             'patient',
//             'today',
//             'journals',
//             'latestJournal'
//         )
//     );
// }
public function index()
{
    $patient = Auth::guard('patient')->user();

    if (!$patient) {
        return redirect()->route('login')
            ->with('error', 'Please login first.');
    }

    $today = Carbon::now()->format('Y-m-d');

    $journals = Journal::where(
        'patient_id',
        $patient->pid
    )->latest()->get();

    $latestJournal = $journals->first();

    return view(
        'patient.journal',
        compact(
            'patient',
            'today',
            'journals',
            'latestJournal'
        )
    );
}
public function store(Request $request)
{
    $request->validate([
        'journal_text' => 'required|min:20|max:3000'
    ]);

    $patient = Auth::guard('patient')->user();

    $analysis =
        $this->analyzeJournal(
            $request->journal_text
        );

    Journal::create([

        'patient_id' => $patient->pid,

        'journal_text' =>
            $request->journal_text,

        'word_count' =>
            str_word_count(
                $request->journal_text
            ),

        'primary_emotion' =>
            $analysis['primary'],

        'secondary_emotion' =>
            $analysis['secondary'],

        'emotion_scores' =>
            $analysis['scores'],

        'journal_date' =>
            Carbon::now()->format('Y-m-d')
    ]);

    return redirect()
        ->route('patient.journal')
        ->with(
            'success',
            'Journal saved successfully.'
        );
}
public function destroy($id)
{
    $journal = Journal::findOrFail($id);

    $journal->delete();

    return back()->with(
        'success',
        'Journal entry deleted successfully.'
    );
}
}
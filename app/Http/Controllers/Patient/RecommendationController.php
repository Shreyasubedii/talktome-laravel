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
    private function tokenize(string $text): array
    {
        return array_values(array_unique(array_filter(
            preg_split('/[^a-z0-9]+/i', strtolower($text))
        )));
    }

    /**
     * Calculate IDF values for all keywords.
     */
    private function calculateIDF($specialties)
    {
        $totalDocs = $specialties->count();
        $df = [];

        foreach ($specialties as $specialty) {

            $keywords = $this->tokenize((string) $specialty->keywords);

            foreach ($keywords as $word) {
                $df[$word] = ($df[$word] ?? 0) + 1;
            }
        }

        $idf = [];

        foreach ($df as $word => $count) {
            $idf[$word] = log(($totalDocs + 1) / ($count + 1)) + 1;
        }

        return $idf;
    }

    /**
     * Build TF-IDF vector.
     */
    private function buildTFIDFVector($words, $idf)
    {
        $tf = [];

        foreach ($words as $word) {
            $tf[$word] = ($tf[$word] ?? 0) + 1;
        }

        $totalWords = count($words);

        foreach ($tf as $word => $count) {
            $tf[$word] = ($count / $totalWords) * ($idf[$word] ?? 1);
        }

        return $tf;
    }

    /**
     * Calculate Cosine Similarity.
     */
    private function cosineSimilarity($vectorA, $vectorB)
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        $allWords = array_unique(
            array_merge(array_keys($vectorA), array_keys($vectorB))
        );

        foreach ($allWords as $word) {

            $a = $vectorA[$word] ?? 0;
            $b = $vectorB[$word] ?? 0;

            $dotProduct += $a * $b;
            $magnitudeA += pow($a, 2);
            $magnitudeB += pow($b, 2);
        }

        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }

        return $dotProduct / (sqrt($magnitudeA) * sqrt($magnitudeB));
    }

    public function index(Request $request)
    {
        $problem = $request->problem;
        $today = date('Y-m-d');
        $patient = Auth::guard('patient')->user();

        if (!$problem) {
            return view('patient.recommendation', compact('today', 'patient'));
        }

        // Patient input words
        $problemWords = $this->tokenize($problem);

        // Get all specialties
        $allSpecialties = Specialty::all();

        // Calculate IDF
        $idf = $this->calculateIDF($allSpecialties);

        // Patient TF-IDF vector
        $patientVector = $this->buildTFIDFVector($problemWords, $idf);

        // Calculate similarity for every specialty
        $specialties = $allSpecialties->map(function ($specialty) use ($patientVector, $idf) {

            $keywords = $this->tokenize((string) $specialty->keywords);

            $specialtyVector = $this->buildTFIDFVector($keywords, $idf);

            $specialty->score = $this->cosineSimilarity(
                $patientVector,
                $specialtyVector
            );

            return $specialty;

        })->filter(function ($specialty) {

            return $specialty->score > 0;

        })->sortByDesc('score');

        if ($specialties->isEmpty()) {

            $doctors = collect();

            return view(
                'patient.recommendation',
                compact(
                    'doctors',
                    'specialties',
                    'problem',
                    'today',
                    'patient'
                )
            )->with(
                'message',
                'No matching specialties found. Please try a different problem description.'
            );
        }

        $specialtyIds = $specialties->pluck('id');

        $doctors = Doctor::whereIn('specialties', $specialtyIds)
            ->with(['specialty', 'schedules' => function ($query) {
                $query->where('scheduledate', '>=', now()->addDay()->toDateString())
                    ->where('status', 'available')
                    ->where('is_full', false)
                    ->where('remaining_capacity', '>', 0);
            }])
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
            compact(
                'doctors',
                'specialties',
                'problem',
                'today',
                'patient'
            )
        );
    }
}
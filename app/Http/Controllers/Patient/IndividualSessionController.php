<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class IndividualSessionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Doctor::with('specialty')
            ->whereHas('user', function ($q) {
                $q->where('status', 1);
            });

        // search doctor name or specialty
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('docname', 'like', "%{$search}%")
                  ->orWhereHas('specialty', function ($sq) use ($search) {
                      $sq->where('sname', 'like', "%{$search}%");
                  });
            });
        }

        $doctors = $query->orderBy('docname')->get();

        $patient = Auth::guard('patient')->user();
        $today = now()->toDateString();

        return view('patient.individual.sessions', compact(
            'doctors',
            'patient',
            'search',
            'today'
        ));
    }
}
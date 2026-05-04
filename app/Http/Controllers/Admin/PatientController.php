<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $query = Patient::query();
        
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('pname', 'like', "%$keyword%")
                  ->orWhere('pemail', 'like', "%$keyword%");
            });
        }
        
        $patients = $query->orderBy('pid', 'desc')->get();
        $allPatients = Patient::select('pname', 'pemail')->get();
        
        return view('admin.patients', compact('patients', 'allPatients', 'today'));
    }
}

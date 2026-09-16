<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\WebUser;
use Illuminate\Validation\Rule;

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('patient', 'pemail')->ignore($id, 'pid'), Rule::unique('webuser', 'email')->ignore($request->email, 'email')],
            'tel' => ['required', 'regex:/^(98|97)[0-9]{8}$/'],
            'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'nic' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email is already registered.',
            'tel.regex' => 'Telephone must be a valid 10-digit number starting with 98 or 97.',
            'dob.before_or_equal' => 'You must be at least 18 years old.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $patient = Patient::findOrFail($id);
        $oldEmail = $patient->pemail;
        $patient->update([
            'pname' => $request->name,
            'pemail' => $request->email,
            'ptel' => $request->tel,
            'pdob' => $request->dob,
            'pnic' => $request->nic,
        ]);

        if ($request->filled('password')) {
            $patient->update(['ppassword' => $request->password]);
        }

        if ($oldEmail !== $request->email) {
            WebUser::where('email', $oldEmail)->delete();
            WebUser::create(['email' => $request->email, 'usertype' => 'p']);
        }

        return back()->with('success', 'Patient updated successfully');
    }
}

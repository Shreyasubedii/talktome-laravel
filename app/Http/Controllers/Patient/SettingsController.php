<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebUser;
use Illuminate\Validation\Rule;
use App\Models\Appointment;

class SettingsController extends Controller
{
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $today = date('Y-m-d');
        return view('patient.settings', compact('patient', 'today'));
    }
    
    public function update(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('patient', 'pemail')->ignore($patient->pid, 'pid'), Rule::unique('webuser', 'email')->ignore($patient->pemail, 'email')],
            'address' => 'required|string|max:255',
            'tel' => ['required', 'regex:/^(98|97)[0-9]{8}$/'],
            'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email is already registered.',
            'tel.regex' => 'Telephone must be a valid 10-digit number starting with 98 or 97.',
            'dob.before_or_equal' => 'You must be at least 18 years old.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
        
        $oldEmail = $patient->pemail;
        $patient->pname = $request->name;
        $patient->pemail = $request->email;
        $patient->paddress = $request->address;
        $patient->ptel = $request->tel;
        $patient->pdob = $request->dob;
        if ($request->password) {
            $patient->ppassword = $request->password;
        }
        $patient->save();

        if ($oldEmail !== $request->email) {
            WebUser::where('email', $oldEmail)->delete();
            WebUser::create(['email' => $request->email, 'usertype' => 'p']);
        }
        
        return back()->with('success', 'Profile updated');
    }
    
    public function destroy()
    {
        $patient = Auth::guard('patient')->user();
        $email = $patient->pemail;
        
        Appointment::where('pid', $patient->pid)->delete();
        $patient->delete();
        
        \App\Models\WebUser::where('email', $email)->delete();
        
        Auth::logout();
        return redirect('/')->with('success', 'Account deleted');
    }
}

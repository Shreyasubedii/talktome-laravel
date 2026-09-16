<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebUser;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();
        $today = date('Y-m-d');
        return view('doctor.settings', compact('doctor', 'today'));
    }
    
    public function update(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('doctor', 'docemail')->ignore($doctor->docid, 'docid'), Rule::unique('webuser', 'email')->ignore($doctor->docemail, 'email')],
            'tel' => ['required', 'regex:/^(98|97)[0-9]{8}$/'],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email is already registered.',
            'tel.regex' => 'Telephone must be a valid 10-digit number starting with 98 or 97.',
            'dob.before_or_equal' => 'You must be at least 18 years old.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
        
        $oldEmail = $doctor->docemail;
        $doctor->docname = $request->name;
        $doctor->docemail = $request->email;
        $doctor->doctel = $request->tel;
        if ($request->password) {
            $doctor->docpassword = $request->password;
        }
        $doctor->save();

        if ($oldEmail !== $request->email) {
            WebUser::where('email', $oldEmail)->delete();
            WebUser::create(['email' => $request->email, 'usertype' => 'd']);
        }
        
        return back()->with('success', 'Profile updated');
    }
}

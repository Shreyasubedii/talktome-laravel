<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebUser;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        
        // Check webuser table for user type
        $webUser = WebUser::where('email', $email)->first();
        
        if (!$webUser) {
            return back()->with('error', 'Email not found')->withInput();
        }
        
        $usertype = $webUser->usertype; // This uses the accessor: 'admin', 'doctor', or 'patient'
        
        switch ($usertype) {
            case 'admin':
                $admin = Admin::where('aemail', $email)->first();
                if ($admin && trim($admin->apassword) === $password) {
                    Auth::guard('admin')->login($admin);
                    return redirect()->route('admin.dashboard');
                }
                break;
                
            case 'doctor':
                $doctor = Doctor::where('docemail', $email)->first();
                if ($doctor && trim($doctor->docpassword) === $password) {
                    Auth::guard('doctor')->login($doctor);
                    return redirect()->route('doctor.dashboard');
                }
                break;
                
            case 'patient':
                $patient = Patient::where('pemail', $email)->first();
                if ($patient && trim($patient->ppassword) === $password) {
                    Auth::guard('patient')->login($patient);
                    return redirect()->route('patient.dashboard');
                }
                break;
        }
        
        return back()->with('error', 'Invalid credentials')->withInput();
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('patient')->logout();
        Auth::logout();
        
        return redirect()->route('login');
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:webuser,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      
                'regex:/[a-z]/',      
                'regex:/[0-9]/',   
                  'regex:/[@$!%*?&.#]/'       
            ],
            'name' => [
    'required',
    'string',
    'max:255',
    'regex:/^[A-Za-z\s]+$/'
],
            'address' => 'required|string|max:255',
           'dob' => [
    'required',
    'date',
    'before_or_equal:' . now()->subYears(18)->format('Y-m-d')
],
           'tel' => [
    'required',
    'regex:/^(98|97)[0-9]{8}$/'
]


            
        ],
        
         [

        // PASSWORD MESSAGES
        'password.min' =>
            'Password must be at least 8 characters long.',

        'password.regex' =>
            'Password must contain at least one number, capital letter, small letter and one special character.',

        // DOB MESSAGE
        'dob.before_or_equal' =>
            'You must be at least 18 years old to register.',

        // EMAIL
        'email.unique' =>
            'This email is already registered.',

        // NAME
            'name.regex' => 'Name should contain only letters and spaces. Numbers and special characters are not allowed.',

    ]
        
        
        );
        
        
        // Create patient
        $patient = Patient::create([
            'pemail' => $request->email,
            'pname' => $request->name,
            'ppassword' => $request->password,
            'paddress' => $request->address,
            'pnic' => $request->nic ?? null,
            'pdob' => $request->dob,
            'ptel' => $request->tel
        ]);
        
        // Create webuser entry
        WebUser::create([
            'email' => $request->email,
            'usertype' => 'p'
        ]);
        
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\WebUser;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $query = Doctor::with('specialty');

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('docname', 'like', '%' . $search . '%')
                    ->orWhereHas('specialty', function ($specialtyQuery) use ($search) {
                        $specialtyQuery->where('sname', 'like', '%' . $search . '%');
                    });
            });
        }

        $doctors = $query->get();
        $specialties = \App\Models\Specialty::orderBy('sname', 'asc')->get();
        return view('admin.doctors', compact('doctors', 'specialties', 'search'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:doctor,docemail|unique:webuser,email',
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&.#]/',
            ],
            'nic' => 'nullable|string|max:20',
            'tel' => ['required', 'regex:/^(98|97)[0-9]{8}$/'],
            'specialty' => 'required|exists:specialties,id',
        ], [
            'email.unique' => 'This email is already registered.',
            'name.regex' => 'Name should contain only letters and spaces.',
            'tel.regex' => 'Telephone must be a valid 10-digit number starting with 98 or 97.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must contain at least one number, capital letter, small letter and one special character.',
        ]);
        
        $doctor = Doctor::create([
            'docemail' => $request->email,
            'docname' => $request->name,
            'docpassword' => $request->password,
            'docnic' => $request->nic,
            'doctel' => $request->tel,
            'specialties' => $request->specialty
        ]);
        
        // Add to webuser
        WebUser::create([
            'email' => $request->email,
            'usertype' => 'd'
        ]);
        
        return back()->with('success', 'Doctor added successfully');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('doctor', 'docemail')->ignore($id, 'docid'), Rule::unique('webuser', 'email')->ignore($request->email, 'email')],
            'tel' => ['required', 'regex:/^(98|97)[0-9]{8}$/'],
            'nic' => 'required|string|max:20',
            'specialty' => 'required|exists:specialties,id',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email is already registered.',
            'tel.regex' => 'Telephone must be a valid 10-digit number starting with 98 or 97.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update([
            'docname' => $request->name,
            'docemail' => $request->email,
            'doctel' => $request->tel,
            'docnic' => $request->nic,
            'specialties' => $request->specialty,
        ]);

        if ($request->filled('password')) {
            $doctor->update(['docpassword' => $request->password]);
        }

        WebUser::where('email', $doctor->getOriginal('docemail'))->delete();
        WebUser::create(['email' => $request->email, 'usertype' => 'd']);

        return back()->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $email = $doctor->docemail;
        $doctor->delete();
        
        WebUser::where('email', $email)->delete();
        
        return back()->with('success', 'Doctor deleted');
    }
}

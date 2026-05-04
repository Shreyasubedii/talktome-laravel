<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function esewa(Request $request)
    {
        // eSewa integration placeholder
        $appointmentId = $request->appointment_id;
        $amount = $request->amount ?? 500; // Default consultation fee
        $today = date('Y-m-d');
        
        return view('patient.esewa-payment', compact('appointmentId', 'amount', 'today'));
    }
    
    public function esewaSuccess(Request $request)
    {
        // Verify payment and update appointment
        return redirect()->route('patient.appointments')->with('success', 'Payment successful!');
    }
    
    public function esewaFailure(Request $request)
    {
        return redirect()->route('patient.appointments')->with('error', 'Payment failed');
    }
}

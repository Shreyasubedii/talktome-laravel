<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\PatientNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $patient = Auth::guard('patient')->user();

        PatientNotification::where('id', $id)
            ->where('patient_id', $patient->pid)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back();
    }
}
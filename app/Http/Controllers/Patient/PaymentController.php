<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function cod($appointmentId)
    {
        $appointment = $this->patientAppointment($appointmentId);
        if ($appointment->payment) {
            return back()->with('error', 'Payment has already been selected for this booking.');
        }

        Payment::create([
            'appointment_id' => $appointment->appoid,
            'patient_id' => $appointment->pid,
            'payment_method' => 'COD',
            'payment_status' => 'selected',
            'amount' => $this->amount(),
            'payment_date' => now(),
        ]);

        return back()->with('success', 'COD selected for this booking.');
    }

    public function esewa($appointmentId)
    {
        $appointment = $this->patientAppointment($appointmentId);
        if ($appointment->payment) {
            return redirect()->route('patient.appointments')->with('error', 'Payment has already been selected for this booking.');
        }

        $transactionUuid = $appointment->appoid . '-' . now()->format('YmdHis') . '-' . Str::lower(Str::random(6));
        $signedFieldNames = 'total_amount,transaction_uuid,product_code';
        $signature = $this->signature($signedFieldNames, [
            'total_amount' => number_format($this->amount(), 2, '.', ''),
            'transaction_uuid' => $transactionUuid,
            'product_code' => config('services.esewa.merchant_code'),
        ]);

        return view('patient.esewa-payment', [
            'patient' => Auth::guard('patient')->user(),
            'appointment' => $appointment,
            'amount' => $this->amount(),
            'paymentUrl' => config('services.esewa.payment_url'),
            'merchantCode' => config('services.esewa.merchant_code'),
            'transactionUuid' => $transactionUuid,
            'signedFieldNames' => $signedFieldNames,
            'signature' => $signature,
        ]);
    }

    public function esewaSuccess(Request $request)
    {
        // testing

    \Log::info('ESEWA SUCCESS CALLBACK REACHED', [
    'query' => $request->query(),
    'data' => $request->input('data'),
]);


        $encodedResponse = $request->input('data');
        if (!$encodedResponse) {
            return redirect()->route('patient.appointments')->with('error', 'eSewa payment response was incomplete.');
        }

        $response = json_decode(base64_decode($encodedResponse, true) ?: '', true);
        if (!is_array($response) || ($response['status'] ?? null) !== 'COMPLETE') {
            return redirect()->route('patient.appointments')->with('error', 'eSewa payment was not completed.');
        }

        $signedFields = $response['signed_field_names'] ?? '';
        if (!$this->validSignature($signedFields, $response, $response['signature'] ?? '')) {
            return redirect()->route('patient.appointments')->with('error', 'eSewa payment response could not be verified.');
        }

        $transactionUuid = $response['transaction_uuid'] ?? '';
        $appointmentId = explode('-', $transactionUuid)[0] ?? null;
        if (!$appointmentId || !is_numeric($appointmentId)) {
            return redirect()->route('patient.appointments')->with('error', 'eSewa payment reference was invalid.');
        }

        $appointment = $this->patientAppointment((int) $appointmentId);
        if ($appointment->payment) {
            return redirect()->route('patient.appointments')->with('error', 'Payment has already been selected for this booking.');
        }

        // try {
        //     $verification = Http::get(config('services.esewa.status_url'), [
        //         'total_amount' => number_format($this->amount(), 2, '.', ''),
        //         'product_code' => config('services.esewa.merchant_code'),
        //         'transaction_uuid' => $transactionUuid,
        //     ]);
        // } catch (\Throwable $exception) {
        //     $verification = null;
        // }

//current one replaced for testing

        try {
    $verification = Http::get(config('services.esewa.status_url'), [
        'total_amount' => number_format($this->amount(), 2, '.', ''),
        'product_code' => config('services.esewa.merchant_code'),
        'transaction_uuid' => $transactionUuid,
    ]);
} catch (\Throwable $exception) {
    \Log::error('ESEWA STATUS CHECK FAILED', [
        'message' => $exception->getMessage(),
    ]);

    $verification = null;
}

\Log::info('ESEWA VERIFICATION RESULT', [
    'status' => $verification?->status(),
    'successful' => $verification?->successful(),
    'body' => $verification?->body(),
    'json' => $verification?->json(),
]);

        $verificationData = $verification?->json();
        if (!$verification?->successful()
            || ($verificationData['status'] ?? null) !== 'COMPLETE'
            || (float) ($verificationData['total_amount'] ?? 0) !== $this->amount()
            || ($verificationData['product_code'] ?? null) !== config('services.esewa.merchant_code')) {
            return redirect()->route('patient.appointments')->with('error', 'eSewa payment could not be verified.');
        }

        Payment::create([
            'appointment_id' => $appointment->appoid,
            'patient_id' => $appointment->pid,
            'payment_method' => 'eSewa',
            'payment_status' => 'paid',
            'amount' => $this->amount(),
            'esewa_transaction_id' => $verificationData['ref_id'] ?? $response['transaction_code'] ?? null,
            'payment_date' => now(),
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Payment successful via eSewa.');
    }

    public function esewaFailure()
    {
        return redirect()->route('patient.appointments')->with('error', 'eSewa payment was cancelled or failed.');
    }

    private function patientAppointment($id): Appointment
    {
        $patient = Auth::guard('patient')->user();
        return Appointment::with('payment', 'schedule')
            ->where('pid', $patient->pid)
            ->whereHas('schedule', function ($query) {
                $query->where('scheduledate', '>=', now()->addDay()->toDateString());
            })
            ->findOrFail($id);
    }

    private function amount(): float
    {
        return (float) config('services.esewa.amount', 500);
    }

    private function signature(string $signedFieldNames, array $fields): string
    {
        $message = collect(explode(',', $signedFieldNames))
            ->map(fn (string $field) => $field . '=' . $fields[$field])
            ->implode(',');

        return base64_encode(hash_hmac('sha256', $message, config('services.esewa.secret_key'), true));
    }

    private function validSignature(string $signedFieldNames, array $fields, string $signature): bool
    {
        if (!$signedFieldNames || !$signature) {
            return false;
        }

        $values = [];
        foreach (explode(',', $signedFieldNames) as $field) {
            if (!array_key_exists($field, $fields)) {
                return false;
            }
            $values[$field] = $fields[$field];
        }

        return hash_equals($this->signature($signedFieldNames, $values), $signature);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\JobPost;
use App\Services\RegistrationFeeService;
use Illuminate\Http\Request;
use App\Enums\PaymentStatus;
use App\Notifications\JobRegistrationPaid;

class JobRegistrationController extends Controller
{
    private function fees(float $cost, RegistrationFeeService $feeService): array
    {
        $emd          = $feeService->calculate($cost);       // 10% of job cost
        $platform_fee = $feeService->platformFee($emd);      // 1% of EMD
        return [
            'emd'          => $emd,
            'platform_fee' => $platform_fee,
            'total'        => $emd + $platform_fee,
        ];
    }

    public function showRegistrationForm(JobPost $job, RegistrationFeeService $feeService)
    {
        $user = auth()->user();

        $paid = Payment::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->where('payment_for', 'job_registration')
            ->where('status', PaymentStatus::COMPLETED)
            ->exists();

        if ($paid) {
            return redirect()->back()->with('info', 'You have already registered for this job.');
        }

        $fees = $this->fees($job->cost, $feeService);

        return view('frontend.jobs.registration_form', [
            'job'          => $job,
            'emd'          => $fees['emd'],
            'platform_fee' => $fees['platform_fee'],
            'total'        => $fees['total'],
        ]);
    }

    public function storeManualPayment(Request $request, JobPost $job, RegistrationFeeService $feeService)
    {
        $user = auth()->user();

        $request->validate([
            'transaction_id'  => 'required|string|min:6|unique:payments,transaction_id',
            'vendor_name'     => 'required|string|max:100',
            'vendor_email'    => 'required|email|max:150',
            'vendor_phone'    => 'required|digits:10',
            'vendor_business' => 'nullable|string|max:150',
            'vendor_details'  => 'nullable|string|max:500',
        ], [
            'transaction_id.required' => 'Please enter your UTR/Transaction ID.',
            'transaction_id.unique'   => 'This Transaction ID has already been submitted.',
            'vendor_name.required'    => 'Please enter your full name.',
            'vendor_email.required'   => 'Please enter a valid email address.',
            'vendor_phone.required'   => 'Please enter your 10-digit phone number.',
            'vendor_phone.digits'     => 'Phone number must be exactly 10 digits.',
        ]);

        $existing = Payment::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->where('payment_for', 'job_registration')
            ->first();

        if ($existing && $existing->status === PaymentStatus::COMPLETED) {
            return response()->json(['message' => 'Already registered and verified.'], 409);
        }

        $fees = $this->fees($job->cost, $feeService);

        Payment::create([
            'user_id'         => $user->id,
            'job_id'          => $job->id,
            'payment_for'     => 'job_registration',
            'amount'          => $fees['total'],
            'emd_amount'      => $fees['emd'],
            'platform_fee'    => $fees['platform_fee'],
            'transaction_id'  => $request->transaction_id,
            'invoice_number'  => 'INV-' . strtoupper(uniqid()),
            'method'          => 'UPI_SCANNER',
            'status'          => PaymentStatus::PENDING,
            'vendor_name'     => $request->vendor_name,
            'vendor_email'    => $request->vendor_email,
            'vendor_phone'    => $request->vendor_phone,
            'vendor_business' => $request->vendor_business,
            'vendor_details'  => $request->vendor_details,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Payment submitted! Admin will verify and enable your bidding soon.'
        ]);
    }

    public function verifyPaymentByAdmin(Payment $payment)
    {
        $payment->update(['status' => PaymentStatus::COMPLETED]);

        if ($payment->user) {
            $payment->user->notify(new JobRegistrationPaid($payment));
        }

        return redirect()->back()->with('success', 'Payment verified and notification sent to user.');
    }

    public function status(JobPost $job, RegistrationFeeService $feeService)
    {
        $user    = auth()->user();
        $payment = Payment::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->where('payment_for', 'job_registration')
            ->first();

        $fees = $this->fees($job->cost, $feeService);

        return response()->json([
            'registered'   => $payment && $payment->status === PaymentStatus::COMPLETED,
            'status'       => $payment ? $payment->status->value : 'not_started',
            'emd'          => $fees['emd'],
            'platform_fee' => $fees['platform_fee'],
            'total_fee'    => $fees['total'],
        ]);
    }
}
<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('frontend.auth.otp-login');
    }

    // Handle OTP request (send OTP to the user)
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate 6-digit OTP
            $otp = rand(100000, 999999);

            // Store OTP in session (for comparison during login)
            Session::put('otp', $otp);
            Session::put('email',$user->email);

            // Send OTP via email
            Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
                $message->to($user->email)->subject('Your OTP for Login');
            });

            return back()->with('status', 'OTP sent to your email.');
        }

        return back()->withErrors(['email' => 'No user found with this email.']);
    }

    // Verify the OTP and log the user in
    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        // Check if the email matches the OTP session
        $user = User::where('email', $request->email)->first();

        if ($user && Session::get('otp') == $request->otp) {
            // Clear OTP from session after login
            Session::forget('otp');

            // Log the user in
            auth()->login($user);

            return redirect()->route('frontend.home'); // Redirect to the dashboard
        }

        return back()->withErrors(['otp' => 'Invalid OTP or email.']);
    }
}

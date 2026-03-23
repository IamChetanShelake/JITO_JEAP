<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class CustomForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send OTP to the user's email.
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We couldn\'t find an account with that email address.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;
        
        // Generate OTP
        $otp = PasswordOtp::generateOtp($email);

        // Send OTP via email
        Mail::to($email)->send(new OtpMail($otp, $email));

        // Store email in session for the next step
        return redirect()->route('password.verifyotp.form')->with([
            'email' => $email,
            'otp_sent' => true
        ]);
    }

    /**
     * Show the OTP verification form.
     */
    public function showVerifyOtpForm()
    {
        if (!session()->has('email')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.verify-otp');
    }

    /**
     * Verify the OTP and redirect to reset password.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;
        $otp = $request->otp;

        // Find valid OTP
        $otpRecord = PasswordOtp::findValidOtp($email, $otp);

        if (!$otpRecord) {
            return back()
                ->withErrors(['otp' => 'Invalid or expired OTP. Please try again.'])
                ->withInput($request->only('email'));
        }

        // Mark OTP as verified
        $otpRecord->verify();

        // Generate password reset token
        $user = User::where('email', $email)->first();
        $token = Password::getRepository()->create($user);

        // Store token in session
        return redirect()->route('password.reset', ['token' => $token])->with([
            'email' => $email,
            'otp_verified' => true
        ]);
    }

    /**
     * Display the password reset form.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->route('token');
        
        // Check if OTP was verified (session has otp_verified flag)
        if (!session()->has('otp_verified') || !session()->has('email')) {
            return redirect()->route('password.request')
                ->with('error', 'Please verify your identity first.');
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => session('email')
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Check if OTP was verified
        if (!session()->has('otp_verified')) {
            return redirect()->route('password.request')
                ->with('error', 'Please verify your identity first.');
        }

        // Reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // Clear session
        session()->forget(['email', 'otp_verified']);

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('status', 'Password has been reset successfully! You can now login with your new password.');
        }

        return back()
            ->withErrors(['email' => [__($status)]])
            ->withInput($request->only('email'));
    }

    /**
     * Resend OTP to the user's email.
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $email = $request->email;

        // Generate new OTP (this will delete old ones)
        $otp = PasswordOtp::generateOtp($email);

        // Send OTP via email
        Mail::to($email)->send(new OtpMail($otp, $email));

        return back()->with([
            'email' => $email,
            'otp_sent' => true,
            'otp_resent' => true
        ]);
    }
}

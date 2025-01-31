<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailVerificationNotification;
use Ichtrojan\Otp\Otp;

class AuthController extends Controller
{
    protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken($request->name)->plainTextToken;
        $otp = $this->otp->generate($user->email, 'numeric', 6, 10);

        // Send OTP to user's email
        $user->notify(new EmailVerificationNotification($otp->token));

        return response()->json([
            'message' => 'Registration Successful. OTP sent to your email.',
            'email' => $user->email,
            'redirect' => env('APP_URL') . '/api/email-verification',
            'token' => $token
        ], 201);
    }

    public function verifyOtp(EmailVerificationRequest $request)
    {
        $otpValidation = $this->otp->validate($request->email, $request->token ?? $request->otp);

        // dd($otpValidation);

        if ($otpValidation->status) {
            // Mark user as verified (optional)
            $user = User::where('email', $request->email)->first();
            $user->update(['email_verified_at' => now()]);

            return response()->json([
                'message' => 'OTP verified successfully.',
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid or expired OTP.',
        ], 401);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
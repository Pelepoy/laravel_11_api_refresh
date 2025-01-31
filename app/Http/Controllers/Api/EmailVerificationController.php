<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    protected $otp;
    public function __construct()
    {
        $this->otp = new Otp();
    }

    public function resend_otp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $otp = $this->otp->generate($user->email, 'numeric', 6, 10);

        // Send OTP to user's email
        $user->notify(new EmailVerificationNotification($otp->token));

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent to your email.',
            'email' => $user->email,
        ], 200);
    }

    public function email_verification(EmailVerificationRequest $request)
    {
        $otpValidation = $this->otp->validate($request->email, $request->token ?? $request->otp);

        // dd($otpValidation);

        if ($otpValidation->status) {
            $user = User::where('email', $request->email)->first();
            $user->email_verified_at = now();
            $user->save();

            return response()->json([
                'status' => $otpValidation->status,
                'message' => $otpValidation->message,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => $otpValidation->status,
                'message' => $otpValidation->message
            ]);
        }
    }
}
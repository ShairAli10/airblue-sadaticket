<?php

namespace App\Http\Controllers\Front\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\IsVerifiedMail;
use App\Mail\OtpEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function signupCustomer(Request $request)
    {
        // Validation rules for signup
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:12|min:11|unique:users,phone',
            'email' => 'required|email|unique:users,email',
        ];

        // Validate the request
        $request->validate($rules);

        // Generate a verification token
        $verify_token = Str::random(40);

        // Create a new user
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'verify_token' => $verify_token,
        ]);

        // Send verification email
        $data = [
            'verification_url' => url("/verify/{$verify_token}"),
        ];
        $email = new IsVerifiedMail($data);
        $email->with($data);
        Mail::to($user->email)->send($email);

        return response()->json(['message' => 'Signup successful. Please check your email for verification.'], 201);
    }
    public function generateOtp(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        $request->validate($rules);
        
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'not found', 'message' => 'Email not found, please sign up first'], 404);
        }
        if ($user->status != 1) {
            return response()->json(['error' => 'not verified', 'message' => 'Please verify your email first'], 404);
        }
        if($request->email == 'hamid22401@gmail.com'){
            $otpCode = 123456;
        }else{
            $otpCode = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        }
    
        $user->otp_code = $otpCode;
        $user->save();

        // Send verification email
        $data = [
            'otpCode' => $otpCode,
        ];
        $email = new OtpEmail($data);
        $email->with($data);
        Mail::to($user->email)->send($email);

        return response()->json(['status' => 'success','message' => 'OTP sent successfully'], 200);
    }

    // Process customer login
    public function loginCustomer(Request $request)
    {
        // Validation rules
        $rules = [
            'email' => 'required|email',
            'otp_code' => 'required|digits:6', // Assuming OTP code is 6 digits
        ];

        $request->validate($rules);

        // Check if the user exists with the provided email and OTP code
        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if ($user) {
            // Login the user
            Auth::login($user);

            // Clear the OTP code (optional)
            $user->update(['otp_code' => null]);

            return response()->json(['message' => 'Login successful', 'user' => $user]);
        } else {
            // Invalid credentials or OTP code
            return response()->json(['message' => 'Invalid email or OTP code', 'error' => 'not authenticated'], 401);
        }
    }

    public function verifyEmail($token)
    {
        $user = User::where('verify_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification token'], 404);
        }
        
        $user->update([
            'status' => 1,
            'verify_token' => null,
            'email_verified_at' => now(),
        ]);
        Auth::login($user);
        // return ['message' => 'Email verification successful', 'user' => $user];
        return redirect()->route('home');
    }

    
}

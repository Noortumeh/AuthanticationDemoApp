<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail};
use App\Models\User;
use App\Mail\VerificationCodeMail;
use App\Http\Requests\UserRequest;
use Exception;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        $validatedData = $request->validated();
        // check if the user not in database
        try {
            $user = User::where('email', $validatedData['email'])->first();
            if ($user) {
                return response()->json(['message' => 'user already in database'], 409);
            }
            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create($validatedData);
            return response()->json(['message' => 'user registered successfully'], 201);
        } catch (Exception  $e) {
            return response()->json(['message' => 'server error'], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }
        $user = User::where('email', $credentials['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        try {
            if (!$request->user()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'server error'], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        // Implementation for forgot password
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }
            // Generate and send verification code logic here
            $code = rand(100000, 999999);
            $user->verification_code = $code;
            $user->expires_at = now()->addMinutes(60);
            $user->save();
            // Send email with the code
            Mail::to($user->email)->send(new VerificationCodeMail($code));

            return response()->json(['message' => 'verification code sent'], 200);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Failed to send email'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        echo "resetPassword called";
        $request->validate([
            'email' => 'required|string|email',
            'new_password' => 'required|string|min:6|confirmed',
            'code' => 'required|string',
        ]);
        echo "resetPassword called2222222";
        try {
            echo "resetPassword called333333333";
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }
            if ($user->verification_code !== $request->code || now()->greaterThan($user->expires_at)) {
                return response()->json(['message' => 'Invalid or expired verification code'], 400);
            }

            $user->password = bcrypt($request->new_password);
            $user->verification_code = null;
            $user->expires_at = null;
            $user->save();

            echo "resetPassword called44444444444444";
            return response()->json(['message' => 'password reset successfully'], 200);
        } catch (Exception  $e) {
            echo "resetPassword called55555555555555555";
            return response()->json(['message' => 'server error'], 500);
        }
    }
}

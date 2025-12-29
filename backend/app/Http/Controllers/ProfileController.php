<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Models\Profile;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $profile = $user->profile;
        $profile['email'] = $user->email;
        $profile['name'] = $user->name;
        return response()->json($profile);
    }

    public function addProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            $data = $request->validated();
            $data['user_id'] = $user->id;
            if ($user->profile) {
                $user->profile->update($data);
                return response()->json($user->profile, 200);
            }
            $profile = Profile::create($data);
            return response()->json($profile, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Profile creation failed'], 500);
        }
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            $data = $request->validated();
            $profile = $user->profile;
            if (!$profile) {
                return response()->json(['error' => 'Profile not found'], 404);
            }
            $profile->update($data);
            return response()->json($profile, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }
}

<?php

namespace App\Services;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Exception;

class ProfileService
{
    public function getProfileWithUserData($user)
    {
        $profile = $user->profile;
        $profile['email'] = $user->email;
        $profile['name'] = $user->name;
        return $profile;
    }

    public function addProfile($user, ProfileRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $user->id;
            if ($user->profile) {
                return $this->updateProfile($user, $request);
            }
            $profile = Profile::create($data);
            return response()->json($profile, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Profile creation failed', $e], 500);
        }
    }

    public function updateProfile($user, ProfileRequest $request){
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
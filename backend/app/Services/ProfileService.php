<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, Storage};
use App\Facades\HelperFacades;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\{Profile, User};
use Exception;

class ProfileService
{
    public function getProfileWithUserData($user)
    {
        try {
            $user = User::with('profile')->find($user->id);
            if (!$user->profile) {
                return HelperFacades::responseError('You Dont Have A Profile Yet, Add Your Information Data.', 404);
            }
            return HelperFacades::responseSuccess(new UserResource($user));
        } catch (Exception $e) {
            return response()->json(['error' => 'User Find Faild', $e], 500);
        }
    }

    public function addProfile($user, ProfileRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $user->id;
            if ($user->profile) {
                return $this->updateProfile($user, $request);
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')?->store('profile', 'public');
            }

            $profile = Profile::create($data);
            return response()->json($profile, 201);
        } catch (Exception $error) {
            return response()->json(['error' => $error || 'Profile creation failed'], 500);
        }
    }

    public function updateProfile($user, ProfileRequest $request)
    {
        try {
            $data = $request->validated();
            $profile = $user->profile()->first();
            if (!$profile) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            if ($request['image']) {
                if (Storage::disk('public')->exists($profile['image'])) {
                    Storage::disk('public')->delete($profile['image']);
                }
                $data['image'] = $request->file('image')?->store('profile', 'public');
            }

            $change = false;
            foreach ($data as $key => $value) {
                if (!$profile->$key || $profile->$key !== $value) {
                    $change = true;
                    break;
                }
            }
            if (!$change) {
                return response()->json(['error' => 'You didnt update any data'], 409);
            }

            $profile->update($data);
            $profile->refresh();
            return response()->json($profile, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }
}

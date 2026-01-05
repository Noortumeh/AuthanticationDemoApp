<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Facades\HelperFacades;
use App\Http\Requests\{ProfileRequest, UserRequest};
use App\Http\Resources\UserResource;
use App\Models\{Profile, User};
use App\Services\ProfileService;
use Exception;

class AdminServices
{
    protected $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function getUsers()
    {
        try {
            $users = User::all();
            if (!$users) {
                return HelperFacades::responseError('Users Not Found', 404);
            }
            return HelperFacades::responseSuccess($users);
        } catch (Exception $e) {
            return response()->json(['error' => 'Users Find Faild', $e], 500);
        }
    }

    public function getUserData(Request $request)
    {
        try {
            if(!User::find($request->id)){
                 return response()->json(['error' => 'User Not Found'], 404);
            }
            $user = User::with('profile')->findOrFail($request->id);
            if (!$user) {
                return HelperFacades::responseError('User Profile Not Found', 404);
            }
            return HelperFacades::responseSuccess(new UserResource($user));
        } catch (Exception $e) {
            return response()->json(['error' => 'User Find Faild', $e], 500);
        }
    }

    public function createUser(UserRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $user = User::where('email', $validatedData['email'])->first();
            if ($user) {
                return HelperFacades::responseError('User already in database', 409);
            }
            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create($validatedData);
            return HelperFacades::responseSuccess($user);
        } catch (Exception  $e) {
            return response()->json(['message' => 'creating user faild'], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return HelperFacades::responseError('User Not Found', 404);
            }
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        } catch (Exception $e) {
            return HelperFacades::responseError('Deleting User Faild', 500);
        }
    }

    public function addUserProfile(ProfileRequest $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return HelperFacades::responseError('User Not Found', 404);
            }
            return $this->profileService->addProfile($user, $request);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Adding Fser Data Faild'], 500);
        }
    }

    public function updateUserProfile(ProfileRequest $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return HelperFacades::responseError('User Not Found', 404);
            }
            return $this->profileService->updateProfile($user, $request);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Adding Fser Data Faild'], 500);
        }
    }

    public function deleteUserProfile($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return HelperFacades::responseError('User Not Found', 404);
            }
            $profile = $user->profile;
            if (!$profile) {
                return HelperFacades::responseError('User Profile Not Found', 404);
            }
            $profile->delete();
            return response()->json([
                'message' => 'Profile deleted successfully'
            ]);
        } catch (Exception  $e) {
            return response()->json(['message' => 'Adding Fser Data Faild'], 500);
        }
    }
}

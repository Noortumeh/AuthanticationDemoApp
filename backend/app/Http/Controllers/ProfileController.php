<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Services\{HelperServices, ProfileService};
use Exception;

class ProfileController extends Controller
{
    protected $helperService;
    protected $profileService;
    public function __construct(HelperServices $helperService, ProfileService $profileService)
    {
        $this->helperService = $helperService;
        $this->profileService = $profileService;
    }

    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return $this->helperService->responseError('Unauthorized', 401);
        }
        $profile = $this->profileService->getProfileWithUserData($user);
        return $this->helperService->responseSuccess($profile, 'Profile fetched successfully');
    }

    public function addProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->profileService->addProfile($user, $request);
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->profileService->updateProfile($user, $request);
    }

    public function welcome(HelperServices $helperService)
    {
        // $helperService = app('welcome');
        
        // return response()->json(['message' => $helperService->welcomeMessage('User')]);

        return response()->json(['message' => $this->helperService->welcomeMessage('User')]);
    }
}

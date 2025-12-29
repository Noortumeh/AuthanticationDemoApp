<?php

namespace App\Http\Controllers;

use App\Facades\HelperFacades;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Services\{HelperServices, ProfileService};

class ProfileController extends Controller
{
    // protected $helperService;
    protected $profileService;
    public function __construct(HelperServices $helperService, ProfileService $profileService)
    {
        // $this->helperService = $helperService;
        $this->profileService = $profileService;
    }

    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return HelperFacades::responseSuccess('Unauthorized', 401);
        }
        $profile = $this->profileService->getProfileWithUserData($user);
        return HelperFacades::responseSuccess($profile, 'Profile fetched successfully');
    }

    public function addProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return HelperFacades::responseSuccess('Unauthorized', 401);
        }
        return $this->profileService->addProfile($user, $request);
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return HelperFacades::responseSuccess('Unauthorized', 401);
        }
        return $this->profileService->updateProfile($user, $request);
    }

    // this method just for testing
    public function welcome(HelperServices $helperService)
    {
        // $helperService = app('welcome');
        
        // return response()->json(['message' => $helperService->welcomeMessage('User')]);

        // return response()->json(['message' => $this->helperService->welcomeMessage('User')]);

        return HelperFacades::welcomeMessage('noor');
    }
}

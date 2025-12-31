<?php

namespace App\Services;

use App\Facades\HelperFacades;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AdminServices
{
    public function welcome()
    {
        return 'welcome';
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
            $user = User::with('profile')->findOrFail($request->id);
            if (!$user) {
                return HelperFacades::responseError('User Not Found', 404);
            }
            return HelperFacades::responseSuccess($user);
        } catch (Exception $e) {
            return response()->json(['error' => 'User Find Faild', $e], 500);
        }
    }
}

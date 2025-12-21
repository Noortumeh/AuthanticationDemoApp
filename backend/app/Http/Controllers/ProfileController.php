<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request){
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $profile = $user->profile;
        return response()->json($profile);
    }

    public function addProfile(Request $request){
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $data = $request->validate([
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $data['user_id'] = $user->id;
        $profile = Profile::create($data);
        return response()->json($profile, 201);
    }
}

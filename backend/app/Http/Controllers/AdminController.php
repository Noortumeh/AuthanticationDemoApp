<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{ProfileRequest, UserRequest};
use App\Services\AdminServices;

class AdminController extends Controller
{
    protected $admin;
    public function __construct(AdminServices $adminServices)
    {
        $this->admin = $adminServices;
    }

    public function getUsers()
    {
        return $this->admin->getUsers();
    }

    public function getUserData(Request $request)
    {
        return $this->admin->getUserData($request);
    }

    public function createUser(UserRequest $request)
    {
        return $this->admin->createUser($request);
    }

    public function deleteUser($id)
    {
        return $this->admin->deleteUser($id);
    }


    //Profile APIs
    public function addUserProfile(ProfileRequest $request, $id)
    {
        return $this->admin->addUserProfile($request, $id);
    }

    public function updateUserProfile(ProfileRequest $request, $id)
    {
        return $this->admin->updateUserProfile($request, $id);
    }
    
    public function deleteUserProfile($id)
    {
        return $this->admin->deleteUserProfile($id);
    }
}

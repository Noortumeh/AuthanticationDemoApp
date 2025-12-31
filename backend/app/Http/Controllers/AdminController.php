<?php

namespace App\Http\Controllers;

use App\Services\AdminServices;
use Illuminate\Http\Request;

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{


    public function store(Request $request)
    {

        $user = UserService::createUser($request->all());

        $usertoken=UserService::generateToken($user);
        $user->setRememberToken($usertoken);
        return response($usertoken, 201);
    }


    public function login(Request $request)
    {
        $user = UserService::login($request->all());
        $resp=['user'=> __($user->getAttribute('username')),'message' => __('Logged in successfully')];

        $token= UserService::generateToken($user);
        return response(json_encode(array($resp,$token)),210);
    }

    public function logout(Request $request)
    {
        UserService::logout(auth()->user());
        return response(['message' => __('Logged out successfully')],210);
    }
}

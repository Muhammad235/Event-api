<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\SignupUserRequest;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function signup(SignupUserRequest $request)
    {

        $request->validated();

        try {

            $user = User::create($request->only('name', 'email', 'password'));

            return response()->json([
                'status_code' => 201, 
                'message' =>'user created sucessfully', 
                'data' => [
                    'name' => $user->name, 
                    'email' => $user->email
                ],
                'token' => $user->createToken($user->email)->plainTextToken,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function login(LoginUserRequest $request)
    {
        $request->validated();

        try {

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => 401,
                    'error' => "incorrect",
                ], 401);
            }
      
            $user = User::where('email', $request->input('email'))->first();
      
            return response()->json([
                'status_code' => 200, 
                'message' =>'user logged in sucessfully', 
                'data' => $user,
                'token' => $user->createToken($user->email)->plainTextToken,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([], 204);
    }




}

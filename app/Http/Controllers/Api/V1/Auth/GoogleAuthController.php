<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $StoreUser = User::updateOrCreate([
                'auth_id' => $user->id
            ], [
                'auth_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'auth_token' => $user->token,
                'auth_type' => 'google',
                'password' => Hash::make(Str::random(10))
            ]);

            Auth::login($StoreUser);
           
            return response()->json([
                'status' => 'sucess', 
                'message' =>'user logged in sucessfully', 
                'data' => [
                    'name' => $user->name, 
                    'email' => $user->email
                ],
                'token' => $StoreUser->createToken($user->email)->plainTextToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => "An error occured while processing the request",
            ], 500);
        }
    }
}

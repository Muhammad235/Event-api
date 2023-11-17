<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;

class UserProfileController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserProfileRequest $request)
    {
        //validate incoming request
        $validatedData = $request->validated();

        //get the user 
        $user = auth()->user();

        try {

            if ($request->hasFile('avatar')) {
                // Rename the avatar with a timestamp and original extension
                $validatedData['avatar'] = time() . '.' . $request->avatar->extension();
            
                // Move the avatar to the 'user_profiles' directory
                $request->avatar->move(public_path('user_profiles'), $validatedData['avatar']);
            }
            

            //store the request 
            $profile = $user->profile()->updateOrCreate($validatedData);

            return response()->json([
                'status_code' => 200, 
                'message' =>'profile created sucessfully', 
                'data' => [
                    'full_name' => $profile->full_name, 
                    'phone_number' => $profile->phone_number,
                    'gender' => $profile->gender,
                    'avatar' => $profile->avatar
                ],
            ], 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {

         return response()->json([
            'status_code' => 200, 
            'message' =>'profile created sucessfully', 
            'data' => [
                'full_name' => $profile->full_name, 
                'phone_number' => $profile->phone_number,
                'gender' => $profile->gender,
                'avatar' => $profile->avatar
            ],
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

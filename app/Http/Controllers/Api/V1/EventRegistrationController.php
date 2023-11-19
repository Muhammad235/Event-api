<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventRegistration;

class EventRegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, Request $request,)
    {
        
        $user = auth()->user();

        try {

            $eventRegistration = EventRegistration::updateOrCreate([
                'user_id' => $user->id,
                'event_id' => $event->id, 
                'name' => $user->name,
                'email' => $user->email,
            ]);

            if ($eventRegistration) {
                return response()->json([
                    'status_code' => 201, 
                    'message' =>'Registration was successfully', 
                ], 201);
            }
 
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => "Internal server error",
            ], 500);
        }
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $deleteEvent = $event->delete();

        if (! $deleteEvent) {
            return response()->json([
                'status_code' => 500,
                'message' => "Internal server error",
            ], 500);
        }

    }
}

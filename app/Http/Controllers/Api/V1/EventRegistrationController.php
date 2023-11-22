<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use App\Http\Controllers\Controller;
use App\Http\Resources\RegisteredEventResource;

class EventRegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, Request $request,)
    {
        
        $user = auth()->user();

        $numberOfTickets = intval($request->number_of_ticket);

        try {

            $eventRegistration = EventRegistration::updateOrCreate([
                'user_id' => $user->id,
                'event_id' => $event->id, 
                'name' => $user->name,
                'email' => $user->email,
                'number_of_ticket' => $numberOfTickets
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
                'message' => "An error occured while processing the request",
            ], 500);
        }
    
    }

    /**
     * Gett all registered event from the storage
    */

    public function registered()
    {
        $userId = auth()->id();

        $registeredEvent = EventRegistration::where('user_id', $userId)->get();

        try {

            if ($registeredEvent->isNotEmpty()) {
                return response()->json([
                    'status_code' => 200, 
                    'data' => RegisteredEventResource::collection($registeredEvent),
                    'message' =>'Request was successfull', 
                ], 200);
            }else {
                return response()->json([
                    'status_code' => 404, 
                    'message' => 'Not event found', 
                ], 404);
            }
 
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => "An error occured while processing the request",
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $user = auth()->user();


        try {

            $deleteRegisteredEvent = EventRegistration::where('user_id', $user->id)->where('event_id', $event->id)->delete();

            if ($deleteRegisteredEvent) {
                return response()->json([], 204);
            }
 
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => "An error occured while processing the request",
            ], 500);
        }


    }
}

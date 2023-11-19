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
    public function store(Event $eventId, Request $request)
    {
        dd($eventId);
        
        $user = auth()->user();

        $user->create()->registerEvent([
            'name' => $user->name,
            'email' => $user->email,
        ]);
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

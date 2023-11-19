<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Middleware\CheckUserEventOwnership;

class EventController extends Controller
{
    public function __construct()
    {
        // Apply the middleware only to the 'show' method
       $this->middleware(CheckUserEventOwnership::class)->only('show', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $events = $user->event()->get();

        try {

            if ($events->isNotEmpty()) {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'User events returned successfully',
                    'data' => $events
                ], 200);
            } else {
                // User has no events
                return response()->json([], 204);
            }
 
        } catch (\Exception $e) {

            return response()->json([
                'status_code' => 500,
                'message' => "Unable to process request, server error",
            ], 500);
        }



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated();

        $user = auth()->user();

        try {

            if ($request->hasFile('image')) {
                // Rename the avatar with a timestamp and original extension
                $validatedData['image'] = time() . '.' . $request->image->extension();
            
                // Move the avatar to the 'user_profiles' directory
                $request->image->move(public_path('event_fliers'), $validatedData['image']);
            }
            
            //store the request 
            $event = $user->event()->create($validatedData);

            return response()->json([
                'status_code' => 201, 
                'message' =>'Event created sucessfully', 
                'data' => $event
            ], 201);

        } catch (\Exception $e) {
            
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json([
            'status_code' => 200, 
            'message' =>'Event returned sucessfully', 
            'data' => $event,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEventRequest $request, Event $event)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            // Rename the avatar with a timestamp and original extension
            $validatedData['image'] = time() . '.' . $request->image->extension();
        
            // Move the avatar to the 'user_profiles' directory
            $request->image->move(public_path('event_fliers'), $validatedData['image']);
        }

        $event->update($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $deleteEvent = $event->delete();

        if ($deleteEvent) {

            return response()->json([], 204);

        }else{
            
            return response()->json([
                'status_code' => 500,
                'message' => "An error occured while processing the request",
            ], 500);
        }

    }

    /**
     * search the specified resource from storage.
     */

     public function search(Event $event, Request $request)
     {

        $user = auth()->user();

        $getEvent = $event
        ->when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%')
            ->orWhere('location', 'like', '%' . $request->search . '%')
            ->orWhere('tags', 'like', '%' . $request->search . '%');
        })
        ->paginate(10);

        return $getEvent;

     }


}

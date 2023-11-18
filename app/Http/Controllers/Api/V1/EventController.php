<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::simplePaginate();
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
                'data' => [
                    'title' => $event->title, 
                    'description' => $event->description,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date
                ],
            ], 201);

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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

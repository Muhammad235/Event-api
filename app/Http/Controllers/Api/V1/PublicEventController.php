<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PublicEventResource;

class PublicEventController extends Controller
{
    
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $event = Event::orderBy("created_at","desc")->simplePaginate(10);
        
        if ($event) {
            return response()->json([
                'status_code' => 200, 
                'message' =>'Event returned sucessfully', 
                'data' => PublicEventResource::collection($event)
            ], 200);
        }else {

            //return 204 when thre is no event available
            return response()->json(null, 204);
        }
    }

    /**
     * search the specified resource from storage.
     */

     public function search(Event $event, Request $request)
     {
        try {
            $getSearchQuery = $event
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('start_date', '>=', $request->dateFrom);
            })
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('ticket_price', '>=', $request->priceFrom);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('ticket_price', '<=', $request->priceTo);
            })
            ->paginate(10);


          return response()->json([
            'status_code' => 200, 
            'message' =>'search result returned sucessfully', 
            'data' => $getSearchQuery,
        ], 200);

            
        } catch (\Exception $e) {

            return response()->json([
                'status_code' => 500,
                'message' => "An error occured while processing the request",
            ], 500);
        }



     }




}

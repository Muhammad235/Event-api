<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicEventController extends Controller
{
    
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $event = Event::simplePaginate();

        if ($event) {
            return response()->json([
                'status_code' => 200, 
                'message' =>'Event returned sucessfully', 
                'data' => $event
            ], 200);
        }else {

            //return 204 when thre is no event available
            return response()->json([], 204);
        }
    }

    /**
     * search the specified resource from storage.
     */

     public function search(Event $event, Request $request)
     {
        $result = $event
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
     }


}

<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisteredEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $event = Event::find($this->event_id);
        return [
            'id' => $this->id,
            'user_details' => [
                'name' => $this->name,
                'email' => $this->email
            ],
            'event_details' => [
                'event_id'=> $this->event_id,
                'title'=> $event->title,
                'description'=> $event->email,
                'start_time'=> $event->start_time,
                'number_of_registered_ticket'=> $this->number_of_ticket,
                'location'=> $event->location,
            ],
        ];
    }
}

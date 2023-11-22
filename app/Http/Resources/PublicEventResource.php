<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title'=> $this->title,
            'description'=> $this->description,
            'start_date'=> $this->start_date,
            'end_date'=> $this->end_date,
            'start_time'=> $this->start_time,
            'end_time'=> $this->end_time,
            'tags'=> $this->tags,
            'is_paid_event'=> $this->is_paid_event,
            'ticket_price'=> $this->ticket_price,
            'number_of_available_tickets'=> $this->number_of_available_tickets,
            'registration_closing_date'=> $this->registration_closing_date,
            'image_url'=> $this->image ? url("event_fliers/{$this->image}") : null,
        ];
    }
}

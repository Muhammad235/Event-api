<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'tags',
        'is_paid_event',
        'ticket_price',
        'number_of_available_tickets',
        'registration_closing_date',
        'image',
    ];

    protected $casts = [
        'is_paid_event' => 'boolean'
    ];
}

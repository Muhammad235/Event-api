<?php

namespace App\Observers;

use App\Models\EventRegistration;

class RegistrationObserver
{
    /**
     * Handle the EventRegistration "created" event.
     */
    public function creating(EventRegistration $eventRegistration): void
    {
        $event = $eventRegistration->event;

        if ($event) {
            $event->number_of_available_tickets -= $eventRegistration->number_of_ticket;
            $event->save();
        }
    }

    /**
     * Handle the EventRegistration "updated" event.
     */
    public function updated(EventRegistration $eventRegistration): void
    {
        //
    }

    /**
     * Handle the EventRegistration "deleted" event.
     */
    public function deleted(EventRegistration $eventRegistration): void
    {
        //
    }

    /**
     * Handle the EventRegistration "restored" event.
     */
    public function restored(EventRegistration $eventRegistration): void
    {
        //
    }

    /**
     * Handle the EventRegistration "force deleted" event.
     */
    public function forceDeleted(EventRegistration $eventRegistration): void
    {
        //
    }
}

<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function View(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }
}

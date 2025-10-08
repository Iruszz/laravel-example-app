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
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }
        return null;
    }

    public function View(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }

    public function Create(User $user)
    {
        return $user !== null
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    public function Update(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }

    public function Delete(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }
}

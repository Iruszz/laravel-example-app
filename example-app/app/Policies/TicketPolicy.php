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

    public function assignAgent(User $user, Ticket $ticket)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(403);
    }


    public function view(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }

    public function create(User $user)
    {
        return $user !== null
            ? Response::allow()
            : Response::denyWithStatus(401);
    }

    public function update(User $user, Ticket $ticket)
    {
        if ($user->is_admin) {

        }

        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }
}

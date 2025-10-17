<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, Ticket $ticket)
    {
        // Only ticket owner or assigned agent can create a comment
        return $user->id === $ticket->user_id || $user->id === $ticket->agent_id;
    }
}

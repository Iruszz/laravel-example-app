<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\Comment;
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
        return $user->id === $ticket->user_id || $user->id === $ticket->agent_id;
    }

    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}

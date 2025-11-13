<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

    public function update(User $user, Note $note)
    {
        return $user->is_admin && $note->user_id === $user->id
            ? Response::allow()
            : Response::denyWithStatus(403);
    }
}

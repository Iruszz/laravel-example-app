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

    public function update(User $user)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

    public function create(User $user)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(403);
    }
}

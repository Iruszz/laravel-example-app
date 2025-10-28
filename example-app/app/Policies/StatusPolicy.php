<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StatusPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Status $ticket)
    {
        return $user->is_admin
            ? Response::allow()
            : Response::denyWithStatus(403, 'Only admins can update statuses.');
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function Update(User $authUser, User $targetUser)
    {
        if ($authUser->is_admin) {
            return Response::allow();
        }

        // if ($authUser->id === $targetUser->id) {
        //     return Response::allow();
        // }

        return Response::deny('You are not authorized to update this user.', 403);
    }
}

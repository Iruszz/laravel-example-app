<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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

    public function View(User $user, Category $category)
    {
        return $user->id === $ticket->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }

    public function Update(User $user, Category $category)
    {
        if ($user->is_admin) {

        }

        return $user->id === $category->user_id
            ? Response::allow()
            : Response::denyWithStatus(404);
    }
}

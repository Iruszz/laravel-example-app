<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function index() {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request) {
        $user = User::create($request->validated());

        $users = User::all();
        event(new Registered($user));
        
        return UserResource::collection($users);
    }

    public function current(Request $request) {
        return new UserResource($request->user());
    }

    public function update (UpdateUserRequest $request, User $user) {
        $this->authorize('update', $user);
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->tickets()->exists()) {
            return response()->json([
                'message' => 'Cannot delete user. Tickets are still assigned to this account.',
                'code' => 'DELETE_USER_FAILED'
            ], 400);
        }

        $user->delete();

        return response()->noContent();
    }
}

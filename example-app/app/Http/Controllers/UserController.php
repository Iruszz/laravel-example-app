<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
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
}

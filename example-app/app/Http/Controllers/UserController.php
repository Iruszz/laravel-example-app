<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function index() {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request) {
        $user = User::create($request->validated());

        $users = User::all();
        return UserResource::collection($users);
    }
}

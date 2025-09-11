<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    public function store(StoreUserRequest $request) {
        $user = User::create($request->validated());

        Auth::login($user);

         $user->sendEmailVerificationNotification();
        return new UserResource($user);
    }
}

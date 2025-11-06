<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request, User $user)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login failed.',
                'errors' => [
                    'email' => ['Email is incorrect.'],
                    'password' => ['Password is incorrect.'],
                ]
            ], 422);
        }


        $request->session()->regenerate();
        return response()->json([
            'message' => 'Login successful.',
            'user' => Auth::user(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out']);
    }
}
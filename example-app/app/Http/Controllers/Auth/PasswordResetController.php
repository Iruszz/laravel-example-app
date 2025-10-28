<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::ResetLinkSent
            ? response()->json(['status' => __($status)], 200)
            : response()->json(['email'=> __($status)], 400);
    }

    public function resetPasswordToken(string $token) {
        return response()->json(['token' => $token]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // return $status === Password::PasswordReset
        //     ? response()->json(['status' => __($status)], 200)
        //     : response()->json(['email'=> __($status)], 400);

        if ($status === Password::PASSWORD_RESET) {
            return ApiResponse::success(__($status), 'passwordReset');
        }

        return ApiResponse::badRequest(__($status), 'PASSWORD_RESET_FAILED');

    }
}

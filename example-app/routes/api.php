<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

Route::get('/email/verify', function () {
    return response()->json([
        'message' => 'Please verify your email address.'
    ]);
    })->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash, Request $request) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid verification link.'], 400);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/verify-email?verified=1');
    }

    $user->markEmailAsVerified();
    event(new Verified($user));

    return redirect('/verify-email?verified=1');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');


Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.perform');

Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');

Route::get('/forgot-password', function () {
})->middleware('guest')->name('password.request');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',

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

    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

    
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('comments', CommentController::class);

    // Alleen voor admin auth admin?
    Route::apiResource('users', UserController::class);
    Route::apiResource('agents', AgentController::class);
});





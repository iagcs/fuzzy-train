<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Services\LoginService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthController extends \Illuminate\Routing\Controller
{
    public function __construct(private readonly LoginService $service)
    {
        $this->middleware('auth:sanctum')->only(['me']);
    }

    public function login(LoginRequest $request): LoginResource
    {
        return LoginResource::make($this->service->getUser($request->validated()));
    }

    public function logout(Request $request): \Illuminate\Http\Response
    {
        $request->user()?->currentAccessToken()->delete();

        return response()->noContent();
    }

    public function forgotPassword(ForgotPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? new JsonResponse('Link for password reset sent to email.')
            : new JsonResponse('Not possible to send link to reset password: ' . $status, 400);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => \Hash::make($password)
                ])->setRememberToken(\Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? new JsonResponse('Password reseted.')
            : new JsonResponse('Not possible to reset password: ' . $status, 400);
    }

    public function me(): UserResource
    {
        return UserResource::make(\Auth::user());
    }
}

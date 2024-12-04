<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends \Illuminate\Routing\Controller
{
    public function __construct(private readonly LoginService $service)
    {
        $this->middleware('auth:sanctum')->only(['me']);
    }

    public function login(LoginRequest $request): LoginResource
    {
        return LoginResource::make($this->service->getUser($request->validated()));
    }

    public function me(): UserResource
    {
        return UserResource::make(\Auth::user());
    }
}

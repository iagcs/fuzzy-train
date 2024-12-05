<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\NewsPreferenceRequest;
use Modules\User\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $repository)
    {
        $this->middleware('auth:sanctum');
    }

    public function setPreferences(NewsPreferenceRequest $request): void
    {
        $this->repository->setNewsPreference(\Auth::user(), $request->validated());

        response()->noContent();
    }
}

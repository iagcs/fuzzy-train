<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\NewsPreferenceRequest;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Http\Resources\NewsPreferenceResource;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $repository)
    {
        //$this->middleware('auth:sanctum');
    }

    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function store(UserRequest $request): UserResource
    {
        return UserResource::make($this->repository->create($request->getData()));
    }
}

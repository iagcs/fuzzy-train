<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\NewsPreferenceRequest;
use Modules\User\Http\Resources\NewsPreferenceResource;
use Modules\User\Repositories\UserRepository;

class NewsPreferenceController extends Controller
{
    public function __construct(private readonly UserRepository $repository)
    {
        $this->middleware('auth:sanctum');
    }

    public function store(NewsPreferenceRequest $request): void
    {
        $this->repository->setNewsPreference(\Auth::user(), $request->validated());

        response()->noContent();
    }

    public function show(): NewsPreferenceResource
    {
        return NewsPreferenceResource::make();
    }
}

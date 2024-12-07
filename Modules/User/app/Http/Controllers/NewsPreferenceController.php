<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\NewsPreferenceRequest;
use Modules\User\Http\Resources\PreferredAuthorResource;
use Modules\User\Http\Resources\PreferredCategoryResource;
use Modules\User\Http\Resources\PreferredSourceResource;
use Modules\User\Repositories\UserRepository;

class NewsPreferenceController extends Controller
{
    public function __construct(private readonly UserRepository $repository)
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @throws \JsonException
     */
    public function store(NewsPreferenceRequest $request): void
    {
        $this->repository->setNewsPreference($request->user(), $request->validated());

        response()->noContent();
    }

    public function show(Request $request): array
    {
        return [
            'authors'    => PreferredAuthorResource::collection($request->user()->preferredAuthors),
            'sources'    => PreferredSourceResource::collection($request->user()->preferredSources),
            'categories' => PreferredCategoryResource::collection($request->user()->preferredCategories),
        ];
    }
}

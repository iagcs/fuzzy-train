<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\Http\Resources\ArticleResource;
use Modules\Article\Models\Article;
use Modules\Article\Services\ArticleService;
use Modules\User\Models\User;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $service)
    {
        $this->middleware('auth:sanctum');
    }

    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function articles(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ArticleResource::collection($this->service->getPreferenceArticles(\Auth::user()));
    }
}

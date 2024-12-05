<?php

namespace Modules\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Article\Http\Resources\ArticleResource;
use Modules\Article\Models\Article;
use Modules\Article\Services\ArticleService;
use Modules\User\Models\User;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $service) {}

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
        return ArticleResource::collection($this->service->getPreferenceArticles(User::first()));
    }
}

<?php

namespace Modules\Article\Repositories;

use App\Services\ElasticService;
use Illuminate\Support\Collection;
use Modules\Article\DTOs\ArticleDto;
use Modules\Article\Models\Article;

class ArticleRepository
{
    public function __construct(private readonly ElasticService $elasticService) {}

    public function insert(array $data): void
    {
        Article::query()->insert($data);
    }

    /**
     * @throws \Exception
     */
    public function index(array $data): void
    {
        $this->elasticService->bulkDocuments($data);
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     */
    public function optimizedSearch(array $query): array
    {
        $body = [
            'size' => 200,
            'query' => $query
        ];

        $result = $this->elasticService->search(compact('body'));

        return ArticleDto::collect(\Arr::pluck($result, '_source'));
    }
}

<?php

namespace Modules\Article\Repositories;

use App\Services\ElasticService;
use Illuminate\Support\Collection;
use Modules\Article\Models\Article;

readonly class ArticleRepository
{
    public function __construct(private ElasticService $elasticService) {}

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
    public function optimizedSearch(array $body): array
    {
        return $this->elasticService->search(compact('body'));
    }
}

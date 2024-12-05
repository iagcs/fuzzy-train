<?php

namespace Modules\Article\Services;

use App\Services\ElasticService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

abstract class ArticleNewsApiService
{
    public function __construct(private readonly ElasticService $elasticService) {}

    abstract public function getBaseUrl(): string;
    abstract public function getQueryParams(): array;
    abstract public function getNewsData(): array;
    abstract public function formatNewsData(array $data): array;
    public function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl($this->getBaseUrl())
            ->withQueryParameters($this->getQueryParams());
    }

    /**
     * @throws \Exception
     */
    public function fetchDataIntoElasticsearch(): void
    {
        $data = $this->getNewsData();

        $this->elasticService->bulkDocuments($data);
    }
}

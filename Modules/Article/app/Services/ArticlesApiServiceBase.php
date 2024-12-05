<?php

namespace Modules\Article\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Modules\Article\DTOs\ArticleDto;

abstract class ArticlesApiServiceBase
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    abstract protected function getBaseUrl(): string;
    abstract protected function getQueryParams(): array;
    abstract protected function getNewsData(): array;
    abstract protected function getArticleData(array $data): ArticleDto;

    protected function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::baseUrl($this->getBaseUrl())
            ->withQueryParameters($this->getQueryParams());
    }

    private function formatNewsData(array $data): array
    {
        return \Arr::whereNotNull(\Arr::map($data, function (array $datum) {
            try {
                return $this->getArticleData($datum)->toArray();
            } catch (ValidationException $e) {
                \Log::error('Failed to fetch article data due to validation errors: '.$e->getMessage());
                return null;
            }
        }));
    }

    /**
     * @throws \Exception
     */
    public function fetchData(): void
    {
        $data = $this->getNewsData();

        $formattedData = $this->formatNewsData($data);

        if(!empty($formattedData)){
            $this->articleService->insertAndIndex($formattedData);
        }
    }
}

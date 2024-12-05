<?php

namespace Modules\Article\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class NewsApiService extends ArticleNewsApiService
{
    /**
     * @throws \Exception
     */
    public function getNewsData(): array
    {
        try {
            $response = $this->client()->get('/everything');

            return $this->formatNewsData($response->json()['articles']);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to fetch news data');
        }
    }

    public function getBaseUrl(): string
    {
        return config('apis.news_api.url');
    }

    public function getQueryParams(): array
    {
        return [
            'apiKey' => config('apis.news_api.key'),
            'from' => today()->subDay()->format('Y-m-d'),
            'to' => today()->subDay()->format('Y-m-d'),
            'language' => 'en',
            'sources' => 'bbc-news,abc-news'
        ];
    }

    public function formatNewsData(array $data): array
    {
        return \Arr::map($data, static function(array $datum){
            return [
                'title'    => $datum['title'],
                'content'  => $datum['content'],
                'url'      => $datum['url'],
                'source'   => $datum['source']['name'],
                'author'   => $datum['author'],
                'category' => $datum['category'] ?? 'general',
            ];
        });
    }
}

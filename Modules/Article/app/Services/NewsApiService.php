<?php

namespace Modules\Article\Services;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Article\DTOs\ArticleDto;

class NewsApiService extends ArticlesApiServiceBase
{
    /**
     * @throws \Exception
     */
    protected function getNewsData(): array
    {
        try {
            $response = $this->client()->get('/everything');

            return $response->json()['articles'];
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to fetch news data');
        }
    }

    protected function getBaseUrl(): string
    {
        return config('apis.news_api.url');
    }

    protected function getQueryParams(): array
    {
        return [
            'apiKey'   => config('apis.news_api.key'),
            'from'     => today()->subDay()->format('Y-m-d'),
            'to'       => today()->subDay()->format('Y-m-d'),
            'language' => 'en',
            'sources'  => 'bbc-news,abc-news',
        ];
    }

    protected function getArticleData(array $data): ArticleDto
    {
        return ArticleDto::from([
            'id'           => \Str::orderedUuid()->toString(),
            'title'        => $data['title'] ?? 'unknown',
            'content'      => $data['content'] ?? 'unknown',
            'url'          => $data['url'] ?? 'unknown',
            'source'       => $data['source']['name'] ?? 'unknown',
            'author'       => $data['author'] ?? 'unknown',
            'category'     => $data['category'] ?? 'general',
            'published_at' => Carbon::parse($data['publishedAt'])->format('Y-m-d h:m:s'),
            'created_at'   => now()->addDay(3),
            'updated_at'   => now(),
        ]);
    }
}

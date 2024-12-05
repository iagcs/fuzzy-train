<?php

namespace Modules\Article\Services;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Article\DTOs\ArticleDto;

class NewYorkTimesApiService extends ArticlesApiServiceBase
{
    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    protected function getNewsData(): array
    {
        try {
            $response = $this->client()->get('/svc/search/v2/articlesearch.json');

            return $response->json()['response']['docs'];
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to fetch news data');
        }
    }

    protected function getBaseUrl(): string
    {
        return config('apis.nyt.url');
    }

    protected function getQueryParams(): array
    {
        return [
            'api-key'  => config('apis.nyt.key'),
            'pub_date' => today()->subDay()->format('Y-m-d'),
        ];
    }

    protected function getArticleData(array $data): ArticleDto
    {
        return ArticleDto::from([
            'id'           => \Str::orderedUuid()->toString(),
            'title'        => $data['abstract'] ?? 'unknown',
            'content'      => $data['lead_paragraph'] ?? 'unknown',
            'url'          => $data['web_url'] ?? 'unknown',
            'source'       => $data['source'] ?? 'unknown',
            'author'       => $data['byline']['original'] ?? 'unknown',
            'category'     => $data['section_name'] ?? 'general',
            'published_at' => Carbon::parse($data['pub_date'])->format('Y-m-d') ?? 'unknown',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}

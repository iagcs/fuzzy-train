<?php

namespace Modules\Article\Services;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Article\DTOs\ArticleDto;

class TheGuardiansApiService extends ArticlesApiServiceBase
{
    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    protected function getNewsData(): array
    {
        try {
            $response = $this->client()->get('/search');

            return $response->json()['response']['results'];
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to fetch news data');
        }
    }

    protected function getBaseUrl(): string
    {
        return config('apis.the_guardian.url');
    }

    protected function getQueryParams(): array
    {
        return [
            'api-key'   => config('apis.the_guardian.key'),
            'from-date' => today()->subDay()->format('Y-m-d'),
            'to-date'   => today()->subDay()->format('Y-m-d'),
        ];
    }

    protected function getArticleData(array $data): ArticleDto
    {
        return ArticleDto::from([
            'id'           => \Str::orderedUuid()->toString(),
            'title'        => $data['webTitle'] ?? 'unknown',
            'content'      => $data['webTitle'] ?? 'unknown',
            'url'          => $data['webUrl'] ?? 'unknown',
            'source'       => $data['pillarName'] ?? 'unknown',
            'author'       => 'unknown',
            'category'     => $data['sectionName'] ?? 'general',
            'published_at' => Carbon::parse($data['webPublicationDate'])->format('Y-m-d h:m:s') ?? 'unknown',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}

<?php

namespace Modules\Article\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class NewYorkTimesApiService extends ArticleNewsApiService
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function getNewsData(): array
    {
        try {
            $response = $this->client()->get('/svc/search/v2/articlesearch.json');

            return $this->formatNewsData($response->json()['response']['docs']);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to fetch news data');
        }
    }

    public function getBaseUrl(): string
    {
        return config('apis.nyt.url');
    }

    public function getQueryParams(): array
    {
        return [
            'api-key' => config('apis.nyt.key'),
            'pub_date' => today()->subDay()->format('Y-m-d')
        ];
    }

    public function formatNewsData(array $data): array
    {
        return \Arr::map($data, static function(array $datum) {
            return [
                'title'    => $datum['abstract'],
                'content'  => $datum['lead_paragraph'],
                'url'      => $datum['web_url'],
                'source'   => $datum['source'],
                'author'   => $datum['byline']['original'] ?? 'unknown',
                'category' => $datum['section_name'] ?? 'general',
            ];
        });
    }
}

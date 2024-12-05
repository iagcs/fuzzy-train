<?php

namespace Modules\Article\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class TheGuardiansApiService extends ArticleNewsApiService
{
    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function getNewsData(): array
    {
        try {
            $response = $this->client()->get('/search');

            return $this->formatNewsData($response->json()['response']['results']);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to fetch news data');
        }
    }

    public function getBaseUrl(): string
    {
        return config('apis.the_guardian.url');
    }

    public function getQueryParams(): array
    {
        return [
            'api-key' => config('apis.the_guardian.key'),
            'from-date' => today()->subDay()->format('Y-m-d'),
            'to-date' => today()->subDay()->format('Y-m-d')
        ];
    }

    public function formatNewsData(array $data): array
    {
        return \Arr::map($data, static function(array $datum) {
            return [
                'title'    => $datum['webTitle'],
                'content'  => $datum['webTitle'],
                'url'      => $datum['webUrl'],
                'source'   => $datum['pillarName'],
                'author'   => 'unknown',
                'category' => $datum['sectionName'],
            ];
        });
    }
}

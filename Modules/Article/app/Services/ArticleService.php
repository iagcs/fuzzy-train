<?php

namespace Modules\Article\Services;

use App\Services\ElasticService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ArticleService
{
    public function __construct(private readonly Client $client)
    {

    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNewsData()
    {
        $response = Http::get(config('apis.news_api.url') . '/top-headlines', [
            'country' => 'us',
            'apiKey' => config('apis.news_api.key')
        ]);

// Inicializa o payload para o bulk
        $body = [];

        foreach ($response->json()['articles'] as $article) {
            $body[] = ['index' => ['_index' => 'articles']];
            $body[] = [
                'title' => $article['title'] ?? null,
                'description' => $article['description'] ?? null,
                'content' => $article['content'] ?? null,
                'source' => $article['source']['name'] ?? null,
                'author' => $article['author'] ?? null,
                'published_at' => $article['publishedAt'] ?? null,
            ];
        }

        app(ElasticService::class)->bulkDocuments($body);
    }
}

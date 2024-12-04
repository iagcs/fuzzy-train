<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;

class ElasticService
{
    public function __construct(private readonly Client $client) {}

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     */
    public function createDocument(array $body): void
    {
        $this->client->index([
            'index' => 'articles',
            'body' => [
                "title" => "Esse eh um teste no laravel",
                "body" => "ola estou testando",
                "author" => "Iago Souto",
                "published_date" => "2024-12-04",
                "content" => "teste"
            ]
        ]);
    }

    public function bulkDocuments(array &$body): void
    {
        try {
            $response = $this->client->bulk(compact('body'));
            dd($response->getStatusCode());
        } catch (\Exception $e) {
            \Log::error('Failed to create index document: '.$e->getMessage());
            throw $e;
        }
    }

    public function searchDocument()
    {
        $response = $this->client->search([
            'index' => 'articles',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'match_phrase' => ['title' => 'Getting Started with Elasticsearch']
                        ]
                    ]
                ]
            ]
        ]);

        dd(Arr::pluck($response['hits']['hits'], '_source'));
    }
}

<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;

readonly class ElasticService
{
    public function __construct(private Client $client) {}

    public function bulkDocuments(array $data): void
    {
        $body = [];

        foreach ($data as $datum){
            $body[] = ['index' => ['_index' => 'articles']];
            $body[] = $datum;
        }

        try {
            $this->client->bulk(compact('body'));
        } catch (\Exception $e) {
            \Log::error('Failed to create index document: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     */
    public function search(array $body)
    {
        try {
            $response = $this->client->search([
                'index' => 'articles',
                ...$body
            ]);

            return $response['hits']['hits'];
        } catch (\Exception $e) {
            \Log::error('Failed to search inside index: '.$e->getMessage());
            throw $e;
        }
    }
}

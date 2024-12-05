<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;

class ElasticService
{
    public function __construct(private readonly Client $client) {}

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

    public function searchDocument()
    {
        $response = $this->client->search([
            'index' => 'articles',
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => [
                                    'author' => [
                                        'query' => 'sdasdasdasd author2',
                                        'operator' => 'or',
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                            [
                                'match' => [
                                    'category' => [
                                        'query' => 'adsasdasd',
                                        'operator' => 'or',
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                            [
                                'match' => [
                                    'source' => [
                                        'query' => 'washingt',
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
                'sort' => [
                    ['_score' => ['order' => 'desc']],
                ],
            ]
        ]);
    }
}

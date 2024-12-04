<?php

namespace App\Providers;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, static function ($app) {
            return ClientBuilder::create()
                ->setElasticCloudId(config('services.elasticsearch.cloud_id'))
                ->setApiKey(config('services.elasticsearch.api_key'))
                ->setSSLVerification(config('services.elasticsearch.https'))
                ->build();
        });
    }
}

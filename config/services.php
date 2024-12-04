<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'elasticsearch' => [
        'host'     => env('ELASTICSEARCH_HOST', 'localhost'),
        'port'     => env('ELASTICSEARCH_PORT', '9200'),
        'user'     => env('ELASTICSEARCH_USER'),
        'scheme'   => env('ELASTICSEARCH_SCHEME', 'http'),
        'password' => env('ELASTICSEARCH_PASS'),
        'api_key'  => env('ELASTIC_API_KEY'),
        'cloud_id' => env('ELASTIC_CLOUD_ID'),
        'https'    => env('ELASTIC_HTTPS', TRUE),
    ],

];

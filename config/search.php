<?php

declare(strict_types=1);

return [
    'driver' => env('SEARCH_DRIVER', 'database'),
    'drivers' => [
        'database' => [
            'description' => 'Fallback SQL LIKE queries via SearchService.',
        ],
        'meilisearch' => [
            'host' => env('MEILISEARCH_HOST', 'http://127.0.0.1:7700'),
            'key' => env('MEILISEARCH_KEY'),
        ],
        'elasticsearch' => [
            'hosts' => explode(',', env('ELASTICSEARCH_HOSTS', '127.0.0.1:9200')),
        ],
    ],
];

<?php

return [
    'cache_items' => [
        'enabled' => env('LARAVEL_DB_VAULT_CACHE_ENABLED', true),
        'ttl' => env('LARAVEL_DB_VAULT_CACHE_TTL', 3600),
    ],
];
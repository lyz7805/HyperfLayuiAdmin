<?php

declare(strict_types=1);

return [
    'default' => [
        'connection_timeout' => 30,
        'debug' => (env('App_ENV', 'dev') == 'dev'),
        'proxy' => '',
        'timeout' => 0,
    ],
    'pool' => [
        'min_connections' => 1,
        'max_connections' => 30,
        'wait_timeout' => 3.0,
        'max_idle_time' => 60,
    ],
    'middlewares' => [
        'retry' => [Hyperf\Guzzle\RetryMiddleware::class, [1, 10]],
    ]
];

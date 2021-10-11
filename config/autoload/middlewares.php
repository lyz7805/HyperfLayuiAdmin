<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'http' => [
        \Hyperf\Session\Middleware\SessionMiddleware::class,
        App\Middleware\Admin\AuthMiddleware::class,
        App\Middleware\Admin\OperationLogMiddleware::class,
        Hyperf\Validation\Middleware\ValidationMiddleware::class
    ],
];

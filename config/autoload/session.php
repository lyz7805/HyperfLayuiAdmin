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
use Hyperf\Session\Handler;

return [
    'handler' => Handler\RedisHandler::class,
    'options' => [
        'connection' => 'default',
        'gc_maxlifetime' => 5 * 60 * 60, // 过期时间，秒
        'session_name' => 'HYPERF_SESSION_ID',
        'domain' => null,
    ],
];

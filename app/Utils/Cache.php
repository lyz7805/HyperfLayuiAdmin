<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;

/**
 * Cache
 * 
 * @method mixed get($key, $default = null) Fetches a value from the cache.
 * @method bool has($key) Determines whether an item is present in the cache.
 * @method bool set($key, $value, $ttl = null) Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
 * @method bool delete($key) Delete an item from the cache by its unique key.
 * @method bool clear() Wipes clean the entire cache's keys.
 */
class Cache
{
    public static function getInstance(): CacheInterface
    {
        return ApplicationContext::getContainer()->get(CacheInterface::class);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return self::getInstance()->$name(...$arguments);
    }
}

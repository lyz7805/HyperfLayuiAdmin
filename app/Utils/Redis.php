<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;

/**
 * Redis
 * 
 * @method static int exists(string|array $keys) Verify if the specified key exists.
 * @method static string|false get(string $key) Get the value related to the specified key
 * @method static bool set($key, string $value, int|array $options) Set the string value in argument as value of the key. If you're using Redis >= 2.6.12, you can pass extended options as explained below
 */
class Redis
{
    /**
     * Redis实例
     *
     * @param string $name redis配置名称
     * @return \Redis
     */
    public static function connection(string $name = 'default')
    {
        return ApplicationContext::getContainer()->get(RedisFactory::class)->get($name);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return self::connection()->$name(...$arguments);
    }
}

<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Log\LoggerInterface;

/**
 * Log
 * 
 * @method static void emergency(string $message, array $context = []) System is unusable.
 * @method static void alert(string $message, array $context = []) Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
 * @method static void critical(string $message, array $context = []) Critical conditions. Example: Application component unavailable, unexpected exception.
 * @method static void error(string $message, array $context = []) Runtime errors that do not require immediate action but should typically be logged and monitored.
 * @method static void warning(string $message, array $context = []) Exceptional occurrences that are not errors. Example: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
 * @method static void notice(string $message, array $context = []) Normal but significant events.
 * @method static void info(string $message, array $context = []) Interesting events. Example: User logs in, SQL logs.
 * @method static void debug(string $message, array $context = []) Detailed debug information.
 * @method static void log($level, string $message, array $context = []) Logs with an arbitrary level.
 */
class Log
{
    /**
     * 获取Logger实例
     *
     * @param string $name
     * @return LoggerInterface
     */
    public static function get(string $name = 'app'): LoggerInterface
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return Log::get()->$name(...$arguments);
    }
}

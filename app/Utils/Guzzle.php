<?php

declare(strict_types=1);

namespace App\Utils;

use GuzzleHttp\Client;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Guzzle\HandlerStackFactory;

/**
 * Guzzle
 */
class Guzzle
{
    /**
     * create a new guzzle client
     * 
     * @return Client
     */
    public static function client(array $options = []): Client
    {
        $defaultOptions = config('guzzle.default', []);

        $options = array_merge(
            $defaultOptions,
            $options
        );

        /**
         * @var ClientFactory
         */
        $clientFactory = ApplicationContext::getContainer()->get(ClientFactory::class);
        $client = $clientFactory->create($options);
        Log::debug('create guzzle client.', ['options' => $options]);
        return $client;
    }


    /**
     * create a new client with pool
     * 
     * @return Client
     */
    public static function pool(array $options = []): Client
    {
        $factory = new HandlerStackFactory();

        $poolOptions = config('guzzle.pool', []);
        if (isset($options['pool']) && is_array($options['pool'])) {
            $poolOptions = array_merge($poolOptions, $options['pool']);
        }
        $middlewaresOptions = config('guzzle.middlewares', []);
        if (isset($options['middlewares']) && is_array($options['middlewares'])) {
            $middlewaresOptions = array_merge($middlewaresOptions, $options['middlewares']);
        }

        $handleStack = $factory->create($poolOptions, $middlewaresOptions);

        $options = array_merge(
            [
                'handler' => $handleStack
            ],
            $options
        );

        Log::debug('create guzzle pool client.', ['options' => $options]);
        return static::client($options);
    }
}

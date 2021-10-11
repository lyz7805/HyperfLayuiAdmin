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
namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $errorMsg = $throwable->validator->errors()->first();
        $contentType = $response->getHeader('Content-Type');
        if ($contentType) {
            $contentType = $contentType[0];
        } else {
            $contentType = 'application/json; charset=utf-8';
            $response = $response->withAddedHeader('content-type', $contentType);
        }
        if (preg_match('/application\/json/', strtolower($contentType))) {
            $data = [
                'code' => $throwable->status,
                'message' => $errorMsg
            ];
            return $response->withStatus(200)->withBody(new SwooleStream(json_encode($data, JSON_UNESCAPED_UNICODE)));
        } else {
            return $response->withStatus($throwable->status)->withBody(new SwooleStream($errorMsg));
        }
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}

<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AbstractController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use OpenApi\Annotations as OA;
use \Psr\Http\Message\ResponseInterface as PsrResponseInterface;

/**
 * @OA\Info(
 *      description="后台数据接口",
 *      version="1.0.0",
 *      title="后台数据接口",
 * )
 * @OA\Tag(
 *      name="Admin",
 *      description="后台管理",
 * )
 * @OA\Schema(
 *      schema="Result",
 *      title="通用返回结果",
 *      @OA\Property(
 *          property="code",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="data",
 *          type="object"
 *      ),
 *      example={"code": 200, "message": "success", "data": "object"}
 * )
 */
class AbstractBaseApiController extends AbstractController
{
    protected function success(array $data = [], string $message = 'success')
    {
        return $this->result($data, 200, $message);
    }

    protected function error(string $message = 'error', array $data = [], int $code = 400)
    {
        return $this->result($data, $code, $message);
    }

    protected function result(array $data = [], int $code = 200, string $message = 'success'): PsrResponseInterface
    {
        $result = [
            'code' => $code,
            'message' => $message
        ];

        if ($data) {
            $result['data'] = $data;
        }

        return $this->response->json($result);
    }
}

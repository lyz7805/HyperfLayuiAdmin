<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Hyperf\HttpServer\Contract\RequestInterface;
use \Psr\Http\Message\ResponseInterface as PsrResponseInterface;

abstract class AbstractBaseAdminController extends AbstractController
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

    protected function getWhere(RequestInterface $request): array
    {
        return [];
    }
}

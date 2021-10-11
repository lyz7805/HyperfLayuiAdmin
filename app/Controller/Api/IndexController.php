<?php

declare(strict_types=1);

namespace App\Controller\Api;

use OpenApi\Annotations as OA;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Controller\Api\AbstractBaseApiController;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * @AutoController
 */
class IndexController extends AbstractBaseApiController
{
    /**
     * Undocumented function
     *
     * @OA\Get(
     *      path="/api/index/hello",
     *      tags={"Index"},
     *      summary="",
     *      description="",
     *      operationId="hello",
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="name",
     *          example="hyperf",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Result"
     *          ),
     *      ),
     * )
     */
    public function hello()
    {
        $name = trim($this->request->input('name', 'hyperf'));
        return $this->success([
            'msg' => 'hello ' . $name
        ]);
    }
}

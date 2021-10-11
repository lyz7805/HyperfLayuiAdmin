<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\OperationLogService;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use App\Controller\Admin\AbstractBaseAdminController;
use App\Controller\Admin\AdminControllerTrait;

/**
 * @AutoController
 */
class OperationLogController extends AbstractBaseAdminController
{
    /**
     * @Inject
     * @var OperationLogService
     */
    protected $service;

    use AdminControllerTrait;

    protected function getWhere(RequestInterface $request): array
    {
        $where = parent::getWhere($request);

        $searchParams = json_decode($request->input('searchParams', ''), true);
        /** @var array */
        $searchParams = $searchParams ?: [];

        !empty($searchParams['id']) && $where[] = ['id', '=', $searchParams['id']];
        !empty($searchParams['user_id']) && $where[] = ['user_id', '=', $searchParams['user_id']];
        !empty($searchParams['ip']) && $where[] = ['ip', '=', $searchParams['ip']];
        !empty($searchParams['method']) && $where[] = ['method', 'like', '%' . $searchParams['method'] . '%'];

        return $where;
    }
}

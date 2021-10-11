<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\RoleService;
use App\Request\Admin\RoleAddRequest;
use App\Request\Admin\RoleEditRequest;
use App\Request\Admin\RoleSetPermissionRequest;
use App\Controller\Admin\AdminControllerTrait;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * @AutoController
 */
class RoleController extends AbstractBaseAdminController
{
    /**
     * @Inject
     * @var RoleService
     */
    protected $service;

    use AdminControllerTrait;

    public function add(RoleAddRequest $request, ResponseInterface $response)
    {
        $res = $this->service->addRole($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function edit(RoleEditRequest $request, ResponseInterface $response)
    {
        $res = $this->service->editRole($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function listAll(RequestInterface $request)
    {
        $all = $this->service->getAll(['state' => 1]);

        return $this->success($all->jsonSerialize());
    }

    public function setPermission(RoleSetPermissionRequest $request, ResponseInterface $response)
    {
        $res = $this->service->setPermission($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function getPermissionMenuIds()
    {
        $id = (int) $this->request->input('id');

        $res = $this->service->getPermissionMenuIds($id);
        if ($res['status']) {
            return $this->success($res['data'], $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    protected function getWhere(RequestInterface $request): array
    {
        $where = parent::getWhere($request);

        $searchParams = json_decode($request->input('searchParams', ''), true);
        /** @var array */
        $searchParams = $searchParams ?: [];

        !empty($searchParams['id']) && $where[] = ['id', '=', $searchParams['id']];
        !empty($searchParams['name']) && $where[] = ['name', 'like', '%' . $searchParams['name'] . '%'];

        return $where;
    }
}

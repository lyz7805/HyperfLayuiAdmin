<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\MenuService;
use Hyperf\Database\Model\Collection;
use App\Controller\Admin\AdminControllerTrait;
use App\Request\Admin\MenuRequest;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * Menu
 * 
 * @AutoController
 */
class MenuController extends AbstractBaseAdminController
{
    /**
     * @Inject
     * @var MenuService
     */
    protected $service;

    use AdminControllerTrait;

    public function add(MenuRequest $request, ResponseInterface $response)
    {
        $res = $this->service->addMenu($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function edit(MenuRequest $request, ResponseInterface $response)
    {
        $res = $this->service->editMenu($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function list(RequestInterface $request)
    {
        $where = [];
        $where = $this->getWhere($request);

        /** @var Collection @all */
        $all = $this->service->getAll($where);

        return $this->success($all->jsonSerialize());
    }

    protected function getWhere(RequestInterface $request): array
    {
        $where = parent::getWhere($request);

        $searchParams = json_decode($request->input('searchParams', ''), true);
        /** @var array */
        $searchParams = $searchParams ?: [];

        !empty($searchParams['id']) && $where[] = ['id', '=', $searchParams['id']];
        !empty($searchParams['parent_id']) && $where[] = ['parent_id', '=', $searchParams['parent_id']];

        return $where;
    }

    public function editList()
    {

    }
}

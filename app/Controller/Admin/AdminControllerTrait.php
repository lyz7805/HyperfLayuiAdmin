<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Utils\Collection;
use Hyperf\Paginator\LengthAwarePaginator as Paginator;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * AdminControllerTrait
 */
trait AdminControllerTrait
{
    /**
     * 分页列表
     *
     * @param RequestInterface $request
     * @return void
     */
    public function list(RequestInterface $request)
    {
        $page = (int) $request->input('page', 1);
        $limit = (int) $request->input('limit', 15);

        $where = [];
        $where = $this->getWhere($request);

        /** @var Paginator */
        $pageList = $this->service->getPageList($where, 'created_at desc, id desc', $page, $limit);
        return $this->success($pageList->jsonSerialize());
    }

    public function changeState(RequestInterface $request)
    {
        if (!$request->has('id')) {
            return $this->error('缺少参数ID');
        }

        $id = (int) $request->input('id');
        $state = $request->input('state', true);

        if ($state == 'true') {
            $state = 1;
        } else {
            $state = 0;
        }

        if ($this->service->changeState($id, $state)) {
            return $this->success([], '设置成功');
        } else {
            return $this->error('设置失败，请重试');
        }
    }

    public function get(RequestInterface $request)
    {
        if (!$request->has('id')) {
            return $this->error('缺少参数ID');
        }

        $id = (int) $request->input('id');

        $res = $this->service->get($id);
        if ($res['status']) {
            return $this->success($res['data']->toArray());
        } else {
            return $this->error($res['msg']);
        }
    }

    public function delete(RequestInterface $request)
    {
        if (!$request->has('id')) {
            return $this->error('未提供必要参数id');
        }

        $id = (int) $request->input('id');
        $res = $this->service->delete($id);
        if ($res['status']) {
            return $this->success($res['data'], $res['msg'] ?: '删除成功');
        } else {
            return $this->error($res['msg'] ?: '删除失败');
        }
    }
}

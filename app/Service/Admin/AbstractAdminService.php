<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Model\Model;

abstract class AbstractAdminService
{
    /**
     * @var Model
     */
    protected $model;

    public function get(int $id)
    {
        $res = ['status' => false, 'msg' => ''];
        $data = $this->model::query()->find($id);
        if ($data == null) {
            $res['msg'] = '要查询的数据不存在';
        } else {
            $res['status'] = true;
            $res['msg'] = '查询成功';
            $res['data'] = $data;
        }
        return $res;
    }

    public function getAll(array $where = [], string $orderBy = null)
    {
        $query = $this->model::query();
        count($where) && $query->where($where);
        if ($orderBy) {
            $orders = explode(',', trim($orderBy));
            foreach ($orders as $order) {
                $ob = explode(' ', preg_replace('/ +/', ' ', trim($order)));
                $query->orderBy($ob[0], $ob[1] ?? 'asc');
            }
        }
        return $query->get();
    }

    public function changeState(int $id, int $state = 1)
    {
        if ($state != 0) {
            $state = 1;
        }

        if ($this->model::query()->where('id', $id)->update(['state' => $state])) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(int $id)
    {
        $res = [
            'status' => false,
            'msg' => '删除失败'
        ];

        $count = $this->model::destroy($id);
        if ($count) {
            $res = [
                'status' => true,
                'msg' => '删除成功',
                'data' => [
                    'count' => $count
                ]
            ];
        }
        return $res;
    }
}

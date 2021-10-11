<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Utils;
use App\Model\AdminMenu;
use App\Model\AdminRoleMenu;
use App\Model\AdminUserRole;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Request\FormRequest;

class MenuService extends AbstractAdminService
{
    /**
     * @Inject
     * @var AdminMenu
     */
    protected $model;

    public function addMenu(FormRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '增加失败'
        ];
        $data = $request->validated();

        if (isset($data['id'])) {
            $res['msg'] = '增加菜单不能设置菜单ID';
            return $res;
        }
        !isset($data['state']) && $data['state'] = 1;

        $menu = new AdminMenu($data);
        if ($menu->save()) {
            $res['status'] = true;
            $res['msg'] = '增加成功';
            $res['data'] = $menu;
        }
        return $res;
    }

    public function changeState(int $id, int $state = 1)
    {
        // 部分菜单禁止修改状态
        if (in_array($id, [100, 101, 102])) {
            return false;
        }
        return parent::changeState($id, $state);
    }

    public function editMenu(FormRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '修改失败'
        ];
        $data = $request->validated();

        if (!isset($data['id'])) {
            $res['msg'] = '修改菜单必须设置菜单ID';
            return $res;
        }

        $menu = $this->model::query()->find($data['id']);
        foreach ($data as $key => $value) {
            $menu->$key = $value;
        }
        if ($menu->save()) {
            $res['status'] = true;
            $res['msg'] = '修改成功';
            $res['data'] = $menu;
        }
        return $res;
    }

    public function getMenuTree(int $userId, int $parentId = 0)
    {
        $builder = AdminMenu::query(true)
            ->where('state', 1)
            ->where('is_menu', 1)
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'asc');
        if ($userId != 1) {
            $roleIds = AdminUserRole::query(true)
                ->where('user_id', $userId)
                ->pluck('role_id');
            $menuIds = AdminRoleMenu::query(true)
                ->whereIn('role_id', $roleIds)
                ->orderBy('menu_id', 'asc')
                ->distinct()
                ->pluck('menu_id');
            $builder->whereIn('id', $menuIds);
        }
        $list = $builder->get(['id', 'parent_id', 'title', 'icon', 'href', 'target'])
            ->toArray();
        return Utils::listToTree($list, $parentId);
    }

    public function getAllMenuList()
    {
        return AdminMenu::all()->toArray();
    }
}

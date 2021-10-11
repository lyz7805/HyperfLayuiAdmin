<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Model\AdminMenu;
use App\Model\AdminRole;
use App\Model\AdminRoleMenu;
use Hyperf\Di\Annotation\Inject;
use App\Request\Admin\RoleAddRequest;
use App\Request\Admin\RoleEditRequest;
use App\Request\Admin\RoleSetPermissionRequest;

class RoleService extends AbstractAdminService
{
    /**
     * @Inject
     * @var AdminRole
     */
    protected $model;

    public function addRole(RoleAddRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '增加失败'
        ];
        $data = $request->validated();

        if (isset($data['id'])) {
            $res['msg'] = '增加角色不能设置角色ID';
            return $res;
        }
        !isset($data['state']) && $data['state'] = 1;

        $role = new AdminRole($data);
        if ($role->save()) {
            $res['status'] = true;
            $res['msg'] = '增加成功';
            $res['data'] = $role;
        }
        return $res;
    }

    public function editRole(RoleEditRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '修改失败'
        ];
        $data = $request->validated();

        if (!isset($data['id'])) {
            $res['msg'] = '修改角色必须设置角色ID';
            return $res;
        }

        $id = (int) $data['id'];
        unset($data['id']);

        $role = $this->model::query()->find($id);
        if (isset($data['name'])) {
            if ($data['name'] == $role->name) {
                unset($data['name']);
            } else {
                if ($this->model::query()->where('name', $data['name'])->exists()) {
                    $res['msg'] = '角色名已存在';
                    return $res;
                }
            }
        }
        foreach ($data as $key => $value) {
            $role->$key = $value;
        }
        if ($role->save()) {
            $res['status'] = true;
            $res['msg'] = '修改成功';
            $res['data'] = $role;
        }
        return $res;
    }

    public function getPermissionMenuIds(int $id)
    {
        $res = [
            'status' => true,
            'msg' => '获取成功',
            'data' => []
        ];

        $role = AdminRole::query()->find($id);
        if ($role) {
            $menus = $role->menus()->pluck('id');
            $res['data'][$id] = implode(',', $menus->toArray());
        } else {
            $res['status'] = false;
            $res['msg'] = '角色不存在';
        }
        return $res;
    }

    public function setPermission(RoleSetPermissionRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '设置失败'
        ];
        $data = $request->validated();

        if (!isset($data['id'])) {
            $res['msg'] = '权限设置必须设置角色ID';
            return $res;
        }

        $id = (int) $data['id'];
        unset($data['id']);

        $menus = explode(',', trim($data['menus'], ', \t\n\r\0\x0B'));
        $menuIds = AdminMenu::query()->whereIn('id', $menus)->pluck('id');
        if (!$menuIds) {
            $res['msg'] = '没有可添加的菜单权限';
            return $res;
        }

        $insert = [];
        foreach ($menuIds as $mendId) {
            $insert[] = [
                'role_id' => $id,
                'menu_id' => $mendId,
            ];
        }

        AdminRoleMenu::query()->where('role_id', $id)->delete();
        AdminRoleMenu::query()->insert($insert);
        $res['status'] = true;
        $res['msg'] = '设置成功';
        $res['data'] = AdminRoleMenu::query()->where('role_id', $id)->get();

        return $res;
    }
}

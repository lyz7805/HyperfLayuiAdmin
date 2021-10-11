<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Utils;
use App\Model\AdminRole;
use App\Model\AdminUser;
use App\Constants\ErrorCode;
use App\Model\AdminUserRole;
use Hyperf\Di\Annotation\Inject;
use App\Constants\SessionConstant;
use App\Request\Admin\UserAddRequest;
use Hyperf\Contract\SessionInterface;
use App\Request\Admin\UserEditRequest;
use App\Request\Admin\UserSetRoleRequest;

class UserService extends AbstractAdminService
{
    /**
     * @Inject
     * @var AdminUser
     */
    protected $model;

    /**
     * @Inject
     * @var SessionInterface
     */
    protected $session;

    public function addUser(UserAddRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '增加失败'
        ];
        $data = $request->validated();

        if (isset($data['id'])) {
            $res['msg'] = '增加用户不能设置用户ID';
            return $res;
        }
        !isset($data['state']) && $data['state'] = 1;

        $salt = Utils::createRandStr(64);
        $password = Utils::encryptPassword($data['password'], $salt);

        $data['salt'] = $salt;
        $data['password'] = $password;

        $user = new AdminUser($data);
        if ($user->save()) {
            $res['status'] = true;
            $res['msg'] = '增加成功';
            $res['data'] = $user;
        }
        return $res;
    }

    public function delete(int $id)
    {
        if ($id == 1) {
            return ['status' => false, 'msg' => '超级管理员不允许删除'];
        }

        return parent::delete($id);
    }

    public function editUser(UserEditRequest $request)
    {
        $res = [
            'status' => false,
            'msg' => '修改失败'
        ];
        $data = $request->validated();

        if (!isset($data['id'])) {
            $res['msg'] = '修改用户必须设置用户ID';
            return $res;
        }

        $id = (int) $data['id'];
        unset($data['id']);
        if (isset($data['salt'])) {
            unset($data['salt']);
        }

        $user = $this->model::query()->find($id);
        if (isset($data['username'])) {
            if ($data['username'] == $user->username) {
                unset($data['username']);
            } else {
                if ($this->model::query()->where('username', $data['username'])->exists()) {
                    $res['msg'] = '用户名已存在';
                    return $res;
                }
            }
        }
        if (isset($data['password'])) {
            $data['password'] = $this->encryptPassword($data['password'], $user->salt);
        }
        foreach ($data as $key => $value) {
            $user->$key = $value;
        }
        if ($user->save()) {
            $res['status'] = true;
            $res['msg'] = '修改成功';
            $res['data'] = $user;
        }
        return $res;
    }

    public function get(int $id)
    {
        $res = ['status' => false, 'msg' => ''];
        $data = $this->model::query()->with('roles')->find($id, ['id', 'username', 'name', 'avatar', 'created_at', 'updated_at']);
        if ($data == null) {
            $res['msg'] = '要查询的数据不存在';
        } else {
            $res['status'] = true;
            $res['msg'] = '查询成功';
            $res['data'] = $data;
        }
        return $res;
    }

    public function hasLogin()
    {
        return $this->session->has(SessionConstant::ADMIN_USER_SESSION_KEY);
    }

    public function login(string $username, string $password): array
    {
        $result = ['status' => true, 'data' => '', 'msg' => 'success'];

        $user = AdminUser::query()->where('username', $username)->first();
        if ($user instanceof AdminUser) {
            $encryptPwd = Utils::encryptPassword($password, $user->salt);

            if ($user->password != $encryptPwd) {
                $result['status'] = false;
                $result['msg'] = ErrorCode::getMessage(ErrorCode::USER_PASSWORD_ERROR);
            } else {
                $this->session->set(SessionConstant::ADMIN_USER_SESSION_KEY, $user);
                $result['data'] = $user;
            }
        } else {
            $result['status'] = false;
            $result['msg'] = ErrorCode::getMessage(ErrorCode::USER_NOT_FOUND_ERROR);
        }
        return $result;
    }

    public function logout(): bool
    {
        $this->session->clear();
        return true;
    }

    /**
     * 加密密码
     *
     * @param string $password 原始密码
     * @param string $salt 盐值
     * @return string
     */
    public static function encryptPassword(string $password, string $salt): string
    {
        return Utils::encryptPassword($password, $salt);
    }

    public function setRole(UserSetRoleRequest $request)
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

        if ($data['id'] == 1) {
            $res['msg'] = '超级管理员不能设置角色';
            return $res;
        }

        $id = (int) $data['id'];
        unset($data['id']);

        $roleIds = AdminRole::query()->whereIn('id', $data['roles'])->where('state', 1)->pluck('id');
        if (!$roleIds) {
            $res['msg'] = '没有可设置的角色';
            return $res;
        }

        $insert = [];
        foreach ($roleIds as $roleId) {
            $insert[] = [
                'user_id' => $id,
                'role_id' => $roleId,
            ];
        }

        AdminUserRole::query()->where('user_id', $id)->delete();
        AdminUserRole::query()->insert($insert);
        $res['status'] = true;
        $res['msg'] = '设置成功';
        $res['data'] = AdminUserRole::query()->where('user_id', $id)->get();

        return $res;
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Utils;
use App\Model\AdminUser;
use Hyperf\Di\Annotation\Inject;
use App\Constants\SessionConstant;
use Hyperf\Contract\SessionInterface;
use App\Request\Admin\UserChangeSettingRequest;
use App\Request\Admin\UserChangePasswordRequest;

class IndexService
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

    public function changeUserPassword(UserChangePasswordRequest $request)
    {
        $user = $this->session->get(SessionConstant::ADMIN_USER_SESSION_KEY);
        $id = (int) $user->id;
        $res = [
            'status' => false,
            'msg' => '修改失败'
        ];
        $data = $request->validated();

        $user = $this->model::query()->find($id);
        if ($user->password != Utils::encryptPassword($data['old_password'], $user->salt)) {
            $res['msg'] = '旧密码错误';
            return $res;
        }

        if ($data['old_password'] == $data['password']) {
            $res['msg'] = '新密码与旧密码一致';
            return $res;
        }

        $user->password = Utils::encryptPassword($data['password'], $user->salt);
        if ($user->save()) {
            // 修改成功更新session信息
            $this->session->set(SessionConstant::ADMIN_USER_SESSION_KEY, $user);

            $res['status'] = true;
            $res['msg'] = '修改成功';
            $res['data'] = $user;
        }
        return $res;
    }

    public function changeUserSetting(UserChangeSettingRequest $request)
    {
        $user = $this->session->get(SessionConstant::ADMIN_USER_SESSION_KEY);
        $id = (int) $user->id;
        $res = [
            'status' => false,
            'msg' => '修改失败'
        ];
        $data = $request->validated();

        $user = $this->model::query()->find($id);
        if (isset($data['username'])) {
            if ($data['username'] == $user->username) {
                unset($data['username']);
            } else {
                if ($this->model::query()->where('id', '<>', $id)->where('username', $data['username'])->exists()) {
                    $res['msg'] = '用户名已存在';
                    return $res;
                }
            }
        }

        foreach ($data as $key => $value) {
            $user->$key = $value;
        }
        if ($user->save()) {
            // 修改成功更新session信息
            $this->session->set(SessionConstant::ADMIN_USER_SESSION_KEY, $user);

            $res['status'] = true;
            $res['msg'] = '修改成功';
            $res['data'] = $user;
        }
        return $res;
    }

    public function user()
    {
        $user = $this->session->get(SessionConstant::ADMIN_USER_SESSION_KEY);
        $id = (int) $user->id;
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
}

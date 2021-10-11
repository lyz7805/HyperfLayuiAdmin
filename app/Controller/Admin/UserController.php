<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\UserService;
use App\Request\Admin\LoginRequest;
use App\Request\Admin\UserAddRequest;
use App\Request\Admin\UserEditRequest;
use App\Request\Admin\UserSetRoleRequest;
use Hyperf\HttpServer\Annotation\PostMapping;
use App\Controller\Admin\AdminControllerTrait;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * User
 * 
 * @AutoController
 */
class UserController extends AbstractBaseAdminController
{
    /**
     * @Inject
     * @var UserService
     */
    protected $service;

    use AdminControllerTrait;

    public function add(UserAddRequest $request, ResponseInterface $response)
    {
        $res = $this->service->addUser($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function edit(UserEditRequest $request, ResponseInterface $response)
    {
        $res = $this->service->editUser($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function hasLogin()
    {
        $hasLogin = $this->service->hasLogin();
        return $this->success(['login' => $hasLogin]);
    }

    /**
     * 用户登录
     *
     * @PostMapping
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->all();
        $res = $this->service->login($validated['username'], $validated['password']);

        $result = ['login' => false, 'message' => 'login error'];
        if (!$res['status']) {
            return $this->error($res['msg']);
        } else {
            $result = [
                'user' => $res['data']
            ];
            return $this->success($result);
        }
    }

    /**
     * 退出登录
     *
     */
    public function logout()
    {
        $this->service->logout();
        return $this->success(['logout' => true]);
    }

    public function setRole(UserSetRoleRequest $request)
    {
        $res = $this->service->setRole($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
        return $this->success($request->validated());
    }
}

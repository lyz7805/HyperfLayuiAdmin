<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use App\Constants\SessionConstant;
use App\Service\Admin\MenuService;
use App\Service\Admin\IndexService;
use Hyperf\Contract\SessionInterface;
use App\Request\Admin\UserChangeSettingRequest;
use App\Request\Admin\UserChangePasswordRequest;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * Index
 * 
 * @AutoController
 */
class IndexController extends AbstractBaseAdminController
{
    /**
     * @Inject
     * @var IndexService
     */
    protected $service;

    /**
     * @Inject
     * @var MenuService
     */
    protected $menuService;

    /**
     * @Inject
     * @var SessionInterface
     */
    protected $session;

    public function index(RequestInterface $request, ResponseInterface $response)
    {
    }

    public function init(ResponseInterface $response)
    {
        $homeInfo = [
            "title" => "首页",
            "href" => "page/welcome.html"
        ];
        $logoInfo = [
            "title" => "HyperfLayuiAdmin",
            "image" => "images/logo.png",
            "href" => ""
        ];

        $user = $this->session->get(SessionConstant::ADMIN_USER_SESSION_KEY);
        $menuInfo = $this->menuService->getMenuTree($user->id, 0);

        $result = [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
            'menuInfo' => $menuInfo
        ];
        return $response->json($result);
    }

    public function changeUserPassword(UserChangePasswordRequest $request)
    {
        $res = $this->service->changeUserPassword($request);
        if ($res['status']) {
            return $this->success([], $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function changeUserSetting(UserChangeSettingRequest $request)
    {
        $res = $this->service->changeUserSetting($request);
        if ($res['status']) {
            return $this->success($res['data']->toArray(), $res['msg']);
        } else {
            return $this->error($res['msg']);
        }
    }

    public function user(RequestInterface $request)
    {
        $res = $this->service->user();
        if ($res['status']) {
            return $this->success($res['data']->toArray());
        } else {
            return $this->error($res['msg']);
        }
    }
}

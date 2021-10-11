<?php

declare(strict_types=1);

namespace App\Middleware\Admin;

use Hyperf\Utils\Context;
use App\Constants\SessionConstant;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 验证用户认证登录中间件
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SessionInterface
     */
    protected $session;

    public function __construct(ContainerInterface $container, SessionInterface $session)
    {
        $this->container = $container;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        if (preg_match('/^\/admin\/.+?/', $path)) {
            if ($path == '/admin/user/login' || $path == '/admin/user/logout' || $path == '/admin/user/hasLogin') {
                return $handler->handle($request);
            }

            $user = $this->session->get(SessionConstant::ADMIN_USER_SESSION_KEY);
            if ($user === null) {
                // 是否Ajax请求
                $isAjax = $request->hasHeader('X-Requested-With') && preg_match('/XMLHttpRequest/', $request->getHeaderLine('X-Requested-With'));
                /** @var ResponseInterface $response*/
                $response = Context::get(ResponseInterface::class);
                $isJson = false;
                if ($request->hasHeader('Accept') && preg_match('/application\/json/', strtolower($request->getHeaderLine('Accept')))) { // 请求头接受json类型
                    $isJson = true;
                    $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');
                } else {
                    $contentType = $response->getHeaderLine('Content-Type');
                    $isJson = !!preg_match('/application\/json/', strtolower($contentType));
                }

                if ($isAjax || $isJson) {
                    $data = [
                        'code' => 401,
                        'message' => 'Unauthorized'
                    ];
                    return $response->withStatus(401)->withBody(new SwooleStream(json_encode($data, JSON_UNESCAPED_UNICODE)));
                } else {
                    $toUrl = $uri->withPath('/admin/page/login.html');
                    return $response->withStatus(302)->withAddedHeader('Location', $toUrl);
                }
            }

            // 已认证请求增加user属性
            $request->user = $user;
            Context::set(ServerRequestInterface::class, $request);
        }
        return $handler->handle($request);
    }
}

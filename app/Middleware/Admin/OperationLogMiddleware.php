<?php

declare(strict_types=1);

namespace App\Middleware\Admin;

use App\Constants\SessionConstant;
use App\Model\AdminOperationLog;
use Hyperf\Contract\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 后台操作记录中间件
 */
class OperationLogMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * 需要记录的请求方法，方法名全大写
     *
     * @var array
     */
    protected $recordMethods = [/* 'GET', */'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'];

    public function __construct(ContainerInterface $container, SessionInterface $session)
    {
        $this->container = $container;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $begin = (float) microtime(true);
        $user = $this->session->get(SessionConstant::ADMIN_USER_SESSION_KEY);
        $path = $request->getUri()->getPath();
        $method = strtoupper($request->getMethod());
        $serverParams = $request->getServerParams();
        $response = $handler->handle($request);
        $end = (float) microtime(true);
        if ($user && preg_match('/^\/admin/', $path) && $this->inRecordMethod($method)) {
            $runtime = (float) sprintf('%.3f', $end - $begin);
            $ip = $serverParams['remote_addr'];
            $params = array_merge($request->getQueryParams(), (array) $request->getParsedBody());
            if ($params) {
                $params = json_encode($params, JSON_UNESCAPED_UNICODE);
                // 键值包含password的将值用*替代
                $params = preg_replace('/([\'|"][\w]*password[\w]*[\'|"]: *)([\'|"])([\w|\.]*)([\'|"])/', '$1$2*****$4', $params);
            } else {
                $params = null;
            }
            try {
                $result = $response->getBody()->getContents();
            } catch (\RuntimeException $e) {
                $result = 'Error: ' . $e->getCode() . ' ' . $e->getMessage();
            }
            $data = [
                'user_id' => $user->id,
                'ip' => $ip,
                'path' => $path,
                'method' => $method,
                'params' => $params,
                'result' => $result,
                'runtime' => $runtime,
                'created_at' => date('Y-m-d H:i:s', time())
            ];

            AdminOperationLog::create($data);
        }

        return $response;
    }

    protected function inRecordMethod(string $method)
    {
        $recordMethods = collect($this->recordMethods);
        if ($recordMethods->isEmpty()) {
            return false;
        }

        return $recordMethods->contains(strtoupper($method));
    }
}
